<?php
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
        /**
            TODO: All additional browsing informations are to be stored as json object here.
        */
        public $additionalInfo;

        public function __construct($emailId = NULL, $phpSessionId = NULL, $hackinSessionId = NULL, $lastLoginTime = NULL, $additionalInfo= NULL) {
            $this->emailId = $emailId;
            $this->phpSessionId = $phpSessionId;
            $this->hackinSessionId = $hackinSessionId;
            $this->lastLoginTime = $lastLoginTime;
            $this->additionalInfo = $additionalInfo;
        }

        public function equals($hackinSessionInfo) {
            $isEqual  = 0;
            if(strcasecmp($this->emailId, $hackinSessionInfo->emailId) == 0 && 
                //strcasecmp($this->phpSessionId, $hackinSessionInfo->phpSessionId) == 0 && 
                strcasecmp($this->hackinSessionId, $hackinSessionInfo->hackinSessionId) ==0) {
                $isEqual = 1;
            }
            return $isEqual;
        }
    }
    /*
    $hackinSessionInfo = new HackinSessionInfo("thirukkakarnan@gmail.com", "somePHPId", uniqid("hackin_"), time(), "some info");
    echo json_encode($hackinSessionInfo);
    $newHackinSessionInfo = new HackinSessionInfo("thirukkakarnan@gmail.com", "somePHPId", $hackinSessionInfo->hackinSessionId, time(), "some info");
    echo json_encode($newHackinSessionInfo);
    echo $hackinSessionInfo->equals($newHackinSessionInfo);
    //*/
?>