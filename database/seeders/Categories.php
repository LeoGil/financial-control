<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            'Alimentação',
            'Assinaturas',
            'Compras e lazer',
            'Educação e desenvolvimento',
            'Emergências',
            'Empréstimos',
            'Entretenimento digital',
            'Hobbies e atividades de lazer',
            'Impostos e taxas',
            'Investimentos',
            'Manutenção e reparos',
            'Moradia',
            'Outros',
            'Renda',
            'Saúde e bem-estar',
            'Seguros',
            'Serviços financeiros e bancários',
            'Streaming',
            'Transferências e pagamentos',
            'Transporte',
            'Viagem',
        ];

        foreach ($categories as $name) {
            DB::table('categories')->insert([
                'name' => $name,
                'user_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
