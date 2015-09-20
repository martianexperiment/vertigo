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
            $errorMsg = $errorOccuredIn . self::errorMsgToShowToHackinUser($errorOccuredIn);
            //log in the file here
            return $errorMsg;
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

            return $interruptionMsg;
        }

    }
?>