<x-layout>
    <x-form title="Nova transação" maxWidth="600px">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            @php
                $hoje = now()->toDateString();
            @endphp
            <div class="row mb-3">
                <div class="col-12">
                    <label for="name" class="form-label fw-bold">Titulo</label>
                    <input 
                        autofocus
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Titulo da transação"
                        class="form-control"
                        value="{{ old('name') }}"
                        required
                    />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="description" class="form-label"><b>Descrição</b> <i class="text-muted">(Opcional)</i></label>
                    <input
                        type="text"
                        name="description"
                        id="description"
                        placeholder="Descrição da transação"
                        class="form-control"
                        value="{{ old('description') }}"
                    />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="date" class="form-label fw-bold">Data</label>
                    <input 
                        type="date"
                        name="date"
                        id="date"
                        max="{{ $hoje }}"
                        class="form-control"
                        value="{{ old('date', $hoje) }}"
                        required
                    />
                </div>           
                <div class="col-6">
                    <label for="value" class="form-label fw-bold">Valor</label>
                    <input
                        type="number"
                        name="value"
                        id="value"
                        step="0.01"
                        min="0.01"
                        placeholder="Valor da transação"
                        class="form-control"
                        value="{{ old('value') }}"
                        required
                    />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="credit_card_id" class="form-label fw-bold">Cartão</label>
                    <select name="credit_card_id" id="credit_card_id" class="form-select" required>
                        <option value="" disabled selected>Selecione um cartão</option>
                        @foreach ($creditCards as $creditCard)
                            <option value="{{ $creditCard->id }}">{{ $creditCard->name }} - {{ $creditCard->account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="installment" class="form-label fw-bold">Parcelas</label>
                    <input
                        type="number"
                        name="installment"
                        id="installment"
                        min="1"
                        max="48"
                        placeholder="Quantidade de parcelas"
                        class="form-control"
                        value="{{ old('installment', 1) }}"
                        required
                    />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="category_id" class="form-label fw-bold">Categoria</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="" disabled selected>Selecione uma categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="budget_category_id" class="form-label fw-bold">Categoria do orçamento</label>
                    <select name="budget_category_id" id="budget_category_id" class="form-select">
                        @foreach ($budgetCategories as $budgetCategory)
                            <option value="{{ $budgetCategory->id }}">{{ $budgetCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Voltar para contas</a>
        </form>
    </x-form>
</x-layout>