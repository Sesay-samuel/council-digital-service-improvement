FROM drupal:11-apache

# Ensure Apache uses only the prefork MPM.
# Some container hosting environments can result in multiple MPMs
# being enabled, which prevents Apache from starting.
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork

# Install Drush inside the Drupal application image.
# This makes Drupal CLI/configuration-management tooling
# available whenever the container is rebuilt.
RUN composer require drush/drush:^13 --no-interaction