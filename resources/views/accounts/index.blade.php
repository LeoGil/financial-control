<x-layout title="Dashboard de Contas" :mensagemSucesso="$mensagemSucesso">
    {{-- Estilos customizados para efeito hover nos cards --}}
    <style>
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>

    {{-- Linha de cards resumo --}}
    <div class="row mb-4">
        <div class="col-6 col-md-3">
            <div class="card bg-warning text-dark card-hover shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Total a Pagar</h6>
                    <p class="display-6">R$ {{ number_format($totalOpen, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-danger text-white card-hover shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Total Vencido</h6>
                    <p class="display-6">R$ {{ number_format($totalOverdue, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-success text-white card-hover shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Total Pago</h6>
                    <p class="display-6">R$ {{ number_format($totalPaid, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-info text-white card-hover shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Próx. Vencimento</h6>
                    <p class="display-6">{{ $nextDueDateFormatted }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Botões de ação --}}
    <div class="d-flex mb-4">
        <a href="{{ route('accounts.create') }}"
           class="btn btn-success btn-sm me-2">
            <i class="fa-solid fa-landmark"></i> Nova conta
        </a>
        <a href="{{ route('transactions.create') }}"
           class="btn btn-danger btn-sm">
            <i class="fa-solid fa-plus-minus"></i> Nova transação
        </a>
    </div>

    {{-- Lista de contas --}}
    @if ($accounts->isEmpty())
        <p class="text-center text-muted fst-italic">Nenhuma conta cadastrada.</p>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach ($accounts as $account)
                <div class="col">
                    <div class="card card-hover shadow-sm rounded-4 h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">{{ $account->name }}</h5>
                                @if ($account->oldestOpenStatement)
                                    <p class="card-text text-muted mb-1">
                                        <span class="fw-semibold">Fatura atual:</span>
                                        R$ {{ number_format($account->oldestOpenStatement->total_amount, 2, ',', '.') }}
                                    </p>
                                    <p class="card-text text-muted">
                                        <span class="fw-semibold">Vencimento:</span>
                                        {{ $account->oldestOpenStatement->due_date->format('d/m/Y') }}
                                    </p>
                                @else
                                    <p class="card-text text-muted fst-italic">Sem fatura atual</p>
                                @endif
                            </div>
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('accounts.statements.index', $account->id) }}"
                                   class="btn btn-info btn-sm flex-fill">
                                    <i class="fa-solid fa-money-bills"></i> Faturas
                                </a>
                                <a href="{{ route('accounts.credit_cards.index', $account->id) }}"
                                   class="btn btn-primary btn-sm flex-fill">
                                    <i class="fa-solid fa-credit-card"></i> Cartões
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-layout>
