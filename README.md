# Atividade Avaliativa - CRUD Mundo

**Nome do Aluno(a):** Bruno Oliveira
**Nome do Projeto:** CRUD Mundo
**Tecnologias Utilizadas:** HTML, CSS, PHP (com MySQLi), JavaScript
**Descrição Detalhada do Projeto:**

Este projeto é uma aplicação web simples desenvolvida para a atividade avaliativa de Programação Web, conforme as especificações do documento "Atividade_Avaliativa__CRUD_Mundo.pdf".

A aplicação implementa as operações CRUD (Create, Read, Update, Delete) para duas entidades: **Países** e **Cidades**, mantendo um relacionamento de 1:N (um país pode ter várias cidades). O foco foi na simplicidade, funcionalidade e na correta utilização das tecnologias solicitadas (HTML, CSS, PHP e JavaScript).

## Funcionalidades Implementadas

*   **Gerenciamento de Países:** Cadastro, listagem, edição e exclusão de países.
*   **Gerenciamento de Cidades:** Cadastro, listagem, edição e exclusão de cidades, com associação obrigatória a um país existente (chave estrangeira).
*   **Integridade Referencial:** A exclusão de um país é impedida caso existam cidades associadas a ele, conforme requisito.
*   **Integração com API (Desafio Extra):**
    *   **REST Countries:** Exibe detalhes adicionais (capital, moeda, bandeira) de um país ao clicar no botão "Ver Detalhes" na listagem de Países.
    *   **OpenWeatherMap:** Exibe informações climáticas (temperatura, descrição) de uma cidade ao clicar no botão "Ver Clima" na listagem de Cidades.
*   **Interface:** Interface simples e responsiva com HTML e CSS.
*   **Interação:** Uso de JavaScript para confirmação de exclusão e para as chamadas AJAX das APIs.

## Instruções de Instalação e Uso (XAMPP)

Para rodar este projeto, você deve ter o **XAMPP** instalado e configurado.

### 1. Configuração do Banco de Dados

1.  Inicie os módulos **Apache** e **MySQL** no painel de controle do XAMPP.
2.  Acesse o **phpMyAdmin** no seu navegador (geralmente em `http://localhost/phpmyadmin`).
3.  Importe o arquivo `bd_mundo.sql` que está na raiz do projeto.
    *   Alternativamente, você pode criar o banco de dados `bd_mundo` e executar o conteúdo do arquivo `bd_mundo.sql` na aba SQL.

### 2. Configuração do Projeto

1.  Copie a pasta `crud_mundo` inteira para o diretório `htdocs` do seu XAMPP (ex: `C:\xampp\htdocs\`).
2.  O arquivo de conexão (`includes/conexao.php`) já está configurado com as credenciais padrão do XAMPP. Se suas credenciais forem diferentes, edite este arquivo.

### 4. Acesso à Aplicação

1.  Abra seu navegador e acesse: `http://localhost/crud_mundo/`
2.  A página inicial listará os países. Você pode navegar para a seção de Cidades através do menu superior.

**Observação:** O projeto já inclui alguns dados de exemplo (Países e Cidades) para facilitar o teste inicial.