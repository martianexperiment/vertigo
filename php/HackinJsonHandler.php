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

        public static function hackinQuestionStateInfoRetrievalFromObject($row) {
            $functionalityWhenInterruptionExpected = "Retrieve data for HackinQuestionState object= " . json_encode($row);
            $hackinQuestionState = new HackinQuestionState();
            try {
                foreach($obj as $field => $fieldValue) {
                    $member = HackinGlobalFunctions::underscores_toCamelCase($field);
                    $hackinQuestionState->$member = $fieldValue;
                }
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, $functionalityWhenInterruptionExpected);
                exit();
            }
            return $hackinQuestionState;
        }
    }
  /*
    $obj = file_get_contents(__DIR__."/../questionModel/q2.json");
    $json = json_decode($obj);
    print_r($json);
    //echo addslashes($obj);
    //*/
?>