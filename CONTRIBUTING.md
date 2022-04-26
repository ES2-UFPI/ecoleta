# Ecoleta - API REST 

## Vesão 0.0.1

## Tests
* Para executar os testes do projeto execute:

``` .\vendor\bin\phpunit .\tests\Feature ```

PS1: Foram implementados apenas testes funcionais.
PS2: Os testes utilizam o banco sqlite.

## Migrations
* Para executar as migrations do projeto execute:

``` php artisan migrate ```

* Caso Realize uma alteração nas migrations, realize as alterações nas tabelas existentes e execute o comando abaixo:

``` php artisan migrate:refresh ```

## Seeders
* Seeders necessárias para o projeto. Devem ser executadas na instalação do projeto dentro do servidor.

``` php artisan db:seed --class=States ```
``` php artisan db:seed --class=Cities ```

* Caso seja necessário, utilize os usuários abaixo para testes:

``` php artisan db:seed --class=Client ```
``` php artisan db:seed --class=Company ```

## Como rodar em localhost
* PS1: Para utilizar em localhost você deve ter:
1. php
2. composer
3. mysql

* PS2: Caso queira utlizar outro banco, fique a vontade para fazer, mas configure o arquivo ``` .env ``` de acordo com suas necessidades.

Primeiro, crie o arquivo ``` .env ``` e configure as variáveis de conexão com o banco. Deve ficar semelhante ao exemplo abaixo:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecoleta
DB_USERNAME=root
DB_PASSWORD=root
```

Depois execute o comando:

``` composer install ```

Depois execute os comandos:

``` php artisan key:generate ```
``` php artisan migrate ```
``` php artisan db:seed --class=States ```
``` php artisan db:seed --class=Cities ```

Caso seja necessário, utilize os usuários abaixo para testes:

``` php artisan db:seed --class=Client ```
``` php artisan db:seed --class=Company ```

* PS3: os comandos ``` db:seed ``` devem ser executados apenas uma única vez, caso contrário você terá dados duplicados no banco.

Após isso, execute o servidor:

``` php artisan serve ```

## Como rodar com docker
PS: O projeto possui um pacote chamado Laravel Sail, e o mesmo só roda no MacOs ou Linux de forma nativa. Caso você use o Windows, você deverá instalar o wsl para conseguir rodar o sail com docker.

Crie o arquivo .env e configure-o para tenha as seguintes variáveis:
```
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

Comandos para rodar:

``` ./vendor/bin/sail up ```

Com o serviço rodando, abra outro terminal e execute:

``` ./vendor/bin/sail artisan migrate ```

Após isso, caso seja a primeira vez iniciando o projeto, execute os seeds dentro do banco com o seguinte comando:

``` ./vendor/bin/sail artisan db:seed --class=States ```
``` ./vendor/bin/sail artisan db:seed --class=Cities ```

## Como executar deploy no heroku

Primeiro você deve fazer login com sua conta no heroku.

Após isso você pode executar os seguintes passos:

* Caso você não tenha um app criado:
1. ``` heroku create -a ufpi-ecoleta ```
2. ``` git remote -v ```

* Caso você tenha um app criado:
1. ``` heroku git:remote -a example-app ```
2. ``` git remote rename heroku ufpi-ecoleta ```

Após isso, vá até sua conta e entre no app que você criou. Acesse a área ``` Resources ``` e na aba addons adicione o ```Heroku Postgres  ```. Após fazer isso, acesse o Postgres e vá na aba ``` Settings ``` e clique em ``` View Credentials... ```. Anote todas as variáveis. Volte até o app e acesse agora a aba ``` Settings ``` e clicque em ``` Reveal Config Vars ``` e insira as variáveis do banco que você anotou nessa área. Também insira as variáveis do arquivo .env aqui. Você deverá ter algo assim:

![image](https://user-images.githubusercontent.com/23065588/164526204-c3f0a997-d0a0-4076-88f7-d15186860f88.png)

Por fim, execute o seguinte comando para executar deploy no app:
1. ``` git push heroku main ```

Depois disso, acesse o bash do seu app com o comando:
1. ``` heroku run bash ```

Com o bash do app aberto execute os comandos abaixo:
1. ``` php artisan migrate ```
2. ``` php artisan db:seed --class=States ```
3. ``` php artisan db:seed --class=Cities ```

Caso seja necessário, utilize os usuários abaixo para testes:
1. ``` php artisan db:seed --class=Client ```
2. ``` php artisan db:seed --class=Company ```

Mais tutoriais:
1. [How to Deploy laravel Applications on Heroku](https://gist.github.com/bernie-haxx/84135f548266c4076c29adb1c1b353fc)

## Contribuidores
* [Carlos Meneses]- [DevUnusual](https://github.com/DevUnusual)
* [Filipe Sampaio]- [filipeas](https://github.com/filipeas)
* [Leonidas Pereira]- [leonidasabreu16](https://github.com/leonidasabreu16)
* [Pedro Marques]- [pedromarquex](https://github.com/pedromarquex)
* [Alan Evangelista]- [alanevangelista](https://github.com/alanevangelista)
