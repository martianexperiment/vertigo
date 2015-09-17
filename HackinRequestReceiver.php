<?php
require_once(__DIR__ . "/php/HackinSessionHandler.php");
require_once(__DIR__ . "/php/HackinGlobalFunctions.php");
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
        HackinGlobalFunctions::isRequestFromHackinUser();
        $functionalityForWhichExceptionExpected = "Verify whether session is valid";
        $hackinSession = HackinSessionHandler::getHackinSession();
        //process all requests here.
        if(isset($_REQUEST["function"])){
            $functionRequest = $_REQUEST["function"];
            switch ($functionRequest) {
                case "logIn()":
                    readfile(__DIR__ . "/index.html");//link to first page
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