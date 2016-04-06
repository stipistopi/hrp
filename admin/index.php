<?php
include_once 'includes/config.php';

if (isset($_SESSION["admin_is_auth"])) {
    header('location: admin.php');
    exit;
}

if (isset($_POST['login-submit'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userId = db_getUserId($username);
        $hash = db_getUserHash($userId, $username);

        if ($userId && $hash) {
            if (password_verify($password, $hash)) {
                $_SESSION['admin_is_auth'] = true;
                $_SESSION['admin_userId'] = $userId;
                header('location: admin.php');
                exit;
            } else {
                $message = "Hibás felhasználónév vagy jelszó!";
            }
        } else {
            $message = "Hibás felhasználónév vagy jelszó!";
        }
    } else {
        $message = "Kérjük, írja be felhasználónevét és jelszavát!";
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>HRP - Adminisztráció</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <form class="form-signin" method="post" action="">
        <h2 class="form-signin-heading">Adminisztráció</h2>
        <?php if (isset($message)): ?>
        <h4 class="form-signin-heading text-danger"><?php echo $message ?></h4>
        <?php endif ?>
        <label for="username" class="sr-only">Felhasználónév</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="Felhasználónév..." required
               autofocus>
        <label for="password" class="sr-only">Jelszó</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Jelszó..." required>
        <!-- <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div> -->
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login-submit" id="login-submit">
            Bejelentkezés
        </button>
    </form>
</div>
</body>
</html>
