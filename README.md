# Sistema de Ordem de Serviços

Sistema desenvolvido em PHP para gerenciamento de serviços, usuários e acompanhamento do status dos serviços. 

## Sobre o projeto 
O gestor da empresa JM Informática decide criar um sistema de ordem de serviços para controlar os serviços prestados pelos seus funcionários. O sistema deve permitir autenticar-se para acesso a tela inicial (dashboard). Na tela inicial deverá mostrar os dados do usuário logado e os serviços prestados. 

## Funcionalidades 
- Cadastro de usuários
- Login e autenticação
- Controle de acesso às páginas autenticadas
- Cadastro, edição, exclusão e finalização de serviços
- Calculo de comissão 
- Listagem de todos os serviços e suas informações
- Listagem de serviços pendentes
- Listagem de servicos recentes
- Filtro de serviços 
- Envio de email apos finalização de um serviço


## Requisitos

- PHP 8.x
- MySQL
- PDO
- PHPMailer
- HTML5
- CSS3

## Configuração

### 1.Banco de dados
Configure as credenciais do banco em: 

    config/database.php

Depois crie o banco utilizando: 

    database/init.php

Popular o banco de dados com um usuario e serviços:
    
    database/create.php


### 2. Email
Configura as credenciais SMTP, para ser usada no serviço responsavel pelo envio de e-mails.

    config/mail.php

### 3. Servidor PHP

O projeto pode ser executado com o servidor embutido do PHP:

    php -S localhost:8000 -t public 