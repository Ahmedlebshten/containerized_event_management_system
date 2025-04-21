    FROM php:8.1-apache  
    
    RUN docker-php-ext-install mysqli pdo pdo_mysql  
    
    COPY . /var/www/html/Event_Management_System  
    COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf
    
    RUN chown -R www-data:www-data /var/www/html/Event_Management_System  
    
    RUN a2enmod rewrite  
    
    WORKDIR /var/www/html

    CMD ["apache2-foreground"]
    