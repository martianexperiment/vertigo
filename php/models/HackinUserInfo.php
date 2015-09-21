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

        public function __construct($emailId, $isUserAlumni, $phoneNo, $screenName=NULL, $rollNo=NULL, $collegeCode=NULL, $departmentName=NULL, $collegeName=NULL, $profilePic=NULL) {
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
    $newHackinAlumni = new HackinUserInfo("thirukkakarnan@gmail.com", 1, "9842146152", "Karnaa", "11PW38", "", "", "");
    $newHackinParticipant = new HackinUserInfo("thirukkakarnan@gmail.com", 0, "9842146152", "Karnaa", "", "code0", "damcs", "");
    echo json_encode($newHackinAlumni);
    echo "<br>".json_encode($newHackinParticipant);
    //*/
?>