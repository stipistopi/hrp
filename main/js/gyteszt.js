$(document).ready(function() {
    var fontSize = parseInt($(".gyteszt_gombok li").height())+"px";
    var nav_state = 1;
    var filled_out = false;
    var valaszok = "";
    var ido = 0;
    var i, j;

    setInterval(function() {
        ido++;
    }, 1000);

    $(".gyteszt_gombok li label").css('font-size', fontSize);

    $("#next").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");          // oldal tetejére
        $("fieldset#f"+nav_state).hide();
        nav_state++;
        if(nav_state <= 4) {
            $("fieldset#main_fieldset div#bev").hide();
            $("#curr_state").html("Gyorsteszt ("+nav_state+"/4)");
            $("fieldset#f" + nav_state).show();
            $("#prev").prop("disabled", false);
            if(nav_state == 4) {
                $(this).prop("disabled", true);
                $(".gyteszt_alja").show();
            }
        } else {
            $(this).prop("disabled", true);
            $(".gyteszt_alja").hide();
            nav_state = 4;
        }
    });

    $("#prev").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");          // oldal tetejére
        $("fieldset#f"+nav_state).hide();
        nav_state--;
        if(nav_state >= 1) {
            $("#curr_state").html("Gyorsteszt ("+nav_state+"/4)");
            $("fieldset#f" + nav_state).show();
            $("#next").prop("disabled", false);
            $(".gyteszt_alja").hide();
            if(nav_state == 1) {
                $(this).prop("disabled", true);
                $("fieldset#main_fieldset div#bev").show();
            }
        } else {
            $(this).prop("disabled", true);
            nav_state = 1;
        }
    });

    $("input:submit").click(function() {
        if($("#form-gyteszt").is(":valid")) {
            if(!filled_out) {
                for(i = 1; i <= 4; i++) {
                    for(j = 1; j <= 5; j++) {
                        valaszok = valaszok.concat($("input[name=csop"+i+"_"+j+"]:checked").val());
                    }
                }
                $.ajax({
                    url: "ajax/send_gyteszt.php",
                    type: "POST",
                    data: {
                        valaszok: valaszok,
                        email: $("input#e-mail").val(),
                        ido: ido
                    },
                    success: function(ret) {
                        if(ret == "gyteszt_send_ok") {
                            filled_out = true;

                            $.blockUI({
                                message: $('div.gyteszt_ok'),
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
            } else {
                $.blockUI({
                    message: $('div.gyteszt_uj'),
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
        } else {
            $.blockUI({
                message: $('div.gyteszt_nem_ok'),
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

});