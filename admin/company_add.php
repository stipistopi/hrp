<?php
include_once 'includes/config.php';

if (isset($_POST['submit'])) {
    db_addCompany($_POST['company-name']);
    $data = db_getCompanyData(null, $_POST['company-name']);
    $id = $data['id'];
    $location = "http://www.hrp-interaktiv.hu/admin/editcompany.php?id=" . $id;
    header("Location: " . $location);
}

$active = "company_add";
include 'includes/header.php';
?>

<h1 class="page-header">Cég hozzáadása</h1>

<form method="post" action="" class="row">
    <div class="form-group row">
        <div class="col-sm-4">
            <label for="companyName">Cégnév</label>
            <input type="text" class="form-control" id="companyName" name="company-name" placeholder="Cég neve...">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-1">
            <button type="submit" class="btn btn-default" name="submit">Tovább</button>
        </div>
    </div>
</form>

<?php include 'includes/footer.php' ?>
