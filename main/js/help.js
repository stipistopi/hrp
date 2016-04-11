$(document).ready(function() {
    var filled_out = false;

    $("input:submit").click(function() {
        if($("#help_form").is(":valid")) {
            if(!filled_out) {
                $.ajax({
                    url: "ajax/send_help_mail.php",
                    type: "POST",
                    data: {
                        userId: $("#userId").html(),
                        timeWindow: $("#timeWindow").html(),
                        msg: $("#help_msg").val()
                    },
                    success: function(ret) {
                        if (ret == "help_mail_sent") {
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
                                },
                                onUnblock: function() {
                                    window.location.replace("lecke.php");
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