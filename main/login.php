<?php
$active = "login";
$color = "magenta";

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
                if (!isset($_SESSION))
                    session_start();
                $_SESSION['is_auth'] = true;
                header('location: lecke.php');
                exit;
            } else {
                $message = "Hibás e-mail cím vagy jelszó!";
            }
        } else {
            $message = "Hibás e-mail cím vagy jelszó!";
        }
    } else {
        $message = "Kérjük, írjon be egy felhasználónevet és jelszót!";
    }
} else if (!empty($_GET['msg'])) {
    $message = "Az interaktív program eléréséhez bejelentkezés szükséges.";
}

include 'includes/header.php';
?>

<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right vertical-padding-10"></div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right">
        <fieldset id="login_fieldset" style="width: 60%;margin:auto;">
            <legend align="center">Bejelentkezés</legend>
            <form method="post" action="">
                <table>
                    <?php
                    if (isset($message))
                        echo "<tr><td class='msg' colspan=\"2\" align=\"center\" style=\"background-color: lightcoral;border-radius: 16px;\">$message</td></tr>";
                    ?>
                    <tr>
                        <td width="50%">E-mail:</td>
                        <td width="50%"><input type="text" name="email" id="email" placeholder="E-mail cím" maxlength="100" autofocus></td>
                    </tr>
                    <tr>
                        <td width="50%">Jelszó:</td>
                        <td width="50%"><input type="password" name="password" id="password" placeholder="Jelszó" maxlength="100"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type="submit" name="login-submit" id="login-submit" value="Bejelentkezés" title="Bejelentkezés"></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div id="uresresz" class="content-right" style="padding: 180px 0;"></div>
</div>

<?php
include 'includes/footer.php';
?>
