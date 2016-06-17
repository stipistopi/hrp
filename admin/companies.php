<?php
$active = "companies";
include 'includes/header.php';

$companies = db_getCompaniesOverview();
?>

<h1 class="page-header">Cégek kezelése</h1>

<table class="table table-striped" style="max-width:550px;">
    <tr>
        <th style="width:70px">ID</th>
        <th>Név</th>
        <th style="width:100px"></th>
    </tr>
    <?php foreach ($companies as $company): ?>
    <tr>
        <td><?php echo $company['id'] ?></td>
        <td><?php echo $company['name'] ?></td>
        <td>
            <a href="editcompany.php?id=<?php echo $company['id'] ?>">Szerkesztés</a>
        </td>
    </tr>
    <?php endforeach ?>
</table>

<?php include 'includes/footer.php' ?>
