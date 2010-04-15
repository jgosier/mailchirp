<?php
namespace MailChirp\GmailWebService;
class Service {
    private $postdata;

    public function __construct($postdata) {
        $this->postdata = $postdata;
    }

    public function Run() {

        //Get the posted API key
        $key = $this->postdata["key"];

        //get the api key service
        $service = new \MailChirp\GmailToTwitterService\ApiKeyService\Service();

        //check that the key is valid
        $isValid = $service->IsRegisteredAPIKey($key);

        //if not valid then return an error
        if(!$isValid) {
            echo '{"result":"fail","message":"The API key you supplied is not a registered API key"}';
            die();
        }

        //Get the connection data
        $data = json_decode($this->postdata["data"]);

        //get the data validation service
        $service = new \MailChirp\GmailToTwitterService\DataValidationService\Service();

        //check the data is valid
        $isValid = $service->IsValidInputData($data);

        //if not valid then return an error
        if(!$isValid) {
            echo '{"result":"fail","message":"The data you supplied was missing key properties."}';
            die();
        }

        //if both are valid then get the service
        $service = new \MailChirp\GmailToTwitterService\GmailToTwitterAdapter\Service($data);

        //run the service
        $return = $service->RunService();

        //return the return message
        return $return;
    }
}
?>
