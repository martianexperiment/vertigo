<?php
    require_once(__DIR__ . "/HackinDbHelper.php");
    require_once(__DIR__ . "/models/HackinUserInfo.php");
    /**
        Place at which all decisions related to the game are made.
        Question Choosing and Retrieval, Mission choosing and retrieval, Answer validation, etc.
        Mainly interacts with the two dbs- "psgtech_login15_hackin_quora" and "psgtech_login15_hackin_game_engine"
        And for game state, may connect with "psgtech_login15_hackin_team_accounts"
    */
    class HackinGameEngine {
        private $hackinDbHelper;

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

        /**
            Fetches the current Mission for the user
        */
        public function getMissionForUser($hackinUserInfo) {

        }

        /**
            validate the answer for the question
            return: 1/0 after updating GameState
        */
        public function validateAnswer($hackinUserInfo, $qnNo, $answer) {
            $isCorrectAnswer = $this->hackinDbHelper->validateAnswer($hackinUserInfo, $qnNo, $answer);
            return $isCorrectAnswer;
        }

        public function getNoOfAttemptsMadeSoFarForQn($hackinUserInfo, $qnNo) {
            $noOfAttemptsMadeSoFarForQn = $this->hackinDbHelper->noOfAttemptsMadeSoFarForQn($hackinUserInfo, $qnNo);
            return $noOfAttemptsMadeSoFarForQn;
        }

        public function getTotalAttemptsAllowedForQn($qnNo) {
            $totalAttemptsAllowedForQn = $this->hackinDbHelper->totalAttemptsAllowedForQn($qnNo);
            return $totalAttemptsAllowedForQn;
        }

    }
    /*$gameEngine = new HackinGameEngine();//only public members are encoded, encoding doesn't show up the class name
    echo json_encode($gameEngine);*/
?>