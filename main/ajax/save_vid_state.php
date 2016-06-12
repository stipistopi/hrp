<?php
include_once '../includes/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $timeWindowName = $_SESSION['timeWindowName'];
    $leckeNum = pregMatch_oneNumberFromString($timeWindowName);
    $vidMp = test_input($_POST['vidMp']);

    setcookie("vid_state_in_secs", "", time() - 3600); // delete cookie

    setcookie(
        'vid_state_in_secs', // name
        $leckeNum . ':' . $vidMp, // value
        time() + (86400 * 11), // expire: 11 days
        '/', // path
        'hrp-interaktiv.hu', // domain
        false, // secure
        true  // httponly
    );
}