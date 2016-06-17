<?php
$active = "cards_overview";
include 'includes/header.php';

$companies = db_getCompaniesOverview();
?>

<h1 class="page-header">Kártyák kezelése</h1>

<table class="table table-striped" style="max-width:650px;">
    <tr>
        <th>Cég neve</th>
        <th style="width:190px">Aktivált / Összes kártyák</th>
        <th style="width:128px"></th>
    </tr>
    <?php foreach ($companies as $company): ?>
        <tr>
            <td><?php echo $company['name'] ?></td>
            <td><?php echo db_getCompanyCardsNum($company['id'], 1) . ' / ' .
                    (db_getCompanyCardsNum($company['id'], 0) + db_getCompanyCardsNum($company['id'], 1)) ?></td>
            <td>
                <a href="cards_edit_company.php?id=<?php echo $company['id'] ?>">Kártyák kezelése</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>

<?php include 'includes/footer.php' ?>
