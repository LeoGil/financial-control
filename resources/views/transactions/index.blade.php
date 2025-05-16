<x-layout title="Transações" :mensagemSucesso="$mensagemSucesso">
    {{-- <a href="{{ route('accounts.create') }}" class="btn btn-success btn-sm fw-bold mb-3">Nova conta</a> --}}
    @if ($installments->isEmpty())
    <p class="text-center text-muted"><i>Nenhuma transação cadastrada.</i></p>
    @else
    <a href="{{ route('accounts.statements.index', $account->id) }}" class="btn btn-sm btn-secondary">Voltar para faturas</a>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mt-3">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($installments as $installment)
                    <tr>
                        <td>{{ $installment->transaction->name }} ({{ $installment->installment_number }}/{{ $installment->installment_total }})</td>
                        <td>{{ $installment->transaction->date->format('d/m/Y') }}</td>
                        <td><strong>R${{ number_format($installment->amount, 2, ',', '.') }}</strong></td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-info">Detalhes</a>
                            <a href="#" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('accounts.statements.installments.transactions.destroy', [$account->id, $installment->transaction_id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja realmente excluir essa transação? Todas as faturas e parcelas vinculadas a essa transação serão excluidas')">
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
    </div>
    @endif
</x-layout>