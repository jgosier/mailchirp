<?php
namespace GmailToTwitterService\GmailToTwitterAdapter;
class TwitterAdapter {
    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
        include_once("Services/Twitter.php");
    }

    public function SendDirectMessage($to, $message) {
        try {
            $service = new \Services_Twitter($this->username, $this->password);
            $service->direct_messages->new($to, $message);
            $service->account->end_session();
        }
        catch (Exception $e) {
            die($e->getMessage());
        }



    }
}
?>
