<?php
    require_once(__DIR__ . "/HackinUserMonitor.php");
    /**
        Session Information of the hackin user.
        Will contain his entire browsing details to be used for
    */
    class HackinSessionInfo {
        public $emailId;
        /**
            phpsessionId- Session id for the whole of login15.
        */
        public $phpSessionId;
        /**
            hackinSessionId- Session id for hackin15
        */
        public $hackinSessionId;
        
        public $lastLoginTime;
        public $lastRefreshTime;
        public $lastActiveTime;

        public $lastActiveUserAgent;
        public $lastActiveBrowser;
        public $lastActiveBrowserDetails;

        public $lastActiveIp;
        public $lastActiveIpDetails;

        public function __construct($emailId = NULL, $phpSessionId = NULL, $hackinSessionId = NULL, 
                                    $lastLoginTime = NULL, $lastRefreshTime = NULL, $lastActiveTime = NULL,
                                    $lastActiveUserAgent = NULL, $lastActiveBrowser = NULL,  $lastActiveBrowserDetails = NULL,
                                    $lastActiveIp = NULL, $lastActiveIpDetails = NULL) {
            $this->emailId = $emailId;
            
            $this->phpSessionId = $phpSessionId;
            $this->hackinSessionId = $hackinSessionId;

            $this->lastLoginTime = $lastLoginTime;
            $this->lastRefreshTime = $lastRefreshTime;
            $this->lastActiveTime = $lastActiveTime;

            $this->lastActiveUserAgent = $lastActiveUserAgent;
            $this->lastActiveBrowser = $lastActiveBrowser;
            $this->lastActiveBrowserDetails = $lastActiveBrowserDetails;

            $this->lastActiveIp = $lastActiveIp;
            $this->lastActiveIpDetails = $lastActiveIpDetails;
        }

        public function equals($hackinSessionInfo) {
            $isEqual  = 0;
            if( ( strcasecmp($this->emailId, $hackinSessionInfo->emailId) == 0 ) 
                // && ( strcasecmp($this->phpSessionId, $hackinSessionInfo->phpSessionId) == 0 ) 
                && (strcasecmp($this->hackinSessionId, $hackinSessionInfo->hackinSessionId) ==0)
               ) {
                $isEqual = 1;
            }
            return $isEqual;
        }
    }

    /*$hackinUserMonitor = new HackinUserMonitor();
    $userBrowserInfo = $hackinUserMonitor->userBrowserInfo;
    $userIpInfo = $hackinUserMonitor->userIpInfo;
    $hackinSessionInfo = new HackinSessionInfo("thirukkakarnan@gmail.com", "somePHPId", uniqid("hackin_"), 
                                                        time(), time(), time(),
                                                        $userBrowserInfo->userAgent, $userBrowserInfo->browser, $userBrowserInfo->browserDetails,
                                                        $userIpInfo->ip, $userIpInfo->ipDetails);
    echo json_encode($hackinSessionInfo);
    /*$hackinSessionInfo = new HackinSessionInfo("thirukkakarnan@gmail.com", "somePHPId", uniqid("hackin_"), time(), "some info");
    echo json_encode($hackinSessionInfo);
    $newHackinSessionInfo = new HackinSessionInfo("thirukkakarnan@gmail.com", "somePHPId", $hackinSessionInfo->hackinSessionId, time(), "some info");
    echo json_encode($newHackinSessionInfo);
    echo $hackinSessionInfo->equals($newHackinSessionInfo);*/
    //*/
?>