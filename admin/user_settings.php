<?php
$active = "index";
include 'includes/header.php';

if (isset($_POST['form-submit'])) {
    $inputCurrentPassword = $_POST['inputCurrentPassword'];
    $userId = $_SESSION['admin_userId'];
    $hash = db_getUserHash($userId, null);
    if (password_verify($inputCurrentPassword, $hash)) {
        db_setUserEmail($userId, $_POST['inputEmail']);
        $newPassword = $_POST['inputNewPassword'];
        $newPasswordVerify = $_POST['inputNewPasswordVerify'];
        if (isset($newPassword) && isset($newPasswordVerify)) {
            if (!strcmp($newPassword, $newPasswordVerify)) {
                $newHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 10]);
                db_setUserHash($userId, $newHash);
            }
        }
        echo 'Adatok sikeresen módosítva!';
        include 'includes/footer.php';
        exit;
    } else {
        echo 'A megadott jelszó érvénytelen!';
        include 'includes/footer.php';
        exit;
    }
}

$currentEmail = db_getUserEmail($_SESSION['admin_userId'], null);
?>

<h1 class="page-header">Felhasználói beállítások</h1>

<form method="post" action="" class="form-horizontal">
    <div class="form-group">
        <label for="inputEmail" class="col-sm-2 control-label">E-mail cím</label>
        <div class="col-sm-10">
            <input type="email" class="form-control"
                   name="inputEmail" id="inputEmail" value="<?php echo $currentEmail ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="inputCurrentPassword" class="col-sm-2 control-label">Jelenlegi jelszó</label>
        <div class="col-sm-10">
            <input type="password" class="form-control"
                   name="inputCurrentPassword" id="inputCurrentPassword" required>
        </div>
    </div>
    <div class="form-group">
        <label for="inputNewPassword" class="col-sm-2 control-label">Új jelszó</label>
        <div class="col-sm-10">
            <input type="password" class="form-control"
                   name="inputNewPassword" id="inputNewPassword">
        </div>
    </div>
    <div class="form-group">
        <label for="inputNewPasswordVerify" class="col-sm-2 control-label">Új jelszó megerősítése</label>
        <div class="col-sm-10">
            <input type="password" class="form-control"
                   name="inputNewPasswordVerify" id="inputNewPasswordVerify">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" name="form-submit">Mentés</button>
        </div>
    </div>
</form>

<?php include 'includes/footer.php' ?>
