<?php
    require_once(__DIR__ . "/../HackinErrorHandler.php");
    
    class UserIpInfo {
        public $ip;
        public $ipDetails;

        public function __construct() {
            try {
                $this->ip = self::getIp();
                $this->ipDetails = self::getIpDetails();
            } catch(Exception $ex) {
                echo HackinErrorHandler::errorHandler($ex, "while retrieving ip info");
                exit();
            }
        }

        public static function getIpDetails() {
            $ips = "{";
            $prevFlag = 0;
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ips = $ips . '"$_SERVER[HTTP_CLIENT_IP]":  ' . ($_SERVER['HTTP_CLIENT_IP']);
                $prevFlag = 1;
            } 
            if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                if($prevFlag == 1) {
                    $ips = $ips . ', ';
                }
                $ips = $ips . ', $_SERVER[HTTP_X_FORWARDED_FOR]": [' . ($_SERVER['HTTP_X_FORWARDED_FOR']) . '], ';
                $prevFlag = 1;
            }
            if(!empty($_SERVER['REMOTE_ADDR'])) {
                if($prevFlag == 1) {
                    $ips = $ips . ', ';
                }
                $ips = $ips . '"$_SERVER[REMOTE_ADDR]":  ' . ($_SERVER['REMOTE_ADDR']);
                $prevFlag = 1;
            }
            $ips = $ips . "}";
            return $ips;
        }

        public static function getIp() {
            $ipaddress = '';
            if(!empty($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = ($_SERVER['HTTP_CLIENT_IP']);
            else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = ($_SERVER['HTTP_X_FORWARDED_FOR']);
            else if(!empty($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = ($_SERVER['HTTP_X_FORWARDED']);
            else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = ($_SERVER['HTTP_FORWARDED_FOR']);
            else if(!empty($_SERVER['HTTP_FORWARDED']))
                $ipaddress = ($_SERVER['HTTP_FORWARDED']);
            else if(!empty($_SERVER['REMOTE_ADDR']))
                $ipaddress = ($_SERVER['REMOTE_ADDR']);
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }
    }

    //echo UserIpInfo::getIpDetails();
    /*$obj = json_encode(new UserIpInfo());
    echo $obj;
    print_r(json_decode($obj));*/
?>