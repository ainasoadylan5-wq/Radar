FROM php:8.2-apache

# Copier tous tes fichiers dans le dossier web
COPY . /var/www/html/

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80
EXPOSE 80
