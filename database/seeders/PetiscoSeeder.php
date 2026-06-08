<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tutor;
use App\Models\Animal;
use App\Models\Servico;
use App\Models\Plano;
use App\Models\PlanoRegra;
use Spatie\Permission\Models\Role;

class PetiscoSeeder extends Seeder
{
    /**
     * Popula o banco com dados de demonstração realistas para o Petisco.
     * Cobre: Roles, Funcionários (Talentos), Tutores, Animais, Serviços e Planos.
     */
    public function run(): void
    {
        // ================================================
        // 1. ROLES (Spatie) — cria se não existirem
        // ================================================
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $cargos = [
            'Atendente',
            'Auxiliar Veterinário',
            'Esteticista / Tosador',
            'Gerente',
            'Veterinário',
            'TI / Desenvolvedor',
        ];

        foreach ($cargos as $cargo) {
            Role::firstOrCreate(['name' => $cargo, 'guard_name' => 'web']);
        }

        $this->command->info('✅ Roles criados.');

        // ================================================
        // 2. FUNCIONÁRIOS (Talentos / Users)
        // ================================================
        $funcionarios = [
            [
                'name'     => 'Dra. Camila Rocha',
                'email'    => 'camila.rocha@petisco.com',
                'cpf'      => '111.222.333-44',
                'celular'  => '(11) 91234-5678',
                'cargo'    => 'Veterinário',
                'crmv'     => 'CRMV-SP 12345',
                'turno'    => 'Manhã',
                'status'   => 'Ativo',
                'password' => 'senha@123',
            ],
            [
                'name'     => 'João Mendes',
                'email'    => 'joao.mendes@petisco.com',
                'cpf'      => '222.333.444-55',
                'celular'  => '(11) 92345-6789',
                'cargo'    => 'Atendente',
                'crmv'     => null,
                'turno'    => 'Tarde',
                'status'   => 'Ativo',
                'password' => 'senha@123',
            ],
            [
                'name'     => 'Larissa Feitosa',
                'email'    => 'larissa.feitosa@petisco.com',
                'cpf'      => '333.444.555-66',
                'celular'  => '(11) 93456-7890',
                'cargo'    => 'Esteticista / Tosador',
                'crmv'     => null,
                'turno'    => 'Manhã',
                'status'   => 'Ativo',
                'password' => 'senha@123',
            ],
            [
                'name'     => 'Rafael Costa',
                'email'    => 'rafael.costa@petisco.com',
                'cpf'      => '444.555.666-77',
                'celular'  => '(11) 94567-8901',
                'cargo'    => 'Gerente',
                'crmv'     => null,
                'turno'    => 'Integral',
                'status'   => 'Ativo',
                'password' => 'senha@123',
            ],
            [
                'name'     => 'Ana Paula Dias',
                'email'    => 'ana.dias@petisco.com',
                'cpf'      => '555.666.777-88',
                'celular'  => '(11) 95678-9012',
                'cargo'    => 'Auxiliar Veterinário',
                'crmv'     => null,
                'turno'    => 'Tarde',
                'status'   => 'Ativo',
                'password' => 'senha@123',
            ],
        ];

        foreach ($funcionarios as $dados) {
            $user = User::updateOrCreate(
                ['email' => $dados['email']],
                [
                    'name'     => $dados['name'],
                    'password' => Hash::make($dados['password']),
                    'cpf'      => $dados['cpf'],
                    'celular'  => $dados['celular'],
                    'cargo'    => $dados['cargo'],
                    'crmv'     => $dados['crmv'],
                    'turno'    => $dados['turno'],
                    'status'   => $dados['status'],
                ]
            );
            $user->syncRoles([$dados['cargo']]);
        }

        $this->command->info('✅ Funcionários criados (senha: senha@123).');

        // ================================================
        // 3. TUTORES
        // ================================================
        $tutores = [
            [
                'nome'        => 'Victor Orlandi',
                'cpf'         => '100.200.300-01',
                'telefone'    => '(11) 98000-1111',
                'email'       => 'victor.orlandi@email.com',
                'cep'         => '01310-100',
                'logradouro'  => 'Avenida Paulista',
                'numero'      => '1578',
                'complemento' => 'Apto 42',
                'bairro'      => 'Bela Vista',
                'cidade'      => 'São Paulo',
            ],
            [
                'nome'        => 'Mariana Souza',
                'cpf'         => '200.300.400-02',
                'telefone'    => '(11) 98000-2222',
                'email'       => 'mariana.souza@email.com',
                'cep'         => '04547-130',
                'logradouro'  => 'Rua Joaquim Floriano',
                'numero'      => '72',
                'complemento' => null,
                'bairro'      => 'Itaim Bibi',
                'cidade'      => 'São Paulo',
            ],
            [
                'nome'        => 'Carlos Eduardo Lima',
                'cpf'         => '300.400.500-03',
                'telefone'    => '(11) 98000-3333',
                'email'       => 'carlos.lima@email.com',
                'cep'         => '05424-150',
                'logradouro'  => 'Rua dos Pinheiros',
                'numero'      => '354',
                'complemento' => 'Casa',
                'bairro'      => 'Pinheiros',
                'cidade'      => 'São Paulo',
            ],
            [
                'nome'        => 'Fernanda Alves',
                'cpf'         => '400.500.600-04',
                'telefone'    => '(11) 98000-4444',
                'email'       => 'fernanda.alves@email.com',
                'cep'         => '22041-001',
                'logradouro'  => 'Rua Farme de Amoedo',
                'numero'      => '90',
                'complemento' => 'Bloco B',
                'bairro'      => 'Ipanema',
                'cidade'      => 'Rio de Janeiro',
            ],
            [
                'nome'        => 'Ricardo Nunes',
                'cpf'         => '500.600.700-05',
                'telefone'    => '(11) 98000-5555',
                'email'       => 'ricardo.nunes@email.com',
                'cep'         => '30140-070',
                'logradouro'  => 'Rua da Bahia',
                'numero'      => '2000',
                'complemento' => null,
                'bairro'      => 'Lourdes',
                'cidade'      => 'Belo Horizonte',
            ],
        ];

        $tutoresIds = [];
        foreach ($tutores as $dados) {
            $tutor = Tutor::updateOrCreate(['cpf' => $dados['cpf']], $dados);
            $tutoresIds[] = $tutor->id;
        }

        $this->command->info('✅ Tutores criados.');

        // ================================================
        // 4. ANIMAIS (1 por tutor)
        // ================================================
        $animais = [
            [
                'nome'       => 'Rex',
                'tutor_id'   => $tutoresIds[0],
                'tipo'       => 'Cão',
                'raca'       => 'Golden Retriever',
                'peso'       => 28.5,
                'nascimento' => '2020-03-15',
                'genero'     => 'M',
                'porte'      => 'G',
                'observacoes'=> 'Alérgico a frango.',
            ],
            [
                'nome'       => 'Mia',
                'tutor_id'   => $tutoresIds[1],
                'tipo'       => 'Gato',
                'raca'       => 'Persa',
                'peso'       => 4.2,
                'nascimento' => '2021-07-22',
                'genero'     => 'F',
                'porte'      => 'P',
                'observacoes'=> 'Necessita ração hipoalergênica.',
            ],
            [
                'nome'       => 'Thor',
                'tutor_id'   => $tutoresIds[2],
                'tipo'       => 'Cão',
                'raca'       => 'Rottweiler',
                'peso'       => 45.0,
                'nascimento' => '2019-11-05',
                'genero'     => 'M',
                'porte'      => 'G',
                'observacoes'=> null,
            ],
            [
                'nome'       => 'Lilica',
                'tutor_id'   => $tutoresIds[3],
                'tipo'       => 'Cão',
                'raca'       => 'Poodle',
                'peso'       => 6.8,
                'nascimento' => '2022-01-30',
                'genero'     => 'F',
                'porte'      => 'P',
                'observacoes'=> 'Muito agitada, usar focinheira.',
            ],
            [
                'nome'       => 'Simba',
                'tutor_id'   => $tutoresIds[4],
                'tipo'       => 'Gato',
                'raca'       => 'Maine Coon',
                'peso'       => 7.1,
                'nascimento' => '2020-09-10',
                'genero'     => 'M',
                'porte'      => 'M',
                'observacoes'=> null,
            ],
        ];

        foreach ($animais as $dados) {
            Animal::updateOrCreate(
                ['nome' => $dados['nome'], 'tutor_id' => $dados['tutor_id']],
                $dados
            );
        }

        $this->command->info('✅ Animais criados.');

        // ================================================
        // 5. SERVIÇOS
        // ================================================
        $servicos = [
            [
                'nome'      => 'Consulta de Rotina',
                'categoria' => 'Consulta',
                'duracao'   => 30,
                'valor'     => 120.00,
                'descricao' => 'Avaliação clínica geral do animal.',
            ],
            [
                'nome'      => 'Vacina V10',
                'categoria' => 'Vacina',
                'duracao'   => 15,
                'valor'     => 85.00,
                'descricao' => 'Vacina polivalente para cães (10 doenças).',
            ],
            [
                'nome'      => 'Vacina Antirrábica',
                'categoria' => 'Vacina',
                'duracao'   => 15,
                'valor'     => 60.00,
                'descricao' => 'Vacina obrigatória contra a raiva.',
            ],
            [
                'nome'      => 'Banho e Tosa Completo',
                'categoria' => 'Estética',
                'duracao'   => 90,
                'valor'     => 95.00,
                'descricao' => 'Banho, secagem, escovação e tosa higiênica.',
            ],
            [
                'nome'      => 'Hemograma Completo',
                'categoria' => 'Exame',
                'duracao'   => 20,
                'valor'     => 140.00,
                'descricao' => 'Exame de sangue para avaliação geral da saúde.',
            ],
        ];

        $servicosIds = [];
        foreach ($servicos as $dados) {
            $servico = Servico::updateOrCreate(['nome' => $dados['nome']], $dados);
            $servicosIds[] = $servico->id;
        }

        $this->command->info('✅ Serviços criados.');

        // ================================================
        // 6. PLANOS DE SAÚDE + REGRAS
        // ================================================
        $planos = [
            [
                'nome'      => 'Plano Bronze',
                'valor'     => 49.90,
                'descricao' => 'Cobertura básica com descontos em consultas e vacinas essenciais.',
                'ativo'     => true,
                'regras'    => [
                    ['servico_id' => $servicosIds[0], 'modalidade' => 'desconto', 'desconto_pct' => 20],
                    ['servico_id' => $servicosIds[1], 'modalidade' => 'desconto', 'desconto_pct' => 10],
                ],
            ],
            [
                'nome'      => 'Plano Prata',
                'valor'     => 89.90,
                'descricao' => 'Consultas inclusas e desconto em exames e estética.',
                'ativo'     => true,
                'regras'    => [
                    ['servico_id' => $servicosIds[0], 'modalidade' => 'incluso',  'desconto_pct' => null],
                    ['servico_id' => $servicosIds[1], 'modalidade' => 'incluso',  'desconto_pct' => null],
                    ['servico_id' => $servicosIds[2], 'modalidade' => 'desconto', 'desconto_pct' => 20],
                    ['servico_id' => $servicosIds[4], 'modalidade' => 'desconto', 'desconto_pct' => 15],
                ],
            ],
            [
                'nome'      => 'Plano Ouro',
                'valor'     => 149.90,
                'descricao' => 'Plano completo: consultas, vacinas e exames 100% inclusos.',
                'ativo'     => true,
                'regras'    => [
                    ['servico_id' => $servicosIds[0], 'modalidade' => 'incluso', 'desconto_pct' => null],
                    ['servico_id' => $servicosIds[1], 'modalidade' => 'incluso', 'desconto_pct' => null],
                    ['servico_id' => $servicosIds[2], 'modalidade' => 'incluso', 'desconto_pct' => null],
                    ['servico_id' => $servicosIds[3], 'modalidade' => 'incluso', 'desconto_pct' => null],
                    ['servico_id' => $servicosIds[4], 'modalidade' => 'incluso', 'desconto_pct' => null],
                ],
            ],
        ];

        foreach ($planos as $dados) {
            $regras = $dados['regras'];
            unset($dados['regras']);

            $plano = Plano::updateOrCreate(['nome' => $dados['nome']], $dados);

            // Recria as regras para evitar duplicatas
            PlanoRegra::where('plano_id', $plano->id)->delete();
            foreach ($regras as $regra) {
                PlanoRegra::create(array_merge($regra, ['plano_id' => $plano->id]));
            }
        }

        $this->command->info('✅ Planos de saúde criados.');
        $this->command->newLine();
        $this->command->line('─────────────────────────────────────────');
        $this->command->info('🎉 PetiscoSeeder concluído com sucesso!');
        $this->command->line('─────────────────────────────────────────');
    }
}
