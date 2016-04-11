$(document).ready(function() {
    var anyBoxesChecked = false;

    $("input:checkbox:not(:last)").change(function() {
        anyBoxesChecked = false;
        $("input:checkbox:not(:last)").each(function() {
            if($(this).is(":checked")) {
                anyBoxesChecked = true;
            }
        });

        if(anyBoxesChecked == true) {
            $("input:checkbox:last").prop("disabled", true);
        } else {
            $("input:checkbox:last").prop("disabled", false);
        }
    });

    $("input[type='checkbox']:last").change(function() {
        if($(this).is(":checked")) {
            $("input:checkbox:not(:last)").prop("disabled", true);
        } else {
            $("input:checkbox:not(:last)").prop("disabled", false);
        }
    });

});