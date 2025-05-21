<x-layout title="Dashboard de Contas" :mensagemSucesso="$mensagemSucesso">

  {{-- Cards Resumo --}}
  <div class="row g-3 mb-4">
    @foreach ([
      ['label'=>'Total a Pagar','value'=>$totalOpen,'color'=>'warning'],
      ['label'=>'Total Vencido','value'=>$totalOverdue,'color'=>'danger'],
      ['label'=>'Total Pago','value'=>$totalPaid,'color'=>'success'],
      ['label'=>'Próx. Vencimento','value'=>$nextDueDateFormatted,'color'=>'info'],
    ] as $card)
      <div class="col-6 col-md-3">
        <div class="card summary-card border-{{ $card['color'] }}">
          <div class="card-body">
            <small class="text-uppercase text-muted">{{ $card['label'] }}</small>
            <h5 class="mt-2">
              {{ is_numeric($card['value'])
                  ? 'R$ '.number_format($card['value'],2,',','.')
                  : $card['value'] }}
            </h5>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- Ações + Busca --}}
  <div class="my-3 d-flex flex-column flex-sm-row gap-2">
    <div class="btn-group mb-2">
      <a href="{{ route('accounts.create') }}" class="btn btn-outline-success btn-sm">
        <i class="fa-solid fa-landmark"></i> Nova conta
      </a>
      <a href="{{ route('transactions.create') }}" class="btn btn-outline-danger btn-sm">
        <i class="fa-solid fa-plus-minus"></i> Nova transação
      </a>
    </div>
  </div>

  {{-- Tabela de Contas --}}
  @if ($accounts->isEmpty())
    <p class="text-center text-muted fst-italic">Nenhuma conta cadastrada.</p>
  @else
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      @foreach($accounts as $account)
        <div class="col">
          <div class="card-account">
            <div class="card-body">
              <div>
                <h5 class="card-title mb-2 text-dark">{{ $account->name }}</h5>
                @if($st = $account->oldestOpenStatement)
                  <p class="mb-1 text-muted small">
                    <span class="fw-semibold">Fatura atual:</span>
                    R$ {{ number_format($st->total_amount, 2, ',', '.') }}
                  </p>
                  <p class="text-muted small">
                    <span class="fw-semibold">Vencimento:</span>
                    {{ $st->due_date->format('d/m/Y') }}
                  </p>
                @else
                  <p class="fst-italic text-muted small">Sem fatura atual</p>
                @endif
              </div>
              <div class="mt-3 d-flex justify-content-between">
                <a href="{{ route('accounts.statements.index', $account->id) }}" 
                  class="btn btn-outline-info btn-sm">
                  <i class="fa-solid fa-money-bills me-1"></i>Faturas
                </a>
                <a href="{{ route('accounts.credit_cards.index', $account->id) }}" 
                  class="btn btn-outline-primary btn-sm">
                  <i class="fa-solid fa-credit-card me-1"></i>Cartões
                </a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</x-layout>
