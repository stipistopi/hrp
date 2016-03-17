<?php
session_start();

if($_POST["feladat"] == "session") {
    if(!isset($_SESSION['erd_jelszo'])) {
        echo "session_fail";
    } else {
        echo "session_ok";
    }
}