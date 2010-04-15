<?php
namespace MailChirp\GmailToTwitterService\GmailToTwitterAdapter;
class Service {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function RunService() {

        //Try to get the emails from Gmail

        try {
            //Get a new Gmail Adapter
            $gmailAdapter = new \MailChirp\GmailToTwitterService\GmailToTwitterAdapter\GmailAdapter(
                    $this->data->gmailUsername,
                    $this->data->gmailPassword);

            //Extract the optional properties from the data
            $fromDate = $this->data->fromDate;
            $limit = $this->data->limit;

            //Get the emails by calling the adapter
            $emails = $gmailAdapter->GetEmails(
                    $fromDate,
                    $limit);

        }
        catch(Exception $e) {
            return array(
                "result" => "fail",
                "exception" => $e
            );
        }

        //then try to send them to twitter
        try {
            //get the Twitter adapter
            $twitterAdapter = new \MailChirp\GmailToTwitterService\GmailToTwitterAdapter\TwitterAdapter(
                    $this->data->twitterUsername,
                    $this->data->twitterPassword);

            //set up a collection to hold individual errors
            $innerExceptions = array();

            //Loop through the emails
            foreach($emails as $email) {
                try {
                    //get a message formatter for the email
                    $formatter = new TwitterMessageFormatter($email);

                    //get the message
                    $message = $formatter->FormatMessage();

                    //Try and call the twitter adapter
                    $twitterAdapter->SendDirectMessage(
                            $this->data->twitterToAddress,
                            $message);
                }
                catch (Exception $innerE) {
                    $innerExceptions[] = array(
                        "exception" => $innerE,
                        "email" => $email,
                    );
                }
            }

            //if there were emails but they all failed
            if(count($emails) > 0 && count($emails) == count($innerExceptions)) {
                //return the result as a fail
                return array(
                    "result" => "fail",
                    "exceptions" => $innerExceptions
                );
            }

            //else return the result as a pass
            return array(
                "result" => "pass",
                "exceptions" => $innerExceptions
            );

        }
        catch(Exception $e) {
            return array(
                "result" => "fail",
                "exception" => $e
            );
        }
    }
}
?>
