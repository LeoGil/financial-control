<x-layout>
    <x-form title="Nova Conta" maxWidth="600px">
        <form action="{{ route('accounts.store') }}" method="POST">
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
                    <label for="closing_day" class="form-label">Dia de fechamento</label>
                    <input
                        type="number"
                        name="closing_day"
                        id="closing_day"
                        class="form-control"
                        value="{{ old('closing_day') }}"
                        max="31"
                        min="1"
                        required
                    />
                </div>
                <div class="col-6">
                    <label for="due_day" class="form-label">Dia de vencimento</label>
                    <input
                        type="number"
                        name="due_day"
                        id="due_day"
                        class="form-control"
                        value="{{ old('due_day') }}"
                        max="31"
                        min="1"
                        required
                    />
                </div>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
    </x-form>
</x-layout>