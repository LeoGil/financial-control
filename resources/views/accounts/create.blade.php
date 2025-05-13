<x-layout>
    <x-form title="Nova Conta" maxWidth="400px">
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
            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
    </x-form>
</x-layout>