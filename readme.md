# Desafio desenvolvedor back-end

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![Sail](https://img.shields.io/badge/Sail-1.x-red.svg)](https://livewire.laravel.com/)

Esse projeto em Laravel foi desenvolvido para o desafio de desenvolvedor back-end. 

A proposta de desenvolvimento pode ser consultada no repositório de origem:
https://github.com/adooreicheckout/adoorei-teste-backend


## Como configurar?

1. Clone o repositório e acesse o diretório raiz do projeto;
2. Instale as dependências:
   
   ```bash
    composer install
    ```
4. Crie uma cópia do arquivo *.env.example* e renomei para *.env*;
5. Subir containers pelo Laravel Sail:
   ```bash
    ./vendor/bin/sail up -d
    ```
6. Gere uma key para o projeto:
   ```bash
    ./vendor/bin/sail artisan key:generate
    ```
8. Execute as migrations e seeders:
   ```bash
    ./vendor/bin/sail artisan migrate

    ./vendor/bin/sail artisan db:seed
    ```

## Documentação da API

Foi utilizada a biblioteca Swagger para a criação de toda documentação da API.
Para visualizar os endpoints e realizar testes, acessar o seguinte link:
```bash
http://localhost/api/documentation
```

## Testes unitários

Foram desenvolvidos testes unitário com foco nas execução das Controllers.
No diretório raiz do projeto, execute o seguinte comando para iniciar os testes:
```bash
./vendor/bin/sail artisan test --testsuite=Unit
```
