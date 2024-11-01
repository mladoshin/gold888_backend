FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    locales \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    supervisor \
    sudo \
    libzip-dev \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && sed -i 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen \
    && sed -i 's/# uk_UA.UTF-8 UTF-8/uk_UA.UTF-8 UTF-8/' /etc/locale.gen \
    && locale-gen

RUN apt-get update && apt-get install -y ffmpeg

# Clear apt cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y --no-install-recommends nodejs

# Set environment variables
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user \
    && chown -R $user:$user /var/www/

# Copy configuration files
COPY ./php.ini /usr/local/etc/php/conf.d/40-custom.ini
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set working directory
WORKDIR /var/www/api

# Set permissions for supervisor logs
RUN mkdir -p /var/log/supervisor \
    && touch /var/log/supervisor/supervisord.log \
    && chown -R $user:$user /var/log/supervisor \
    && chown -R $user:$user /var/run/

# Switch to non-root user
USER $user

# Start Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
