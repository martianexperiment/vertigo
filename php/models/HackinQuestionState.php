<?php
    class HackinQuestionState {
        public $emailId;
        public $questionNo;
        public $hasSolved;
        public $noOfAttemptsMade;
        public $maxNoOfAttemptsAllowed;
        public $isViolationDetected;
        public $playsAsCharacter;

        public function __construct($emailId = NULL, $questionNo = NULL, $hasSolved = NULL, $noOfAttemptsMade = NULL, 
            $maxNoOfAttemptsAllowed = NULL,  $isViolationDetected = NULL, $playsAsCharacter = NULL) {
            $this->emailId = $emailId;
            $this->questionNo = $questionNo;
            $this->hasSolved = $hasSolved;
            $this->noOfAttemptsMade = $noOfAttemptsMade;
            $this->maxNoOfAttemptsAllowed = $maxNoOfAttemptsAllowed;
            $this->isViolationDetected = $isViolationDetected;
            $this->playsAsCharacter = $playsAsCharacter;
        }
    }
    /*$hackinQuestionState = new HackinQuestionState("thirukkakarnan@gmail.com", 1, 0, 2, 5, "Veronica");
    echo json_encode($hackinQuestionState);//*/
?>