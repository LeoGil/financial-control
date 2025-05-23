<x-layout>
    <x-form title="Novo Cartão para {{ $account->name }}" maxWidth="600px">
        <form action="{{ route('accounts.credit_cards.store', $account->id) }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <label for="name" class="form-label">Nome</label>
                    <input 
                        autofocus
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required
                    />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="credit_limit" class="form-label">Limite de crédito <i class="text-muted">(Opcional)</i></label>
                    <input type="number"
                        name="credit_limit"
                        id="credit_limit"
                        class="form-control"
                        value="{{ old('credit_limit') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
    </x-form>
</x-layout>