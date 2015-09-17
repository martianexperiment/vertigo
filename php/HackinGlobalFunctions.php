<?php
    class HackinGlobalFunctions {
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
        function isRequestFromHackinUser() {
            $isRequestFromHackin = false;

            if(isset($_REQUEST) && !empty($_REQUEST) && isset($_REQUEST["function"])) {
                $isRequestFromHackin = true;
            }
            return $isRequestFromHackin;
        }
    }
?>