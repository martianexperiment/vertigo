<?php
    class HackinConfig {
        /**
            Insert or remove '/' at the end of the line before public static $phpServer to switch
        */
        /*/*/
        public static $phpServer = 'localhost/hackin15/vertigo';
        public static $dbServer = "localhost";
        public static $dbUser = "root";
        public static $dbPwd="";
        public static $dbPlatform = "mysql";
        public static $db_accounts = "psgtech_login15_hackin_team_accounts";
        public static $db_game_engine = "psgtech_login15_hackin_game_engine";
        public static $db_quora = "psgtech_login15_hackin_quora";
        public static $db_logger;
        public static $db_test;
        public static $db_connection_logger;
        public static $db_session_logger;
        public static $db_request_logger;
        
        public function __construct() {
            self::$db_logger = self::$db_accounts;
            self::$db_test = self::$db_accounts;
            self::$db_connection_logger = self::$db_logger;
            self::$db_session_logger = self::$db_logger;
            self::$db_request_logger = self::$db_logger;
        }
        /*///*

        public static $phpServer = "hackin.psglogin.in";
        public static $dbServer = "localhost";
        public static $dbUser = "psgtechs_hackin";
        public static $dbPwd="UDKIPFTKUHS8";
        public static $dbPlatform = "mysql";
        public static $db_accounts="psgtechs_hackin_team_accounts";
        public static $db_game_engine = "psgtechs_hackin_game_engine";
        public static $db_quora;
        public static $db_logger;
        public static $db_test;
        public static $db_connection_logger;
        public static $db_session_logger;
        public static $db_request_logger;

        public function __construct() {
            self::$db_quora = self::$db_game_engine;
            self::$db_logger = self::$db_accounts;
            self::$db_test = self::$db_accounts;
            self::$db_connection_logger = self::$db_logger;
            self::$db_session_logger = self::$db_logger;
            self::$db_request_logger = self::$db_logger;
        }
        //*/

        public static $multipleSessionInterruption = "MulitpleSessionsInterruption";

    }
    new HackinConfig();
?>