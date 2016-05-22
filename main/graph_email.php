<html>
<head>
    <title>Graph test</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="http://hrp-interaktiv.hu/main/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="http://hrp-interaktiv.hu/main/css/graph.css" />
</head>
<body>
<section class="main">
    <ul class="graph-container">
        <li>
            <span>Egyéni szint</span>
            <div class="bar-wrapper">
                <div class="bar-container">
                    <div class="bar-background"></div>
                    <div class="bar-inner" style="height: 25%; bottom: 0;"></div>
                    <div class="bar-inner-text" data-height="25" style="height: 25%; bottom: 0;"></div>
                    <div class="bar-foreground"></div>
                </div>
            </div>
        </li>
        <li>
            <span>Elfogadható minimum szint</span>
            <div class="bar-wrapper">
                <div class="bar-container">
                    <div class="bar-background"></div>
                    <div class="bar-inner" style="height: 50%; bottom: 0;"></div>
                    <div class="bar-inner-text" data-height="50" style="height: 50%; bottom: 0;"></div>
                    <div class="bar-foreground"></div>
                </div>
            </div>
        </li>
        <li>
            <span>Céges átlag szint</span>
            <div class="bar-wrapper">
                <div class="bar-container">
                    <div class="bar-background"></div>
                    <div class="bar-inner" style="height: 75%; bottom: 0;"></div>
                    <div class="bar-foreground"></div>
                </div>
            </div>
        </li>
        <li>
            <ul class="graph-marker-container">
                <li style="bottom:25%;"><span>25%</span></li>
                <li style="bottom:50%;"><span>50%</span></li>
                <li style="bottom:75%;"><span>75%</span></li>
                <li style="bottom:100%;"><span>100%</span></li>
            </ul>
        </li>
    </ul>
</section>
</body>
</html>