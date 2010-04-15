<?php
header('Content-type: application/json');

//include all the source files
$dirItterator = new \RecursiveDirectoryIterator(dirname(__FILE__));
$iterator = new \RecursiveIteratorIterator($dirItterator, \RecursiveIteratorIterator::SELF_FIRST);
foreach($iterator as $file) {
    if($file->isFile()) {
        $filePath = $file->getPathname();
        if(strpos($filePath, ".php") && !strpos($filePath, "index.php")) {
            include_once($filePath);
        }
    }
}

//Get the posted API key
$key = $_POST["key"];

//get the api key service
$service = new GmailToTwitterService\ApiKeyService\Service();

//check that the key is valid
$isValid = $service->IsRegisteredAPIKey($key);

//if not valid then return an error
if(!$isValid) {
    echo '{"result":"fail","message":"The API key you supplied is not a registered API key"}';
    die();
}

//Get the connection data
$data = $_POST["data"];

//get the data validation service
$service = new GmailToTwitterService\DataValidationService\Service();

//check the data is valid
$isValid = $service->IsValidInputData($data);

//if not valid then return an error
if(!$isValid) {
    echo '{"result":"fail","message":"The data you supplied was missing key properties."}';
    die();
}

//if both are valid then get the service
$service = new \GmailToTwitterService\GmailToTwitterAdapter\Service($data);

//run the service
$return = $service->RunService();

//return the return message
return $return;
?>