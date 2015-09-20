<?php
    require_once(__DIR__ . "/UserIpInfo.php");
    require_once(__DIR__ . "/UserBrowserInfo.php");

    class HackinUserMonitor {
        public $userBrowserInfo;
        public $userIpInfo;

        public function __construct() {
            $this->userBrowserInfo = new UserBrowserInfo();
            $this->userIpInfo = new UserIpInfo(); 
        }
    }

    /*echo json_encode(new HackinUserMonitor());*/
?>