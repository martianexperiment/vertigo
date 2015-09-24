<?php
    require_once(__DIR__ . "/config/HackinConfig.php");
    /**
        Global, centralized error handler for Hackin event
        TODO: Create error model to be help handling easier in frontend and bind the message and errors.
        TODO: Create a log and log all these exceptions.
    */
    class HackinErrorHandler {
        /**
            TODO: create/use existing error log and dump the state along with the error msg.
        */
        public static function errorHandler(Exception $ex, $errorOccuredIn) {
            $errorOccuredIn = "Error occured during **".$errorOccuredIn."** msg=" . $ex->getMessage() ;
            $errorMsg = "";
            
            $errorMsg = file_get_contents(__DIR__ . "/../views/errorPagePart1.view");
            $errorMsg = $errorMsg . 
                '<div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img src="http://'. HackinConfig::$phpServer .'/img/sad.png" height="150" alt="Sad Smiley :(">
                        </div>
                    </div>
                <div class="row voffset">
                    <div class="col-lg-12 text-center">
                        <p id="error-text">';
            $errorMsg = $errorMsg. $errorOccuredIn;
            $errorMsg = $errorMsg. '</p>';
            $errorMsg = $errorMsg . file_get_contents(__DIR__ . "/../views/errorPagePart2.view");
            
            echo $errorMsg;//donot comment this line
            self::endStackTrace();
        }

        /**
            Use this function to integrate with the error page
            TODO: String output based on the error
        */
        private static function errorMsgToShowToHackinUser($errorOccuredIn) {
            $errorMsg = "{" . 
                            "\"error\": " . json_encode($errorOccuredIn) .
                            "\"html\": " . json_encode(file_get_contents(__DIR__ . "/../oops.html")) .
                        "}";
            return $errorMsg;
        }

        /**
            Use this function to interrupt the current flow other than error
            TODO: Generalize it
        */
        public static function interruptHandler($interruption, $interruptionMsg) {
            /*if(strcasecmp($interruption, HackinConfig::$multipleSessionInterruption) == 0) {
                //$jsonObject = json_decode($interruptionMsg);
                $interruptionMsg = $interruptionMsg;
            }*/
            $jsonObject = json_decode($interruptionMsg);
            $multipleSessionPage = file_get_contents(__DIR__ . "/../views/multipleSessionsPagePart1.view");
            $multipleSessionPage = $multipleSessionPage . 
                '<p class="error-msg"> Alive Session: ' . $jsonObject->{'liveSession'}->{'browser'} . ", " . $jsonObject->{'liveSession'}->{'ip'} . ", " .
                    $jsonObject->{'liveSession'}->{'lastActiveTime'} . "</p>" .
                '<p class="error-msg"> Current Session: ' . $jsonObject->{'currentSession'}->{'browser'} . ", " . $jsonObject->{'currentSession'}->{'ip'} . ", " .
                    $jsonObject->{'currentSession'}->{'lastActiveTime'} . "</p>";
            $multipleSessionPage = $multipleSessionPage . file_get_contents(__DIR__ . "/../views/multipleSessionsPagePart2.view");
            echo $multipleSessionPage;
        }

        public static function endStackTrace() {
            session_destroy();
            exit();
        }

    }
    //$interruption = HackinConfig::$multipleSessionInterruption;
    //$interruptionMsg = 
        //  '{"interruption": "MulitpleSessionsInterruption","liveSession": {"browser": "Firefox","ip": "::1","lastActiveTime": "2015-09-21 07:19:32"},"currentSession": {"browser": "Chrome", "ip": "::1", "lastActiveTime": "2015-09-21 07:28:12"}}'
    //HackinErrorHandler::interruptHandler("", "");
?>