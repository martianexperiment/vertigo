<?php
    require_once("HackinDbHelper.php");
    $dbHelper = new HackinDbHelper();
    $dbHelper->testConnectionCreation();
    $dbHelper->testGetAliveHackinSessionNotEqualToCurrentSession();
    $dbHelper->testHasUserRegistered();
?>