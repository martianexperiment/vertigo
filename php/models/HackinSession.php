<?php
    require_once(__DIR__ . "/HackinSessionInfo.php");
    require_once(__DIR__ . "/HackinUserInfo.php");
    require_once(__DIR__ . "/HackinGameState.php");
    /**
        Model to track the hackin user and his game state via game specific session informations
    */
    class HackinSession {
        public $hackinSessionInfo;
        public $hackinUserInfo;
        public $hackinGameState;

        function __construct($hackinSessionInfo, $hackinUserInfo, $hackinGameState) {
            $this->hackinSessionInfo = $hackinSessionInfo;
            $this->hackinUserInfo = $hackinUserInfo;
            $this->hackinGameState = $hackinGameState;
        }
    }
?>