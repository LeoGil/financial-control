<x-layout title="Contas" :mensagemSucesso="$mensagemSucesso">
    <a href="{{ route('accounts.create') }}" class="btn btn-success btn-sm fw-bold mb-3">Nova conta</a>
    @if ($accounts->isEmpty())
    <p class="text-center text-muted"><i>Nenhuma conta cadastrada.</i></p>
    @else
    <ul class="list-group">
        @foreach ($accounts as $account)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $account->name }}
                <div class="float-end d-flex gap-2">
                    <a href="{{ route('accounts.statements.index', $account->id) }}" class="btn btn-info btn-sm" title="Faturas vinculadas">Faturas</a>
                    <a href="{{ route('accounts.credit_cards.index', $account->id) }}" class="btn btn-primary btn-sm" title="Cartões vinculados">Cartões</a>
                    <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir? Todas as faturas/cartões vinculadas a essa conta serão excluidas')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
    @endif
</x-layout>