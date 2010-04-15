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

//Create a new service
$service = new \MailChirp\GmailWebService\Service($_POST);

//run the service
$returnMessage = $service->Run();

//return the result
echo $returnMessage;
?>