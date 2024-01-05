<?php

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'sendgrid-php'. DIRECTORY_SEPARATOR .'sendgrid-php.php';


$email = new \SendGrid\Mail\Mail();
$email->setFrom("support@cosmotogether.com", "COSMO");
$email->setSubject("Sending with Twilio SendGrid is Fun");
$email->addTo("suderson.halder@codeclouds.com", "Suderson");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
);
$sendgrid = new \SendGrid(SENDGRIDKEY);
//$sendgrid = new \SendGrid('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');
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}