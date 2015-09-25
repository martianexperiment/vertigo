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
                case "getQuestionState()":
                    if(empty($_REQUEST['questionNum'])) {
                        $functionalityForWhichExceptionExpected = "getting question state";
                        $ex = new Exception("invalid request to get question state. Pls try again after refreshing the front end");
                        throw $ex;
                    }
                    $qnNo = intval($_REQUEST['questionNum']);
                    $questionState = json_encode($hackinRequestHandler->getQuestionState($qnNo));
                    echo addslashes($questionState);
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
                    $hackinRequestHandler->verifyLiveSessionBeforeProcessingRequest();
                    $obj = file_get_contents(__DIR__."/../questionModel/q1.json");
                    echo addslashes($obj);
                    break;
                case "getQuestion(2)":
                    $hackinRequestHandler->verifyLiveSessionBeforeProcessingRequest();
                    $obj = file_get_contents(__DIR__."/../questionModel/q2.json");
                    echo addslashes($obj);
                    break;
                case "getQuestion(3)":
                    $hackinRequestHandler->verifyLiveSessionBeforeProcessingRequest();
                    $obj = file_get_contents(__DIR__."/../questionModel/q3.json");
                    echo addslashes($obj);
                    break;
                case "getQuestion(4)":
                    $hackinRequestHandler->verifyLiveSessionBeforeProcessingRequest();
                    $obj = file_get_contents(__DIR__."/../questionModel/q4.json");
                    echo addslashes($obj);
                    break;
                case "verifyAnswer()":
                    $hackinRequestHandler->verifyLiveSessionBeforeProcessingRequest();
                    //TODO: get from request string, else throw exception
                    if(empty($_REQUEST['questionNum']) || empty($_REQUEST['answer'])) {
                        $functionalityForWhichExceptionExpected = "verifying answer";
                        $ex = new Exception("invalid request to verify answer. Pls try again after refreshing the front end");
                        throw $ex;
                    }
                    $qnNo = intval($_REQUEST['questionNum']);
                    $answer = $_REQUEST['answer'];
                    $answer = strtolower(addslashes($answer));
                    $answer = HackinGlobalFunctions::truncate($answer, 40);
                    $hackinRequestHandler->verifyLiveSessionBeforeProcessingRequest();
                    $questionState = json_encode($hackinRequestHandler->verifyAnswer($qnNo, $answer));
                    echo addslashes($questionState);
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