<?php
$active = "login";
$color = "magenta";

include_once 'includes/config.php';

if(isset($_SESSION["is_auth"])) {
    header('location: lecke.php');
    exit;
}

if (isset($_POST['login-submit'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userId = db_getUserId($username, null, null);
        $userFirstName = db_getUserFirstName($username, null, null);
        $userLastLogin = db_getUserLastLogin($username, null, null);
        db_updateLastLogin(null, $username, null, null);
        $timeWindowName = db_getUserTimeWindow(null, $username, null, null);
        $hash = db_getUserHash($userId, $username, null, null);

        if ($userId && $hash) {
            if (password_verify($password, $hash)) {
                $_SESSION['is_auth'] = true;
                $_SESSION['userId'] = $userId;
                $_SESSION['userFirstName'] = $userFirstName;
                $_SESSION['userLastLogin'] = $userLastLogin;
                $_SESSION['timeWindowName'] = $timeWindowName;
                if (isset($_POST['remember_me'])) {
                    storeNewAuthToken($userId);
                }
                header('location: lecke.php');
                exit;
            } else {
                $message = "Hibás jelszó!";
            }
        } else {
            $message = "A megadott felhasználónév nem létezik!";
        }
    } else {
        $message = "Kérjük, írja be felhasználónevét és jelszavát!";
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
    <div class="content-right content-right-center">
        <fieldset id="login_fieldset" style="width: 60%;">
            <legend align="center">Bejelentkezés</legend>
            <form method="post" action="">
                <table>
                    <?php if (isset($message)): ?>
                        <tr>
                            <td class="msg" colspan="2" align="center">
                                <div style="background-color:darkred;border-radius:16px;font-weight: bold;color:white;padding:5px 0;">
                                    <?php echo $message ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif ?>
                    <tr>
                        <td width="50%">Felhasználónév:</td>
                        <td width="50%">
                            <input type="text" name="username" id="username" placeholder="peldatomi"
                                   maxlength="100" required autofocus>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">Jelszó:</td>
                        <td width="50%">
                            <input type="password" name="password" id="password" placeholder="jelszó"
                                   maxlength="100" required>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">Emlékezzen rám</td>
                        <td width="50%">
                            <input type="checkbox" name="remember_me" value="1">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" name="login-submit" id="login-submit"
                                   value="Bejelentkezés" title="Bejelentkezés">
                        </td>
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
