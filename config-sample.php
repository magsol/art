<?php

/**
 * @file
 * A single location to store configuration.
 */

define('CONSUMER_KEY', 'consumer_key');
define('CONSUMER_SECRET', 'consumer_secret');
define('OAUTH_CALLBACK', 'oauth_callback_url');

// Database.
define('DBNAME', 'your_database_name_here');
define('DBUSER', 'your_database_user_here');
define('DBPASS', 'your_database_password_here');
define('DBHOST', 'your_database_host_here');

$conn = @mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (!$conn) {
  echo 'Unable to establish a database connection. Please let me know and check back later.';
  exit;
}
