$(document).ready(function() {
    var attr = "border"; //szövegmező helyes kitöltése esetén ez az attribútum fog megváltozni
    var val_accept = "2px dashed rgba(137, 197, 64, 1)";
    var val_default = "1px dashed #DBDBDB";
    var val_default_focus = "1px dashed #969696";
    var kartya = $("#kartya");

    $("input:submit").click(function() {
        if($("#form-main-reg").is(":valid")) {
            $.ajax({
                url: "ajax/user_register.php",
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
                    jelszo: $("#passw").val(),
                    thely: $("select#vall_thely option:checked").val()
                },
                success: function(ret) {
                    //console.log(ret);
                    if(ret == "registration_succeeded") {
                        $.blockUI({
                            message: $('div.reg_ok'),
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
                            },
                            onUnblock: function() {
                                window.location.replace("login.php");
                            }
                        });
                    } else if(ret == "username_in_use") {
                        $.blockUI({
                            message: $('div.username_in_use'),
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
                    } else if(ret == "card_in_use") {
                        $.blockUI({
                            message: $('div.card_in_use'),
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
                    } else if(ret == "email_in_use") {
                        $.blockUI({
                            message: $('div.email_in_use'),
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
                    } else {
                        // uzenet megjelenitese
                        // ismeretlen hiba tortent, a cucc ertesitette a fejlesztoket (ezt kesobb megoldjuk),
                        // dolgozunk a hiba elharitasan, stb
                    }
                }
            });
        }
    });

    kartya.keyup(function() {

        // itt kérdezzük le az adatbázisból a kártyaszámot...
        // ha minden jól megy, nyitjuk a regisztrációs formot,
        // ezt jelezzük a jobb felső sarokban,
        // és eltüntetjük az üres részt a lap aljáról

        if($(this).val().length == 10) {
            $.ajax({
                url: "ajax/card_validate.php",
                type: "POST",
                data: {
                    kartya: $(this).val()
                },
                success: function(ret) {
                    if(ret == "kartya_ok") {
                        kartya.css(attr, val_accept); // ha az ajax sikeresen azonosította a kártyát, csak akkor zöldüljön ki

                        kartya.prop("disabled", true); // ha az ajax sikeresen azonosította a kártyát, akkor legyen disabled

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

                        $(".reg").fadeIn(1200, function() {
                            $.ajax({
                                type: 'POST',
                                url: 'ajax/get_company_data.php',
                                data: {
                                    kartya: kartya.val()
                                },
                                dataType: 'json',
                                success: function(cegEsTelephelyei) {
                                    var vallalatNeveInput = $("#vall_neve");
                                    vallalatNeveInput.val(cegEsTelephelyei["vallalat_neve"]);
                                    vallalatNeveInput.prop("disabled", true);
                                    var i;
                                    for(i = 0; i < cegEsTelephelyei["vallalat_telephelyei"].length; i++) {
                                        $("#vall_thely").append(
                                            "<option>" + cegEsTelephelyei["vallalat_telephelyei"][i] + "</option>");
                                    }
                                }
                            });
                        });
                        $("#uresresz").css("padding", "20px 0");
                    } else if(ret == "kartya_nem_ok") {
                        $.blockUI({
                            message: $('div.kartya_nem_ok'),
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
                    } else {
                        // uzenet megjelenitese
                        // ismeretlen hiba tortent, a cucc ertesitette a fejlesztoket (ezt kesobb megoldjuk),
                        // dolgozunk a hiba elharitasan, stb.
                    }
                }
            });
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