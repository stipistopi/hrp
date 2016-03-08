$(document).ready(function() {
    var attr = "border"; //szövegmező helyes kitöltése esetén ez az attribútum fog megváltozni
    var val_accept = "2px dashed rgba(137, 197, 64, 1)";
    var val_default = "1px dashed #DBDBDB";
    var val_default_focus = "1px dashed #969696";

    $("#kartya").keyup(function() {

        // itt kérdezzük le az adatbázisból a kártyaszámot...
        // ha minden jól megy, nyitjuk a regisztrációs formot,
        // ezt jelezzük a jobb felső sarokban,
        // és eltüntetjük az üres részt a lap aljáról

        if($(this).val().length > 5) {
            $(this).css(attr, val_accept);

            $.blockUI({
                message: $('div.kartya_ok'),
                fadeIn: 700,
                fadeOut: 700,
                timeout: 2500,
                showOverlay: false,
                centerY: false,
                css: {
                    width: '450px',
                    top: '10px',
                    left: '',
                    right: '10px',
                    border: 'none',
                    padding: '5px',
                    backgroundColor: '#000',
                    'border-radius': '10px',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .7,
                    color: '#fff'
                }
            });

            $(".reg").fadeIn(1200);
            $("#uresresz").css("padding", "20px 0");
        } else {
            $(this).css(attr, val_default);
            $(this).focus().css(attr, val_default_focus);
        }
    });

    $("table.reg td input[type=text]").keyup(function() {
        if($(this).is(":valid")) {
            $(this).css(attr, val_accept);
        } else {
            $(this).css(attr, val_default);
            $(this).focus().css(attr, val_default_focus);
        }
    });

    $("#passw").keyup(function() {
        if($(this).is(":valid")) {
            $(this).css(attr, val_accept);
        } else {
            $(this).css(attr, val_default);
            $(this).focus().css(attr, val_default_focus);
        }
    });

    $("#passw_re").keyup(function() {
        if($(this).is(":valid") && $(this).val() == $("#passw").val()) {
            $(this).css(attr, val_accept);
        } else {
            $(this).css(attr, val_default);
            $(this).focus().css(attr, val_default_focus);
        }
    });

});