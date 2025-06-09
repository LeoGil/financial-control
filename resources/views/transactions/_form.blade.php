@php
    $hoje = now()->toDateString();
@endphp

<form action="{{ $formAction }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

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
                value="{{ old('name', $transaction->name ?? '') }}"
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
                value="{{ old('description', $transaction->description ?? '') }}"
            />
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            @php
                $dataSelecionada = old('date') ?? optional($transaction->date)->format('Y-m-d') ?? $hoje;
            @endphp
            <label for="date" class="form-label fw-bold">Data</label>
            <input 
                type="date"
                name="date"
                id="date"
                max="{{ $hoje }}"
                class="form-control"
                value="{{ $dataSelecionada }}"
                required
            />
        </div>
        <div class="col-6">
            <label for="value" class="form-label fw-bold">Valor</label>
            <input
                type="number"
                name="amount"
                id="amount"
                step="0.01"
                min="0.01"
                placeholder="Valor da transação"
                class="form-control"
                value="{{ old('amount', $transaction->amount ?? '') }}"
                required
            />
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label for="credit_card_id" class="form-label fw-bold">Cartão</label>
            <select name="credit_card_id" id="credit_card_id" class="form-select" required>
                <option value="" {{ !isset($transaction) ? 'selected' : '' }}>Selecione um cartão</option>
                @foreach ($creditCards as $creditCard)
                    <option value="{{ $creditCard->id }}" 
                        {{ old('credit_card_id', $transaction->credit_card_id ?? '') == $creditCard->id ? 'selected' : '' }}>
                        {{ $creditCard->name }} - {{ $creditCard->account->name }}
                    </option>
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
                value="{{ old('installment', $transaction->installment ?? 1) }}"
                required
            />
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label for="category_id" class="form-label fw-bold">Categoria</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">Selecione uma categoria</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id', $transaction->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label for="budget_category_id" class="form-label fw-bold">Categoria do orçamento</label>
            <select name="budget_category_id" id="budget_category_id" class="form-select">
                @foreach ($budgetCategories as $budgetCategory)
                    <option value="{{ $budgetCategory->id }}" 
                        {{ old('budget_category_id', $transaction->budget_category_id ?? '') == $budgetCategory->id ? 'selected' : '' }}>
                        {{ $budgetCategory->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Voltar para contas</a>
</form>
