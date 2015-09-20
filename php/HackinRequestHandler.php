<?php
    require_once(__DIR__ . "/HackinSessionHandler.php");
    require_once(__DIR__ . "/HackinDbHelper.php");
    /**
        All requests pass via this handler.
        Gets all info related to the current request and validates it.
    */
    class HackinRequestHandler {
        public static $debug = 0;
        public static function logIn() {
            if(self::$debug == 1)
                echo "<br> logIn() page";
            //$hackinSession = HackinSessionHandler::getHackinSession();
            HackinSessionHandler::verifySession();
            $hackinUserInfo = HackinSessionHandler::getHackinUserInfo();
            $hackinSessionInfo = HackinSessionHandler::getCurrentHackinSessionInfo();
            if(self::$debug == 1) {
                echo "<br>logIn():<br>";
                print_r($hackinUserInfo);
                print_r($hackinSessionInfo);
            }
            $hackinDbHelper = new HackinDbHelper();

            $hasUserRegistered = $hackinDbHelper->hasUserRegistered($hackinUserInfo);
            if(self::$debug == 1) {
                echo "<br>hasUserRegistered:??" . $hasUserRegistered;
            }
            if($hasUserRegistered == 0) {
                if(self::$debug == 1) {
                    echo "<br>user to be Registered now";
                }
                $hackinDbHelper->registerNewUserAndCreateGameState($hackinUserInfo);
                $hackinDbHelper->createLiveHackinSession($hackinSessionInfo);
                if(self::$debug == 1) {
                    echo "<br>user to be Registered now";
                }
                //create session log with type register()
            } else {
                $liveHackinSessionInfo = $hackinDbHelper->getLiveSessionInfo($hackinUserInfo);
                if(self::$debug == 1) {
                    echo "<br>retrieve live session::<br>";
                    print_r($liveHackinSessionInfo);
                }
                if(self::$debug == 1) {
                    echo "<br>";
                }
                if($liveHackinSessionInfo == NULL ) {
                    if(self::$debug == 1) {
                        echo "live session info is null";
                    }
                    $hackinDbHelper->createLiveHackinSession($hackinSessionInfo);
                    //create session log with type login()
                } else if(strcasecmp($liveHackinSessionInfo->hackinSessionId, $hackinSessionInfo->hackinSessionId) == 0) {//same User
                    if(self::$debug == 1) {
                        echo "<br>live session info is equal to the current session";
                    }
                    $hackinDbHelper->updateLiveSession($liveHackinSessionInfo);
                    //create session log with type refresh()
                } else {
                    if(self::$debug == 1) {
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
                        '}';
                    echo HackinErrorHandler::interruptHandler($interruption, $interruptionMsg);
                    exit();
                }
            }
        }

        public static function logOut() {
            //remove live session()
            //session_destroy()
        }

        public static function forceLogIn() {
            //update live session.
        }

    }
    //echo json_encode($_SERVER);
?>