<?php
    require_once(__DIR__ . "/php/HackinGlobalFunctions.php");
    require_once(__DIR__ . "/php/HackinSessionStarter.php");
    require_once(__DIR__ . "/php/models/HackinUserMonitor.php");

    require_once(__DIR__ . "/php/config/HackinConfig.php");
    /**
        The page which is loaded initially on sign in.
        The header remains the same, though the content body is dynamically determined by the post request.
        Helps to maintain the website as single page html content.
    */
    if(!isset($_SESSION['ses_auth'])) {
        /**
            insert or remove '/' between /** and header('... to switch on/off simulations
        */
        /**header('LOCATION: //accounts.psglogin.in/index.php?r=hackin');/*/
        //Simulating  the sessions from accounts.psglogin.in
        $_SESSION['ses_auth'] = "1";
        $_SESSION['ses_account_type'] = 'PAR';
        $_SESSION['ses_email'] = 'thirukkakarnan@gmail.com';
        $_SESSION['ses_phone'] = '9842146152';
        
        if(strcasecmp($_SESSION['ses_account_type'], 'ALU') == 0) {
            $_SESSION['ses_alumni_rollno'] = '11PW38';
            $_SESSION['ses_alumni_name'] = 'Thirukka Karnan S';
            //echo $_SESSION['ses_account_type'] . "; " . $_SESSION['ses_email'] . "; " . $_SESSION['ses_phone'] . "; " . $_SESSION['ses_alumni_rollno'] . "; " . $_SESSION['ses_alumni_name'] . "; 
        } else if(strcasecmp($_SESSION['ses_account_type'], 'PAR') == 0) {
            $_SESSION['ses_cCode'] = "1234";
            $_SESSION['ses_college_name'] = "PSG College Of Technology";
            $_SESSION['ses_dept_name'] = "DAMCS";
            //echo $_SESSION['ses_account_type'] . "; " . $_SESSION['ses_email'] . "; " . $_SESSION['ses_phone'] . "; " . $_SESSION['ses_cCode'] . "; " . $_SESSION['ses_college_name'] . "; " . $_SESSION['ses_dept_name'];
        }
        //*/
    }

    $userBrowserInfo = new UserBrowserInfo();
    $_SESSION['hackin_user_agent'] = $userBrowserInfo->userAgent;

    /**
        Post method from login.php to HackinRequestReceiver.php, to load the page when a user logs in for the first time.
    */
    $protocol = "http";
    $filePathFromServer = "/php/HackinRequestReceiver.php";
    $data = array('function' => 'logIn()');
    $header = "Content-type: application/x-www-form-urlencoded\r\n" . 
                "Cookie: " . session_name() . "=" . session_id() . "\r\n";
    $method = 'POST';
    session_write_close();
    echo HackinGlobalFunctions::simulateHttpRequest($protocol, HackinConfig::$phpServer, $filePathFromServer, $header, $method, $data);
?>