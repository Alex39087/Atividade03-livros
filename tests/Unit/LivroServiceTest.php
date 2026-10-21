<?php

namespace Tests\Unit;

use App\Models\Livro;
use App\Services\LivroService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class LivroServiceTest extends TestCase
{
    use RefreshDatabase;

    private LivroService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new LivroService();
    }

    public function test_nao_cria_livro_com_preco_abaixo_do_minimo(): void
    {
        try {
            $this->service->criar([
                'titulo' => 'Dom Casmurro',
                'autor' => 'Machado de Assis',
                'preco' => 9.90,
            ]);
            $this->fail('Era esperada uma InvalidArgumentException.');
        } catch (InvalidArgumentException $e) {
            $this->assertDatabaseMissing('livros', ['titulo' => 'Dom Casmurro']);
        }
    }

    public function test_cria_livro_com_preco_valido(): void
    {
        $livro = $this->service->criar([
            'titulo' => 'Dom Casmurro',
            'autor' => 'Machado de Assis',
            'preco' => 29.90,
        ]);

        $this->assertDatabaseHas('livros', [
            'id' => $livro->id,
            'titulo' => 'Dom Casmurro',
        ]);
    }

    public function test_atualiza_livro_com_sucesso(): void
    {
        $livro = Livro::factory()->create([
            'titulo' => 'O Cortiço',
            'preco' => 20.00,
        ]);

        $atualizado = $this->service->atualizar($livro, [
            'titulo' => 'O Cortiço (Edição Especial)',
            'preco' => 45.00,
        ]);

        $this->assertEquals('O Cortiço (Edição Especial)', $atualizado->titulo);
        $this->assertEquals(45.00, $atualizado->preco);

        $this->assertDatabaseHas('livros', [
            'id' => $livro->id,
            'titulo' => 'O Cortiço (Edição Especial)',
            'preco' => 45.00,
        ]);
    }

    public function test_nao_atualiza_livro_com_preco_abaixo_do_minimo(): void
    {
        $livro = Livro::factory()->create([
            'titulo' => 'Capitães da Areia',
            'preco' => 60.00,
        ]);

        try {
            $this->service->atualizar($livro, ['preco' => 5.00]);
            $this->fail('Era esperada uma InvalidArgumentException.');
        } catch (InvalidArgumentException $e) {
            $this->assertDatabaseHas('livros', [
                'id' => $livro->id,
                'preco' => 60.00,
            ]);
        }
    }
}
