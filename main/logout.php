<?php
session_start();
unset($_SESSION['is_auth']);
session_destroy();
header("location: about.php");
exit;
