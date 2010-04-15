<?php
namespace GmailToTwitterService\Tests;
require_once 'PHPUnit/Framework.php';
class ServiceTest extends \PHPUnit_Framework_TestCase {
    public function test() {
        //include all the source files
        $dirItterator = new \RecursiveDirectoryIterator(dirname(__FILE__)."/../");
        $iterator = new \RecursiveIteratorIterator($dirItterator, \RecursiveIteratorIterator::SELF_FIRST);
        foreach($iterator as $file) {
            if($file->isFile()) {
                $filePath = $file->getPathname();
                if(strpos($filePath, ".php") && !strpos($filePath, "index.php")) {
                    include_once($filePath);
                }
            }
        }

        //buid the data
        $postdata = array(
            "key" => "somegoodkey",
            "data" => '{'.
                        '"gmailUsername":"ENTER-HERE",'.
                        '"gmailPassword":"ENTER-HERE",'.
                        '"limit":3,'.
                        '"twitterUsername":"ENTER-HERE",'.
                        '"twitterPassword":"ENTER-HERE",'.
                        '"twitterToAddress":"ENTER-HERE"'.
                       '}'
        );

        //get the service
        $service = new \MailChirp\GmailWebService\Service($postdata);

        //run the service
        $return = $service->Run();
    }
}
?>
