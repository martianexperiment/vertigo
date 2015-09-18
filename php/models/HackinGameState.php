<?php
    class HackinGameState {
        public $emailId;
        public $currentLevelNo;
        public $currentMissionNo;
        public $currentPlotNo;
        public $currentCountOfAttemptsMade;
        public $currentScore;
        public $isUserAlumni;
        public $playsAsCharacter;

        public function __construct($emailId, $currentLevelNo, $currentMissionNo, $currentPlotNo, $currentCountOfAttemptsMade, 
            $currentScore, $isUserAlumni, $playsAsCharacter) {
            $this->emailId = $emailId;
            $this->currentLevelNo = $currentLevelNo;
            $this->currentMissionNo = $currentMissionNo;
            $this->currentPlotNo = $currentPlotNo;
            $this->currentCountOfAttemptsMade = $currentCountOfAttemptsMade;
            $this->currentScore = $currentScore;
            $this->isUserAlumni = $isUserAlumni;
            $this->playsAsCharacter = $playsAsCharacter;
        }
    }
    /*$hackinGameState = new HackinGameState("thirukkakarnan@gmail.com", 1, 1, 1, 0, 0, 1, "Veronica");
    echo json_encode($hackinGameState);*/
?>