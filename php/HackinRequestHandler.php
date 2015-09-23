<?php
    require_once(__DIR__ . "/HackinSessionHandler.php");
    require_once(__DIR__ . "/HackinGameEngine.php");
    require_once(__DIR__ . "/HackinDbHelper.php");
    /**
        All requests pass via this handler.
        Gets all info related to the current request and validates it.
    */
    class HackinRequestHandler {
        public $debug = 0;
        private $hackinDbHelper;
        private $hackinGameEngine;
        private $hackinSessionHandler;

        public function __construct() {
            $this->hackinDbHelper = new HackinDbHelper();
            $this->hackinGameEngine = new HackinGameEngine($this->hackinDbHelper);
            $this->hackinSessionHandler = new HackinSessionHandler($this->hackinDbHelper);
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
                $this->verifyLiveSessionBeforeProcessingRequest();
            }
            echo file_get_contents(__DIR__ . "/../dash.html");
        }

        /**
            When the user logs out
        */
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
            echo file_get_contents(__DIR__ . "/../dash.html");
            return;
        }

        /**
            Live sessions not verified for these 2 getGameState() and getHackinUserInfo() functions.
        */
        public function getHackinUserInfo() {
            HackinSessionHandler::verifySession();
            return HackinSessionHandler::getHackinUserInfo();
        }

        public function getGameState() {
            HackinSessionHandler::verifySession();
            $hackinUserInfo = HackinSessionHandler::getHackinUserInfo();
            return $this->hackinGameEngine->getGameStateOfUser($hackinUserInfo);
        }

        public function verifyLiveSessionBeforeProcessingRequest() {
            HackinSessionHandler::verifyLiveSession();
        }

        public function verifyAnswerAndReturnJson($qnNo, $answer) {
            $hackinUserInfo = HackinSessionHandler::getHackinUserInfo();
            $isCorrectAnswer = $this->hackinGameEngine->validateAnswer($hackinUserInfo, $qnNo, $answer);
            $gameState = $this->getGameState();
            //TODO: populate these too.
            $noOfAttemptsSoFar = $this->hackinGameEngine->getNoOfAttemptsMadeSoFarForQn($hackinUserInfo, $qnNo);
            $totalAttemptsAllowed = $this->hackinGameEngine->getTotalAttemptsAllowedForQn($qnNo);
            $result = "{ \"isCorrectAnswer\": " . $isCorrectAnswer . ", " . 
                        "\"noOfAttemptsSoFar\": " . $noOfAttemptsSoFar . ", " . 
                        "\"totalAttemptsAllowed:\"" . $totalAttemptsAllowed . ", " . 
                        "\"gameState\": " . json_encode($gameState) .
                      "}";
            return $result;
        }
    }
    //echo json_encode($_SERVER);
?>