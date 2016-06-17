<?php
$active = "cards_overview";
include 'includes/header.php';

$id = $_GET['id'];

if (isset($_POST['submit'])) {
    $cards = db_getCompanyCards($id);
    foreach ($cards as $card) {
        if (isset($_POST[$card['id']])) {
            $active = 1;
        } else {
            $active = 0;
        }
        db_setCardActive($card['id'], $active);
    }
}

$company = db_getCompanyData($id);
$cards = db_getCompanyCards($id);
?>

<h1 class="page-header">Kártyák kezelése - <?php echo $company['name'] ?></h1>

<form method="post" action="">
    <table class="table table-striped" style="max-width:200px;">
        <tr>
            <th>Kártyaszám</th>
            <th style="width:25px">Aktivált</th>
        </tr>
        <?php foreach ($cards as $card): ?>
            <tr>
                <td><?php echo $card['id'] ?></td>
                <td>
                    <input type="checkbox" name="<?php echo $card['id'] ?>" value="<?php echo $card['id'] ?>"
                        <?php if ($card['active']) echo 'checked' ?>>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <button type="submit" class="btn btn-default" name="submit">Mentés</button>
</form>

<?php include 'includes/footer.php' ?>
