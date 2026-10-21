# Atividade 03 – Livros (Service Layer + Testes)

Projeto em **Laravel** que mostra como separar a regra de negócio em uma
camada de serviço e como testá-la com testes unitários.

## O que ele faz

- `LivroService` cria e atualiza livros.
- Regra de negócio: **nenhum livro pode custar menos de R$ 15,00**.
  Se o preço for menor, o serviço lança `InvalidArgumentException` e nada é salvo.
- Os testes (`tests/Unit/LivroServiceTest.php`) cobrem:
  1. criar livro com preço inválido (deve dar erro e não salvar);
  2. criar livro com preço válido;
  3. atualizar livro com sucesso;
  4. atualizar com preço inválido (deve dar erro e manter os dados originais).
