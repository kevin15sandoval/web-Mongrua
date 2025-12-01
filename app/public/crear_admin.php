<?php
require_once('wp-load.php');

$username = 'adminlocal';
$password = '12345';
$email = 'admin@mongruas.local';

if (username_exists($username)) {
  echo "El usuario ya existe.";
} else {
  $user_id = wp_create_user($username, $password, $email);
  $user = new WP_User($user_id);
  $user->set_role('administrator');
  echo "Usuario creado: $username / $password";
}
?>
