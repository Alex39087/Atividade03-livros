<?php

namespace App\Services;

use App\Models\Livro;
use InvalidArgumentException;

class LivroService
{
    private const PRECO_MINIMO = 15.00;

    public function criar(array $dados): Livro
    {
        $this->validarPreco($dados['preco'] ?? null);

        return Livro::create($dados);
    }

    public function atualizar(Livro $livro, array $dados): Livro
    {
        if (array_key_exists('preco', $dados)) {
            $this->validarPreco($dados['preco']);
        }

        $livro->update($dados);

        return $livro;
    }

    private function validarPreco(mixed $preco): void
    {
        if (!is_numeric($preco) || (float) $preco < self::PRECO_MINIMO) {
            throw new InvalidArgumentException(
                'O preço do livro não pode ser menor que R$ ' . number_format(self::PRECO_MINIMO, 2, ',', '.')
            );
        }
    }
}
