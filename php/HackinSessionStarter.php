<?php
    /**
        Global place to start session.
        TODO: log session creations
    */
    if(!isset($_SESSION)) {
        session_start();
    }
?>