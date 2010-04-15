<?php
namespace GmailToTwitterService\GmailToTwitterAdapter;
class GmailAdapter {
    private $hostname;
    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $this->username = $username;
        $this->password = $password;
    }

    /**
     *
     * @param time $fromDate
     * @param int $limit
     * @return Email[]
     */
    public function GetEmails($fromDate = null, $limit = -1) {
        //try to open the inbox
        $inbox = imap_open($this->hostname, $this->username, $this->password);

        //get the emails
        $emails = imap_search($inbox,'ALL');

        if(!$emails) {
            //do something?
        }

        //put the newest email first
        rsort($emails);

        //set up the return array
        $returnEmails = array();

        $counter = 0;

        foreach($emails as $emailId) {
            //check we are not over our limit
            if($limit > 0 && $counter > $limit) {
                //if we are then stop adding emails
                break;
            }

            //get the email overview
            $overview = imap_fetch_overview($inbox,$emailId,0);

            //get the date of the email
            $date = $overview[0]->date;

            //If a from date is supplied
            if(isset($fromDate)) {
                //check if this is within the date
                if(strtotime($date) < $fromDate) {
                    //if it is then skip it.
                    continue;
                }
            }

            //get the email message
            $message = imap_fetchbody($inbox,$emailId,2);

            //Create a new email object
            $returnEmail = new Email();
            
            //collect the data for imap 
            $returnEmail->date = $date;
            $returnEmail->message = $message;
            $returnEmail->read = $overview[0]->seen;
            $returnEmail->sender = $overview[0]->from;
            $returnEmail->subject = $overview[0]->subject;
            
            //Add the email to the return array
            $returnEmails[] = $returnEmail;

            //increment the counter
            $counter++;
        }

        //Close the imap connection
        imap_close($inbox);

        //return the emails
        return $returnEmails;
    }
}
?>
