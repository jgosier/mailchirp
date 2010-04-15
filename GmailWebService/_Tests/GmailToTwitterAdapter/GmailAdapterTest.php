<?php
namespace GmailToTwitterService\Tests\GmailToTwitterAdapter;
require_once 'PHPUnit/Framework.php';
class GmailAdapterTest extends \PHPUnit_Framework_TestCase {
    public function test() {
        include_once(dirname(__FILE__)."/../../GmailToTwitterAdapter/GmailAdapter.php");
        include_once(dirname(__FILE__)."/../../GmailToTwitterAdapter/Email.php");
        $username = "mrmatthewgriffiths@gmail.com";
        $password = "hellit";
        $adapter = new \GmailToTwitterService\GmailToTwitterAdapter\GmailAdapter($username, $password);
        $emails = $adapter->GetEmails(strtotime("-2 days"), 30);
    }
}
?>
