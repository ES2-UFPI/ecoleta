# Ecoleta - API REST

## Vesão 0.0.1

## Seeders
* Seeders necessárias para o projeto. Devem ser executadas na instalação do projeto dentro do servidor.
``` php artisan db:seed --class=States ```
``` php artisan db:seed --class=Cities ```

## Como rodar com docker
PS: O projeto possui um pacote chamado Laravel Sail, e o mesmo só roda no MacOs ou Linux de forma nativa. Caso você use o Windows, você deverá instalar o wsl para conseguir rodar o sail com docker.

Comandos para rodar:

``` ./vendor/bin/sail up ```

Com o serviço rodando, abra outro terminal e execute:

``` ./vendor/bin/sail artisan migrate ```

Após isso, caso seja a primeira vez iniciando o projeto, execute os seeds dentro do banco com o seguinte comando:

``` ./vendor/bin/sail artisan db:seed --class=States ```
``` ./vendor/bin/sail artisan db:seed --class=Cities ```

## Contribuidores
* [Carlos Meneses]- [DevUnusual](https://github.com/DevUnusual)
* [Filipe Sampaio]- [filipeas](https://github.com/filipeas)
* [Leonidas Pereira]- [leonidasabreu16](https://github.com/leonidasabreu16)
* [Pedro Marques]- [pedromarquex](https://github.com/pedromarquex)
* [Alan Evangelista]- [alanevangelista](https://github.com/alanevangelista)
