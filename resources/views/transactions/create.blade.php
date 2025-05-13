<x-layout>
    <x-form title="Nova transação" maxWidth="600px">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <label for="name" class="form-label">Titulo</label>
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
                    <label for="description" class="form-label">Descrição <i class="text-muted">(Opcional)</i></label>
                    <input 
                        autofocus
                        type="text"
                        name="description"
                        id="description"
                        placeholder="Descrição da transação"
                        class="form-control"
                        value="{{ old('description') }}"
                        required
                    />
                </div>
            </div>
            {{-- <div class="row mb-3">
                <div class="col-6">
                    <label for="seasonsQty" class="form-label">Nº Temporadas</label>
                    <input 
                        type="text"
                        name="seasonsQty"
                        id="seasonsQty"
                        placeholder="Nome da série"
                        class="form-control"
                        value="{{ old('seasonsQty') }}"
                        required
                    />
                </div>
                <div class="col-6">
                    <label for="episodesPerSeason" class="form-label">Nº Episodios / Temporada</label>
                    <input 
                        type="text"
                        name="episodesPerSeason"
                        id="episodesPerSeason"
                        placeholder="Nome da série"
                        class="form-control"
                        value="{{ old('episodesPerSeason') }}"
                        required
                    />
                </div>
            </div> --}}
            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
    </x-form>
</x-layout>