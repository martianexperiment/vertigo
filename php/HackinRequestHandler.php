<?php
    require_once(__DIR__ . "/HackinSessionHandler.php");
    require_once(__DIR__ . "/HackinDbHelper.php");
    /**
        All requests pass via this handler.
        Gets all info related to the current request and validates it.
    */
    class HackinRequestHandler {
        public $debug = 0;
        private $hackinDbHelper;

        public function __construct() {
            $this->hackinDbHelper = new HackinDbHelper();
        }

        public function logIn() {
            $hackinDbHelper = $this->hackinDbHelper;
            $functionalityForWhichExceptionExpected = "logIn()";
            if($this->debug) {
                echo "<br>***************** logIn() page<br>";
            }
            HackinSessionHandler::verifySession();
            $hackinUserInfo = HackinSessionHandler::getHackinUserInfo();
            $hackinSessionInfo = HackinSessionHandler::getCurrentHackinSessionInfo();
            if($this->debug) {
                echo "<br>logIn():<br>";
                print_r($hackinUserInfo);
                print_r($hackinSessionInfo);
            }
            $hasUserRegistered = $hackinDbHelper->hasUserRegistered($hackinUserInfo);
            if($this->debug) {
                echo "<br>hasUserRegistered:??" . $hasUserRegistered;
            }
            if($hasUserRegistered == 0) {
                if($this->debug) {
                    echo "<br>user to be Registered now";
                }
                $hackinDbHelper->registerNewUserAndCreateGameState($hackinUserInfo);
                $hackinDbHelper->createLiveHackinSession($hackinSessionInfo);
                if($this->debug) {
                    echo "<br>user to be Registered now";
                }
                //create session log with type register()
            } else {
                if($this->debug) {
                    echo "<br>user has already registered.. proceeding to verify session";
                }
                $hackinDbHelper->logRefresh($hackinSessionInfo);
                HackinSessionHandler::verifyLiveSession();
            }
            echo file_get_contents(__DIR__ . "/../dash.html");
        }

        public function logOut() {
            $hackinDbHelper = $this->hackinDbHelper;
            //remove live session()
            $functionalityForWhichExceptionExpected = "logOut()";
            $hackinSessionInfo = HackinSessionHandler::getCurrentHackinSessionInfo();
            if($this->debug) {
                echo "<br>**********logOut():";
                print_r($hackinSessionInfo);
            }
            $hackinDbHelper->removeLiveHackinSession($hackinSessionInfo);
        }

        public function forceLogIn() {
            $hackinDbHelper = $this->hackinDbHelper;
            HackinSessionHandler::verifySession();
            $hackinUserInfo = HackinSessionHandler::getHackinUserInfo();
            $hackinSessionInfo = HackinSessionHandler::getCurrentHackinSessionInfo();
            $hackinDbHelper->updateNewLiveSession($hackinSessionInfo);
            //$this->logIn();
            echo file_get_contents(__DIR__ . "/../dash.html");
            return;
        }

        public function getHackinUserInfo() {
            HackinSessionHandler::verifySession();
            return HackinSessionHandler::getHackinUserInfo();
        }

        public function getGameState() {
            HackinSessionHandler::verifySession();
            return HackinSessionHandler::getHackinGameStateForRegisterdUser();
        }

    }
    //echo json_encode($_SERVER);
?>