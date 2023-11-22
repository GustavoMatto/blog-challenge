Instalação
Para este projeto estamos utilizando docker v24.0.6 e composer v2.6.5 e PHP 8.1 com nginx.

Após baixar o projeto do Github https://github.com/GustavoMatto/blog-challenge , crie uma a pasta "desafiobis2bis" para armazena-lo. Feito isso, devemos baixar e iniciar nossos containers com o comando "docker-compose up -d". Como nosso projeto utiliza composer, será necessário acessar o container do PHP para executar a instalação das dependencias do projeto. Para acessar o container devemos utilizar o comando "docker exec -it <nome_do_container> sh", assim que acessado, executamos o comando "composer install".

Após os passos acima o ambiente já deve funcionar. Existe um dump da nossa base de dados de teste em MysqlDump. As configurações de ambiente podem ser encontradas no arquivo docker-compose.yml.

Geral
Trata-se de um blog simples: Em sua tela inicial (Home) serão carregados os posts de acordo com os registros no banco de dados. "About Us" é apenas uma tela onde pode ser adicionado algum conteudo sobre o blog. Register é a nossa tela de registro, o usuário apenas pode cadastrar o seu user name e senha, ele possui também o campo "Roles" que armazena seu usuário. Log in a tela de login para o usuário já cadastrado. Após logado teremos as páginas: Post onde os usuários logados podem fazer seus posts Account onde podemos alterar o nosso nome de usuário ou excluir-lo A dashboard que seria como uma "Home" após o login Caso o usuário seja administrador: Terá acesso a tela de administração que contém o botão onde o backup (dump) é gerado. Gerenciamento de usuário, onde pode se ver todos os usuários cadastrados, atualizar seu nome de usuário e permissão de acesso, ou exclui-los. Gerenciamento de posts aqui é possível ver os posts já feitos, edita-los ou exclui-los.

Usuario
O usuário admin possui a senha admin. Apenas ele foi criado com permissão administrativa, podendo ceder para os demais usuários.

Funcionalidades
O projeto foi desenvolvido para atender aos requisitos:

Sistema de rotas para acessar a página inicial, página de post e página administrativa, e outras se achar necessário.
Sistema de gerenciamento de permissões(ACL).
Usuário Visitante e administrador (CRUD).
Gerenciamento dos posts(CRUD).
Sistema de backup, o sistema deve permitir gerar um dump da base por dentro do painel administrativo.
Considerações finais
Foi restringido posts apenas para usuários logados.

O projeto foi todo desenvolvido com rotas e permissões. Apesar de um simples sistema de Acl validamos todas as páginas administrativas para que somente possa acessa-las, caso esteja cadastrado como administrador.

Pensamos em uma maneira de desenvolver onde o código pudesse ser implementado em um futuro, prezando manter o mais organizado possível. Então há um potêncial para ajustes e evolução do conteúdo apresentado.

TODO
Houve um problema ao gerar o backup através do código, possivelmente algo relacionado ao ambiente, apensar das analises ainda não foi possível ajustar. O projeto foi desenvolvido em wsl com distro 20.04.6.

Foi possível gerar o dump apenas pelo terminal após a instalção de "apt install mysql-client-core-8.0" comando executado no terminal "mysqldump -h 127.0.0.1 -P 8002 -uroot --password=admin123 blogdatabase > ./MysqlDump/dump.sql".
