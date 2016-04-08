<?php
if (!isset($_SESSION)) session_start();
date_default_timezone_set("Europe/Budapest");

/* Utils */
include_once 'utils/db/companies.php';
include_once 'utils/db/users.php';

/* Config */
include_once '../main/includes/config/db.php';
