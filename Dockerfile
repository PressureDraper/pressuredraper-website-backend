# Imagen base de PHP con CLI
FROM php:8.2-cli

# Instala dependencias del sistema necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    curl

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece el directorio de trabajo
WORKDIR /app

# Copia archivos del proyecto
COPY . .

# Instala dependencias PHP
RUN composer install --prefer-dist --no-dev --optimize-autoloader

# Expone el puerto que usará el servidor embebido
EXPOSE 8085

# Comando para iniciar el servidor
CMD ["php", "-S", "0.0.0.0:8085", "-t", "public"]
