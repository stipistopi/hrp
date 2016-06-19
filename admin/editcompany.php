<?php
$active = "companies";
include 'includes/header.php';

$id = $_GET['id'];

if (isset($_POST['submit'])) {
    db_updateCompanyName($id, $_POST['company-name']);
    db_updateCompanyLocationData($id, $_POST['address']);
}

$company = db_getCompanyData($id);
$companyLocations = db_getCompanyLocationData($id);
?>

<h1 class="page-header">Cég szerkesztése - <?php echo $company['name'] ?></h1>

<form method="post" action="" class="row">
    <div class="form-group row">
        <div class="col-sm-4">
            <label for="companyName">Cégnév</label>
            <input type="text" class="form-control" id="companyName" name="company-name" placeholder="Cég neve..."
                   value="<?php echo $company['name'] ?>">
        </div>
    </div>
    <div id="container">
        <label for="address[0]">Telephelyek</label>
        <?php foreach ($companyLocations as $key => $location): ?>
            <div class="form-group">
                <div class="extraLocation">
                    <div class="col-sm-5">
                        <input type="text" class="form-control" placeholder="Cím..."
                               id="address[<?php echo $key ?>]"
                               name="address[<?php echo $key ?>]"
                               value="<?php echo $location[0] ?>">
                    </div>
                    <button type="button" class="btn btn-default removeRow">Telephely törlése</button>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <div class="form-group">
        <div class="col-sm-4">
            <button type="button" id="addRow" class="btn btn-default">További telephely hozzáadása</button>
        </div>
        <div class="col-sm-1">
            <button type="submit" class="btn btn-default" name="submit">Mentés</button>
        </div>
    </div>
</form>

<div class="row">
    <br>
    <a href="companies.php">Vissza</a>
</div>

<!-- Dynamic form handler code -->
<script>
    var index;
    $(document).ready(function () {
        index = $('.extraLocation').length;
        $('#addRow').click(function () {
            $('<div/>', {
                'class': 'extraLocation', html: GetHtml()
            }).appendTo('#container');
        });
        $('body').on('click', 'button.removeRow', function () {
            $(this).parent().parent().remove();
        });
    });
    function GetHtml() {
        ++index;
        var $html = $('.extraLocationTemplate').clone();
        $html.find('[name=address]')[0].name = "address[" + index + "]";
        return $html.html();
    }
</script>
<!-- Dynamic form handler code end -->

<!-- Hidden template -->
<div class="extraLocationTemplate" style="display:none">
    <div class="form-group">
        <div class="col-sm-5">
            <input class="form-control" placeholder="Cím..." name="address" type="text">
        </div>
        <button type="button" class="btn btn-default removeRow">Telephely törlése</button>
    </div>
</div>
<!-- Hidden template end -->

<?php include 'includes/footer.php' ?>
