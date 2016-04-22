<?php
$active = "add_cards";
include 'includes/header.php';

$cardIds = db_getAllCardIds();
$companies = db_getCompaniesOverview();

// array containing the range of free card IDs in the following form:
// freeRanges[range index]['start'] - freeRanges[range index]['stop']
// where 'start' is the first free ID, and stop is the last free ID.
$freeRanges = array();

// populate freeRanges
for ($i = 1; $i < count($cardIds); $i++) {
    $currVal = $cardIds[$i]['id'];
    $prevVal = $cardIds[$i - 1]['id'];
    if ($currVal - $prevVal > 1) {
        $j = count($freeRanges);
        $freeRanges[$j]['start'] = $prevVal + 1;
        $freeRanges[$j]['end'] = $currVal - 1;
    }
}
?>

<datalist id="companies">
    <?php foreach ($companies as $company): ?>
    <option value="<?php echo $company['name'] ?>">
        <?php endforeach; ?>
</datalist>

<form class="form-inline">
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
        <input list="companies" class="form-control" name="company" id="company" placeholder="Kezdjen el gépelni...">
    </div>
    <button type="submit" class="btn btn-default">Hozzáadás</button>
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
