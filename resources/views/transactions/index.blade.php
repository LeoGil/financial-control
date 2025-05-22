<x-layout title="Todas as transações">
    <div class="d-flex justify-content-between align-items-center mt-3">
        <form action="{{ route('transactions.index') }}" method="GET" class="d-flex" role="search">
            <input type="text" name="search" class="form-control form-control-sm me-2" 
                placeholder="Buscar transação..." value="{{ $search }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-search"></i> Buscar
            </button>
        </form>
    </div>
    @if ($transactions->isEmpty())
    <p class="text-center text-muted"><i>Nenhuma transação cadastrada.</i></p>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mt-3">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Cartão</th>
                    <th>Parcelas</th>
                    <th>Categoria</th>
                    <th>Valor</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->name }}</td>
                        <td>{{ $transaction->date->format('d/m/Y') }}</td>
                        <td>{{ $transaction->creditCard->name }}</td>
                        <td>{{ $transaction->installments_count }}</td>
                        <td>{{ $transaction->category->name }}</td>
                        <td><strong>R${{ number_format($transaction->amount, 2, ',', '.') }}</strong></td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja realmente excluir essa transação? Todas as faturas e parcelas vinculadas a essa transação serão excluidas')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Excluir
                                </button>
                            </form>
                            <!-- outros botões se necessário -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $transactions->appends(['search' => $search])->links() }}
        </div>
    </div>
    @endif
</x-layout>