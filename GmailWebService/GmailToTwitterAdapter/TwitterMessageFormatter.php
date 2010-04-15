<?php
namespace MailChirp\GmailToTwitterService\GmailToTwitterAdapter;
class TwitterMessageFormatter {
    private $email;

    public function __construct($email) {
        $this->email = $email;
    }

    public function FormatMessage() {
        $message =
            "mailchirp;".
            "from:".$this->email->sender.";".
            "subject:".$this->email->subject;
        
        if(count($message) > 140) {
            $message = substr($message, 0, 137)."...";
        }

        return $message;
    }
}
?>
