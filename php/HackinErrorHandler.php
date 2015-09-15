<?php
    /**
        Global, centralized error handler for Hackin event
    */
    class HackinErrorHandler {
        /**
            TODO: create/use existing error log and dump the state along with the error msg.
        */
        public static function errorHandler(Exception $ex, $errorOccuredIn) {
            $errorMsg = "FATAL!! error occured during **".$errorOccuredIn."** <br>Error Msg=".$ex->getMessage();
            $errorMsg = $errorMsg . self::errorMsgToShowToPlayer();
            //log in the file here
            return $errorMsg;
        }

        /**
            Use this function to integrate with the error page
            TODO: String output based on the error
        */
        private static function errorMsgToShowToPlayer() {
            $errorMsg = "<br> Quiting process.. Refresh after sometime or kindly contact event co-ordinator.".
                         "<br> For details of the co-ordinator, refer ".
                         "<a href=\"http://psglogin.in/hackin.php\">hackin</a> event page under ".
                         "<a href=\"http://psglogin.in\">Login15</a> <br>";
            return $errorMsg;
        }
}
?>