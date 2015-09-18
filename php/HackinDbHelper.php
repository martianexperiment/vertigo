<?php
    require_once("HackinErrorHandler.php");
    require_once("HackinGlobalFunctions.php");
    require_once("models/hackinSessionInfo.php");
    require_once('models/HackinUserInfo.php');
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

        private $debug = 0;

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
        private function getPDOConnectionToDbAndVerifyUser($additionalInfo="NULL") {
            if($this->debug) {
                echo "<br><br>getPDOConnectionToDbAndVerifyUser()<br>"."dsn=" . $this->dsn . ", user=" . $this->user . ", pwd=". $this->pwd . ", db_test=" . $this->db_test;
            }
            $pdo = self::createPDOConnectionToDbAndVerifyUser($this->dsn, $this->user, $this->pwd, $this->db_test);
            $this->newConnectionCreated($pdo, $additionalInfo);
            return $pdo;
        }

        /**
            Steps to be done on creation of new connection
            Excluded for logging db_access made as the functions are not static (=> cannot be called from constructor)
            Only getPDOConnectionToDbAndVerifyUser() should call this method
        */
        private function newConnectionCreated($pdo, $additionalInfo="NULL") {
            $connection_logger_query = 
                "insert into `" . $this->db_connection_logger . "`.`connections_creation_logger` " . 
                    "(      `additional_info`     ) values " . 
                    "( '" . $additionalInfo . "' )";
            if($this->debug) {
                echo "<br><br>newConnectionCreated()<br>" . $connection_logger_query;
            }
            $pdo->query($connection_logger_query);
        }

        /**
            Steps to be done while accessing a db
            Excludes those access made while logging the connection creation and db access for this function
        */
        private function newAccessToDb($pdo, $db_name, $additionalInfo = "NULL") {
            $db_logger_query = 
                "insert into `" . $this->db_connection_logger . "`.`connections_db_access_logger` " .
                    "(      `db_name`     ,      `additional_info`    ) values " .
                    "( '" . $db_name . "' , '" . $additionalInfo ."' )";
            if($this->debug) {
                echo "<br><br>newAccessToDb():<br>" . $db_logger_query;
            }
            $pdo->query($db_logger_query);
        }

/**
    +********************************************************** HACKIN FUNCTIONS TESTING SEGMENT ***********************************************************+
*/
        public function testConnectionCreation() {
            $pdo = $this->getPDOConnectionToDbAndVerifyUser("To test the HackinDbHelper class");
            $this->newAccessToDb($pdo, $this->db_game_engine, "game_engine");
        }

        public function testGetAliveHackinSessionNotEqualToCurrentSession() {
            $hackinUserInfo = new HackinUserInfo("thirukkakarnan@gmail.com", "Karnaa", "1", "", "9842146152", "11PW38", "", "", "");
            $suffix = "hackin_";
            $hackinSessionId = uniqid($suffix);//openssl_random_pseudo_bytes() can also be used.
            $hackinSessionInfo = new HackinSessionInfo("thirukkakarnan@gmail.com", "php_session_id", time(), $hackinSessionId, "some more info");

            /**/echo "<br><br>checkMultipleAccessTest():<br>session info";
            echo json_encode($hackinSessionInfo);
            echo "<br> user info";
            echo json_encode($hackinUserInfo);//*/

            $this->getAliveHackinSessionNotEqualToCurrentSession($hackinSessionInfo, $hackinUserInfo);
        }

/**
    +********************************************************** HACKIN STATIC FUNCTIONS SEGMENT ***********************************************************+
*/
        

