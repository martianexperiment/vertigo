<?php
    require_once(__DIR__ . "/HackinErrorHandler.php");
    
    require_once(__DIR__ . "/models/HackinSessionInfo.php");
    require_once(__DIR__ . "/models/HackinUserInfo.php");
    require_once(__DIR__ . "/models/HackinGameState.php");
    require_once(__DIR__ . "/models/HackinQuestionState.php");
    require_once(__DIR__ . "/models/HackinSession.php");

    /**
        From associative array to corresponding model object retrieval.
    */
    class HackinJsonHandler {
        public static $debug = 0;
        /**
            Convert Hackin Session Information retrieved from Db(associative array $obj) to HackinSessionInfo object
            return: $hackinSessionInfo
        */
        public static function hackinSessionInfoRetrievalFromObject($obj) {
            $functionalityWhenInterruptionExpected = "Retrieve data for HackinSessionInfo object:";
            $hackinSessionInfo = new HackinSessionInfo();
            try {
                foreach($obj as $field => $fieldValue) {
                    $member = HackinGlobalFunctions::underscores_toCamelCase($field);
                    $hackinSessionInfo->$member = $fieldValue;
                }
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityWhenInterruptionExpected);
                exit();
            }
            return $hackinSessionInfo;
        }

        public static function hackinGameStateInfoRetrievalFromObject($obj) {
            $functionalityWhenInterruptionExpected = "Retrieve data for HackinGameState object:";
            $hackinGameState = new HackinGameState();
            try {
                foreach($obj as $field => $fieldValue) {
                    $member = HackinGlobalFunctions::underscores_toCamelCase($field);
                    $hackinGameState->$member = $fieldValue;
                }
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityWhenInterruptionExpected);
                exit();
            }
            return $hackinGameState;
        }

        public static function hackinQuestionStateInfoRetrievalFromObject($obj) {
            $functionalityWhenInterruptionExpected = "Retrieve data for HackinQuestionState object= " . json_encode($obj);
            if(self::$debug) {
                echo "<br>@jsonDecoder::<br>".$functionalityWhenInterruptionExpected;
            }
            $hackinQuestionState = new HackinQuestionState();
            try {
                foreach($obj as $field => $fieldValue) {
                    $member = HackinGlobalFunctions::underscores_toCamelCase($field);
                    if(self::$debug) {
                        echo "<br>". $field." is " . $member ."";
                        echo " ";
                    }
                    $hackinQuestionState->$member = $fieldValue;
                }
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityWhenInterruptionExpected);
                exit();
            }
            return $hackinQuestionState;
        }
    }
    /*$obj = array("email_id" => "thirukkakarnan@gmail.com", "question_no" => 1, "has_solved" => 0, "no_of_attempts_made" => 0, 
        "plays_as_character" => "{\"name\":\"Dimitry\", \"profilePic\":\"img/dimitry.png\"}", "max_no_of_attempts_allowed" => 15);
    $jsonObj = HackinJsonHandler::hackinQuestionStateInfoRetrievalFromObject($obj) ;
    echo json_encode($jsonObj);*/
  /*
    $obj = file_get_contents(__DIR__."/../questionModel/q2.json");
    $json = json_decode($obj);
    print_r($json);
    //echo addslashes($obj);
    //*/
?>