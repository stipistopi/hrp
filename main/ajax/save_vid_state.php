<?php
include_once '../includes/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $leckeNum = test_input($_POST['leckeNum']);
    $vidMp = test_input($_POST['vidMp']);

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