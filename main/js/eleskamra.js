$(document).ready(function() {
    var filled_out = false;

    $("#eleskamra_mail").click(function() {
        $(this).hide();
        $("#eleskamra_fieldset").show();
    });

    $("input:submit").click(function() {
        if($("#eleskamra_form").is(":valid")) {
            if(!filled_out) {
                $.ajax({
                    url: "ajax/send_eleskamra_mail.php",
                    type: "POST",
                    data: {
                        elk_nev: $("#elk_nev").val(),
                        elk_email: $("#elk_email").val(),
                        elk_lakhely: $("#elk_lakhely").val()
                    },
                    success: function(ret) {
                        if (ret == "eleskamra_mail_sent") {
                            filled_out = true;

                            $.blockUI({
                                message: $('div.contact_ok'),
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
                    message: $('div.contact_uj'),
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
        }
    });

});