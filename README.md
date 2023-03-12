# Sistema Teste - Ergon
Esse sistema foi desenvolvido como teste técnico, parte do processo seletivo do Grupo Ergon.
A proposta é desenvolver uma espécie de mini rede social, inteiramente web, dentro do nicho de filmes e séries.
## Funcionalidades
Nesse sistema, os usuários podem:
- Fazer cadastro.
	- O usuário insere seus dados no formulário de cadastro e cria seu registro. CPF e e-mail são chaves únicas, não podendo ser cadastrados em duplicidade.
- Fazer login.
	- O usuário insere os dados cadastrados anteriormente na tela de login para entrar no sistema. O sistema então cria uma sessão, que persiste por 120 minutos ou até que o usuário faça logout.
- Acessar o feed central.
	- Uma vez logado, o usuário vai pro feed principal, onde aparecem todas as postagens.
- Acessar o feed dos posts que ele segue.
	- O usuário logado tem acesso ao feed segido, visualizando os post em que ele interagiu.
- Criar post.
	- O usuário pode criar uma postagem sobre um filme ou série. As postagens irão aparecer no feed geral para todos os usuários e no feed de postagens seguidas dos usuários que interagirem com a postagem.
- Apagar post.
	- O usuário pode apagar um post feito por ele, desde que ninguém tenha interagido com o post.
- Marcar post como concluído.
	- O usuário pode marcar um post feito por ele como concluído, impedindo assim que interajam com o post.
## Utilização
Para utilização do sistema, o responsável pelo teste deve baixar os arquivos e ligar o Apache em um servidor local (XAMPP recomendado).
Com isso, basta acessar a pasta do sistema através do navegador (localhost/teste-ergon/).
### Login
Insira os dados cadastrados (e-mail e senha) e clique em "Entrar" para ser direcionado ao feed.
### Cadastro
Clique no botão cinza "Cadastro", encontrado em baixo à esquerda do login, para ser direcionado para a página de cadastro. Insira os dados do usuário a ser cadastrado e clique em "Cadastrar Usuário" para registrá-lo. O botão "Voltar", encontrado em baixo à esquerda do cadastro, retorna à tela de login.
### Feed Geral
No feed, que funciona como página inicial quando já existe um usuário logado (verificado através da sessão), pode-se ver os posts que existem na rede. O usuário pode interagir com qualquer um deles, marcando para seguir e recomendando ou não o filme ou série em questão. Além disso, ele pode criar novos posts clicando no botão azul no canto inferior direito, "Criar Post". Pode também marcar seus posts como concluídos, bloqueando interações, ou excluir um post que seja seu e que não tenha interações.
### Feed Seguindo
Clicando em "Seguindo", na barra de navegação no topo da tela, o usuário é direcionado à um feed que mostra apenas os posts com os quais ele interagiu, seja clicando para seguir, para recomendar ou não recomendar. Além disso, ele pode criar novos posts clicando no botão azul no canto inferior direito, "Criar Post". Pode também marcar seus posts como concluídos, bloqueando interações, ou excluir um post que seja seu e que não tenha interações.
### Logout
O usuário pode fazer logout clicando no botão vermelho "Logout", no topo direito da tela. Isso encerra a sessão e redireciona para a tela de login.
## Desenvolvimento
O sistema foi desenvolvido inteiramente para web, utilizando HTML, CSS + Bootstrap e JavaScript + jQuery para o front-end, adicionalmente com ícones gratuitos do Font Awesome (fontawesome.com/search?m=free), e PHP para o back-end. Os dados do sistema são gravados localmente em formato JSON, substituindo um banco de dados externo. Também foi utilizado AJAX para que o front-end e o back-end trabalhassem em conjunto. Durante o desenvolvimento, foi utilizando o XAMPP como servidor para possibilitar a execução de scripts PHP de forma local.
### Desenvolvedor
![Athos Fernandez - Desenvolvedor Web](https://media.licdn.com/dms/image/C4D03AQF_vLdhTsgcjw/profile-displayphoto-shrink_200_200/0/1649098300048?e=1683763200&v=beta&t=xc2fz6CvFoTf19p8Y7DUOJNhV5wGw0uHfNx7xsDNUCY "Athos Fernandez - Desenvolvedor Web")
Athos Fernandez
Curitiba - PR
(41) 99769-3058
athos@docsa.com.br
www.linkedin.com/in/athos-fernandez-818813171/