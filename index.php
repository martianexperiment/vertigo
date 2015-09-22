<?php
require_once(__DIR__ . "/php/models/HackinUserMonitor.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Hack[IN] 2015</title>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
  
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript" src="js/impeccable.js"></script>
  <link rel="stylesheet" href="css/impeccable.css">
  <link rel="stylesheet" href="css/benji.css">

  <script src="js/pace-min.js"></script>
  <link href="css/pace-min.css" rel="stylesheet" />

    <!-- Custom js is attached at the end of the page -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container">

  <div class="row voffset3">
    <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-3 col-lg-4 col-md-4 col-sm-6 col-xs-6">
      <img class="img-responsive center-block" src="img/hackin.png" />
    </div>
  </div>
  <div class="row voffset2">
    <div class="col-lg-12">
      <div id="event-title" class="text-center">Hack[IN]</div>
    </div>
  </div>

<?php
    $userBrowserInfo = new UserBrowserInfo();
    $browser = $userBrowserInfo->browser;
    //echo "browser = $browser";
 if(strcasecmp($browser, "Firefox") == 0 || strcasecmp($browser, "Chrome") == 0 || preg_match('/Android/',$browser) !== false) {
    //Only if firefox, chrome
    echo '<div class="row voffset6" id="starts-text-row">
    <div class="col-lg-12">
      <p class="start-text">Ends within</p>
    </div>
    </div>
  <div class="row voffset1">
            <div class="col-lg-12">'.
     "<div class='wrapper text-center'>
       <div class='time-part-wrapper' id='days'>
         <div class='time-part days tens'>
           <div class='digit-wrapper'>
             <span class='digit'>0</span>
             <span class='digit'>9</span>
             <span class='digit'>8</span>
             <span class='digit'>7</span>
             <span class='digit'>6</span>
             <span class='digit'>5</span>
             <span class='digit'>4</span>
             <span class='digit'>3</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
           </div>
         </div>
         <div class='time-part days ones'>
           <div class='digit-wrapper'>
             <span class='digit'>0</span>
             <span class='digit'>9</span>
             <span class='digit'>8</span>
             <span class='digit'>7</span>
             <span class='digit'>6</span>
             <span class='digit'>5</span>
             <span class='digit'>4</span>
             <span class='digit'>3</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
           </div>
         </div>
       </div>
       <div class='time-part-wrapper' id='hours'>
         <div class='time-part hours tens'>
           <div class='digit-wrapper'>
             <span class='digit'>0</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
           </div>
         </div>
         <div class='time-part hours ones'>
           <div class='digit-wrapper'>
             <span class='digit'>0</span>
             <span class='digit'>3</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
             <span class='digit'>9</span>
             <span class='digit'>8</span>
             <span class='digit'>7</span>
             <span class='digit'>6</span>
             <span class='digit'>5</span>
             <span class='digit'>4</span>
             <span class='digit'>3</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
             <span class='digit'>9</span>
             <span class='digit'>8</span>
             <span class='digit'>7</span>
             <span class='digit'>6</span>
             <span class='digit'>5</span>
             <span class='digit'>4</span>
             <span class='digit'>3</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
           </div>
         </div>
       </div>
       <div class='time-part-wrapper hidden-xs' id='minutes'>
         <div class='time-part minutes tens'>
           <div class='digit-wrapper'>
             <span class='digit'>0</span>
             <span class='digit'>5</span>
             <span class='digit'>4</span>
             <span class='digit'>3</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
           </div>
         </div>
         <div class='time-part minutes ones'>
           <div class='digit-wrapper'>
             <span class='digit'>0</span>
             <span class='digit'>9</span>
             <span class='digit'>8</span>
             <span class='digit'>7</span>
             <span class='digit'>6</span>
             <span class='digit'>5</span>
             <span class='digit'>4</span>
             <span class='digit'>3</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
           </div>
         </div>
       </div>
       <div class='time-part-wrapper hidden-sm hidden-xs' id='seconds'>
         <div class='time-part seconds tens'>
           <div class='digit-wrapper'>
             <span class='digit'>0</span>
             <span class='digit'>5</span>
             <span class='digit'>4</span>
             <span class='digit'>3</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
           </div>
         </div>
         <div class='time-part seconds ones'>
           <div class='digit-wrapper'>
             <span class='digit'>0</span>
             <span class='digit'>9</span>
             <span class='digit'>8</span>
             <span class='digit'>7</span>
             <span class='digit'>6</span>
             <span class='digit'>5</span>
             <span class='digit'>4</span>
             <span class='digit'>3</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
           </div>
         </div>
       </div>
       <div class='time-part-wrapper hidden-md hidden-sm hidden-xs' id='hundreths'>
         <div class='time-part hundredths tens'>
           <div class='digit-wrapper'>
             <span class='digit'>0</span>
             <span class='digit'>9</span>
             <span class='digit'>8</span>
             <span class='digit'>7</span>
             <span class='digit'>6</span>
             <span class='digit'>5</span>
             <span class='digit'>4</span>
             <span class='digit'>3</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
           </div>
         </div>
         <div class='time-part hundredths ones'>
           <div id='ht_d' class='digit-wrapper'>
             <span class='digit'>0</span>
             <span class='digit'>9</span>
             <span class='digit'>8</span>
             <span class='digit'>7</span>
             <span class='digit'>6</span>
             <span class='digit'>5</span>
             <span class='digit'>4</span>
             <span class='digit'>3</span>
             <span class='digit'>2</span>
             <span class='digit'>1</span>
             <span class='digit'>0</span>
           </div>
         </div>
       </div>
     </div>
        
           </div>
        </div>" . 
        '<div class="row voffset3">
            <div class="col-lg-12">
                <div id="sign-in-IE" class="loader"><a href="http://hackin.psglogin.in/login.php" >SIGN IN</a></div>
            </div>
        </div>';
} else {
    echo '
    <div class="row voffset3">
        <div class="col-lg-12">
            <div id="sign-in"><a href="http://hackin.psglogin.in/login.php" >SIGN IN</a></div>
    </div>
    </div>';
}
?>
<div class="row offset2">
  <div class="col-lg-12">
    <p class="text-center">
        <span>Made with</span>        
        <span class="glyphicon glyphicon-heart"></span>
      </p>
  </div>
</div>

</div>
</body>
</html>