/**
    +********************************************************** HACKIN MEMBER FUNCTIONS SEGMENT ***********************************************************+
*/
        /**
            function to retrieve live session information from db.
            NOTE: This session may get expired though(Zombie).
            TODO: validate the zombiness of the session.
            return: $liveHackinSessionInfo object for a given $hackinUserInfo
        */
        private function getLiveSessionInfo($pdo, $hackinUserInfo) {
            $functionalityForWhichExceptionExpected = "Retreiving alive session for the user:" . $hackinUserInfo->emailId;
            $liveHackinSessionInfo = NULL;
            try {
                $db_live_session_retrieval_query = 
                    "select * from `" . $this->db_accounts . "`.`sessions_alive` " .
                        "where `email_id` = '". $hackinUserInfo->emailId . "'";
                if($this->debug) {
                    echo "<br><br>getLiveSessionInfo():<br>" . $db_live_session_retrieval_query;
                }
                $stmt = $pdo->query($db_live_session_retrieval_query);
                $row_count = $stmt->rowCount();
                if($row_count == 0) {
                    return NULL;
                }
                if($row_count > 1) {
                    $ex = "Integrity constraint violation. Multiple alive sessions stored in db for same user";
                    throw $ex;
                }
                $liveHackinSessionInfo = new HackinSessionInfo();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($rows as $row) {
                    foreach($row as $field => $fieldValue) {
                        $member = HackinGlobalFunctions::underscores_toCamelCase($field);
                        /**
                            TODO: Move this functionality to HackinGlobalFunctions.php and generalize it for nested classes too.
                        */
                        $liveHackinSessionInfo->$member = $fieldValue;
                    }
                    if($this->debug) {
                        echo "<br>liveHackinSessionInfo (for user= " . $hackinUserInfo->emailId . ")= ". json_encode($liveHackinSessionInfo);
                    }
                }
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                exit();
            }
            return $liveHackinSessionInfo;
        }

        /**
            check for multiple sessions.
            Multiple sessions need not denote multiple active sessions. Some may be stale due to not logging out too.
            Check live sessions from db, and update them.
            return: $liveHackinSessionInfo;
                    if(strcasecmp($liveHackinSessionInfo->hackinSessionId), $hackinSessionId)==0) 
                        //proceed, user who logs in for the first time or the same user who logged previously.
                        //TODO: all logging should have been done.
                    else 
                        //take care of multiple alive sessions.
        */
        public function getAliveHackinSessionNotEqualToCurrentSession($hackinSessionInfo, $hackinUserInfo) {
            $additionalInfo =  '{"Check Multiple Access": {
                                    "hackinSessionId": ' . json_encode($hackinSessionInfo) . ',
                                    "hackinUserInfo": ' . json_encode($hackinUserInfo). '
                                    }
                                }';
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
            $liveHackinSessionInfo = $this->getLiveSessionInfo($pdo, $hackinUserInfo);

            if($this->debug) {
                echo "<br> checkMultipleAccess():";
                echo "<br> user info";
                echo json_encode($hackinUserInfo);
                echo "<br>hackin session info";
                echo json_encode($hackinSessionInfo);
                echo "<br> live session info";
                echo json_encode($liveHackinSessionInfo);;
            }

            if($liveHackinSessionInfo == NULL) {
                $liveHackinSessionInfo = $hackinSessionInfo;
                $db_live_session_accounting_query = 
                    "insert into  `" . $this->db_accounts . "`.`sessions_alive` " .
                        "(     `email_id`                    ,             `php_session_id`                   ,             `hackin_session_id`                          )  values " .
                        "( '". $liveHackinSessionInfo->emailId . "' , '" . $liveHackinSessionInfo->phpSessionId . "' , '" . $liveHackinSessionInfo->hackinSessionId . "' )";
            
                if($this->debug) {
                    echo "<br><br>checkMultipleAccess(): db_live_session_accounting_query<br>" . $db_live_session_accounting_query;
                }
            
                $stmt = $pdo->query($db_live_session_accounting_query);
            } else if(strcasecmp($liveHackinSessionInfo->hackinSessionId, $hackinSessionInfo->hackinSessionId) == 0){
                $db_live_session_updation_query = 
                    "update `" . $this->db_accounts . "`.`sessions_alive` " . 
                        "set `last_login_time` = now()" . 
                        "where `email_id` = '". $liveHackinSessionInfo->emailId ."'";

                if($this->debug) {
                    echo "<br><br>checkMultipleAccess: db_live_session_updation_query<br>" . $db_live_session_updation_query;
                }

                $pdo->query($db_live_session_updation_query);
            } else {
                if($this->debug) {
                    echo "other logins are alive: ". json_encode($liveHackinSessionInfo);
                }
            }
            return $liveHackinSessionInfo;
        }
    }
?>