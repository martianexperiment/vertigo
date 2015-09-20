<?php
require_once(__DIR__ . "/HackinSessionHandler.php");
require_once(__DIR__ . "/HackinGlobalFunctions.php");
require_once(__DIR__ . "/HackinRequestHandler.php");
/**
    Every request comes and flows through this php.
    Handles session via HackinSessionHandler.php
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
        //$hackinSession = HackinSessionHandler::getHackinSession();
        //process all requests here.
        if(isset($_REQUEST["function"])){
            $functionRequest = $_REQUEST["function"];
            switch ($functionRequest) {
                case "logIn()":
                    HackinRequestHandler::logIn();
                    break;
                case "logOut()":
                    HackinRequestHandler::logOut();
                    session_destroy();
                    header("Location: http://hackin.psglogin.in/");
                    break;
                case "forceLogIn()":
                    HackinRequestHandler::forceLogIn();
                    HackinRequestHandler::logIn();
                    break;
                case "getUserInfo()":
                    //userinfo -> emailid, colgname obj
                    echo json_encode(HackinRequestHandler::getHackinUserInfo());
                    break;
                case "getGameState()":
                    echo json_encode(HackinRequestHandler::getGameState());
                    break;
                case "getCurrentView()":
                    //
                    break;
                case "getNextQuestion()":
                    //gives you the entire json file for that question.
                    break;
                case "verifyAnswer()":
                    //
                    break;
                default:
                    try {
                        throw new Exception("illegal request");
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