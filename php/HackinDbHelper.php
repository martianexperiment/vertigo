<?php
    require_once("HackinErrorHandler.php");
    /**
        Wrapper over PDO (or mysqli) connections to create and use database connections privately and dynamically
        List of all databases should be mentioned before hand, during construction
        TODO: Move all configuration parameters out of the class
    */
    class HackinDbHelper {
        private $host;// = "localhost";
        private $user;// = /**"psgtechs_hackin");//*/"root";
        private $pwd;// = /**"UDKIPFTKUHS8");//*/"";    
        private $dsn;
        private $dbPlatform;//="mysql";
        
        private $db_accounts;// = "psgtech_login15_hackin_team_accounts";
        private $db_quora;// = "psgtech_login15_hackin_quora";
        private $db_game_engine;// = "psgtech_login15_hackin_game_engine";
        private $db_test;
        private $db_connection_logger;

        /**
            TODO: input all supported platforms here and make use of it in DSN creation.
        */
        //private static $supportedDbPlatformsList = ["mysql"];

        /**
            Constructor to initialize database connection parameters and verify connection creation
            TODO: Provide with parameterized constructor
            return: void
        */
        public function __construct() {
            $this->host = "localhost";
            $this->user = /**"psgtechs_hackin");//*/"root";
            $this->pwd =  /**"UDKIPFTKUHS8");//*/"";

            $this->dbPlatform = "mysql";
            $this->db_accounts = "psgtech_login15_hackin_team_accounts";
            $this->db_quora = "psgtech_login15_hackin_quora";
            $this->db_game_engine = "psgtech_login15_hackin_game_engine";
            $this->db_test = $this->db_accounts;
            $this->db_connection_logger = $this->db_accounts;

            $this->dsn = self::createDsnBasedOnDb($this->host, $this->dbPlatform);
            $pdo = self::createPDOConnectionToDbAndVerifyUser($this->dsn, $this->user, $this->pwd, $this->db_test);

            try {
                $functionalityForWhichExceptionExpected = "verifying connection with the dbs";
                $query = "use ";
                $pdo->query($query.$this->db_accounts);
                $pdo->query($query.$this->db_quora."");
                $pdo->query($query.$this->db_game_engine."");
                //$pdo->query($query."unavailable_db");//test to verify error handling
            } catch(PDOException $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                exit();
            }
        }

/**
    +********************************************************** HELPER STATIC FUNCTIONS SEGMENT ***********************************************************+
*/
          
        /**
            To create DSN for PDO creation
            return: $dsn
        */
        private static function createDsnBasedOnDb($host, $dbPlatform) {
            $dsn = "";
            /**
                TODO: make use of the supportedDbPlatformsList for the following condition check
            */
            $functionalityForWhichExceptionExpected = "creating DSN for use by PDO_DbConnection object";
            if($dbPlatform == "mysql") {
                $dsn="mysql";
            } else {
                $ex = new Exception("connection request for unsupported db platform, during PDO creation in SqlConnection.php, requested dbPlatform=".$dbPlatform);
                echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                exit();
            }
            $dsn = $dsn.":host=".$host;
            return $dsn;
        }

        /**
            Use this functionality to create db connection everytime.
            return: $authenticatedDbConnectionForUser
        */
        private static function createPDOConnectionToDbAndVerifyUser($dsn, $user, $pwd, $db_test) {
            $authenticatedDbConnectionForUser = null;
            $query = "use ".$db_test;
            $functionalityForWhichExceptionExpected = "veriying database user account using test db";
            try {
                $authenticatedDbConnectionForUser = new PDO($dsn, $user, $pwd);
                $authenticatedDbConnectionForUser->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //$authenticatedDbConnectionForUser->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $authenticatedDbConnectionForUser->query($query);
            } catch(PDOException $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                /*print_r($authenticatedDbConnectionForUser->errorInfo());*/
                exit();
            }
            return $authenticatedDbConnectionForUser;
        }

/**
    +********************************************************** HELPER MEMBER FUNCTIONS SEGMENT ***********************************************************+
*/
        
        /**
            Use this function for connection creation
            Provide with additional info for logging
            return: $pdo
        */
        private function getPDOConnectionToDbAndVerifyUser($additional_info="NULL") {
            echo "dsn=" . $this->dsn . ", user=" . $this->user . ", pwd=". $this->pwd . ", db_test=" . $this->db_test;
            $pdo = self::createPDOConnectionToDbAndVerifyUser($this->dsn, $this->user, $this->pwd, $this->db_test);
            $this->newConnectionCreated($pdo, $additional_info);
            return $pdo;
        }

        /**
            Steps to be done on creation of new connection
            Excluded for logging db_access made as the functions are not static (=> cannot be called from constructor)
            Only getPDOConnectionToDbAndVerifyUser() should call this method
        */
        private function newConnectionCreated($pdo, $additional_info="NULL") {
            $connection_logger_query = "insert into `" . $this->db_connection_logger . "`.`connections_creation_logger` (`additional_info`) values (\"" . $additional_info . "\")";
            echo "<br>" . $connection_logger_query;
            $pdo->query($connection_logger_query);
        }

        /**
            Steps to be done while accessing a db
            Excludes those access made while logging the connection creation and db access for this function
        */
        private function newAccessToDb($pdo, $db_name, $additional_info = "NULL") {
            $db_logger_query = "insert into `" . $this->db_connection_logger . "`.`connections_db_access_logger` (`db_name`, `additional_info`) values (\"" 
                . $db_name . "\" , \"" . $additional_info ."\")";
            echo "<br>" . $db_logger_query;
            $pdo->query($db_logger_query);
        }

        public function dummyFunctionToTestConnectionCreation() {
            $pdo = $this->getPDOConnectionToDbAndVerifyUser("To test the HackinDbHelper class");
            $this->newAccessToDb($pdo, $this->db_game_engine, "game_engine");
        }

/**
    +********************************************************** HACKIN STATIC FUNCTIONS SEGMENT ***********************************************************+
*/
        

/**
    +********************************************************** HACKIN MEMBER FUNCTIONS SEGMENT ***********************************************************+
*/
    }
?>