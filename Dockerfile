FROM php:8.2-apache

# Copie tous tes fichiers dans /var/www/html
COPY . /var/www/html/

# Donne les droits d'écriture à frape.txt
RUN chmod 666 /var/www/html/frape.txt
