<?php
$active = "login";

include 'includes/header.php';
include 'includes/configHRP.php';

if (isset($_POST['login-submit'])) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT jelszo
                                FROM felhasznalo
                                WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $ret = $stmt->execute();

        $hash = $stmt->fetchColumn();

        if ($hash) {
            if (password_verify($password, $hash)) {
                $_SESSION['is_auth'] = true;
                //header('location: index.php');
                $error = "Sikeres bejelentkezés.";
                //exit;
            } else {
                $error = "Hibás e-mail cím vagy jelszó.";
            }
        } else {
            $error = "Hibás e-mail cím vagy jelszó.";
        }
    } else {
        $error = "Kérjük írjon be egy felhasználónevet és jelszót.";
    }
}
?>

<form method="post" action="">
    <div>
        <?php
        if (isset($error)) {
            echo "<div class='errormsg'>$error</div>";
        }
        ?>
        <div>
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" placeholder="E-mail cím" maxlength="100">
        </div>
        <div>
            <label for="password">Jelszó:</label>
            <input type="password" name="password" id="password" placeholder="Jelszó" maxlength="100">
        </div>

        <div>
            <input type="submit" name="login-submit" id="login-submit" value="Bejelentkezés" title="Bejelentkezés">
        </div>
    </div>
</form>
