<x-layout title="Categorias" :mensagemSucesso="$mensagemSucesso">
    <a href="{{ route('categories.create') }}" class="btn btn-outline-success btn-sm">Nova categoria</a>
    @if ($categories->isEmpty())
    <!-- outros botões se necessário -->
    <p class="text-center text-muted"><i>Nenhuma categoria cadastrada.</i></p>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mt-3">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-info">Detalhes</a>
                            <a href="#" class="btn btn-sm btn-warning">Editar</a>
                            {{-- <form action="{{ route('accounts.statements.installments.transactions.destroy', [$account->id, $installment->transaction_id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja realmente excluir essa transação? Todas as faturas e parcelas vinculadas a essa transação serão excluidas')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Excluir
                                </button>
                            </form> --}}
                            <!-- outros botões se necessário -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-layout>