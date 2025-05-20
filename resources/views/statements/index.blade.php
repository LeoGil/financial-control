<x-layout title="Faturas" :mensagemSucesso="$mensagemSucesso">
    <a href="{{ route('accounts.index') }}" class="btn btn-sm btn-secondary">Voltar para contas</a>
    @if ($statements->isEmpty())
        <p class="text-center text-muted"><i>Nenhuma fatura cadastrada.</i></p>
    @else
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Valor Total</th>
                        <th>Vencimento</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statements as $statement)
                        @php
                            $badgeData = match($statement->status) {
                                'open' => ['text-bg-primary', 'Aberta'],
                                'closed' => ['text-bg-secondary', 'Fechada'],
                                'paid' => ['text-bg-success', 'Paga'],
                                'overdue' => ['text-bg-danger', 'Vencida'],
                                'upcoming' => ['text-bg-warning', 'Proxima'],
                                default => ['text-bg-light', 'Desconhecido']
                            };
                        @endphp
                        <tr>
                            <td><strong>R${{ number_format($statement->total_amount, 2, ',', '.') }}</strong></td>
                            <td>{{ $statement->due_date->format('d/m/Y') }}</td>
                            <td><span class="badge fw-light {{ $badgeData[0] }}">{{ $badgeData[1] }}</span></td>
                            <td class="text-center">
                                @if ($statement->status !== 'paid')
                                <form action="{{ route('accounts.statements.pay', [$statement->account_id, $statement->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja realmente pagar essa fatura?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i> Pagar
                                    </button>
                                </form>
                                @endif
                                <a href="{{ route('accounts.statements.installments.index', [$statement->account_id, $statement->id]) }}" class="btn btn-sm btn-primary">Transações</a>
                                <!-- outros botões se necessário -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-layout>
