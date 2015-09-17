<?php
    require_once(__DIR__ . "/HackinUserInfo.php");
    require_once(__DIR__ . "/HackinGameState.php");
    /**
        Model to track the hackin user and his game state via game specific session id
    */
    class HackinSession {
        public $hackinSessionId;
        public $hackinUserInfo;
        public $hackinGameState;

        function __construct($hackinSessionId, $hackinUserInfo, $hackinGameState) {
            $this->hackinSessionId = $hackinSessionId;
            $this->hackinUserInfo = $hackinUserInfo;
            $this->hackinGameState = $hackinGameState;
        }
    }
?>