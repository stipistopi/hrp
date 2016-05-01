<?php

//$to = "tisopeti@gmail.com";
$subject = "Graph test";

$message = "
            <html>
            <head>
            <title>Graph test</title>
            <link rel=\"stylesheet\" type=\"text/css\" href=\"http://hrp-interaktiv.hu/main/css/normalize.css\" />
            <link rel=\"stylesheet\" type=\"text/css\" href=\"http://hrp-interaktiv.hu/main/css/graph.css\" />
            </head>
            <body>
            <section class=\"main\">
                <ul class=\"graph-container\">
                    <li>
                        <span>2008</span>
                        <div class=\"bar-wrapper\">
                            <div class=\"bar-container\">
                                <div class=\"bar-background\"></div>
                                <div class=\"bar-inner\" style=\"height: 25%; bottom: 0;\"></div>
                                <div class=\"bar-foreground\"></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <span>2009</span>
                        <div class=\"bar-wrapper\">
                            <div class=\"bar-container\">
                                <div class=\"bar-background\"></div>
                                <div class=\"bar-inner\" style=\"height: 50%; bottom: 0;\"></div>
                                <div class=\"bar-foreground\"></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <span>2010</span>
                        <div class=\"bar-wrapper\">
                            <div class=\"bar-container\">
                                <div class=\"bar-background\"></div>
                                <div class=\"bar-inner\" style=\"height: 75%; bottom: 0;\"></div>
                                <div class=\"bar-foreground\"></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <span>2011</span>
                        <div class=\"bar-wrapper\">
                            <div class=\"bar-container\">
                                <div class=\"bar-background\"></div>
                                <div class=\"bar-inner\" style=\"height: 100%; bottom: 0;\"></div>
                                <div class=\"bar-foreground\"></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <span>2012</span>
                        <div class=\"bar-wrapper\">
                            <div class=\"bar-container\">
                                <div class=\"bar-background\"></div>
                                <div class=\"bar-inner\" style=\"height: 50%; bottom: 0;\"></div>
                                <div class=\"bar-foreground\"></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <ul class=\"graph-marker-container\">
                            <li style=\"bottom:25%;\"><span>25%</span></li>
                            <li style=\"bottom:50%;\"><span>50%</span></li>
                            <li style=\"bottom:75%;\"><span>75%</span></li>
                            <li style=\"bottom:100%;\"><span>100%</span></li>
                        </ul>
                    </li>
                </ul>
            </section>
            </body>
            </html>";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

mail($to, $subject, $message, $headers);