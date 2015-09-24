<?php
    require_once(__DIR__ . "/HackinDbHelper.php");
    require_once(__DIR__ . "/models/HackinUserInfo.php");
    require_once(__DIR__ . "/models/HackinQuestionState.php");
    /**
        Place at which all decisions related to the game are made.
        Question Choosing and Retrieval, Mission choosing and retrieval, Answer validation, etc.
        Mainly interacts with the two dbs- "psgtech_login15_hackin_quora" and "psgtech_login15_hackin_game_engine"
        And for game state, may connect with "psgtech_login15_hackin_team_accounts"
    */
    class HackinGameEngine {
        private $hackinDbHelper;
        private $debug = 0;

        public function __construct($hackinDbHelper = NULL) {
            if($hackinDbHelper == NULL) {
                $hackinDbHelper = new HackinDbHelper();
            }
            $this->hackinDbHelper = $hackinDbHelper;
        }

        /**
            Should retrieve the game state of the given user from Db.
        */
        public function getGameStateOfUser($hackinUserInfo) {
            $gameState = $this->hackinDbHelper->getHackinGameStateForRegisterdUser($hackinUserInfo);
            return $gameState;
        }

        public function getQuestionStateOfUser($hackinUserInfo, $qnNo) {
            $questionState = $this->hackinDbHelper->getHackinQuestionStateForRegisterdUser($hackinUserInfo, $qnNo);
            return $questionState;
        }

        /**
            validate the answer for the question
            return: $questionState after updation
        */
        public function validateAnswer($hackinUserInfo, $hackinSessionInfo, $qnNo, $answer) {
            /**
                get question state of the user before validation
                if he has not answered it yet, then, a state will be created for the first time he views it(getsGameStateFromFrontEnd)
            */
            $hackinQuestionState = $this->getQuestionStateOfUser($hackinUserInfo, $qnNo);
            if($this->debug) {
                echo "<br>validateAnswer-GameEngine::<br>";
                print_r($hackinQuestionState);
            }
            $noOfAttemptsSoFar = $hackinQuestionState->noOfAttemptsMade;
            $maxNoOfAttemptsAllowed = $hackinQuestionState->maxNoOfAttemptsAllowed;
            /**
                Though u can retrieve violationDetection column from Db, calculate again from db
            */
            $isViolationDetected = 0;
            if($maxNoOfAttemptsAllowed <= $noOfAttemptsSoFar) {
                $isViolationDetected = 1;
            }
            if($this->debug) {
                echo "<br>isViolationDetected-gameEngine:<br>" . $isViolationDetected;
            }
            if($hackinQuestionState->hasSolved == 0){
                $hackinQuestionState = $this->hackinDbHelper->validateAnswerAndLogResults($hackinUserInfo, $hackinSessionInfo, $qnNo, $answer, $isViolationDetected);
            }
            $hackinQuestionState->isViolationDetected = $isViolationDetected;
            return $hackinQuestionState;
        }
    }
    /*$gameEngine = new HackinGameEngine();//only public members are encoded, encoding doesn't show up the class name
    echo json_encode($gameEngine);*/
?>