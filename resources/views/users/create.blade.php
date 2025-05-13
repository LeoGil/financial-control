<x-layout>
    <x-form title="Novo Usuário" maxWidth="600px">
        <form method="POST" onsubmit="preventDoubleSubmit(this)">
            @csrf
            <div class="form-group mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Registrar</button>
        </form>
    </x-form>
</x-layout>