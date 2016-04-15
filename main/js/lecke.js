/*
 * jQuery code by Peter Tisóczki
 */

$.fn.progBarAnim = function() {
    var $szoveg;
    var $szazalek;
    var $ido;

    $szoveg = this.children().html();
    $szazalek = $szoveg.substr(0, $szoveg.indexOf("%"));

    if($szazalek < 25) $ido = 1000; else $ido = 2000;

    this.animate({width: $szazalek+"%"}, $ido);
};

$(document).ready(function() {
    var nev;
    var kor;
    var szoveg;
    var dur = 800;
    var current_point1x;
    var current_point1y;
    var current_point3x;
    var current_point3y;
    var current_point4x;
    var current_point4y;
    var kerdezz = $("#kerdezz");
    var tunet = $("#tunet");
    var tudastar = $("#tudastar");
    var orvos = $("#orvos");
    var segitseg = $("#segitseg");
    var vallalom = $("#vallalom");
    var fontSize = parseInt($(".gyteszt_gombok li").height())+"px";

    $(".gyteszt_gombok li label").css('font-size', fontSize);

    $(document).tooltip({
        track: true,
        show: { delay: dur - 200 }
    });

    //var ret = getUrlParameter('return');

    $("#bar1").progBarAnim();
    $("#bar2").progBarAnim();

    $("polygon[id*='_hover'], rect[id*='_hover']").hover(function() {
        nev = $(this).attr("id");
        kor = nev.replace("_hover", "_kor");
        $("#" + kor).attr("class", "cls-1-mod");
    }, function() {
        $("#" + kor).attr("class", "cls-1");
    });

    $("#kerdezz_hover").hover(function() {
        //$("#kerdezz-anim").attr("begin", "0.5s");
        var max_width = $("#kerdezz_referencia").attr("width");

        szoveg = "Erre a gombra kattintva egy gyors teszt segítségével mérheti le az adott témakör elsajátításának, tudásszintjének mértékét.";
        $(this).attr("title", szoveg);

        kerdezz.finish();
        kerdezz.show();
        //kerdezz.attr("width", "0"); //ha az animate előtt nem lenne inicializálva, itt tennénk meg

        $({"width":0}).animate(
            {"width":max_width},
            {
                step: function(curr_width) {
                    kerdezz.attr("width", curr_width);
                },
                fail: function() {
                    // ...
                },
                done: function() {
                    // ...
                },
                duration: dur
            });

    }, function() {
        //kerdezz.stop(); //ezt abban az esetben használjuk, ha az animate előtt a kerdezz van megadva
        kerdezz.fadeOut();
    });

    $("#tunet_hover").hover(function() {
        var max_points = $("#tunet_referencia").attr("points");
        var coords = max_points.split(" ");
        var coord1 = coords[0].split(",");
        var coord2 = coords[1].split(",");
        var coord3 = coords[2].split(",");
        var coord4 = coords[3].split(",");

        szoveg = "Erre a gombra kattintva, csoportosítva megtalálja a tárgyalt betegségek legjellemzőbb tüneteit és ellenőrizheti, összehasonlíthatja az önmagán tapasztalt tünetekkel, jelzésekkel.";
        $(this).attr("title", szoveg);

        tunet.finish();
        tunet.show();
        tunet.attr("points", "");

        /* ------- INSTRUKCIÓK AZ ALÁBBI ANIMÁCIÓ-SOROZAT HASZNÁLATÁHOZ -------
        *
        * Koordinátáknál megállapítjuk, melyek azok, amelyeknek állandónak kell lenniük, s
        * melyek azok, amelyeknek meg kell változniuk (ez utóbbiaknak a kiinduló állapotuk
        * az állandó koordináták), s célállapotuk az eredeti állapotuk, melyet a max_point
        * felbontogatásából nyerünk. Ennek megfelelően inicializáljuk az animációknál a
        * változtatandó koordináták kezdőértékeit.
        *
        * Pl. az alábbi esetben írjuk fel ilyen alakokban a koordinátákat:
        *
        * 677,242 580,75 545,99 646,270
        *
        * vált,vált (jobb felső); marad,marad (bal felső); marad,marad (bal alsó); vált,vált (jobb alsó)
        *
        * 2. -> 1.
        * 3. -> 4.
        *
        * --------------------------------------------------------------------
        * */

        $({"prop":coord2[0]}).animate({"prop":coord1[0]}, { queue: false, step: function(now) { current_point1x = now; }, duration: dur });
        $({"prop":coord2[1]}).animate({"prop":coord1[1]}, { queue: false, step: function(now) { current_point1y = now; }, duration: dur });
        $({"prop":coord3[0]}).animate({"prop":coord4[0]}, { queue: false, step: function(now) { current_point4x = now; }, duration: dur });
        $({"prop":coord3[1]}).animate({"prop":coord4[1]}, { queue: false, step: function(now) { current_point4y = now; }, duration: dur });
        $({"set":0}).animate({"set":100}, { queue: false, step: function() { tunet.attr("points",
            current_point1x + "," + current_point1y + " "
            + coords[1] + " " + coords[2] + " "
            + current_point4x + "," + current_point4y); },
            duration: dur })
        ;

    }, function() {
        //tunet.stop();
        tunet.fadeOut();
    });

    $("#tudastar_hover").hover(function() {
        var max_points = $("#tudastar_referencia").attr("points");
        var coords = max_points.split(" ");
        var coord1 = coords[0].split(",");
        var coord2 = coords[1].split(",");
        var coord3 = coords[2].split(",");
        var coord4 = coords[3].split(",");

        szoveg = "Erre a gombra kattintva további hasznos ismereteket, fontos szakmai információkat találhat a leckék teljesebb, bővebb feldolgozása érdekében.";
        $(this).attr("title", szoveg);

        tudastar.finish();
        tudastar.show();

        $({"prop":coord2[0]}).animate({"prop":coord3[0]}, { queue: false, step: function(now) { current_point3x = now; }, duration: dur });
        $({"prop":coord2[1]}).animate({"prop":coord3[1]}, { queue: false, step: function(now) { current_point3y = now; }, duration: dur });
        $({"prop":coord1[0]}).animate({"prop":coord4[0]}, { queue: false, step: function(now) { current_point4x = now; }, duration: dur });
        $({"prop":coord1[1]}).animate({"prop":coord4[1]}, { queue: false, step: function(now) { current_point4y = now; }, duration: dur });
        $({"set":0}).animate({"set":100}, { queue: false, step: function() { tudastar.attr("points",
            coords[0] + " " + coords[1] + " "
            + current_point3x + "," + current_point3y + " "
            + current_point4x + "," + current_point4y); },
            duration: dur })
        ;

    }, function() {
        tudastar.fadeOut();
    });

    $("#orvos_hover").hover(function() {
        var max_points = $("#orvos_referencia").attr("points");
        var coords = max_points.split(" ");
        var coord1 = coords[0].split(",");
        var coord2 = coords[1].split(",");
        var coord3 = coords[2].split(",");
        var coord4 = coords[3].split(",");

        szoveg = "Erre a gombra kattintva találhatja az ajánlott szakrendelések, illetve orvosok listáját, mellyel segítséget szeretnénk adni a további kivizsgálások, kezelések elvégzéséhez.";
        $(this).attr("title", szoveg);

        orvos.finish();
        orvos.show();

        $({"prop":coord2[0]}).animate({"prop":coord3[0]}, { queue: false, step: function(now) { current_point3x = now; }, duration: dur });
        $({"prop":coord2[1]}).animate({"prop":coord3[1]}, { queue: false, step: function(now) { current_point3y = now; }, duration: dur });
        $({"prop":coord1[0]}).animate({"prop":coord4[0]}, { queue: false, step: function(now) { current_point4x = now; }, duration: dur });
        $({"prop":coord1[1]}).animate({"prop":coord4[1]}, { queue: false, step: function(now) { current_point4y = now; }, duration: dur });
        $({"set":0}).animate({"set":100}, { queue: false, step: function() { orvos.attr("points",
            coords[0] + " " + coords[1] + " "
            + current_point3x + "," + current_point3y + " "
            + current_point4x + "," + current_point4y); },
            duration: dur })
        ;

    }, function() {
        orvos.fadeOut();
    });

    $("#segitseg_hover").hover(function() {
        var max_points = $("#segitseg_referencia").attr("points");
        var coords = max_points.split(" ");
        var coord1 = coords[0].split(",");
        var coord2 = coords[1].split(",");
        var coord3 = coords[2].split(",");
        var coord4 = coords[3].split(",");

        szoveg = "Erre a gombra kattintva kérhet segítséget ügyfélszolgálatunktól.";
        $(this).attr("title", szoveg);

        segitseg.finish();
        segitseg.show();

        $({"prop":coord2[0]}).animate({"prop":coord3[0]}, { queue: false, step: function(now) { current_point3x = now; }, duration: dur });
        $({"prop":coord2[1]}).animate({"prop":coord3[1]}, { queue: false, step: function(now) { current_point3y = now; }, duration: dur });
        $({"prop":coord1[0]}).animate({"prop":coord4[0]}, { queue: false, step: function(now) { current_point4x = now; }, duration: dur });
        $({"prop":coord1[1]}).animate({"prop":coord4[1]}, { queue: false, step: function(now) { current_point4y = now; }, duration: dur });
        $({"set":0}).animate({"set":100}, { queue: false, step: function() { segitseg.attr("points",
            coords[0] + " " + coords[1] + " "
            + current_point3x + "," + current_point3y + " "
            + current_point4x + "," + current_point4y); },
            duration: dur })
        ;

    }, function() {
        segitseg.fadeOut();
    });

    $("#vallalom_hover").hover(function() {
        var max_points = $("#vallalom_referencia").attr("points");
        var coords = max_points.split(" ");
        var coord1 = coords[0].split(",");
        var coord2 = coords[1].split(",");
        var coord3 = coords[2].split(",");
        var coord4 = coords[3].split(",");

        szoveg = "Erre a gombra kattintva teheti meg személyes vállalásait egészsége megőrzése érdekében.";
        $(this).attr("title", szoveg);

        vallalom.finish();
        vallalom.show();

        $({"prop":coord2[0]}).animate({"prop":coord3[0]}, { queue: false, step: function(now) { current_point3x = now; }, duration: dur });
        $({"prop":coord2[1]}).animate({"prop":coord3[1]}, { queue: false, step: function(now) { current_point3y = now; }, duration: dur });
        $({"prop":coord1[0]}).animate({"prop":coord4[0]}, { queue: false, step: function(now) { current_point4x = now; }, duration: dur });
        $({"prop":coord1[1]}).animate({"prop":coord4[1]}, { queue: false, step: function(now) { current_point4y = now; }, duration: dur });
        $({"set":0}).animate({"set":100}, { queue: false, step: function() { vallalom.attr("points",
            coords[0] + " " + coords[1] + " "
            + current_point3x + "," + current_point3y + " "
            + current_point4x + "," + current_point4y); },
            duration: dur })
        ;

    }, function() {
        vallalom.fadeOut();
    });

});