$(document).ready(function() {
    var attr = "border"; //szövegmező helyes kitöltése esetén ez az attribútum fog megváltozni
    var val_accept = "2px dashed rgba(137, 197, 64, 1)";
    var val_default = "1px dashed #DBDBDB";
    var val_default_focus = "1px dashed #969696";

    $("input:submit").click(function() {
        if($("#form-main-reg").is(":valid")) {
            $.ajax({
                url: "reg_ajax.php",
                type: "POST",
                data: {
                    kartyaId: $("#kartya").val(),
                    vez_nev: $("#vez_nev").val(),
                    ker_nev: $("#k_nev").val(),
                    elonev: $("#e_nev").val(),
                    email: $("#e-mail").val(),
                    telefon: $("#t_szam").val(),
                    lakhely_varos: $("#lakhely_varos").val(),
                    lakhely_varosresz: $("#lakhely_vresz").val(),
                    felh_nev: $("#user_n").val(),
                    jelszo: $("#passw").val()
                },
                success: function(ret) {
                    //console.log(ret);
                    if(ret == "registration_succeeded") {
                        // uzenet megjelenitese
                        // a regisztacio sikerult, lehet bejelentkezni
                    } else if(ret == "email_in_use") {
                        // uzenet megjelenitese
                        // a beirt email cim mar hasznalatban van
                    } else {
                        // uzenet megjelenitese
                        // ismeretlen hiba tortent, a cucc ertesitette a fejlesztoket (ezt kesobb megoldjuk),
                        // dolgozunk a hiba elharitasan, stb
                    }
                }
            });
        }
    });

    $("#kartya").keyup(function() {

        // itt kérdezzük le az adatbázisból a kártyaszámot...
        // ha minden jól megy, nyitjuk a regisztrációs formot,
        // ezt jelezzük a jobb felső sarokban,
        // és eltüntetjük az üres részt a lap aljáról

        if($(this).val().length > 5) {
            $(this).css(attr, val_accept); // ha az ajax sikeresen azonosította a kártyát, csak akkor zöldüljön ki

            $(this).prop("disabled", true); // ha az ajax sikeresen azonosította a kártyát, akkor legyen disabled

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