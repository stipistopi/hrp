<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>HRP Interaktív Program</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <link rel="stylesheet" type="text/css" href="css/component.css">
    <script src="../js/jquery.min.js"></script>
    <script src="js/jquery-ui.js"></script>
</head>
<body>
<div id="page-wrapper">
    <div id="top-menu-wrapper">
        <img src="images/logo.png">
        <ul id="top-menu">
            <li><a href="../index.html">Főoldal</a></li>
            <li><a href="about.html">Rólunk</a></li>
            <li><a href="services.html">Szolgáltatásaink</a></li>
            <li><a href="contact.html">Kapcsolat</a></li>
            <li><a href="career.html">Karrier</a></li>
            <li style="float:right;">
                <ul style="list-style-type:none;">
                    <li><a class="active" href="reg.php">Regisztráció</a></li>
                    <li><a href="#">Bejelentkezés</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div id="content-wrapper">
        <div id="content">
            <div class="flexbox-container">
                <div class="content-left">
                    <div class="line-magenta"></div>
                </div>
                <div class="content-right vertical-padding-10"></div>
            </div>
            <div class="flexbox-container">
                <div class="content-left">
                    <div class="line-magenta"></div>
                </div>
                <div class="content-right">
                    <form style="margin-left: 5em">
                        <fieldset>
                            <legend>Regisztráció adatai</legend>
                            <table class="reg">
                                <tr>
                                    <td>Plasztik kártya száma<span style="color: red;font-weight: bold;">*</span>:</td><td><input id="kartya" type="text" placeholder="Kezdjen el gépelni..." required autofocus></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Név</td>
                                </tr>
                                <tr>
                                    <td>Vezetéknév<span style="color: red;font-weight: bold;">*</span>:</td><td><input id="vez_nev" type="text" placeholder="Példa" required></td>
                                </tr>
                                <tr>
                                    <td>Keresztnév<span style="color: red;font-weight: bold;">*</span>:</td><td><input id="k_nev" type="text" placeholder="Tamás" required></td>
                                </tr>
                                <tr>
                                    <td>Előnév:</td><td><input id="e_nev" type="text" placeholder="Ifj."></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Elérhetőségek</td>
                                </tr>
                                <tr>
                                    <td>E-mail cím<span style="color: red;font-weight: bold;">*</span>:</td><td><input id="e-mail" type="text" placeholder="valami@valami.hu" required></td>
                                </tr>
                                <tr>
                                    <td>Telefonszám:</td><td><input id="t_szam" type="text" placeholder="30/123-4567"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Cég adatai</td>
                                </tr>
                                <tr>
                                    <td>Vállalat/intézmény neve<span style="color: red;font-weight: bold;">*</span>:</td><td><input id="vall_neve" type="text" placeholder="Minta Bt." required></td>
                                </tr>
                                <tr>
                                    <td>Vállalat/intézmény telephelye:</td><td><input id="vall_thely" type="text" placeholder="1111, Budapest, Ötletes u. 4."></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Lakhely</td>
                                </tr>
                                <tr>
                                    <td>Lakóhely (város)<span style="color: red;font-weight: bold;">*</span>:</td><td><input id="lakhely_varos" type="text" placeholder="Szeged" required></td>
                                </tr>
                                <tr>
                                    <td>Lakóhely (kerület/városrész):</td><td><input id="lakhely_vresz" type="text" placeholder="Makkosháza"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Válasszon saját felhasználónevet!</td>
                                </tr>
                                <tr>
                                    <td>Felhasználónév<span style="color: red;font-weight: bold;">*</span>:</td><td><input id="user_n" type="text" placeholder="peldatomi" required></td>
                                </tr>
                                <tr>
                                    <td>Jelszó<span style="color: red;font-weight: bold;">*</span>:</td><td><input id="passw" type="password" placeholder="jelszo" required></td>
                                </tr>
                                <tr>
                                    <td>Jelszó megerősítése<span style="color: red;font-weight: bold;">*</span>:</td><td><input id="passw_re" type="password" placeholder="jelszo" required></td>
                                </tr>
                                <tr>
                                    <td>Adatkezelési szabályzat elfogadása<span style="color: red;font-weight: bold;">*</span>:</td><td><input id="adatk" type="checkbox" required></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center"><input type="submit" value="Regisztráció"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-size: 80%">A <span style="color: red;font-weight: bold;">*</span>-al jelölt mezők kitöltése kötelező.</td>
                                </tr>
                            </table>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="flexbox-container">
                <div class="content-left">
                    <div class="line-magenta"></div>
                </div>
                <div class="content-right vertical-padding-10"></div>
            </div>
            <div class="flexbox-container">
                <div class="content-left">
                    <div class="line-magenta"></div>
                </div>
                <div class="content-right vertical-padding-10"></div>
            </div>
        </div>
        <div id="right-menu">
            <ul>
                <li class="magenta-bottom"><nav class="cl-effect-12"><a href="#">Éléskamra program</a></nav></li>
                <li class="magenta-bottom"><nav class="cl-effect-12"><a href="#">Gyorsteszt</a></nav></li>
                <li class="magenta-bottom"><nav class="cl-effect-12"><a href="#">Kapcsolatfelvétel</a></nav></li>
                <li class="magenta-bottom"><nav class="cl-effect-12"><a href="#">Tanulmányok</a></nav></li>
                <li class="magenta-bottom"><nav class="cl-effect-12"><a href="#">Közösségi oldalak</a></nav></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>