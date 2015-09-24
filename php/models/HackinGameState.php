<?php
    class HackinGameState {
        public $emailId;
        public $currentScore;
        public $isUserAlumni;
        public $playsAsCharacter;

        public function __construct($emailId = NULL, $currentScore = NULL, $isUserAlumni = NULL, $playsAsCharacter = NULL) {
            $this->emailId = $emailId;
            $this->currentScore = $currentScore;
            $this->isUserAlumni = $isUserAlumni;
            $this->playsAsCharacter = $playsAsCharacter;
        }
    }
    /*$hackinGameState = new HackinGameState("thirukkakarnan@gmail.com", 1, 1, 1, 0, 0, 1, "Veronica");
    echo json_encode($hackinGameState);*/
?>