<x-layout title="Cartões">
    <a href="{{ route('accounts.credit_cards.create', $account->id) }}" class="btn btn-success btn-sm mb-3">Novo cartão</a>
    <a href="{{ route('accounts.index') }}" class="btn btn-sm btn-secondary mb-3">Voltar para contas</a>
    @if ($creditCards->isEmpty())
    <p class="text-center text-muted"><i>Nenhum cartão cadastrado.</i></p>
    @else
    <ul class="list-group">
        @foreach ($creditCards as $creditCard)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $creditCard->name }}
                <div class="float-end d-flex gap-2">
                    {{-- <a href="{{ route('credit_cards.edit', $creditCard->id) }}" class="btn btn-warning btn-sm">Editar</a> --}}
                    <form action="{{ route('credit_cards.destroy', $creditCard->id) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir? Todas as faturas vinculadas ao cartão serão excluidas')">
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