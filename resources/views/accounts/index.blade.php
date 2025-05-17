<x-layout title="Contas" :mensagemSucesso="$mensagemSucesso">
    <style>
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); /* Bootstrap-like shadow */
        }
    </style>

    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('accounts.create') }}"
           class="btn btn-success btn-sm fw-bold me-2">
            + Nova conta
        </a>
        <a href="{{ route('transactions.create') }}"
           class="btn btn-danger btn-sm fw-bold">
            + Nova transação
        </a>
    </div>

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
                                    Faturas
                                </a>
                                <a href="{{ route('accounts.credit_cards.index', $account->id) }}"
                                   class="btn btn-primary btn-sm flex-fill">
                                    Cartões
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-layout>
