<?php
    class HackinGlobalFunctions {
        public static $phpServer = /**'localhost/hackin15/vertigo';//*/"hackin.psglogin.in";
        public static $multipleSessionInterruption = "MulitpleSessionsInterruption";
        
        /**
            Initialize configs related to php
            return: void
        */
        public static function phpConfigInitilaization() {
            setlocale(LC_MONETARY, 'en_IN');
            date_default_timezone_set('Asia/kolkata');
        }

        /**
            Simulates http request.
            TODO: Extend the support to all types of protocols and header values
        */
        public static function simulateHttpRequest($protocol, $server, $filePathFromServer, $data, $header, $method) {
            $url = $protocol . '://' . $server . $filePathFromServer;
            // using key as 'http' even if the request is to https://...
            $key = $protocol;
            if($protocol == "https") {
                $key = "http";
            }
            $options = array(
                $key => array(
                    'header'  => $header,
                    'method'  => $method,
                    'content' => http_build_query($data),
                    ),
                );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            return $result;
        }

        /**
            check whether the request is from hackin page.
            return: true if the request is from front-end of hackin
                    else false.
            TODO: change all request methods to post and encrypt them
        */
        public static function isRequestFromHackinPage() {
            $isRequestFromHackin = false;

            if(isset($_REQUEST) && !empty($_REQUEST) && isset($_REQUEST["function"])) {
                $isRequestFromHackin = true;
            }
            return $isRequestFromHackin;
        }

        /**
            Converts SQL Time Format(Y-m-d H:i:s) to PHP(unix epoch) time format
            return: $unixTime
        */
        public static function timeStampFromSqlToPhp($sqltime){
            $unixTime = strtotime($sqltime);
            return $unixTime;
        }
         
        /**
            Converts PHP(unix epoch) time format to SQL Time Format(Y-m-d H:i:s)
            return: $sqlTimeStamp
        */
        public static function timeStampFromPhpToSql($unixtime){
            $sqlTimeStamp = gmdate("Y-m-d H:i:s", $unixtime);
            return $sqlTimeStamp;
        }

        public static function underscores_toCamelCase($string, $capitalizeFirstCharacter = false) {
            $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
            if (!$capitalizeFirstCharacter) {
                $str[0] = strtolower($str[0]);
            }
            return $str;
        }
    }
    HackinGlobalFunctions::phpConfigInitilaization();
    /*$inputTimeStamp = "2015-09-18 10:50:06";
    $phpTimeStamp = HackinGlobalFunctions::timeStampFromSqlToPhp($inputTimeStamp);
    $sqlTimeStamp = HackinGlobalFunctions::timeStampFromPhpToSql($phpTimeStamp);
    echo "currentTime=" . time();
    echo "<br>inputTimeStamp= ". $inputTimeStamp;
    echo "<br>phpTimeStamp= " . $phpTimeStamp;
    echo "<br>sqlTimeStamp= " . $sqlTimeStamp;
    echo HackinGlobalFunctions::underscores_toCamelCase('this_is_a_string');
    //*/
?>