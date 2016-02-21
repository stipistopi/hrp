<?php
$dir = dirname(__FILE__);
echo "<p>Full path to this dir: " . $dir . "</p>";
echo "<p>Full path to a .htpasswd file in this dir: " . $dir . "/.htpasswd" . "</p>";
echo "<p>User: " . $_SERVER['REMOTE_USER'] . "." . "</p>";
//echo "<p>User: " . $_SERVER['PHP_AUTH_USER'] . "." . "</p>";
//echo "<p>Password: " . $_SERVER['PHP_AUTH_PW'] . "." . "</p>";
?>