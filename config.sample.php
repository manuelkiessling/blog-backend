<?php
define('DB_NAME', 'blog_wordpress');
define('DB_USER', 'blog');
define('DB_PASSWORD', 'Jhd778gh8gzgGTFZTF76346gfwsu3778z783g4g6g');
define('DB_HOST', 'localhost');
define('SECRET_KEY', 'sQFUdc7DoDly02J8U0B1RQNTw23CcJ3yVwnkWtck9l');

#This will disable the update notification.
define('WP_CORE_UPDATE', false);

$table_prefix  = 'wp_';
$server = DB_HOST;
$loginsql = DB_USER;
$passsql = DB_PASSWORD;
$base = DB_NAME;
$upload_path = "/opt/blog-backend/wp-content/uploads";
$upload_url_path = "http://wordpress/wordpress/wp-content/uploads";
?>
