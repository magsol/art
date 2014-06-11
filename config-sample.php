<?php

/**
 * @file
 * A single location to store configuration.
 */

// Site root.
define('SITE_ROOT', '/twitletic/');
define('SITE_NAME', 'Twitletic');

// Smarty setup.
define('SMARTY_DIR', '/path/to/smarty/libs/');
require_once(SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty();
$smarty->setTemplateDir('/path/to/templates/');
$smarty->setCompileDir('/path/to/compile/');
$smarty->setConfigDir('/path/to/configs/');
$smarty->setCacheDir('/path/to/cache/');
$smarty->assign('SITE_ROOT', SITE_ROOT);
$smarty->assign('SITE_NAME', SITE_NAME);

// Twitter App OAuth information.
define('CONSUMER_KEY', 'consumer_key');
define('CONSUMER_SECRET', 'consumer_secret');
define('OAUTH_CALLBACK', 'oauth_callback_url');

// Database.
define('DBNAME', 'your_database_name_here');
define('DBUSER', 'your_database_user_here');
define('DBPASS', 'your_database_password_here');
define('DBHOST', 'your_database_host_here');

// Encryption.
define('KEY', 'your_encryption_key_here');

$conn = @mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (!$conn) {
  echo 'Unable to establish a database connection. Please let me know and check back later.';
  exit;
}
