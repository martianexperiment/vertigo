<?php
    require_once(__DIR__ . "/../HackinGlobalFunctions.php");
    class UserBrowserInfo {
        public $userAgent;
        public $browser;
        public $browserDetails;

        public function __construct() {
            if(!empty($_SERVER['HTTP_USER_AGENT'])) {
                $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
                $this->browserDetails = self::returnBrowserDetailsAsJson($this->userAgent);
                $browserDetailsObject = json_decode($this->browserDetails);
                $this->browser = $browserDetailsObject->agent_name;
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

    /*$userBrowserDetails = new UserBrowserDetails();
    print_r($userBrowserDetails);*/
?>