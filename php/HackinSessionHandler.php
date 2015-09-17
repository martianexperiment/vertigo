<?php
    require_once(__DIR__ . "/HackinSessionStarter.php");
    require_once(__DIR__ . "/models/HackinSession.php");
    require_once(__DIR__ . "/HackinDbHelper.php");
    /**
        The only place where session variables are to be accessed.
        To maintain the code clean and for easier maintenance of changes to session variables.
    */
    class HackinSessionHandler {
        /**
            Verify whether all required session variables are set.
            return: throws exception if not.
        */
        public static function verifySession() {
            if(!isset($_SESSION)) {
                $ex = new Exception("verifySession(): Session has not been started. Game play requires session creation. Please sign in again");
                throw $ex;
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
                $ex = new Exception("verifySession(): user details insufficient");
                throw $ex;
            }
            if($_SESSION['ses_account_type'] == "PAR" && (empty($_SESSION['ses_cCode']) || empty($_SESSION['ses_college_name']) || empty($_SESSION['ses_dept_name']))) {
                $ex = new Exception("verifySession(): participant details insufficient");
                throw $ex;
            }
            if($_SESSION['ses_account_type'] == "ALU" && (empty($_SESSION['ses_alumni_rollno']) || empty($_SESSION['ses_alumni_name']))) {
                $ex = new Exception("verifySession(): alumni details insufficient");
                throw $ex;
            }
        }

        /**
            to get the hackin session object populated with values
            Retrieves HackinUserInfo and HackinGameState objects from session variables and database respectively
            Used everywhere instead of session variables.
            TODO: getHackinGameState from db for the user.
            TODO: Include processes for authorization too.(Disallow multiple user access)
            return: $hackinSession
        */
        public static function getHackinSession() {
            self::verifySession();
            $hackinSessionId = rand(1111, 9999);////use the openssl functionality
            $hackinUserInfo = self::getHackinUserInfo();
            //$hackinDbHelper = new HackinDbHelper();
            $gameState = NULL;//$hackinDbHelper->getHackinGameState();
            $hackinSession = new HackinSession($hackinSessionId, $hackinUserInfo, $gameState);
            return $hackinSession;
        }

        public static function getHackinUserInfo() {
            //$functionalityForWhichExceptionExpected = "getting HackinUser Info from session variables";
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

            if($_SESSION['is_user_alumni'] == 0){
                $collegeCode = $_SESSION['hackin_code'] = $_SESSION['ses_cCode'];
                $collegeName = $_SESSION['hackin_college_name'] = $_SESSION['ses_college_name'];
                $departmentName = $_SESSION['hackin_department_name'] = $_SESSION['ses_dept_name'];
            } else {
                $rollNo = $_SESSION['hackin_alumni_rollno'] = $_SESSION['ses_alumni_rollno'];
                $screenName = $_SESSION['hackin_alumni_name'] =  $_SESSION['ses_alumni_name'];
            }

            $hackinUserInfo = new HackinUserInfo($emailId, $screenName, $isUserAlumni, $profilePic, $phoneNo, $rollNo, $collegeCode, $departmentName, $collegeName);
            return $hackinUserInfo;
        }
    }
    //HackinSessionHandler::getHackinSession();
?>