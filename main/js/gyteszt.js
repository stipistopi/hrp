$(document).ready(function() {
    var fontSize = parseInt($(".gyteszt_gombok li").height())+"px";
    var nav_state = 1;

    $(".gyteszt_gombok li label").css('font-size', fontSize);

    $("#next").click(function() {
        $("fieldset#f"+nav_state).hide();
        nav_state++;
        if(nav_state <= 4) {
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
        $("fieldset#f"+nav_state).hide();
        nav_state--;
        if(nav_state >= 1) {
            $("#curr_state").html("Gyorsteszt ("+nav_state+"/4)");
            $("fieldset#f" + nav_state).show();
            $("#next").prop("disabled", false);
            $(".gyteszt_alja").hide();
            if(nav_state == 1) {
                $(this).prop("disabled", true);
            }
        } else {
            $(this).prop("disabled", true);
            nav_state = 1;
        }
    });
});