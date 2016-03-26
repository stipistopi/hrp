$(document).ready(function() {
    var filled_out = false;

    $("#contact_mail").click(function() {
        $(this).hide();
        $("#contact_fieldset").show();
    });

    $("input:submit").click(function() {
        if($("#contact_form").is(":valid")) {
            if(!filled_out) {
                $.ajax({
                    url: "ajax/send_contact_mail.php",
                    type: "POST",
                    data: {
                        msg_to: $("option:checked").val(),
                        subj: $("#email_targy").val(),
                        msg: $("#contact_uzi").val()
                    },
                    success: function (ret) {
                        if (ret == "contact_mail_sent") {
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
                            alert("valami bibi van");
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