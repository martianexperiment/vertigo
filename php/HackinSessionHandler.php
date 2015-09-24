<?php
    require_once(__DIR__ . "/HackinSessionStarter.php");
    require_once(__DIR__ . "/HackinDbHelper.php");

    require_once(__DIR__ . "/models/HackinSession.php");
    require_once(__DIR__ . "/models/HackinUserMonitor.php");
    require_once(__DIR__ . "/config/HackinConfig.php");
    /**
        The only place where session variables are to be accessed.
        To maintain the code clean and for easier maintenance of changes to session variables.
    */
    class HackinSessionHandler {
        /**
            Verify whether all required session variables are set.
            return: throws exception if not.
        */
        public static $debug = 0;   
        private static $hackinDbHelper;

        public function __construct($hackinDbHelper = NULL) {
            if($hackinDbHelper == NULL) {
                $hackinDbHelper = new HackinDbHelper();
            }
            self::$hackinDbHelper = $hackinDbHelper;
        }

        public static function verifySession() {
            if(!isset($_SESSION)) {
                $ex = new Exception("verifySession(): Session has not been started. Game play requires session creation. Please sign in again");
                throw $ex;
            }
            if(self::$debug) {
                print_r($_SESSION);
            }
            if(empty($_SESSION['ses_auth'])) {
                $ex = new Exception("verifySession(): Session has not been authenticated. Game play requires authenticated session. Please sign in again.");
                throw $ex;
            }
            if(empty($_SESSION['ses_account_type']) || ($_SESSION['ses_account_type'] != "PAR" && $_SESSION['ses_account_type'] != "ALU")) {
                $ex = new Exception("verifySession(): (user | alumni)?");
                throw $ex;
            }
            if(empty($_SESSION['ses_email']) || empty($_SESSION['ses_phone'])) {
                $ex = new Exception("verifySession(): user details insufficient.. (email|phone_no)==NULL??");
                throw $ex;
            }
            if(strcasecmp($_SESSION['ses_account_type'], "PAR") == 0 && (empty($_SESSION['ses_cCode']) || empty($_SESSION['ses_college_name']) || empty($_SESSION['ses_dept_name']))) {
                $ex = new Exception("verifySession(): participant details insufficient (cCode|collegeName|departmentName)==NULL??");
                throw $ex;
            }
            if(strcasecmp($_SESSION['ses_account_type'], "ALU") == 0 && (empty($_SESSION['ses_alumni_rollno']) || empty($_SESSION['ses_alumni_name']))) {
                $ex = new Exception("verifySession(): alumni details insufficient. (rollno|name)==NULL??");
                throw $ex;
            }
        }

        public static function getHackinUserInfo() {
            self::verifySession();
            $hackinUserInfo = NULL;
            $isUserAlumni = NULL;
            if(strcasecmp($_SESSION['ses_account_type'], 'PAR') == 0) {
                $isUserAlumni = $_SESSION['is_user_alumni'] = 0;
            } else {
                $isUserAlumni = $_SESSION['is_user_alumni'] = 1;
            }

            $emailId = $_SESSION['hackin_email'] = $_SESSION['ses_email'];
            $phoneNo = $_SESSION['hackin_phone'] = $_SESSION['ses_phone'];
            $collegeCode = $_SESSION['hackin_code'] = "";
            $collegeName = $_SESSION['hackin_college_name'] = "";
            $departmentName = $_SESSION['hackin_department_name'] = "";
            $rollNo = $_SESSION['hackin_alumni_rollno'] = "";
            $screenName = $_SESSION['hackin_alumni_name'] =  "";
            $profilePic = "";

            if($_SESSION['is_user_alumni'] == 0) {
                $collegeCode = $_SESSION['hackin_code'] = $_SESSION['ses_cCode'];
                $collegeName = $_SESSION['hackin_college_name'] = $_SESSION['ses_college_name'];
                $departmentName = $_SESSION['hackin_department_name'] = $_SESSION['ses_dept_name'];
            } else {
                $rollNo = $_SESSION['hackin_alumni_rollno'] = $_SESSION['ses_alumni_rollno'];
                $screenName = $_SESSION['hackin_alumni_name'] =  $_SESSION['ses_alumni_name'];
            }

            $hackinUserInfo = new HackinUserInfo($emailId, $isUserAlumni, $phoneNo, $screenName, $rollNo, $collegeCode, $departmentName, $collegeName, $profilePic);
            return $hackinUserInfo;
        }

        /**
            create unique id for every new session.
            openssl_random_pseudo_bytes() can also be used.
            return: $hackinSessionId
        */
        private static function createHackinSessionId() {
            $prefix = "hackin_";
            $hackinSessionId = uniqid($prefix);
            return $hackinSessionId;
        }

        public static function getHackinSessionId() {
            if(!isset($_SESSION['hackin_session'])) {
                //generate uniqid
                $hackinSessionId = self::createHackinSessionId();
                $_SESSION['hackin_session'] = $hackinSessionId;
            } else {
                //check whether he is the same as the last recently used user.
                $hackinSessionId = $_SESSION['hackin_session'];
            }
            return $hackinSessionId;
        }

        public static function getHackinUserMonitor() {
            self::verifySession();
            $hackinUserMonitor = new HackinUserMonitor();
            $userBrowserInfo = $hackinUserMonitor->userBrowserInfo;
            if(empty($userBrowserInfo->userAgent)) {
                $userBrowserInfo = new UserBrowserInfo($_SESSION['hackin_user_agent']);
            }
            $hackinUserMonitor->userBrowserInfo = $userBrowserInfo;
            return $hackinUserMonitor;
        }

        /**
            Function to get currentHackinSessionInfo
            TODO: get browser, ip and other details from php.
            return $currentHackinSessionInfo
        */
        public static function getCurrentHackinSessionInfo() {
            $hackinUserInfo = self::getHackinUserInfo();
            $hackinSessionId = self::getHackinSessionId();
            $hackinUserMonitor = self::getHackinUserMonitor();
            $userBrowserInfo = $hackinUserMonitor->userBrowserInfo;
            $userIpInfo = $hackinUserMonitor->userIpInfo;

            //HackinGlobalFunctions::timeStampFromPhpToSql(time()) can also be used.
            $hackinSessionInfo = new HackinSessionInfo($hackinUserInfo->emailId, session_id(), $hackinSessionId, 
                                                        time(), time(), time(),
                                                        $userBrowserInfo->userAgent, $userBrowserInfo->browser, $userBrowserInfo->browserDetails,
                                                        $userIpInfo->ip, $userIpInfo->ipDetails);
            return $hackinSessionInfo;
        }

        /**
            Verifies live session and redirects to interrupt handler if any
        */
        public static function verifyLiveSession() {
            try {
                $hackinDbHelper = self::$hackinDbHelper;

                self::verifySession();
                $hackinUserInfo = self::getHackinUserInfo();
                $hackinSessionInfo = self::getCurrentHackinSessionInfo();
                $additionalInfo = "verifyLiveSession()";

                $functionalityForWhichExceptionExpected = $additionalInfo;
                if(self::$debug) {
                    echo "<br>***************** verifying live session() page<br>";
                }
                $liveHackinSessionInfo = $hackinDbHelper->getLiveSessionInfo($hackinUserInfo);
                if(self::$debug) {
                    echo "<br>retrieve live session::<br>";
                    print_r($liveHackinSessionInfo);
                }
                if(self::$debug) {
                    echo "<br>";
                }
                if($liveHackinSessionInfo == NULL ) {
                    if(self::$debug) {
                        echo "live session info is null";
                    }
                    $hackinDbHelper->createLiveHackinSession($hackinSessionInfo);
                    //create session log with type login()
                } else if(strcasecmp($liveHackinSessionInfo->hackinSessionId, $hackinSessionInfo->hackinSessionId) == 0) {//same User
                    if(self::$debug) {
                        echo "<br>live session info is equal to the current session";
                    }
                    $hackinDbHelper->updateLiveSession($liveHackinSessionInfo);
                    //create session log with type refresh()
                } else {
                    $hackinDbHelper->logForceLogin($hackinSessionInfo);
                    if(self::$debug) {
                        echo "not equal";
                    }
                    $interruption = HackinConfig::$multipleSessionInterruption;
                    $liveSession = "\"liveSession\": {" . 
                                            "\"browser\": " . json_encode($liveHackinSessionInfo->lastActiveBrowser) . ",". 
                                            "\"ip\": " . json_encode($liveHackinSessionInfo->lastActiveIp) . ',' .
                                            "\"lastActiveTime\": " . json_encode(HackinGlobalFunctions::timeStampFromPhpToSql($liveHackinSessionInfo->lastActiveTime)) .
                                     "}";
                    $currentSession = '"currentSession": {' .
                                               '"browser": ' . json_encode($hackinSessionInfo->lastActiveBrowser) . ', ' .
                                                '"ip": ' . json_encode($hackinSessionInfo->lastActiveIp) . ', ' .
                                                '"lastActiveTime": ' . json_encode(HackinGlobalFunctions::timeStampFromPhpToSql($hackinSessionInfo->lastActiveTime)) .
                                             '}';
                    $interruptionMsg = 
                        '{' .  
                            '"interruption": ' . json_encode($interruption) . ',' .
                            $liveSession . ',' .
                            $currentSession . 
                            //',' ."\"html\" :"  . json_encode(file_get_contents(__DIR__ . "/../multiple.html")) .
                         '}';
                    //echo $interruptionMsg;
                    echo HackinErrorHandler::interruptHandler($interruption, $interruptionMsg);
                    exit();
                } 
            } catch(Exception $ex) {
                    echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
                    exit();
            }
        }
    }
    //new HackinSessionHandler();//Mandatory to instantiate dbhelper
    //HackinSessionHandler::getHackinSession();
?>