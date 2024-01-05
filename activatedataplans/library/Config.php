<?php
/**
 * Config
 * @author: Arindam Metya
 * @note: this is config file
 */
// header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
// header('Cache-Control: no-store, no-cache, must-revalidate');
// header('Cache-Control: post-check=0, pre-check=0', FALSE);
// header('Pragma: no-cache');

//path details

DEFINE('BASEPATH', dirname(dirname( __FILE__ )));
DEFINE('CLASSPATH', dirname( __FILE__ ));

DEFINE('ROOT_PATH','https://activate.cosmotogether.com/activatedataplans/');
DEFINE('CSS_PATH',ROOT_PATH.'asset/css/');
DEFINE('JS_PATH',ROOT_PATH.'asset/js/');
DEFINE('FONT_PATH',ROOT_PATH.'asset/fonts/');

DEFINE('IMAGE_PATH',ROOT_PATH.'asset/images/');
DEFINE('EMAILIMAGE_PATH',ROOT_PATH.'emailimage/');
DEFINE('VERSION','?version='.time());



//Db details
// DEFINE('DBHOST', 'localhost');
// DEFINE('DBUSER', 'activatecosmotog_planmanagement');
// DEFINE('DBPASSWORD', 'it90Fl@6z$taky0qfTTC');
// DEFINE('DBNAME', 'activatecosmotog_plan_mgmt');

DEFINE('DBHOST', 'node-cosmotogether.cluster-ro-cw9dtvbwzq8s.us-east-1.rds.amazonaws.com');
DEFINE('DBUSER', 'admin');
DEFINE('DBPASSWORD', '0k697U$XrGXNK6#K');
DEFINE('DBNAME', 'node_cosmotogether');

DEFINE('USERTABLE', 'user_mstr');
DEFINE('DEVICETABLE', 'device_details_new');
DEFINE('USERADDRESS', 'user_address');
DEFINE('MAILDETAILS', 'tbl_mail_send_dtls');
DEFINE('APILOG', 'api_log');
DEFINE('PLANSTATUS', 'plan_status');
DEFINE('ACTIVATION_PENDING', 'activation_pending');
DEFINE('ENDOFPLANEMAIL', 'end_of_plan_email'); 
DEFINE('WEBCREDIT', 'web_credit'); 
DEFINE('SIPPENDING', 'sip_pending'); 
DEFINE('SETACTIVATION', 'set_activation'); 
DEFINE('SETPURCHASE', 'set_purchase'); 
DEFINE('SETCANCELLATION', 'set_cancelation'); 

DEFINE('PENDING', 'pending'); 
DEFINE('REFURBEDACTIVATION', 'refurbed_activation'); 
DEFINE('ACTIVATEOUTOFFLOWDEVICES', 'activate_out_of_flow_devices');
DEFINE('SHOPIFYENDPOINT', 'https://cosmosmartwatch.myshopify.com/admin/api/2023-04/'); 


//Information for GIGS 
/*DEFINE('GIGSPROJECTNAME', 'cosmo-demo');
DEFINE('GIGSAPIENDPOINT', 'https://api.gigs.tel/projects/');
DEFINE('GIGSAPIKEY', 'pky_1RTNaRkAi6jkN47bllz2XYxpZIN3C6l2Nn3fUqjN2vDmZubv6Q5JbelPI3QuYalVDjDgN9F8OTcBOg');*/

DEFINE('GIGSPROJECTNAME', 'cosmo-direct-test');
DEFINE('GIGSAPIENDPOINT', 'https://api.gigs.tel/projects/');
DEFINE('GIGSAPIKEY', 'gpk_2jgAiwyeI60ssgb2nFdFOIyVjxjfaksrnmRjQJa6echR');

DEFINE('RECHARGEAPIENDPOINT', 'https://api.rechargeapps.com/');
DEFINE('RECHARGEAPIKEY', '7qAWrYZb8a08U0FGzvZXjobpBdeKqb');
DEFINE('RECHARGEWEBHOOKAPIKEY', 'sk_2x2_21b0b60784a87596dc83c8fb6f6c60f90ba9e1cf695235bd43c6e6f82b8459c1');

DEFINE('SPEEDTALKAPIENDPOINT', 'https://portal.speedtalk.mobi/service.aspx');

DEFINE('KLAVIYOAPIENDPOINT', 'https://a.klaviyo.com/api/');
DEFINE('KLAVIYOAPIKEY', 'pk_ff3f15a21ce8f8e124cfbcb0115910fb94');

DEFINE('TELNYXAPIENDPOINT', 'https://api.telnyx.com/v2/');
//DEFINE('TELNYXAPIKEY', 'KEY018510DA5DE04BD3E78100C5AC03C0D3_EgdDMx2Ru76RjCJgffDajB');
DEFINE('TELNYXAPIKEY', 'KEY01833CDB70EDF3771E6C637EFD8FC72F_e1KnllwWTjqzTGCNjDpdVY');



DEFINE('COSMOSIPAPIENDPOINT', 'https://cosmoadmin.senlab.io/sip/');
DEFINE('COSMONETWORKAPIENDPOINT', 'https://cosmoadmin.senlab.io/api/');

DEFINE('COSMOSIP_USERNAME', 'CodeCloudActivation');
DEFINE('COSMOSIP_PASSWORD', 'fgPynVY4HZ');


DEFINE('FRESHDESKAPIENDPOINT', 'https://cosmojrtrack.freshdesk.com/api/v2/');

DEFINE('FRESHDESK_USERNAME', 'fgSrCkNipiLtBWbs7uxi');
DEFINE('FRESHDESK_PASSWORD', 'X');


DEFINE('SHIPSTAIONAPI', 'https://ssapi.shipstation.com/');
DEFINE('SHIPSTAIONUSERNAME', '16b55ead98ac4419935267f6be71a070');
DEFINE('SHIPSTAIONPASSWORD', '40fd35617eb3475fa3ab04d550486067');

//DEFINE('TELNYXAPIKEY', 'KEY018510DA5DE04BD3E78100C5AC03C0D3_EgdDMx2Ru76RjCJgffDaj');

//SMTP details

/*
DEFINE('SMTPHOST', 'smtp.sendgrid.net');
DEFINE('SMTPUSERNAME', 'apikey');
DEFINE('SMTPPASSWORD', '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');
DEFINE('SMTPPORT', '465');
DEFINE('SMTPSENDEREMAIL', 'support@activate.cosmotogether.com');
*/


DEFINE('SENDGRIDKEY', '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');
DEFINE('SMTPSENDEREMAIL', 'support@cosmotogether.com');



// Speedtalk details
DEFINE('AGID', 'russell@saganglobal.com');
//DEFINE('AGPASS', 'SA%G73GofjL');
DEFINE('AGPASS', '942115');
DEFINE('SKU', '8010');
DEFINE('AMOUNT', '5');
DEFINE('ADDRESSINFO', '5500 GROSSMONT CENTER DR STE 440 #2068, LA MESA, CA 91942-9996');
DEFINE('ADDRESS1', '');
DEFINE('ADDRESS2', '');
DEFINE('CITYINFO', 'LA MESA');
DEFINE('STATE', 'CA');
DEFINE('EMAIL', 'support@cosmotogether.com');
DEFINE('PHONE', '8772154741');
DEFINE('CAMPAIGN', '');
DEFINE('ZIPCODE', '90067');


//Encrption Cipher Details 
DEFINE('IV', 'fedcba9876543210');
DEFINE('KEY', '0123456789abcdef');
?>

