<?php
    require_once(__DIR__ . "/config/HackinConfig.php");
    /**
        Global, centralized error handler for Hackin event
        TODO: Create error model to be help handling easier in frontend and bind the message and errors.
        TODO: Create a log and log all these exceptions.
    */
    class HackinErrorHandler {
        /**
            TODO: create/use existing error log and dump the state along with the error msg.
        */
        public static function errorHandler(Exception $ex, $errorOccuredIn) {
            $errorOccuredIn = "Error occured during **".$errorOccuredIn."** msg=" . $ex->getMessage() ;
            $errorMsg = $errorOccuredIn . self::errorMsgToShowToHackinUser($errorOccuredIn);
            //log in the file here
            return $errorMsg;
        }

        /**
            Use this function to integrate with the error page
            TODO: String output based on the error
        */
        private static function errorMsgToShowToHackinUser($errorOccuredIn) {
            $errorMsg = "{" . 
                            "\"error\": " . json_encode($errorOccuredIn) .
                            "\"html\": " . json_encode(file_get_contents(__DIR__ . "/../oops.html")) .
                        "}";
            return $errorMsg;
        }

        /**
            Use this function to interrupt the current flow other than error
            TODO: Generalize it
        */
        public static function interruptHandler($interruption, $interruptionMsg) {
            /*if(strcasecmp($interruption, HackinConfig::$multipleSessionInterruption) == 0) {
                //$jsonObject = json_decode($interruptionMsg);
                $interruptionMsg = $interruptionMsg;
            }*/

            return $interruptionMsg;
            /*$obj = json_decode($interruptionMsg);
            $file = __DIR__ . "\..\mutiple.html";
            echo $file . "<br>";
            print_r($file);
            $doc = new DOMDocument();
            $doc->loadHTMLFile('C:\DevTools\WebKits\wamp22\www\hackin15\vertigo\mutiple.html');
            $div = $dom->getElementById('error-msg');

            $xpath = new DOMXpath($doc);
            $elements = $xpath->query("//*[@id='error-msg']");
            if (!is_null($elements)) {
                foreach ($elements as $element) {
                    $nodes = $element->childNodes;
                    $browser =  $obj->{'liveSession'}->{'browser'};
                    $nodes[0]->nodeValue = $browser;
                    $browser =  $obj->{'currentSession'}->{'browser'};
                    $nodes[1]->nodeValue = $browser;
                }
            }
            echo $doc->saveHTML;
            * /
            $path = '/wiki/Pop_music';
            $url = "http://en.wikipedia.org$path";
            $doc = new \DOMDocument();
            $success = @$doc->loadHTMLFile($url);

            if ($success) {
                $xpath = new DOMXPath($doc);
                $xpathCode = "//h1[@id='firstHeading']";
                $nodes = $xpath->query($xpathCode);
                echo $nodes->item(0)->nodeValue."<br />";
                print $doc->saveHTML;
            }
            echo $success;*/
        }

    }
    //$interruption = HackinConfig::$multipleSessionInterruption;
    //$interruptionMsg = 
        //  '{"interruption": "MulitpleSessionsInterruption","liveSession": {"browser": "Firefox","ip": "::1","lastActiveTime": "2015-09-21 07:19:32"},"currentSession": {"browser": "Chrome", "ip": "::1", "lastActiveTime": "2015-09-21 07:28:12"}}'
    HackinErrorHandler::interruptHandler("", "");
?>