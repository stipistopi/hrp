<?php
$active = "add_cards";
include 'includes/header.php';

$msg = null;
$err = null;
if (isset($_POST['add-submit'])) {
    $start = $_POST['start'];
    $end = $start + $_POST['quantity'] - 1;
    if (db_isCardRangeFree($start, $end)) {
        $company = db_getCompanyData(null, $_POST['company']);
        if ($company !== FALSE) {
            $companyId = $company['id'];
            $ret = db_addCardRange($start, $end, $companyId, 0);
            if ($ret === TRUE) {
                $msg = "Sikeres hozzáadás.";
            } else {
                $err = "Hiba a hozzáadás során!";
            }
        } else {
            $err = "Érvénytelen cég!";
        }
    } else {
        $err = "A kiválasztott intervallum érvénytelen!";
    }
}

if ($err)
    echo '<h4 style="color:red">' . $err . '</h4>' . '<br>';

if ($msg)
    echo '<h4>' . $msg . '</h4>' . '<br>';

$freeRanges = db_getFreeCardRanges();

$cardIds = db_getAllCardIds();
$companies = db_getCompaniesOverview();
?>

<datalist id="companies">
    <?php foreach ($companies as $company): ?>
        <option value="<?php echo $company['name'] ?>">
    <?php endforeach; ?>
</datalist>

<form method="post" action="" class="form-inline">
    <div class="form-group">
        <label for="start">Kezdőérték</label>
        <input type="number" class="form-control" style="width:115px;" name="start" id="start"
               min="10000000"
               max="99999999"
               value="<?php echo $cardIds[count($cardIds) - 1]['id'] + 1; ?>">
    </div>
    <div class="form-group">
        <label for="quantity">Darabszám</label>
        <input type="number" class="form-control" style="width:100px;" name="quantity" id="quantity"
               min="1"
               value="1">
    </div>
    <div class="form-group">
        <label for="company">Cég</label>
        <input list="companies" class="form-control" name="company" id="company"
               placeholder="Kezdjen el gépelni..." autocomplete="off">
    </div>
    <button type="submit" class="btn btn-default" name="add-submit">Hozzáadás</button>
</form>
<br>
<h4>Szabad azonosítók:</h4>
<div class="row">
    <div class="col-sm-3">
        <table class="table table-condensed">
            <tr>
                <th>Tól</th>
                <th>Ig</th>
                <th>Összesen</th>
            </tr>
            <?php foreach ($freeRanges as $range): ?>
                <tr>
                    <td><?php echo $range['start']; ?></td>
                    <td><?php echo $range['end']; ?></td>
                    <td><?php echo $range['end'] - $range['start'] + 1; ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td><?php echo $cardIds[count($cardIds) - 1]['id'] + 1; ?></td>
                <td>-</td>
                <td>-</td>
            </tr>
        </table>
    </div>
</div>

<?php include 'includes/footer.php' ?>
