<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            [
                'name' => 'Moradia',
                'description' => 'Aluguel, condomínio, contas de luz, água, gás e manutenção da casa',
            ],
            [
                'name' => 'Transporte',
                'description' => 'Combustível, passagens, Uber, manutenção e seguro do veículo',
            ],
            [
                'name' => 'Alimentação',
                'description' => 'Compras de supermercado, padaria, intens de despensa (essencial)',
            ],
            [
                'name' => 'Delivery & Restaurantes',
                'description' => 'Pedidos de comida por aplicativo e refeições fora de casa',
            ],
            [
                'name' => 'Saúde & Bem-Estar',
                'description' => 'Plano de saúde, medicamentos, consultas e academia',
            ],
            [
                'name' => 'Lazer & Hobbies',
                'description' => 'Cinema, shows, cursos, esportes, viagens e atividades de lazer',
            ],
            [
                'name' => 'Streaming & Digital',
                'description' => 'Netflix, Spotify, apps pagos, jogos e entretenimento digital',
            ],
            [
                'name' => 'Assinaturas & Mensalidades',
                'description' => 'Software, clubes de livro, academia e serviços por assinatura',
            ],
            [
                'name' => 'Empréstimos & Financiamentos',
                'description' => 'Parcelas de empréstimos, financiamentos e consórcios',
            ],
            [
                'name' => 'Tarifas & Taxas',
                'description' => 'Tarifas bancárias, impostos, IOF e demais taxas',
            ],
            [
                'name' => 'Investimentos',
                'description' => 'Aportes, corretagem e aplicações financeiras',
            ],
            [
                'name' => 'Emergências',
                'description' => 'Gastos imprevistos, reparos urgentes e multas',
            ],
            [
                'name' => 'Outros',
                'description' => 'Despesas que não se encaixam em outras categorias',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'user_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
