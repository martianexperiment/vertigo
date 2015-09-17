<?php
    /**
        Model to preserve user information in runtime environment, than to retrieve it from db.
    */
    class HackinUserInfo {
        public $emailId;
        public $screenName;
        public $isUserAlumni;
        public $profilePic;
        public $phoneNo;
        public $rollNo;
        public $collegeCode;
        public $departmentName;
        public $collegeName;

        public function __construct($emailId, $screenName, $isUserAlumni, $profilePic, $phoneNo, $rollNo, $collegeCode, $departmentName, $collegeName) {
            $this->emailId = $emailId;
            $this->screenName = $screenName;
            $this->isUserAlumni = $isUserAlumni;
            $this->profilePic = $profilePic;
            $this->phoneNo = $phoneNo;
            $this->rollNo = $rollNo;
            $this->collegeCode = $collegeCode;
            $this->departmentName = $departmentName;
            $this->collegeName = $collegeName;
        }
    }
    /*$newHackinUser = new HackinUserInfo("thirukkakarnan@gmail.com", "Karnaa", "1", "", "9842146152", "11PW38", "", "", "");
    echo json_encode($newHackinUser);*/
?>