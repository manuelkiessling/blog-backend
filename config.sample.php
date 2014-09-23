<?php
define('DB_NAME', 'wordpress');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');
define('SECRET_KEY', 'sQFUdc7DoDly02J8U0B1RQNTw23CcJ3yVwnkWtck9l');

#This will disable the update notification.
define('WP_CORE_UPDATE', false);

$table_prefix  = 'wp_';
$server = DB_HOST;
$loginsql = DB_USER;
$passsql = DB_PASSWORD;
$base = DB_NAME;
$upload_path = "/var/www/wordpress/wp-content/uploads";
$upload_url_path = "http://wordpress/wordpress/wp-content/uploads";
?>
