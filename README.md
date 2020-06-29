# API LARAVEL PARA SERVIR CADASTRO DE FILMES
Autor: Fernando Bino Machado<br>
e-mail: fernando.bino.machado@gmail.com<br>
Descrição: Exemplo de API REST com Laravel, trabalhando com os 4 principais verbos HTTP

Observação: Versão Beta ;)
Está sujeita a refatoramento de código!!

<h1>Instruções</h1>

<h5>1 - git clone https://github.com/devBino/apiFilmes.git</h5>
<h5>2 - Rode o comando cd apiFilmes/apiFilmes</h5>
<h5>3 - Criar e Configurar arquivo .env </h5>
<p>Aviso! Configure o .env com muita atenção porque as próximas etapas de configuração bem como o funcionamento da aplicação dependem dessa configuração...</p>
<hr>
# INICIO DO .env
<p>
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:dBe/QHQmD8mldjG0ldrRUSJKn7sx9azdKn08+Gs7mNU=
APP_DEBUG=true
APP_URL=http://localhost
</p><br>
<p>
LOG_CHANNEL=stack
<br>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apiFilmes
DB_USERNAME={seu usuario de conexão do banco local}
DB_PASSWORD={sua senha de conexão do banco local}
</p><br>
<p>
BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
</p><br>
<p>
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
</p><br>
<p>
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME={coleque o email da aplicação}
MAIL_PASSWORD={coloque a senha desse email}
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS={coleque o email da aplicação}
MAIL_FROM_NAME="Api Filmes Magic Design"
SMTP_DEBUG=false
</p><br>
<p>
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
</p><br>
<p>
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1
</p><br>
<p>
MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
</p><br>
<p>
KEY_APP_API = 2f3a4fccca6406e35bcf33e92dd93135
API_PORT = 8000
TEMPO_TOKEN_API = 300

API_DOC = https://documenter.getpostman.com/view/9798213/SzzrZaEr?version=latest
</p><br>
# FIM DO .env
</hr>

<h5>4 - Acesse seu Workbench ou PhpMyadmin e crie o banco de dados com o seguinte comando</h5>
    <p>create database apiFilmes;</p>

<h5>5 - Rodar comandos com php artisan, exatamente na sequencia abaixo</h5>
    <p>composer install</p>
    <p>php artisan migrate</p>
    <p>php artisan db:seed</p>
    <p>php artisan serv</p>
    <p>Após essa sequencia de comandos acesse http://localhost:8000/</p>

<h5>6 - Confirme seu acesso no Email você recebeu como admin uma mensagem que devera ser confirmada, clique no link Confirmar
    Você será redirecionado para uma url parecida com isso</h5>
    <p>http://localhost:8000/usuarioAutorizacao/admin/b54bbbc63b0d0d3f10ddba78adbb226dd2d48c82/7aaeaa87c842946f346dd80049a4ac1de1a3b5f2</p><br>
    <p>o que estiver depois da última barra será o seu token</p><br>
    <p>Nesse exemplo temos os dados de acesso a API da seguinte maneira:</p><br>
    <p>usuario = admin</p><br>
    <p>senha = admin</p><br>
    <p>token = 7aaeaa87c842946f346dd80049a4ac1de1a3b5f2</p><br>
    

<h5>7 - Documentação da API</h5>
<p><center><a href="https://documenter.getpostman.com/view/9798213/SzzrZaEr?version=latest" target="_blank">Documentação API</a></center></p>

<h5>8 - Informações Adicionais em: http://localhost:8000/documentacao</h5>

<hr>
<h5><b>OBSERVAÇÃO:</b<h5>
<p>Esse projeto precisa que o Redis esteja instalado no Sistema Operacional</p>