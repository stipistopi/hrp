$(document).ready(function() {
    var attr = "border"; //szövegmező helyes kitöltése esetén ez az attribútum fog megváltozni
    var val_accept = "2px dashed rgba(137, 197, 64, 1)";
    var val_default = "1px dashed #DBDBDB";
    var val_default_focus = "1px dashed #969696";
    var mail_msg;
    var kod_msg;
    var hirlevel;

    $("#also_link, #lecke_vid_link").click(function() {
        if($("#also_link").is(":visible")) {
            //$("#lecke_vid_link").blur();
            $("#also_resz").fadeOut(1200);
            $("#demo_login").fadeOut(1200, function () {
                $("#demo_reg").fadeIn(1200, function () {
                    //$("#uresresz").css("padding", "20px 0");
                });
            });
        } else {
            //$("#lecke_vid_link").blur();
        }
    });

    $("input:submit").click(function() {
        if($("#demo_reg").is(":valid")) {

            if($("#hirlevel").is(":checked")) hirlevel = 1; else hirlevel = 0;

            $.ajax({
                url: "demo_reg.php",
                type: "POST",
                data: {
                    feladat: "hozzaad",
                    vez_nev: $("#vez_nev").val(),
                    k_nev: $("#k_nev").val(),
                    e_nev: $("#e_nev").val(),
                    email: $("#e-mail").val(),
                    hirlevel: hirlevel,
                    t_szam: $("#t_szam").val(),
                    vall_neve: $("#vall_neve").val()
                },
                success: function(siker) {
                    if(siker == "mail_ok") {
                        mail_msg = $('div.erd_reg_ok');

                        $("#demo_reg").fadeOut(1200, function() {
                            $("#also_resz").fadeIn(1200);
                            $("#demo_login").fadeIn(1200, function() {
                                //$("#uresresz").css("padding", "140px 0");
                            });
                        });
                    } else if(siker == "mail_error") {
                        mail_msg = $('div.erd_reg_nem_ok');
                    }
                    $.blockUI({
                        message: mail_msg,
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
                }
            });
        }
    });

    $("#kod").keyup(function() {

        // itt kerdezzuk le az adatbazisbol a kodot...
        // ha minden jol megy, nyitjuk a videot,
        // ezt jelezzuk a jobb felso sarokban,
        // es eltuntetjuk az ures reszt a lap aljarol

        if($(this).val().length == 10) {
            $.ajax({
                url: "demo_reg.php",
                type: "POST",
                data: {
                    feladat: "keres",
                    kod: $(this).val()
                },
                success: function(siker) {
                    if(siker == "kod_ok") {
                        $("#kod").css(attr, val_accept);
                        kod_msg = $('div.kod_ok');

                        $("#also_resz").fadeOut(1200);
                        $("#demo_login").fadeOut(1200, function() {
                            $("#lecke_vid").fadeIn(1200, function() {
                                //$(this).css("display", "block");
                                //$("#uresresz").css("padding", "40px 0");
                            });
                        });
                    } else if(siker == "kod_nem_ok") {
                        kod_msg = $('div.kod_nem_ok');
                    }
                    $.blockUI({
                        message: kod_msg,
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
                }
            });
        } else {
            $(this).css(attr, val_default);
            $(this).focus().css(attr, val_default_focus);
        }
    });

    $("table.erdeklodo_reg td input[type=text]").keyup(function() {
        if($(this).is(":valid")) {
            $(this).css(attr, val_accept);
        } else {
            $(this).css(attr, val_default);
            $(this).focus().css(attr, val_default_focus);
        }
    });

});