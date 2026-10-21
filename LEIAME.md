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

## Como rodar

Você precisa de **PHP 8.3+** (com a extensão `pdo_sqlite` ativada) e do **Composer**.

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite      # no Windows: type nul > database\database.sqlite
php artisan migrate
php artisan test --filter=LivroServiceTest
```

Para abrir o site no navegador:

```bash
php artisan serve
```

e acesse http://localhost:8000

> **Importante:** não abra os arquivos direto no navegador nem use `htdocs`
> sem configurar. Use sempre `php artisan serve`.

## Problemas comuns

- **`could not find driver`**: ative `extension=pdo_sqlite` no `php.ini`.
- **`vendor/autoload.php` não encontrado**: faltou rodar `composer install`.
- **Erro de chave (`No application encryption key`)**: rode `php artisan key:generate`.

## Estrutura principal

```
app/Models/Livro.php
app/Services/LivroService.php
database/migrations/..._create_livros_table.php
database/factories/LivroFactory.php
tests/Unit/LivroServiceTest.php
```
