<?php
    require_once(__DIR__ . "/../HackinGlobalFunctions.php");
    require_once(__DIR__ . "/../HackinErrorHandler.php");
    class UserBrowserInfo {
        public $userAgent;
        public $browser;
        public $browserDetails;

        public function __construct($userAgent = NULL) {
            //TODO: merge into single if condition.
            try {
                if(!empty($_SERVER['HTTP_USER_AGENT'])) {
                    $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
                    $this->browserDetails = self::returnBrowserDetailsAsJson($this->userAgent);
                    $browserDetailsObject = json_decode($this->browserDetails);
                    $this->browser = $browserDetailsObject->agent_name;
                } else if(!empty($userAgent)) {
                    $this->userAgent = $userAgent;
                    $this->browserDetails = self::returnBrowserDetailsAsJson($this->userAgent);
                    $browserDetailsObject = json_decode($this->browserDetails);
                    $this->browser = $browserDetailsObject->agent_name;
                } else {
                    //echo '$_SERVER[\'HTTP_USER_AGENT\'] is null';
                    $this->userAgent = NULL;
                    $this->browserDetails = NULL;
                    $this->browser = NULL;
                }
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, "while retrieving browser info");
                exit();
            }
        }

        public static function returnBrowserDetailsAsJson($uAgent) {
            $url = "www.useragentstring.com";
            $protocol = "http";
            $filePathFromServer = "/?uas=".urlencode($uAgent)."&getJSON=all";
            $method = 'GET';
            $header = "Content-type: application/x-www-form-urlencoded\r\n";
            $json = HackinGlobalFunctions::simulateHttpRequest($protocol, $url, $filePathFromServer, $header, $method);
            return $json;
        }
    }

    /*$userBrowserInfo = new UserBrowserInfo();
    print_r($userBrowserInfo);*/
?>