FROM drupal:11-apache

# Ensure Apache uses only the prefork MPM.
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork

# Install the MariaDB/MySQL command-line client.
# This is required by Drush database commands such as sql:query and sql:drop.
RUN apt-get update \
    && apt-get install -y --no-install-recommends mariadb-client \
    && rm -rf /var/lib/apt/lists/*

# Install Drush inside the Drupal application image.
RUN composer require drush/drush:^13 --no-interaction

# Install persistent Drupal settings for Railway.
# Database credentials are read from Railway environment variables at runtime.
COPY settings.railway.php /opt/drupal/web/sites/default/settings.php

RUN chown www-data:www-data /opt/drupal/web/sites/default/settings.php \
    && chmod 644 /opt/drupal/web/sites/default/settings.php