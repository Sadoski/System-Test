# System Test

Sistema Web e API simples de cadastro de empresas e usuários. 

## Inicialização do sistema.

Sistema construido com o framework Laravel 8, e utilizando o Laragon para o ambiente de desenvolvimento.

- 1. Baixar o projeto `git clone https://github.com/Sadoski/System-Test.git`
- 2. Criar as configurações do banco conforme no arquivo .env ou modificar conforme queira.
- 3. Abrir a teminal na pasta do projeto `php artisan migrate --seend`, este comando ira as tabelas e inserir dados padrão no bando de dados.
- 4. Para que a localização via Latitude e Longitude seja mostrada na visualição do registro dever ser configurado no arquivo .env a tag "GOOGLE_MAPS_API_KEY", para ter essa chave acesse o site `https://console.cloud.google.com/google/maps-apis/overview` faça seu registro ou acesse sua conta google, insira informações de faturamento e em Credencias cria sua Chave de API.


## Padrão do sistema.

Tipos de empresa padrão.

- Matriz ID 1
- Filial ID 2

Ao acessar o sistema pelo navegador, será aberto a janela de login.

- E-mail: admin@systemtest.com.br
- Senha: admin
    

O sistema é composto apenas de duas permissões "ADMINISTRADOR" e "USUARIO".
    
**ADMINISTRADOR**
- Cadatrar empresas matriz e filiais, e usuário.
    
**USUARIO**
- Cadastra empresas filiais.

Para a API é nescessario fazer a requisição do token para inserir dados via API.

Configurado no Apache o endereço `systemtest.test` (Opcional).
- systemtest.test/api/login
- systemtest.test/api/login/login-refresh
- systemtest.test/api/empresa
- systemtest.test/api/empresa/cadastrar
- systemtest.test/api/empresa/editar/{id}
- systemtest.test/api/empresa/deletar/{id}
- systemtest.test/api/usuario
- systemtest.test/api/usuario/cadastrar
- systemtest.test/api/usuario/editar/{id}
- systemtest.test/api/usuario/deletar/{id}
    
Pode ser feito a requisição do Token inserindo os dado do login acima informado `systemtest.test/api/login?email=admin@systemtest.com.br&password=admin`