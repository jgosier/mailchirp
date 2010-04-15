<?php
namespace GmailToTwitterService\Tests\GmailToTwitterAdapter;
require_once 'PHPUnit/Framework.php';
class TwitterAdapterTests extends \PHPUnit_Framework_TestCase {
    public function test() {
        include_once(dirname(__FILE__)."/../../GmailToTwitterAdapter/TwitterAdapter.php");
        $username = "mkgriffiths";
        $password = "";
        $adapter = new \GmailToTwitterService\GmailToTwitterAdapter\TwitterAdapter($username, $password);
    }
}
?>
