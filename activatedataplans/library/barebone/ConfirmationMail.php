<?php


namespace Application;

/**
 * 
 */

require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activate_dataplans/vendor/'.'PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activate_dataplans/vendor/'.'SMTP.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activate_dataplans/vendor/'.'Exception.php';


// require_once  '..'.DIRECTORY_SEPARATOR. 'vendor' .DIRECTORY_SEPARATOR . 'PHPMailer.php';
// require_once  '..'.DIRECTORY_SEPARATOR. 'vendor' .DIRECTORY_SEPARATOR . 'SMTP.php';
// require_once '..'.DIRECTORY_SEPARATOR. 'vendor' .DIRECTORY_SEPARATOR . 'Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
@session_start();
class WebMail 
{
    
    function __construct()
    {
        // code...
    }

    public function sendMail($to)
    {

        $mail = new PHPMailer(true);
        $otp=mt_rand(100000,999999);
        $_SESSION['otp']=$otp;

        $message="Your 6 Digits OTP for COSMO Verification is: ".$otp;
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = SMTPHOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = SMTPUSERNAME;                     //SMTP username
            $mail->Password   = SMTPPASSWORD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('vijaya.jha@codeclouds.in', 'Mailer');
            $mail->addAddress($to, '');     //Add a recipient
         //   $mail->addAddress('vijaya.jha@codeclouds.in');               //Name is optional
            $mail->addReplyTo($to, '');
          

          

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'COSMO Verification';
            $mail->Body    = $message;
            
            $mail->send();
         //   echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendConfirmMail($to)
    {

        $mail = new PHPMailer(true);
        $otp=mt_rand(100000,999999);
        $_SESSION['otp']=$otp;

        $message="Your 6 Digits OTP for COSMO Verification is: ".$otp;
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = SMTPHOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = SMTPUSERNAME;                     //SMTP username
            $mail->Password   = SMTPPASSWORD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('vijaya.jha@codeclouds.in', 'Mailer');
         //   $mail->addAddress($to, '');     //Add a recipient
            $mail->addAddress('vijaya.jha@codeclouds.com','');               //Name is optional
            $mail->addReplyTo($to, '');
          

          

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Confirmation';
            $mail->Body    = $message;
            
            $mail->send();
         //   echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


    public function sendConfirmationMail($to,$order_number,$plan_type)
    {

        echo $to;
        echo $order_number;
        echo $plan_type;
        //echo "confirmation mail";
        $mail = new PHPMailer(true);
       
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = SMTPHOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = SMTPUSERNAME;                     //SMTP username
            $mail->Password   = SMTPPASSWORD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('vijaya.jha@codeclouds.in', 'Mailer');
           // $mail->addAddress($to, '');     //Add a recipient
            $mail->addAddress('vijaya.jha@codeclouds.com');               //Name is optional
            $mail->addReplyTo($to, '');
          

          

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Confirmation';
          /*  $mail->Body    = '<table border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="max-width: 100%;border-collapse: collapse;">
    <tbody>
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" class="templateRow row_container" width="100%">
                    <tbody>
                        <tr>
                            <td class="rowContainer kmFloatLeft column_container single_column ui-sortable" data-section="0" valign="top">
                                <div class="template_block ui-droppable" data-block="1372439827" data-blocktype="full_image">
                                    <table border="0" cellpadding="0" cellspacing="0" class="kmImageBlock" style="min-width:100%" width="100%">
                                        <tbody class="kmImageBlockOuter">
                                            <tr>
                                                <td class="kmImageBlockInner" style="padding:9px;padding-left:9;padding-right:9;" valign="top">
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmImageContentContainer" style="min-width:100%" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td class="kmImageContent" style="padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;text-align: center;" valign="top">
                                                                    <img align="center" alt="" class="kmImage" src="https://d3k81ch9hvuctc.cloudfront.net/company/XGapYi/images/c6405f2b-5d95-4ef6-a014-f012018c3780.png" style="max-width:1920px;padding:0;border-width:0;" width="546">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- IN-FRAME TEMPLATE BLOCK CONTROLS -->
                                    <div class="template_block_controls">
                                        <div class="template_block_triangle"></div>
                                        <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
                                        <div class="divider"></div>
                                        <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
                                        <div class="divider"></div>
                                        <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
                                    </div>
                                    <div class="template_block_controls_spacer"></div>
                                </div>
                                <div class="template_block ui-droppable" data-block="1372439830" data-blocktype="spacer">
                                    <table border="0" cellpadding="0" cellspacing="0" class="kmDividerBlock" width="100%">
                                        <tbody class="kmDividerBlockOuter">
                                            <tr>
                                                <td class="kmDividerBlockInner" style="padding-top:30px;">
                                                    <table border="0" cellpadding="0" cellspacing="0" class="kmDividerContent" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td><span></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- IN-FRAME TEMPLATE BLOCK CONTROLS -->
                                    <div class="template_block_controls">
                                        <div class="template_block_triangle"></div>
                                        <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
                                        <div class="divider"></div>
                                        <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
                                        <div class="divider"></div>
                                        <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
                                    </div>
                                    <div class="template_block_controls_spacer"></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" class="templateRow row_container" width="100%">
                    <tbody>
                        <tr>
                            <td class="rowContainer kmFloatLeft column_container single_column ui-sortable" data-section="2" valign="top">
                                <div class="template_block ui-droppable" data-block="1372439829" data-blocktype="text">
                                    <table border="0" cellpadding="0" cellspacing="0" class="kmTextBlock" width="100%">
                                        <tbody class="kmTextBlockOuter">
                                            <tr>
                                                <td class="kmTextBlockInner" style="" valign="top">
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmTextContentContainer" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td class="kmTextContent" style="padding-top:9px;padding-bottom:9px;padding-left:100px;padding-right:100px;" valign="top">
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;"><span style="font-family: arial, helvetica, sans-serif;">Your <b><span class="template_variable" title="'.$plan_type.'">'.$plan_type.'</span>&nbsp;</b></span><span style="font-family: arial, helvetica, sans-serif;">subscription with unlimited talk, text, and&nbsp;data has been purchased.</span></div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;">&nbsp;</div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;"><span style="font-family: arial, helvetica, sans-serif;"></span></div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); margin-left: 0px; text-align: center;"><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"><strong>Order:</strong></span><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"> <span class="template_variable" title="'.$order_number.'"> '.$order_number.' </span></span></div>
                                                                    <div style="font-size: 14px; color: rgb(0, 0, 0); text-align: center;">&nbsp;</div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;"><span style="font-size:20px;"><strong>Now its time to pair with your watch!</strong></span></div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;">&nbsp;</div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;">Simply download the free Mission Control&nbsp;Parent App linked below, create an account and follow the steps to pair.&nbsp;</div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;">&nbsp;</div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;"><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;">If you need help with these steps, please visit our <a href="https://cosmotogether.com/pages/support" style="color:#15c; font-weight:normal; text-decoration:underline">support page</a> or email us at support@cosmotogether.com</span></div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;">&nbsp;</div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- IN-FRAME TEMPLATE BLOCK CONTROLS -->
                                    <div class="template_block_controls">
                                        <div class="template_block_triangle"></div>
                                        <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
                                        <div class="divider"></div>
                                        <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
                                        <div class="divider"></div>
                                        <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
                                    </div>
                                    <div class="template_block_controls_spacer"></div>
                                </div>
                                <div class="template_block ui-droppable" data-block="1372439834" data-blocktype="full_image">
                                    <table border="0" cellpadding="0" cellspacing="0" class="kmImageBlock" style="min-width:100%" width="100%">
                                        <tbody class="kmImageBlockOuter">
                                            <tr>
                                                <td class="kmImageBlockInner" style="padding:9px;padding-left:190px;padding-right:190px;" valign="top">
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmImageContentContainer" style="min-width:100%" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td class="kmImageContent" style="padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;" valign="top">
                                                                    <img align="left" alt="" class="kmImage" src="https://d3k81ch9hvuctc.cloudfront.net/company/XGapYi/images/59b212e4-ef58-4010-9264-eb5fbeeb8535.png" style="max-width:1920px;padding:0;border-width:0;" width="184">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- IN-FRAME TEMPLATE BLOCK CONTROLS -->
                                    <div class="template_block_controls">
                                        <div class="template_block_triangle"></div>
                                        <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
                                        <div class="divider"></div>
                                        <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
                                        <div class="divider"></div>
                                        <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
                                    </div>
                                    <div class="template_block_controls_spacer"></div>
                                </div>
                                <div class="template_block ui-droppable" data-block="1372439832" data-blocktype="split">
                                    <table border="0" cellpadding="0" cellspacing="0" class="kmSplitBlock" width="100%">
                                        <tbody class="kmSplitBlockOuter">
                                            <tr>
                                                <td class="kmSplitBlockInner" style="padding-top:9px;padding-bottom:9px;padding-left:100px;padding-right:110px;" valign="top">
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmSplitContentOuter" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td class="kmSplitContentInner" valign="top">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmSplitContentLeftContentContainer" width="193">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="kmImageContent" style="padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;" valign="top">
                                                                                    <a href="https://apps.apple.com/us/app/cosmo-mission-control/id1580600845" target="_self">
                                                                                    <img align="left" alt="" class="kmImage" src="https://d3k81ch9hvuctc.cloudfront.net/company/XGapYi/images/7339b289-1bb4-4e2c-818a-9c00da1be227.png" style="max-width:767px;" width="157">
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table align="right" border="0" cellpadding="0" cellspacing="0" class="kmSplitContentRightContentContainer" width="194">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="kmImageContent" style="padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;text-align: center;" valign="top">
                                                                                    <a href="https://play.google.com/store/apps/details?id=com.cosmo.missioncontrol&amp;hl=en_US&amp;gl=US&amp;showAllReviews=true" target="_self">
                                                                                    <img align="center" alt="" class="kmImage" src="https://d3k81ch9hvuctc.cloudfront.net/company/XGapYi/images/f447ecd1-f665-44cd-9b01-67bc9cee2218.png" style="max-width:1004px;" width="158">
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- IN-FRAME TEMPLATE BLOCK CONTROLS -->
                                    <div class="template_block_controls">
                                        <div class="template_block_triangle"></div>
                                        <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
                                        <div class="divider"></div>
                                        <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
                                        <div class="divider"></div>
                                        <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
                                    </div>
                                    <div class="template_block_controls_spacer"></div>
                                </div>
                                <div class="template_block ui-droppable" data-block="1372439833" data-blocktype="spacer">
                                    <table border="0" cellpadding="0" cellspacing="0" class="kmDividerBlock" width="100%">
                                        <tbody class="kmDividerBlockOuter">
                                            <tr>
                                                <td class="kmDividerBlockInner" style="padding-top:20px;">
                                                    <table border="0" cellpadding="0" cellspacing="0" class="kmDividerContent" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td><span></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- IN-FRAME TEMPLATE BLOCK CONTROLS -->
                                    <div class="template_block_controls">
                                        <div class="template_block_triangle"></div>
                                        <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
                                        <div class="divider"></div>
                                        <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
                                        <div class="divider"></div>
                                        <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
                                    </div>
                                    <div class="template_block_controls_spacer"></div>
                                </div>
                                <div class="template_block ui-droppable" data-block="1372439831" data-blocktype="button_bar">
                                    <table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarBlock" width="100%">
                                        <tbody class="kmButtonBarOuter">
                                            <tr>
                                                <td align="center" class="kmButtonBarInner" style="padding-top:9px;padding-bottom:9px;background-color:#8542EC;padding-left:9px;padding-right:9px;" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarContentContainer" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" style="padding-left:9px;padding-right:9px;">
                                                                    <table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarContent">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" valign="top">
                                                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td valign="top">
                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="padding-right:10px;" valign="top">
                                                                                                                    <a href="https://www.facebook.com/CosmoSW.Tech/" target="_blank"><img alt="Button Text" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/facebook_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <!--[if gte mso 6]>
                                                                                                </td>
                                                                                                <td align="left" valign="top">
                                                                                                    <![endif]-->
                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="padding-right:10px;" valign="top">
                                                                                                                    <a href="https://www.instagram.com/cosmotogether/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/instagram_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <!--[if gte mso 6]>
                                                                                                </td>
                                                                                                <td align="left" valign="top">
                                                                                                    <![endif]-->
                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="padding-right:10px;" valign="top">
                                                                                                                    <a href="https://www.pinterest.com/cosmotogether/_saved/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/pinterest_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <!--[if gte mso 6]>
                                                                                                </td>
                                                                                                <td align="left" valign="top">
                                                                                                    <![endif]-->
                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="" valign="top">
                                                                                                                    <a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/youtube_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <!--[if gte mso 6]>
                                                                                                </td>
                                                                                                <td align="left" valign="top">
                                                                                                    <![endif]-->
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- IN-FRAME TEMPLATE BLOCK CONTROLS -->
                                    <div class="template_block_controls">
                                        <div class="template_block_triangle"></div>
                                        <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
                                        <div class="divider"></div>
                                        <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
                                        <div class="divider"></div>
                                        <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
                                    </div>
                                    <div class="template_block_controls_spacer"></div>
                                </div>
                                <div class="template_block ui-droppable" data-block="1372439828" data-blocktype="text">
                                    <table border="0" cellpadding="0" cellspacing="0" class="kmTextBlock" width="100%">
                                        <tbody class="kmTextBlockOuter">
                                            <tr>
                                                <td class="kmTextBlockInner" style="" valign="top">
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmTextContentContainer" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td class="kmTextContent" style="padding-top:9px;padding-bottom:9px;padding-left:18px;padding-right:18px;color:#727272;font-size:12px;text-align:center;" valign="top">
                                                                    No longer want to receive these emails? {% unsubscribe %}.<br>
                                                                    <span class="template_variable" title=" organization.name "> organization.name </span> <span class="template_variable" title=" organization.full_address "> organization.full_address </span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- IN-FRAME TEMPLATE BLOCK CONTROLS -->
                                    <div class="template_block_controls">
                                        <div class="template_block_triangle"></div>
                                        <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
                                        <div class="divider"></div>
                                        <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
                                        <div class="divider"></div>
                                        <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
                                    </div>
                                    <div class="template_block_controls_spacer"></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>';
            */

           $mail->Body='hello'; 
            $mail->send();
           // print_r($res);
            return $res;
         //   echo 'Message has been sent';
        } catch (Exception $e) {
            echo "{$mail->ErrorInfo}";
        }
    }


    

}
?>