<?php
namespace GmailToTwitterService\GmailToTwitterAdapter;
class TwitterAdapter {
    $result = shell_exec('curl -u davidwalshblog:myPass -d "text=Testing a remote direct message via C
URL&user=fellowTweeter" http://twitter.com/direct_messages/new.xml');

    public function SendDirectMessage() {
        
    }
}
?>
