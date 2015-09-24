<?php
    class HackinGameState {
        public $emailId;
        public $currentScore;
        public $isUserAlumni;
        public $noOfViolationsMade;
        public $playsAsCharacter;

        public function __construct($emailId = NULL, $currentScore = NULL, $isUserAlumni = NULL, $noOfViolationsMade = NULL, $playsAsCharacter = NULL) {
            $this->emailId = $emailId;
            $this->currentScore = $currentScore;
            $this->isUserAlumni = $isUserAlumni;
            $this->noOfViolationsMade = $noOfViolationsMade;
            $this->playsAsCharacter = $playsAsCharacter;
        }
    }
    /*$hackinGameState = new HackinGameState("thirukkakarnan@gmail.com", 1, 1, 1, 0, 0, 1, "Veronica");
    echo json_encode($hackinGameState);*/
?>