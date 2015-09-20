<?php
    /**
        Model to preserve user information in runtime environment, than to retrieve it from db.
    */
    class HackinUserInfo {
        public $emailId;
        public $screenName;
        public $rollNo;
        public $isUserAlumni;
        public $profilePic;
        public $phoneNo;
        public $collegeCode;
        public $departmentName;
        public $collegeName;

        public function __construct($emailId, $screenName, $rollNo, $isUserAlumni, $profilePic, $phoneNo, $collegeCode, $departmentName, $collegeName) {
            $this->emailId = $emailId;
            $this->screenName = $screenName;
            $this->rollNo = $rollNo;
            $this->isUserAlumni = $isUserAlumni;
            $this->profilePic = $profilePic;
            $this->phoneNo = $phoneNo;
            $this->collegeCode = $collegeCode;
            $this->departmentName = $departmentName;
            $this->collegeName = $collegeName;
        }
    }
    /*
    $newHackinUser = new HackinUserInfo("thirukkakarnan@gmail.com", "Karnaa", "1", "", "9842146152", "11PW38", "", "", "");
    echo json_encode($newHackinUser);
    //*/
?>