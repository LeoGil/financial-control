<x-layout title="Faturas" :mensagemSucesso="$mensagemSucesso">
    <a href="{{ route('transactions.create') }}" class="btn btn-success btn-sm fw-bold mb-3">Nova transação</a>
    @if ($statements->isEmpty())
    <p class="text-center text-muted"><i>Nenhuma fatura cadastrada.</i></p>
    @else
    <ul class="list-group">
        @foreach ($statements as $statement)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Fatura atual em <b>R${{ $statement->total_amount }}</b>
                {{-- <div class="float-end d-flex gap-2">
                    <a href="{{ route('series.edit', $serie->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('series.destroy', $serie->id) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </div> --}}
            </li>
        @endforeach
    </ul>
    @endif
</x-layout>