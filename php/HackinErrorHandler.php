<?php
    /**
        Global, centralized error handler for Hackin event
        TODO: Create error model to be help handling easier in frontend.
    */
    class HackinErrorHandler {
        /**
            TODO: create/use existing error log and dump the state along with the error msg.
        */
        public static function errorHandler(Exception $ex, $errorOccuredIn) {
            $errorMsg = "FATAL!! error occured during **".$errorOccuredIn."** <br>Error Msg=".$ex->getMessage();
            $errorMsg = $errorMsg . self::errorMsgToShowToHackinUser();
            //log in the file here
            return $errorMsg;
        }

        /**
            Use this function to integrate with the error page
            TODO: String output based on the error
        */
        private static function errorMsgToShowToHackinUser() {
            $errorMsg = "<br><br> Errors are thrown only when invalid and unauthorized requests are made.".
                         "<br> Better clear cookies and Login again from the <a href=\"http://hackin.psglogin.in\">hackin event home</a>". 
                         "<br> If the problem persists, kindly contact the event co-ordinator.".
                         "<br> For details of the co-ordinator, refer ".
                         "<a href=\"http://psglogin.in/hackin.php\">hackin</a> event page under ".
                         "<a href=\"http://psglogin.in\">Login15</a> <br>";
            return $errorMsg;
        }
    }
?>