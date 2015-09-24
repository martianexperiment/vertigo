<?php
require_once(__DIR__ . "/HackinGlobalFunctions.php");
require_once(__DIR__ . "/HackinRequestHandler.php");
/**
    Every request comes and flows through this php.
    Handles Game requests via HackinGameEngine.php
    Acts as the mapper for the requests.
    When moving on to MVC, replace this file with the url mapper, and provide urls for every functionality mentioned here.
*/
    try {
        //process request first to avoid verifying game state of the user, for invalid requests.
        $functionalityForWhichExceptionExpected = "RequestReceiver.php: Verifying whether the request is valid";
        if(!HackinGlobalFunctions::isRequestFromHackinPage()) {
            $ex = new Exception("Invalid request. Intrusion detected");
            echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
            exit();
        }
        $functionalityForWhichExceptionExpected = "Verify whether session is valid";
        //process all requests here.
        $hackinRequestHandler = new HackinRequestHandler();
        if(isset($_REQUEST["function"])){
            $functionRequest = $_REQUEST["function"];
            switch ($functionRequest) {
                case "logIn()":
                    //echo "logIn() called";
                    echo $hackinRequestHandler->logIn();
                    break;
                case "logOut()":
                    $hackinRequestHandler->logOut();
                    session_destroy();
                    header("Location: http://" . HackinConfig::$phpServer);
                    break;
                case "forceLogIn()":
                    echo $hackinRequestHandler->forceLogIn();
                    break;

                /**
                    Functionalities for which verifying live sessions doesn't matter.
                */
                case "getUserInfo()":
                    //userinfo -> emailid, colgname obj
                    $hackinUserInfo = json_encode($hackinRequestHandler->getHackinUserInfo());
                    echo addslashes($hackinUserInfo);
                    break;
                case "getGameState()":
                    $gameState = json_encode($hackinRequestHandler->getGameState());
                    echo addslashes($gameState);
                    break;

                /**
                    Verify live sessions without fail.
                */
                case "getCurrentView()":
                    $hackinRequestHandler->verifyLiveSessionBeforeProcessingRequest();
                    $obj = json_decode(readfile(__DIR__."/../questionModel/q1.json"));
                    json_encode($obj);
                    break;
                case "getNextQuestion()":
                case "getQuestion(1)":
                    $obj = file_get_contents(__DIR__."/../questionModel/q1.json");
                    echo addslashes($obj);
                    break;
                case "getQuestion(2)":
                    $obj = file_get_contents(__DIR__."/../questionModel/q2.json");
                    echo addslashes($obj);
                    break;
                case "verifyAnswer()":
                    $hackinRequestHandler->verifyLiveSessionBeforeProcessingRequest();
                    //
                    break;
                default:
                    try {
                        throw new Exception("illegal request to Hackin");
                    } catch(Exception $ex) {
                        echo HackinErrorHandler::errorHandler($ex, $_REQUEST['function']);
                        exit();
                    }
                    break;
                }
            return;
        } /*else if(other functionalities are available) {

        }*/
    } catch(Exception $ex) {
        //$ex = new Exception("Page request is invalid. Illegal access detected");
        echo HackinErrorHandler::errorHandler($ex, $functionalityForWhichExceptionExpected);
        exit();
    }

/**
    +********************************************************** HACKIN FUNCTIONS SEGMENT ***********************************************************+
*/
?>