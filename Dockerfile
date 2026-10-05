FROM drupal:11-apache

# Install Drush inside the Drupal application image.
# This makes Drupal CLI/configuration-management tooling
# available whenever the container is rebuilt.
RUN composer require drush/drush:^13 --no-interaction