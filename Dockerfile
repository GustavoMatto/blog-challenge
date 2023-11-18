# Imagem PHP 8.1 com o Apache
FROM php:8.1-apache

# Instalação Mysql
RUN docker-php-ext-install mysqli pdo_mysql

# Diretório container
COPY . /var/www/html/

# Configuração de porta
EXPOSE 80

# Inicializa Apache
CMD ["apache2-foreground"]
