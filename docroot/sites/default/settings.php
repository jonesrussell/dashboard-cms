<?php

// @codingStandardsIgnoreFile

/**
 * @file
 * Drupal site-specific configuration file.
 */

/**
 * Database settings:
 */
$databases = [];

$databases['default']['default'] = [
  'database' => getenv('DB_DATABASE'),
  'username' => getenv('DB_USERNAME'),
  'password' => getenv('DB_PASSWORD'),
  'host' => getenv('DB_HOST'),
  'port' => getenv('DB_PORT'),
  'driver' => getenv('DB_CONNECTION'),
  'prefix' => '',
  'collation' => 'utf8mb4_general_ci',
];

/**
 * @file
 * Example settings to connect to MongoDB.
 *
 * This is the default data to add to your settings.local.php.
 *
 * Using this format instead of raw settings enables easier enabling/disabling
 * of the MongoDB features by just commenting the last line out.
 */

$configureMongoDb = function (array $settings): array {
  $settings['mongodb'] = [
    'clients' => [
      // Client alias => connection constructor parameters.
      'default' => [
        'uri' => 'mongodb://nosql:27017',
        'uriOptions' => [],
        'driverOptions' => [],
      ],
    ],
    'databases' => [
      // Database alias => [ client_alias, database_name ].
      'default' => ['default', 'drupal'],
      'keyvalue' => ['default', 'keyvalue'],
      'logger' => ['default', 'logger'],
    ],
  ];

  return $settings;
};

// @codingStandardsIgnoreLine
$settings = $configureMongoDb($settings);

/**
 * Location of the site configuration files.
 *
 * The $settings['config_sync_directory'] specifies the location of file system
 * directory used for syncing configuration data. On install, the directory is
 * created. This is used for configuration imports.
 *
 * The default location for this directory is inside a randomly-named
 * directory in the public files path. The setting below allows you to set
 * its location.
 */
$settings['config_sync_directory'] = getenv('CMS_CONFIG_SYNC_DIR');

/**
 * Salt for one-time login links, cancel links, form tokens, etc.
 *
 * This variable will be set to a random value by the installer. All one-time
 * login links will be invalidated if the value is changed. Note that if your
 * site is deployed on a cluster of web servers, you must ensure that this
 * variable has the same value on each server.
 *
 * For enhanced security, you may set this variable to the contents of a file
 * outside your document root; you should also ensure that this file is not
 * stored with backups of your database.
 *
 * Example:
 * @code
 *   $settings['hash_salt'] = file_get_contents('/home/example/salt.txt');
 * @endcode
 */
$settings['hash_salt'] = getenv('CMS_KEY');

/**
 * Access control for update.php script.
 *
 * If you are updating your Drupal installation using the update.php script but
 * are not logged in using either an account with the "Administer software
 * updates" permission or the site maintenance account (the account that was
 * created during installation), you will need to modify the access check
 * statement below. Change the FALSE to a TRUE to disable the access check.
 * After finishing the upgrade, be sure to open this file again and change the
 * TRUE back to a FALSE!
 */
$settings['update_free_access'] = FALSE;

/**
 * Default mode for directories and files written by Drupal.
 *
 * Value should be in PHP Octal Notation, with leading zero.
 */
$settings['file_chmod_directory'] = 0775;
$settings['file_chmod_file'] = 0664;

/**
 * Public file base URL:
 *
 * An alternative base URL to be used for serving public files. This must
 * include any leading directory path.
 *
 * A different value from the domain used by Drupal to be used for accessing
 * public files. This can be used for a simple CDN integration, or to improve
 * security by serving user-uploaded files from a different domain or subdomain
 * pointing to the same server. Do not include a trailing slash.
 */
# $settings['file_public_base_url'] = 'http://downloads.example.com/files';

/**
 * Public file path:
 *
 * A local file system path where public files will be stored. This directory
 * must exist and be writable by Drupal. This directory must be relative to
 * the Drupal installation directory and be accessible over the web.
 */
$settings['file_public_path'] = 'sites/default/files';

/**
 * Private file path:
 *
 * A local file system path where private files will be stored. This directory
 * must be absolute, outside of the Drupal installation directory and not
 * accessible over the web.
 *
 * Note: Caches need to be cleared when this value is changed to make the
 * private:// stream wrapper available to the system.
 *
 * See https://www.drupal.org/documentation/modules/file for more information
 * about securing private files.
 */
$settings['file_private_path'] = $app_root . '/../private';

