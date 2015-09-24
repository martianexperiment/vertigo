<?php
    require_once(__DIR__ . "/HackinErrorHandler.php");
    require_once(__DIR__ . "/HackinJsonHandler.php");

    require_once(__DIR__ . "/models/HackinSessionInfo.php");
    require_once(__DIR__ . "/models/HackinUserInfo.php");
    require_once(__DIR__ . "/models/HackinGameState.php");
    require_once(__DIR__ . "/config/HackinConfig.php");

    /**
        Wrapper over PDO (or mysqli) connections to create and use database connections privately and dynamically
        List of all databases should be mentioned before hand, during construction
        TODO: Move all configuration parameters out of the class
    */
    class HackinDbHelper {
        private $host;
        private $user;
        private $pwd;
        private $dsn;
        private $dbPlatform;
        
        private $db_accounts;
        private $db_game_engine;
        private $db_quora;
        private $db_logger;
        private $db_test;
        private $db_connection_logger;
        private $db_session_logger;
        private $db_request_logger;

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
            $this->host = HackinConfig::$dbServer;
            $this->user = HackinConfig::$dbUser;
            $this->pwd =  HackinConfig::$dbPwd;

            $this->dbPlatform = HackinConfig::$dbPlatform;
            $this->db_accounts = HackinConfig::$db_accounts;
            $this->db_game_engine = HackinConfig::$db_game_engine;
            $this->db_quora = HackinConfig::$db_quora;
            $this->db_logger = HackinConfig::$db_logger;
            $this->db_test = HackinConfig::$db_test;
            $this->db_connection_logger = HackinConfig::$db_connection_logger;
            $this->db_session_logger = HackinConfig::$db_session_logger;
            $this->db_request_logger = HackinConfig::$db_request_logger;

            $this->dsn = self::createDsnBasedOnDb($this->host, $this->dbPlatform);
            $pdo = self::createPDOConnectionToDbAndVerifyUser($this->dsn, $this->user, $this->pwd, $this->db_test);

            try {
                $functionalityForWhichExceptionExpected = "verifying connection with the dbs";
                /**
                    QUERY: check presence of db
                */
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
                echo "<br><br>getPDOConnectionToDbAndVerifyUser()<br>";
                //echo "dsn=" . $this->dsn . ", user=" . $this->user . ", pwd=". $this->pwd . ", db_test=" . $this->db_test;
                //don't allow logging of username and password even while debugging
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
            /**
                QUERY: logger, connection creation.
            */
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
            /**
                QUERY: logger, connection's db access.
            */
            $db_logger_query = 
                "insert into `" . $this->db_connection_logger . "`.`connections_db_access_logger` " .
                    "(      `db_name`     ,      `additional_info`   ) values " .
                    "( '" . $db_name . "' , '" . $additionalInfo ."' )";
            if($this->debug) {
                echo "<br><br>newAccessToDb():<br>" . $db_logger_query;
            }
            $pdo->query($db_logger_query);
        }

        private function newSessionAccess($pdo, $sessionAccessType) {

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
            $hackinUserMonitor = new HackinUserMonitor();
            $userBrowserInfo = $hackinUserMonitor->userBrowserInfo;
            $userIpInfo = $hackinUserMonitor->userIpInfo;
            $hackinSessionInfo = new HackinSessionInfo("thirukkakarnan@gmail.com", "somePHPId", uniqid("hackin_"), 
                                                        time(), time(), time(),
                                                        $userBrowserInfo->userAgent, $userBrowserInfo->browser, $userBrowserInfo->browserDetails,
                                                        $userIpInfo->ip, $userIpInfo->ipDetails);
            /**/echo "<br><br>checkMultipleAccessTest():<br>session info";
            echo json_encode($hackinSessionInfo);
            echo "<br> user info";
            echo json_encode($hackinUserInfo);//*/

            $this->getLiveSessionInfo($hackinUserInfo);
        }

        public function testHasUserRegistered() {
            $hackinUserInfo = new HackinUserInfo("thirukkakarnan@gmail.com", "Karnaa", "1", "", "9842146152", "11PW38", "", "", "");
            $result = $this->hasUserRegistered($hackinUserInfo);
            echo "has user registered:" . $result;
            $this->registerNewUserAndCreateGameState($hackinUserInfo);
            return;
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
        public function getLiveSessionInfo($hackinUserInfo) {
            $additionalInfo =  '{"getLiveSessionInfo": {' .
                                    '"hackinUserInfo": ' . json_encode($hackinUserInfo) . 
                                    '}' .
                                '}';
            if($this->debug) {
                echo $additionalInfo;
            }
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
            $functionalityForWhichExceptionExpected = "Retreiving alive session for the user:" . $hackinUserInfo->emailId;
            $liveHackinSessionInfo = NULL;
            try {
                /**
                    Query: logger, session, Live session retrieval
                */
                $db_live_session_retrieval_query = 
                    "select * from `" . $this->db_accounts . "`.`sessions_alive` " .
                        "where " . 
                            "`email_id` = '". $hackinUserInfo->emailId . "'";
                if($this->debug) {
                    echo "<br><br>getLiveSessionInfo():<br>" . $db_live_session_retrieval_query;
                }
                $stmt = $pdo->query($db_live_session_retrieval_query);
                $row_count = $stmt->rowCount();
                if($row_count == 0) {
                    return NULL;
                }
                if($row_count > 1) {
                    $ex = new Exception("Integrity constraint violation. Multiple alive sessions stored in db for same user");
                    throw $ex;
                }
                $liveHackinSessionInfo = new HackinSessionInfo();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($rows as $row) {
                    $liveHackinSessionInfo = HackinJsonHandler::hackinSessionInfoRetrievalFromObject($row);
                    
                    if($this->debug) {
                        echo "<br>liveHackinSessionInfo (for user= " . $hackinUserInfo->emailId . ")= ". json_encode($liveHackinSessionInfo);
                    }
                }
                $liveHackinSessionInfo->lastLoginTime = HackinGlobalFunctions::timeStampFromSqlToPhp($liveHackinSessionInfo->lastLoginTime);
                $liveHackinSessionInfo->lastRefreshTime = HackinGlobalFunctions::timeStampFromSqlToPhp($liveHackinSessionInfo->lastRefreshTime);
                $liveHackinSessionInfo->lastActiveTime = HackinGlobalFunctions::timeStampFromSqlToPhp($liveHackinSessionInfo->lastActiveTime);
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                exit();
            }
            return $liveHackinSessionInfo;
        }

        public function hasUserRegistered($hackinUserInfo) {
            $additionalInfo =  '{"hasUserRegistered": {' .
                                    '"hackinUserInfo": ' . json_encode($hackinUserInfo) . 
                                '}';
            if($this->debug) {
                echo $additionalInfo;
            }
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
            /**
                QUERY:: registration, check if the user is registered
            */
            $db_check_user_registration_query = 
                "SELECT " . 
                    " * " .
                " FROM " .
                    $this->db_accounts . ".`registration`" .
                " WHERE " .
                    " `email_id`='". $hackinUserInfo->emailId ."'";
            if($this->debug) {
                echo $db_check_user_registration_query;
            }
            $stmt = $pdo->query($db_check_user_registration_query);
            $row_count = $stmt->rowCount();
            if($row_count > 1) {
                $ex = new Exception("Integrity constraint violation. Multiple alive sessions stored in db for same user");
                throw $ex;
            }
            $hasUserRegistered = 0;
            if($row_count == 1) {
                $hasUserRegistered = 1;
            }
            if($this->debug) {
                echo "<br>hasUserRegistered=".$hasUserRegistered;
            }
            return $hasUserRegistered;
        }

        public function registerNewUserAndCreateGameState($hackinUserInfo) {
            $additionalInfo =  '{"registerNewUser": {' .
                                    '"hackinUserInfo": ' . json_encode($hackinUserInfo) . 
                                '}';
            if($this->debug) {
                echo $additionalInfo;
            }
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
            if($this->debug) {
                print_r($additionalInfo);
            }
            /**
                QUERY:: register new user, registration db, first time the user arrives
            */
            $db_register_user_query = 
                "INSERT INTO `". $this->db_accounts . "`.`registration` 
                    (     `email_id`
                        , `screen_name`
                        , `roll_no`
                        , `is_user_alumni`
                        , `profile_pic`
                        , `phone_no`
                        , `college_code`
                        , `department_name`
                        , `college_name`
                    ) VALUES (
                        :emailId,
                        :screenName,
                        :rollNo,
                        :isUserAlumni,
                        :profilePic,
                        :phoneNo,
                        :collegeCode,
                        :departmentName,
                        :collegeName
                    )";
            $stmt = $pdo->prepare($db_register_user_query);
            $stmt->execute(
                array(
                    ":emailId"      => $hackinUserInfo->emailId,
                    ":screenName"   => $hackinUserInfo->screenName,
                    ":rollNo"       => $hackinUserInfo->rollNo,
                    ":isUserAlumni" => $hackinUserInfo->isUserAlumni,
                    ":profilePic"   => $hackinUserInfo->profilePic,
                    ":phoneNo"      => $hackinUserInfo->phoneNo,
                    ":collegeCode"  => $hackinUserInfo->collegeCode,
                    ":departmentName" => $hackinUserInfo->departmentName,
                    ":collegeName"  => $hackinUserInfo->collegeName
                )
            );
            if($this->debug) {
                echo "<br>******db_register_user_query::";
                $stmt->debugDumpParams();
            }
            $additionalInfo =  '{"createGameState": {' .
                                    '"hackinUserInfo": ' . json_encode($hackinUserInfo) . 
                                '}';
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);

            /**
                QUERY: Game engine, create game state, registering new user
            */
            $db_create_game_state = 
                "insert into `". $this->db_accounts . "`.`game_state` 
                    (
                        email_id,
                        is_user_alumni
                    ) values 
                    (" .
                        "'" .   $hackinUserInfo->emailId . "'" .
                        ", '" . $hackinUserInfo->isUserAlumni . "'" .
                    ")"; 
            $pdo->query($db_create_game_state);
        }

        public function logRefresh($hackinSessionInfo) {
            $additionalInfo = '{"logRefresh()": {' . 
                                    '"HackinSessionInfo": ' . json_encode($hackinSessionInfo) .
                                '}';
            if($this->debug) {
                echo "<br><br>".$additionalInfo;
            }
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            //$this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
        }

        public function logForceLogin($hackinSessionInfo) {
            $additionalInfo = '{"logForceLogin()": {' . 
                                    '"HackinSessionInfo": ' . json_encode($hackinSessionInfo) .
                                '}';
            if($this->debug) {
                echo "<br><br>".$additionalInfo;
            }
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            //$this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
        }

        public function createLiveHackinSession($hackinSessionInfo) {
            $additionalInfo =  '{"createLiveHackinSession": {' .
                                    '"hackinSessionInfo": ' . json_encode($hackinSessionInfo) . 
                                '}';
            if($this->debug) {
                echo "createLiveHackinSession():";
                print_r($additionalInfo);
            }
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
            $liveHackinSessionInfo = $hackinSessionInfo;
            $functionalityForWhichExceptionExpected = "create new live HackinSessionInfo for session:" . json_encode($hackinSessionInfo);
            try {
                /**
                    QUERY: logger, session, account new incoming session
                */
                $db_new_live_session_accounting_query = 
                    "insert into " . $this->db_accounts . ".`sessions_alive` ( " .
                            "`email_id` " .
                            ", `php_session_id` " .
                            " , `hackin_session_id` " . 
                            " , `last_login_time` " .
                            ", `last_refresh_time` " .
                            ", `last_active_time` " .
                             ", `last_active_user_agent` " .
                             ", `last_active_browser` " .
                             ", `last_active_browser_details` " .
                             " , `last_active_ip` , `last_active_ip_details` " . 
                        ") values ( " .
                        " :emailId , :phpSessionId , :hackinSessionId " . 
                        ", :lastLoginTime            ,  :lastRefreshTime               ,   :lastActiveTime" .
                        ", :lastActiveUserAgent, :lastActiveBrowser, :lastActiveBrowserDetails " .
                        ", :lastActiveIp, :lastActiveIpDetails" .
                        ")";
            
                $stmt = $pdo->prepare($db_new_live_session_accounting_query);
                $array = array( ":emailId"                   => $liveHackinSessionInfo->emailId
                                , ":phpSessionId"              => $liveHackinSessionInfo->phpSessionId
                                , ":hackinSessionId"           => $liveHackinSessionInfo->hackinSessionId
                                , ":lastLoginTime"             => HackinGlobalFunctions::timeStampFromPhpToSql($liveHackinSessionInfo->lastLoginTime)
                                , ":lastRefreshTime"           => HackinGlobalFunctions::timeStampFromPhpToSql($liveHackinSessionInfo->lastRefreshTime)
                                , ":lastActiveTime"            => HackinGlobalFunctions::timeStampFromPhpToSql($liveHackinSessionInfo->lastActiveTime)
                                , ":lastActiveUserAgent"       => $liveHackinSessionInfo->lastActiveUserAgent
                                , ":lastActiveBrowser"         => $liveHackinSessionInfo->lastActiveBrowser
                                , ":lastActiveBrowserDetails"  => $liveHackinSessionInfo->lastActiveBrowserDetails
                                , ":lastActiveIp"              => $liveHackinSessionInfo->lastActiveIp
                                , ":lastActiveIpDetails"       => $liveHackinSessionInfo->lastActiveIpDetails
                                );
                $stmt->execute($array);
                
                if($this->debug) {
                    echo "<br><br>checkMultipleAccess(): db_live_session_accounting_query<br>" . $db_new_live_session_accounting_query;
                    $stmt->debugDumpParams();
                }
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                exit();
            }
        }

        /**
            TODO: rename it to refreshLiveSession
        */
        public function updateLiveSession($liveHackinSessionInfo) {
            $additionalInfo =  '{"updateLiveSession": {' .
                                    '"liveHackinSessionInfo": ' . json_encode($liveHackinSessionInfo) . 
                                '}';
            if($this->debug) {
                echo "updateLiveSession():";
                print_r($additionalInfo);
            }
            $functionalityForWhichExceptionExpected = "updateLiveSession: " . json_encode($liveHackinSessionInfo);
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
            try{
                /**
                    QUERY: session, time log, page refresh (=> active time)
                */
                $db_live_session_updation_query = 
                    "update `" . $this->db_accounts . "`.`sessions_alive` " . 
                        "set `last_active_time` = now(),  `last_refresh_time` = now() " .
                        "where `email_id` = '". $liveHackinSessionInfo->emailId ."' ";
                
                if($this->debug) {
                    echo "<br><br>firstLiveSession: db_live_session_updation_query<br>" . $db_live_session_updation_query;
                }

                $pdo->query($db_live_session_updation_query);
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                exit();
            }
        }

        public function updateNewLiveSession($liveHackinSessionInfo) {
            $additionalInfo =  '{"updateNewLiveSession": {' .
                                    '"liveHackinSessionInfo": ' . json_encode($liveHackinSessionInfo) . 
                                '}';
            if($this->debug) {
                echo $additionalInfo;
            }
            $functionalityForWhichExceptionExpected = $additionalInfo;
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
            try{
                /**
                    QUERY: logger, session, force access.
                */
                $db_force_live_session_accounting_query = 
                    "update `" . $this->db_accounts . "`.`sessions_alive`  " .
                        "set php_session_id = '". $liveHackinSessionInfo->phpSessionId . "'" .
                            ", hackin_session_id = '" . $liveHackinSessionInfo->hackinSessionId . "'" .
                            ", last_login_time = now() " .
                            ", last_refresh_time = now() " .
                            ", last_active_time = now() " .
                            ", last_active_user_agent = '" . $liveHackinSessionInfo->lastActiveUserAgent . "'" .
                            ", last_active_browser = '" . $liveHackinSessionInfo->lastActiveBrowser . "'" .
                            ", last_active_browser_details = '" . $liveHackinSessionInfo->lastActiveBrowserDetails . "'".
                            ", last_active_ip = '" . $liveHackinSessionInfo->lastActiveIp . "'" .
                            ", last_active_ip_details = '" . $liveHackinSessionInfo->lastActiveIpDetails . "'" .
                            "where email_id = '" . $liveHackinSessionInfo->emailId . "' ";
                    /*"update `" . $this->db_accounts . "`.`sessions_alive`  " .
                            "set `php_session_id` = :phpSessionId" .
                            " , `hackin_session_id` = :hackinSessionId" . 
                            " , `last_login_time` = :lastLoginTime" .
                            ", `last_refresh_time` = :lastRefreshTime" .
                            ", `last_active_time` = :lastActiveTime" .
                             ", `last_active_user_agent` = :lastActiveUserAgent" .
                             ", `last_active_browser` = :lastActiveBrowser" .
                             ", `last_active_browser_details` = :lastActiveBrowserDetails" .
                             " , `last_active_ip` = :lastActiveIp" .
                             ", `last_active_ip_details` = :lastActiveIpDetails" . 
                        "where `email_id` = :emailId";
            
                $stmt = $pdo->prepare($db_new_live_session_accounting_query);
                $array = array(   ":phpSessionId"              => $liveHackinSessionInfo->phpSessionId
                                , ":hackinSessionId"           => $liveHackinSessionInfo->hackinSessionId
                                , ":lastLoginTime"             => HackinGlobalFunctions::timeStampFromPhpToSql($liveHackinSessionInfo->lastLoginTime)
                                , ":lastRefreshTime"           => HackinGlobalFunctions::timeStampFromPhpToSql($liveHackinSessionInfo->lastRefreshTime)
                                , ":lastActiveTime"            => HackinGlobalFunctions::timeStampFromPhpToSql($liveHackinSessionInfo->lastActiveTime)
                                , ":lastActiveUserAgent"       => $liveHackinSessionInfo->lastActiveUserAgent
                                , ":lastActiveBrowser"         => $liveHackinSessionInfo->lastActiveBrowser
                                , ":lastActiveBrowserDetails"  => $liveHackinSessionInfo->lastActiveBrowserDetails
                                , ":lastActiveIp"              => $liveHackinSessionInfo->lastActiveIp
                                , ":lastActiveIpDetails"       => $liveHackinSessionInfo->lastActiveIpDetails
                                , ":emailId"                   => $liveHackinSessionInfo->emailId
                                );
                print_r("The final array is::".$array);
                //$stmt->execute($array);*/
                if($this->debug) {
                    echo "The update query is::" . $db_force_live_session_accounting_query;
                }
                $pdo->query($db_force_live_session_accounting_query);
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                exit();
            }
        }

        public function removeLiveHackinSession($hackinSessionInfo) {
            $additionalInfo = '{"logout-removeLiveHackinSession" :' . json_encode($hackinSessionInfo) . ' }' ;
            if($this->debug) {
                echo $additionalInfo;
            }
            $functionalityForWhichExceptionExpected = $additionalInfo;
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
            try{
                /**
                    QUERY: session, logout, delete live session
                */
                $db_live_session_deletion_query = 
                    "delete from `". $this->db_accounts ."`.`sessions_alive` where email_id = '" . $hackinSessionInfo->emailId . "' and hackin_session_id = '" . $hackinSessionInfo->hackinSessionId . "'" ;
                if($this->debug) {
                    echo "<br><br>removeLiveHackinSession: db_live_session_deletion_query<br>" . $db_live_session_deletion_query;
                    echo "<br>";
                    print_r($hackinSessionInfo);
                }

                $pdo->query($db_live_session_deletion_query);
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                exit();
            }
        }

        public function getHackinGameStateForRegisterdUser($hackinUserInfo) {
            $additionalInfo = '{"getGameState":' . json_encode($hackinUserInfo). ' }';
            if($this->debug) {
                echo "getHackinGameStateForRegisterdUser():";
                print_r($additionalInfo);
            }
            $functionalityForWhichExceptionExpected = $additionalInfo;
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
            try{
                /**
                    QUERY: gameEngine, gameState retrieval
                */
                $db_game_state_retrieval_query = 
                    "select * from `". $this->db_accounts ."`.`game_state` where email_id = '" . $hackinUserInfo->emailId . "'" ;
                if($this->debug) {
                    echo "<br><br>getHackinGameState: db_game_state_retrieval_query<br>" . $db_game_state_retrieval_query;
                    echo "<br>";
                    print_r($hackinUserInfo);
                }
                $hackinGameState="";
                $stmt = $pdo->query($db_game_state_retrieval_query);
                $row_count = $stmt->rowCount();
                if($row_count == 0) {
                    $ex = new Exception("Game state table empty.. Violating constraints");
                    throw $ex;
                }
                if($row_count > 1) {
                    $ex = new Exception("Integrity constraint violation. Multiple game states stored in db for same user");
                    throw $ex;
                }
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($rows as $row) {
                     $hackinGameState = HackinJsonHandler::hackinGameStateInfoRetrievalFromObject($row);
                    
                    if($this->debug) {
                        echo "<br>hackinGameState (for user= " . $hackinUserInfo->emailId . ")= ". json_encode($hackinGameState);
                    }
                }
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                exit();
            }
            return $hackinGameState;
        }

        public function getHackinQuestionStateForRegisterdUser($hackinUserInfo, $qnNo) {
            $additionalInfo = '{"getQuestionState":' . json_encode($hackinUserInfo). ' }';
            if($this->debug) {
                echo "getHackinQuestionStateForRegisterdUser():";
                print_r($additionalInfo);
            }
            $functionalityForWhichExceptionExpected = $additionalInfo;
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
            $hackinQuestionState = new HackinQuestionState();
            try{
                /**
                    QUERY: gameEngine, questionState retrieval
                */
                $db_question_state_retrieval_query = 
                    "SELECT " . 
                        "qn_state.* " .
                        ", qn.max_no_of_attempts_allowed " .
                    "FROM " .
                        "`" . $this->db_accounts . "`.`question_state` qn_state " .
                    "JOIN " .
                        "`" . $this->db_quora ."`.`question_details` qn " .
                        " ON qn.question_no = qn_state.question_no " .
                    "WHERE " .
                        "qn_state.question_no = " . intval($qnNo) . " " .
                        "and qn_state.email_id = '" . $hackinUserInfo->emailId . "'" ;
                    //"select * from `". $this->db_accounts ."`.`game_state` where email_id = '" . $hackinUserInfo->emailId . "'" ;

                if($this->debug) {
                    echo "<br><br>getHackinQuestionState: db_question_state_retrieval_query<br>" . $db_question_state_retrieval_query;
                    echo "<br>";
                    print_r($hackinUserInfo);
                }

                $stmt = $pdo->query($db_question_state_retrieval_query);
                $row_count = $stmt->rowCount();
                if($row_count > 1) {
                    $ex = new Exception("Integrity constraint violation. Multiple question states stored in db for same user");
                    throw $ex;
                }
                if($row_count == 0) {
                    /**
                        QUERY: Game engine, question state, create question state for the current question for this User
                    */
                    $additionalInfo = "{ \"questionStateCreation\": { " .
                                            "\"emailId\": " . json_encode($hackinUserInfo->emailId) . ", " .
                                            "\"questionNo\": " . intval($qnNo) . " " .
                                      "}";
                    if($this->debug) {
                        echo "<br>" . $additionalInfo;
                    }
                    $functionalityForWhichExceptionExpected = $additionalInfo;
                    $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
                    $db_question_state_creation_query = 
                        "Insert into `" . $this->db_accounts . "`.`question_state`  " .
                            "(" .
                                "email_id, " .
                                "question_no " .
                            ") values " .
                            "(" .
                                "'" . $hackinUserInfo->emailId . "', " .
                                "" . intval($qnNo) . " " .
                            ")";
                    if($this->debug) {
                        echo "<br>inserting question state():query:<br>" . $db_question_state_creation_query;
                    }
                    $pdo->query($db_question_state_creation_query);
                    $hackinQuestionState = $this->getHackinQuestionStateForRegisterdUser($hackinUserInfo, $qnNo);
                } else {
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if($this->debug) {
                        print_r($rows);
                    }
                    $hackinQuestionState = new HackinQuestionState();
                    foreach($rows as $row) {
                         $hackinQuestionState = HackinJsonHandler::hackinQuestionStateInfoRetrievalFromObject($row);
                        if($this->debug) {
                            echo "<br>hackinQuestionState (for user= " . $hackinUserInfo->emailId . " and for question= ". intval($qnNo) .
                                " )= ". json_encode($hackinQuestionState);
                        }
                    }
                }
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                exit();
            }
            return $hackinQuestionState;
        }

        public function validateAnswerAndLogResults($hackinUserInfo, $hackinSessionInfo, $qnNo, $answer, $isViolationDetected) {
            $isCorrectAnswer = 0;
            $md5Answer = md5($answer);
            if($isViolationDetected == 1) {
                $isCorrectAnswer = 0;
            } else {
                $pdo = $this->getPDOConnectionToDbAndVerifyUser();
                $this->newAccessToDb($pdo, $this->db_quora);
                /**
                    QUERY: quora, answer, validation
                */
                $db_answer_verification_query = 
                    "select " .
                        "* ".
                    "from " .
                        "`" . $this->db_quora . "`.`answer_details` " .
                    "where " . 
                         "question_no = " . intval($qnNo) . " " .
                    "and answer = '" . md5($answer) . "' ";

                if($this->debug) {
                    echo "<br>validateAnswer(): query:</br>" . $db_answer_verification_query . "<br>";
                }
                $stmt = $pdo->query($db_answer_verification_query);
                $row_count = $stmt->rowCount();
                if($row_count > 1) {
                    $ex = new Exception("Integrity constraint violation. Same answer duplicated in db for same question");
                    throw $ex;
                }
                $isCorrectAnswer = $row_count;
            }
            $this->logAnswer($hackinUserInfo, $hackinSessionInfo, $qnNo, $answer, $isCorrectAnswer, $isViolationDetected);
            $questionState = $this->getHackinQuestionStateForRegisterdUser($hackinUserInfo, $qnNo);
            $questionState->isViolationDetected = $isViolationDetected;
            if($isViolationDetected) {
                //TODO: integrate 
            }
            return $questionState;
        }

        public function logAnswer($hackinUserInfo, $hackinSessionInfo, $qnNo, $answer, $isCorrectAnswer, $isViolationDetected) {
            $additionalInfo = '{"logAnswer": {' . 
                                    '"hackinUserInfo": ' . json_encode($hackinUserInfo) . ", " .
                                    '"hackinSessionInfo": ' . json_encode($hackinSessionInfo) . ", " .
                                    '"questionNo": ' . $qnNo . ", " .
                                    '"answer": ' . json_encode($answer) . ', ' .
                                    '"isCorrectAnswer": ' . json_encode($isCorrectAnswer) . ', ' .
                                    '"isViolationDetected": ' . $isViolationDetected . " " .
                                '}';
            if($this->debug) {
                echo "<br>logAnswer:<br>".$additionalInfo;
            }
            $pdo = $this->getPDOConnectionToDbAndVerifyUser($additionalInfo);
            $this->newAccessToDb($pdo, $this->db_accounts, $additionalInfo);
            /**
                QUERY: game engine, answer validation done, log answer in question state
            */
            $db_update_question_state_query = 
                "update question_state " .
                    "set " . 
                        "no_of_attempts_made = no_of_attempts_made+1 " . 
                        ", has_solved = " . $isCorrectAnswer . " "  .
                "where "  .
                    "email_id = '" . $hackinUserInfo->emailId ."' " .
                    "and question_no = " . intval($qnNo) . " ";
            if($this->debug) {
                echo "<br>logAnswerAttempt()<br>". $db_update_question_state_query;
            }
            $pdo->query($db_update_question_state_query);
        }
    }
?>