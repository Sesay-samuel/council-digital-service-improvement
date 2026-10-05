<?php

/**
 * Drupal settings for Railway deployment.
 *
 * Database credentials are read from Railway environment variables.
 * No database passwords are stored in this repository.
 */

$databases['default']['default'] = [
  'database' => getenv('MYSQLDATABASE') ?: 'railway',
  'username' => getenv('MYSQLUSER') ?: 'root',
  'password' => getenv('MYSQLPASSWORD') ?: '',
  'host' => getenv('MYSQLHOST') ?: 'mysql.railway.internal',
  'port' => getenv('MYSQLPORT') ?: '3306',
  'driver' => 'mysql',
  'prefix' => '',
  'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
  'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
];

/**
 * Configuration synchronization directory.
 *
 * The project's exported Drupal configuration is stored in /opt/drupal/config.
 */
$settings['config_sync_directory'] = '../config';

/**
 * Allow Railway's reverse proxy to communicate with Drupal.
 */
$settings['reverse_proxy'] = TRUE;
$settings['reverse_proxy_addresses'] = ['127.0.0.1'];

/**
 * Trusted host pattern for the Railway deployment.
 */
$settings['trusted_host_patterns'] = [
  '^council-digital-service-improvement-production\.up\.railway\.app$',
  '^localhost$',
];

/**
 * Hash salt supplied by Railway when configured.
 * Falls back to a non-secret development value for this portfolio deployment.
 */
$settings['hash_salt'] = getenv('DRUPAL_HASH_SALT') ?: 'council-digital-service-improvement';