/**
 * Temporary file path:
 *
 * A local file system path where temporary files will be stored. This directory
 * must be absolute, outside of the Drupal installation directory and not
 * accessible over the web.
 *
 * If this is not set, the default for the operating system will be used.
 *
 * @see \Drupal\Component\FileSystem\FileSystem::getOsTemporaryDirectory()
 */
$settings['file_temp_path'] = '/tmp';

/**
 * Configuration overrides.
 *
 * To globally override specific configuration values for this site,
 * set them here. You usually don't need to use this feature. This is
 * useful in a configuration file for a vhost or directory, rather than
 * the default settings.php.
 *
 * Note that any values you provide in these variable overrides will not be
 * viewable from the Drupal administration interface. The administration
 * interface displays the values stored in configuration so that you can stage
 * changes to other environments that don't have the overrides.
 *
 * There are particular configuration values that are risky to override. For
 * example, overriding the list of installed modules in 'core.extension' is not
 * supported as module install or uninstall has not occurred. Other examples
 * include field storage configuration, because it has effects on database
 * structure, and 'core.menu.static_menu_link_overrides' since this is cached in
 * a way that is not config override aware. Also, note that changing
 * configuration values in settings.php will not fire any of the configuration
 * change events.
 */
$config['system.site']['name'] = getenv('CMS_NAME');

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';
$settings['container_yamls'][] = $app_root . '/modules/contrib/redis/example.services.yml';
// dpm($settings['container_yamls']);
//kpr($settings);

/**
 * Trusted hosts patterns
 */
$settings['trusted_host_patterns'] = [
  //    '^www\.example\.com$',
  '^localhost$',
];

/**
 * The default list of directories that will be ignored by Drupal's file API.
 *
 * By default ignore node_modules and bower_components folders to avoid issues
 * with common frontend tools and recursive scanning of directories looking for
 * extensions.
 *
 * @see \Drupal\Core\File\FileSystemInterface::scanDirectory()
 * @see \Drupal\Core\Extension\ExtensionDiscovery::scanDirectory()
 */
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];

/**
 * The default number of entities to update in a batch process.
 *
 * This is used by update and post-update functions that need to go through and
 * change all the entities on a site, so it is useful to increase this number
 * if your hosting configuration (i.e. RAM allocation, CPU speed) allows for a
 * larger number of entities to be processed in a single batch run.
 */
$settings['entity_update_batch_size'] = 50;

/**
 * Entity update backup.
 *
 * This is used to inform the entity storage handler that the backup tables as
 * well as the original entity type and field storage definitions should be
 * retained after a successful entity update process.
 */
$settings['entity_update_backup'] = TRUE;

/**
 * Redis
 *
 * cache and queues
 */
$settings['redis.connection']['interface'] = getenv('REDIS_INTERFACE');
$settings['redis.connection']['host'] = getenv('REDIS_HOST');
$settings['redis.connection']['password'] = getenv('REDIS_PASSWORD');
$settings['redis.connection']['base'] = getenv('REDIS_BASE');
$settings['cache']['default'] = 'cache.backend.redis';
$settings['queue_default'] = 'queue.redis';

/**
 * Flysystem / Minio
 *
 * S3 compatible block storage
 */
$minio_port     = getenv('MINIO_PORT');
$minio_region   = getenv('MINIO_REGION');
$minio_bucket   = getenv('MINIO_BUCKET');
$minio_endpoint = getenv('MINIO_ENDPOINT');
$minio_protocol = parse_url($minio_endpoint, PHP_URL_SCHEME);
$minio_cname    = $minio_protocol . '://localhost:' . $minio_port;
$minio_prefix   = getenv('MINIO_PREFIX');

$schemes = [];

$schemes['s3'] = [];
$schemes['s3']['driver'] = 's3';
$schemes['s3']['cache'] = TRUE;
$schemes['s3']['serve_js'] = TRUE;
$schemes['s3']['serve_css'] = TRUE;
$schemes['s3']['config'] = [
  'key'    => getenv('MINIO_ACCESS_KEY'),
  'secret' => getenv('MINIO_SECRET_KEY'),
  'region' => $minio_region,
  'bucket' => $minio_bucket,
  'endpoint' => $minio_endpoint,
  'protocol' => $minio_protocol,
  'cname_is_bucket' => false,
  'cname' => $minio_cname,
  'use_path_style_endpoint' => TRUE,
  'public' => true,
  'prefix' => $minio_prefix,
];

$settings['flysystem'] = $schemes;

/**
 * Local environment settings
 */
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}

// Automatically generated include for settings managed by ddev.
if (file_exists($app_root . '/' . $site_path . '/settings.ddev.php') && getenv('IS_DDEV_PROJECT') == 'true') {
  include $app_root . '/' . $site_path . '/settings.ddev.php';
}
