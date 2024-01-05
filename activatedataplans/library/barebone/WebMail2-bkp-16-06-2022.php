<?php


namespace Application;

/**
 * 
 */


require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activate_dataplans/vendor/'.'PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activate_dataplans/vendor/'.'SMTP.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activate_dataplans/vendor/'.'Exception.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/vendor/sendgrid-php'. DIRECTORY_SEPARATOR .'sendgrid-php.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
@session_start();
class WebMailNew
{
	
	function __construct()
	{
		// code...
	}

	public function sendMailConfirmation($to)
    {
        echo "string";
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
            $mail->setFrom('vijaya.jha@codeclouds.in', 'COSMO');
            $mail->addAddress($to, '');     //Add a recipient
         //   $mail->addAddress('vijaya.jha@codeclouds.in');               //Name is optional
            $mail->addReplyTo($to, '');
          

          

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'COSMO Verification';
            $mail->Body    = $message;
            
            $res = $mail->send();
           echo 'Message has been sent';
           return $res;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


    public function sendConfirmationMail($to,$order_number=100000,$plan_type="Monthly Plan")
    {

  
        echo "string";
        $mail = new PHPMailer(true);
        $otp=mt_rand(100000,999999);
        $_SESSION['otp']=$otp;

        $message="Your 6 Digits OTP for COSMO Verification is: ".$otp;
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = SMTPHOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = SMTPUSERNAME;                     //SMTP username
            $mail->Password   = SMTPPASSWORD;                               //SMTP password
            $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(SMTPUSERNAME, 'COSMO');
            $mail->addAddress($to, '');     //Add a recipient
         //   $mail->addAddress('vijaya.jha@codeclouds.in');               //Name is optional
            $mail->addReplyTo($to, '');
          

          

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'COSMO Verification';
          //  $mail->Body    = $message;
              //$mail->Body    = '<p style="color:blue;">'.$plan_type.'-'.$order_number.'</p>';
            $mail->Body    = '<table border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="max-width: 100%;border-collapse: collapse;"><tbody><tr>
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
                                                                                                 

                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="padding-right:10px;" valign="top">
                                                                                                                    <a href="https://www.instagram.com/cosmotogether/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/instagram_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                   

                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="padding-right:10px;" valign="top">
                                                                                                                    <a href="https://www.pinterest.com/cosmotogether/_saved/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/pinterest_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                  

                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="" valign="top">
                                                                                                                    <a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/youtube_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                   
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
          
            $res = $mail->send();
           echo 'Message has been sent';
           return $res;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }



     public function sendOTP($to)
    {

       $otp=mt_rand(00000,999999);
       $_SESSION['otp']=$otp;

         $message    = '<!DOCTYPE html>
<html>
<head>
    <title>Mail Template</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Poppins:wght@300;400;500;600;700&family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 600px;width: 100%;margin: 0 auto;">
        <thead>
            <tr>
                <th align="center">
                    <img height="auto" src="https://s3.us-west-1.amazonaws.com/wthmedia/plugin-assets/8315/94963/Logo%20%281%29.png" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;max-width: 138px;" width="138">
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center" style="font-family: Lato, Tahoma, sans-serif; font-size: 13px; text-align: center;padding:18px 15px 15px 15px;word-break:break-word;">Your 6-digit COSMO verification code is:</td>
            </tr>
            <tr>
                <td align="center" style="font-size: 30px;font-family: Poppins, sans-serif;padding: 3px 15px 23px 15px;word-break:break-word;"><strong>'.$otp.'</strong></td>
            </tr>
            <tr>
                <td align="center" style="font-size: 13px;font-family: Lato, Tahoma, sans-serif;padding-bottom: 13px;"><strong>COSMO Technologies, Inc.</strong></td>
            </tr>
            <tr>
                <td align="center" style="font-size:0px;padding:5px 10px 0px 10px;word-break:break-word;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="float:none;display:inline-table;">
                        <tr>
                            <td style="padding:4px;">
                                <a href="https://www.facebook.com/CosmoSW.Tech" target="_blank" style="color: #0000EE; font-family: Ubuntu, Helvetica, Arial;">
                                    <img alt="facebook" height="35" src="https://s3-eu-west-1.amazonaws.com/ecomail-assets/editor/social-icos/ikony-black/outlinedblack/facebook.png" style="border-radius:3px;display:block;" width="35">
                                 </a>
                            </td>
                        </tr>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="float:none;display:inline-table;">
                        <tr>
                            <td style="padding:4px;">
                                <a href="https://www.instagram.com/cosmotogether" target="_blank" style="color: #0000EE; font-family: Ubuntu, Helvetica, Arial;">
                                    <img alt="instagram" height="35" src="https://s3-eu-west-1.amazonaws.com/ecomail-assets/editor/social-icos/ikony-black/outlinedblack/instagram.png" style="border-radius:3px;display:block;" width="35">
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" style="padding:10px 10px;padding-top:10px;word-break:break-word;">
                    <p style="font-family: Ubuntu, Helvetica, Arial; border-top: solid 1px #000000; font-size: 1; margin: 0px auto; width: 100%;"></p>
                </td>
            </tr>
            
            <tfoot align="center">
                <tr>
                    <td align="center"><p style="font-size: 13px;font-family: Lato, Tahoma, sans-serif;margin: 0;margin-top: 16px;color: #000000;">700 Colorado Boulevard #238</p></td>
                </tr>
                <tr>
                    <td align="center"><p style="font-size: 13px; font-family: Lato, Tahoma, sans-serif;margin: 4px 0 0 0;color: #000000;">Denver, CO 80206</p></td>
                </tr>
                <tr>
                    <td align="center"><p style="font-size: 13px;font-family: Lato, Tahoma, sans-serif;margin: 21px 0 0 0;color: #000000;"><em>Need help? </em></p></td>
                </tr>
                <tr>
                    <td align="center"><p style="font-size: 13px;font-family: Lato, Tahoma, sans-serif;margin: 5px 0 0 0;    color: #000000;">support@cosmotogether.com</p></td>
                </tr>
                <tr>
                    <td align="center"><p style="font-size: 13px;font-family: Lato, Tahoma, sans-serif;margin: 4px 0 0 0;    color: #000000;">(877)-215-4741</p></td>
                </tr>
                <tr>
                    <td align="center"><p style="font-size: 13px;font-family: Lato, Tahoma, sans-serif;margin: 4px 0 0 0;    color: #000000;">www.cosmotogether.com</p></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
</body>
</html>
        ';

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject("COSMO Verification");
        $email->addTo($to);
        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            return $response->statusCode();
            //print $response->statusCode() . "\n";
           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }


     public function sendPhoneNumber($to,$plan_type,$watch_phone_number)
    {


     $phn1=substr($watch_phone_number,0,3);
     $phn2=substr($watch_phone_number,3,3);
     $phn3=substr($watch_phone_number,6,4);
     $phone_format= "+1 (".$phn1.") ".$phn2."-".$phn3;



         $message    = '<!DOCTYPE html>
<html>
<head>
    <title>Cosmo</title>
</head>
<body>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 600px;width: 100%;margin: 0 auto;    padding: 20px 0;">
        <thead>
            <tr>
                <th align="left" style="padding: 0px 0px 21px;">
                    <img height="auto" src="'.EMAILIMAGE_PATH."cosmoblue-big.png".'" alt="logo" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;max-width: 200px;" width="200">
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: bold; font-size: 26px; color: rgb(45, 50, 65);">Success!</td>
            </tr>
            <tr>
                <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 16px 0;">We successfully activated your <span style="font-weight: bold;">'.$plan_type.'</span> with unlimited talk, text, and data.</td>
            </tr>
            <tr>
                <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 20px;">Your JrTrack 2 phone number is below - go ahead and add it to your contacts and copy it for pairing with the app!</td>
            </tr>
            <tr>
                <td align="center" style="background-color: rgb(245, 244, 245);padding: 23px 52px; word-break: break-word;font-size: 26px; font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: bold; color: rgb(75, 75, 75);">'.$phone_format.'</td>
            </tr>
            <tr>
                <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 35px 0 16px 0;">Now it\'s time to pair the watch with the parent app! Download the free Mission Control parent app linked below, create an account, and follow the steps in the app to pair.&nbsp;</td>
            </tr>
            <tr>
                <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 30px;">If you need help pairing, email us at <span style="color: rgb(0, 79, 235);">support@cosmotogether.com</span></td>
            </tr>
            <tr>
                <td style="box-sizing: border-box;padding: 9px 25px;">
                  <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;">
                    <tbody><tr>
                      <td style="padding-right:15px;box-sizing: border-box;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;">
                          <tbody><tr>
                            <td style="box-sizing: border-box;">
                              <img src="'.EMAILIMAGE_PATH."appstoreqr.png".'" alt="app-store" style="box-sizing: border-box;max-width:100%;">
                            </td>
                          </tr> 
                        </tbody></table>
                      </td>

                      <td style="padding-left:15px;box-sizing: border-box;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;">
                          <tbody><tr>
                            <td style="box-sizing: border-box;">
                              <img src="'.EMAILIMAGE_PATH."googleplayqr.png".'" alt="google-play" style="box-sizing: border-box;max-width:100%;">
                            </td>
                          </tr> 
                        </tbody></table>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
             </tr>

             <tr>
               <td style="background-color:#fff;padding: 20px 0 0;box-sizing: border-box;">
                  <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;">
                     <tbody>
                        <tr>
                           <td style="width: 48%; border: 0px; padding: 0px;">
                              <img src="'.EMAILIMAGE_PATH."cosmo-logo-email.png".'" width="150" alt="logo" style="max-width: 100%;">
                           </td>
                           <td align="right" style="box-sizing: border-box;width: 50%;" align="right">
                              <span style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 300;">
                                <a href="https://cosmotogether.com/" style="color: rgb(11, 11, 38);font-size: 14px;">Website</a>&nbsp; &nbsp; &nbsp; &nbsp;
                                <a href="https://cosmotogether.com/blogs/news" style="color: rgb(11, 11, 38);font-size: 14px;">Blog</a>&nbsp; &nbsp; &nbsp; &nbsp; 
                                <a href="https://cosmotogether.com/pages/support" style="color: rgb(11, 11, 38);font-size: 14px;">Support</a>&nbsp; &nbsp; &nbsp; &nbsp; 
                                <a href="https://cosmotogether.com/pages/our-mission" style="color: rgb(11, 11, 38);font-size: 14px;">About</a>&nbsp; </span>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>

            <tr>
                <td style="padding-top: 10px;">
                    <table>
                        <tr>
                            <td style="padding-right: 10px;"><a href="https://www.facebook.com/CosmoSW.Tech"><img src="'.EMAILIMAGE_PATH."facebook_96_new.png".'" alt="facebook" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
                            <td style="padding-right: 10px;"><a href="https://www.instagram.com/cosmotogether/"><img src="'.EMAILIMAGE_PATH."instagram_96_new.png".'" alt="instagram" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
                            <td style="padding-right: 10px;"><a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg"></a><img src="'.EMAILIMAGE_PATH."youtube_96_new.png".'" alt="/youtube" width="32" style="box-sizing: border-box;max-width:100%;"></td>
                            <td style="padding-right: 10px;"><a href="https://www.pinterest.com/cosmotogether/_saved/"><img src="'.EMAILIMAGE_PATH."pinterest_96_new.png".'" alt="pinterest" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
                            <td style="padding-right: 10px;"><a href="https://www.linkedin.com/company/cosmo-technologies"><img src="'.EMAILIMAGE_PATH."linkedin_96_new.png".'" alt="linkedin" width="32" style="box-sizing: border-box;max-width:32px;"></a></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tfoot align="center">
                <tr>
                    <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 0;margin-top: 16px;">©2022 COSMO Technologies, Inc.</p></td>
                </tr>
                <tr>
                    <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">700 Colorado Blvd #238</p></td>
                </tr>
                <tr>
                    <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">Denver, CO 80206</p></td>
                </tr>
                <tr>
                    <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 21px 0 0 0;">All rights reserved.</p></td>
                </tr>
            </tfoot>
            
            
        </tbody>
    </table>
</body>
</html>
        ';

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject("COSMO Verification");
        $email->addTo($to);
        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            return $response->statusCode();
            //print $response->statusCode() . "\n";
           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }





     public function sendPlanPurchase($to,$plan_type,$order_number)
    {

         $message    = '<!DOCTYPE html>
<html>
<head>
    <title>Cosmo purchase confirmation</title>
</head>
<body>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 600px;width: 100%;margin: 0 auto;    padding: 20px 0;">
        <thead>
            <tr>
                <th align="left" style="padding: 0px 0px 28px;">
                    <img height="auto" src="'.EMAILIMAGE_PATH."cosmoblue-big.png".'" alt="logo" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;max-width: 200px;" width="200">
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: bold; font-size: 26px; color: rgb(45, 50, 65);">Welcome!</td>
            </tr>
            <tr>
                <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 17px; color: rgb(45, 50, 65);padding: 16px 0;">You\'ve purchased a <span style="font-weight: bold;">'.$plan_type.'</span> subscription with unlimited talk, text, and data.</td>
            </tr>
            <tr>
                <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 20px;">Order number:&nbsp;<span style="font-weight: bold;">'.$order_number.'</span></td>
            </tr>
            <tr>
                <td align="center" style="padding:10px 0;padding-top:10px;word-break:break-word;">
                    <p style="border-top: solid 1px #000000; font-size: 1; margin: 0px auto; width: 100%;"></p>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 10px;">
                    <table>
                        <tr>
                            <td style="padding-right: 10px;"><a href="https://www.facebook.com/CosmoSW.Tech"><img src="'.EMAILIMAGE_PATH."facebook_96_new.png".'" alt="facebook" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
                            <td style="padding-right: 10px;"><a href="https://www.instagram.com/cosmotogether/"><img src="'.EMAILIMAGE_PATH."instagram_96_new.png".'" alt="instagram" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
                            <td style="padding-right: 10px;"><a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg"></a><img src="'.EMAILIMAGE_PATH."youtube_96_new.png".'" alt="/youtube" width="32" style="box-sizing: border-box;max-width:100%;"></td>
                            <td style="padding-right: 10px;"><a href="https://www.pinterest.com/cosmotogether/_saved/"><img src="'.EMAILIMAGE_PATH."pinterest_96_new.png".'" alt="pinterest" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
                            <td style="padding-right: 10px;"><a href="https://www.linkedin.com/company/cosmo-technologies"><img src="'.EMAILIMAGE_PATH."linkedin_96_new.png".'" alt="linkedin" width="32" style="box-sizing: border-box;max-width:32px;"></a></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tfoot align="center">
                <tr>
                    <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 0;margin-top: 16px;">©2022 COSMO Technologies, Inc.</p></td>
                </tr>
                <tr>
                    <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">700 Colorado Blvd #238</p></td>
                </tr>
                <tr>
                    <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">Denver, CO 80206</p></td>
                </tr>
                <tr>
                    <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 21px 0 0 0;">All rights reserved.</p></td>
                </tr>
            </tfoot>
            
            
        </tbody>
    </table>
</body>
</html>
        ';

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject("COSMO Verification");
        $email->addTo($to);
        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            return $response->statusCode();
            //print $response->statusCode() . "\n";
           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }




































    //////////////////////////////////////////////////////////////////////



     public function sendConfirmationMailNew($to,$order_number,$plan_type,$phone_number)
    {

       
         $message    = '
<table border="0" cellpadding="0" cellspacing="0" class="templateRow row_container" width="600" align="center">
    <tbody>
        <tr>
            <td class="rowContainer kmFloatLeft column_container single_column ui-sortable" data-section="2" valign="top">
                <div class="template_block ui-droppable" data-block="1425686045" data-blocktype="full_image">
                    <table border="0" cellpadding="0" cellspacing="0" class="kmImageBlock kmDesktopOnly" style="min-width:100%" width="100%">
                        <tbody class="kmImageBlockOuter">
                            <tr>
                                <td class="kmImageBlockInner" style="padding:9px;padding-left:160px;padding-right:160px;" valign="top">
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmImageContentContainer" style="min-width:100%" width="100%">
                                        <tbody>
                                            <tr>
                                                <td class="kmImageContent" style="padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;text-align: center;" valign="top">
                                                    <img align="center" alt="" class="kmImage" src="'.EMAILIMAGE_PATH."cosmo-logo-email.png".'" style="max-width:2640px;padding:0;border-width:0;" width="244">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                <div class="template_block ui-droppable" data-block="1374149363" data-blocktype="text">
                    <table border="0" cellpadding="0" cellspacing="0" class="kmTextBlock" width="100%">
                        <tbody class="kmTextBlockOuter">
                            <tr>
                                <td class="kmTextBlockInner" style="" valign="top">
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmTextContentContainer" width="100%">
                                        <tbody>
                                            <tr>
                                                <td class="kmTextContent" style="padding-top:9px;padding-bottom:9px;padding-left:100px;padding-right:100px;" valign="top">
                                                    <p>&nbsp;</p>
                                                    <p><span style="font-family:trebuchet ms,helvetica,sans-serif;"><span style="color: rgb(0, 0, 0); font-size: 14px;">We successfully activated your&nbsp;</span><span style="color: rgb(0, 0, 0); font-size: 14px;"><b style="color: rgb(0, 0, 0); font-family: arial, helvetica, sans-serif; font-size: 14px; text-align: center;"><span class="template_variable" title=" '.$plan_type.' "> '.$plan_type.' </span>&nbsp;</b>plan with unlimited data.&nbsp;</span></span></p>
                                                    <div style="font-size: 14px; color: rgb(0, 0, 0);"><font face="arial, helvetica, sans-serif">Your JrTrack 2 phone number is:&nbsp;&nbsp;</font></div>
                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);"><strong><span style="font-family: inherit;"><span class="template_variable" title="'.$phone_number.'"> '.$phone_number.' </span></span></strong></div>
                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);">&nbsp;</div>
                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);"><strong style="font-size: 20px; font-family: inherit;">Now its time to pair with your watch!</strong></div>
                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);">&nbsp;</div>
                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);">Simply download the free Mission Control&nbsp;Parent App linked below, create an account and follow the steps to pair.&nbsp;</div>
                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);">&nbsp;</div>
                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);"><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;">If you need help with these steps, please visit our <a href="https://cosmotogether.com/pages/support" style="color:#15c; font-weight:normal; text-decoration:underline">support page</a> or email us at support@cosmotogether.com</span></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                <div class="template_block ui-droppable small_block" data-block="1425689560" data-blocktype="spacer">
                    <table border="0" cellpadding="0" cellspacing="0" class="kmDividerBlock kmMobileOnly" width="100%">
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
              
                <div class="template_block ui-droppable" data-block="1374149368" data-blocktype="full_image">
                    <table border="0" cellpadding="0" cellspacing="0" class="kmImageBlock" style="min-width:100%" width="100%">
                        <tbody class="kmImageBlockOuter">
                            <tr>
                                <td class="kmImageBlockInner" style="padding:9px;padding-left:190px;padding-right:190px;" valign="top">
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmImageContentContainer" style="min-width:100%" width="100%">
                                        <tbody>
                                            <tr>
                                                <td class="kmImageContent" style="padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;" valign="top">
                                                    <img align="left" alt="" class="kmImage" src="'.EMAILIMAGE_PATH."Mission-Control.png".'" style="max-width:1920px;padding:0;border-width:0;" width="184">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                <div class="template_block ui-droppable" data-block="1374149366" data-blocktype="split">
                    <table border="0" cellpadding="0" cellspacing="0" class="kmSplitBlock kmDesktopOnly" width="100%">
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
                                                                    <img align="left" alt="" class="kmImage" src="'.EMAILIMAGE_PATH."appstoreqr.png".'" style="max-width:611px;" width="157">
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
                                                                    <img align="center" alt="" class="kmImage" src="'.EMAILIMAGE_PATH."googleplayqr.png".'" style="max-width:611px;" width="158">
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
                <div class="template_block ui-droppable" data-block="1374149367" data-blocktype="spacer">
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
                <div class="template_block ui-droppable" data-block="1374149365" data-blocktype="button_bar">
                    <table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarBlock" width="100%">
                        <tbody class="kmButtonBarOuter">
                            <tr>
                                <td align="center" class="kmButtonBarInner" style="padding-top:9px;padding-bottom:9px;background-color:#7C46F7;padding-left:9px;padding-right:9px;" valign="top">
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
                                                                                   
                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td align="center" style="padding-right:10px;" valign="top">
                                                                                                    <a href="https://www.instagram.com/cosmotogether/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/instagram_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                
                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td align="center" style="padding-right:10px;" valign="top">
                                                                                                    <a href="https://www.pinterest.com/cosmotogether/_saved/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/pinterest_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                              
                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td align="center" style="" valign="top">
                                                                                                    <a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/youtube_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
        ';

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject("Congratulations, Your Cosmo Plan is Activated!");
        $email->addTo($to);
        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            return $response->statusCode();
            //print $response->statusCode() . "\n";
           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }




  public function sendPlanPurchaseConfirmationMail($to,$order_number,$plan_type)
    {

       
         $message    = '<table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
    <tbody>
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" class="templateRow row_container" width="100%">
                    <tbody>
                        <tr>
                            <td class="rowContainer kmFloatLeft column_container single_column ui-sortable" data-section="0" valign="top">
                                <div class="template_block ui-droppable" data-block="1375886676" data-blocktype="full_image">
                                    <table border="0" cellpadding="0" cellspacing="0" class="kmImageBlock" style="min-width:100%" width="100%">
                                        <tbody class="kmImageBlockOuter">
                                            <tr>
                                                <td class="kmImageBlockInner" style="padding:9px;padding-left:160px;padding-right:160px;padding-top:30px;padding-bottom:3px;" valign="top">
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmImageContentContainer" style="min-width:100%" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td class="kmImageContent" style="padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;text-align: center;" valign="top">
                                                                    <img align="center" alt="" class="kmImage" src="https://d3k81ch9hvuctc.cloudfront.net/company/XGapYi/images/5e5bfd11-fa96-4a63-bddc-8f0735bce574.png" style="max-width:2640px;padding:0;border-width:0;" width="244">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                <div class="template_block ui-droppable" data-block="1375799106" data-blocktype="spacer">
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
                                <div class="template_block ui-droppable" data-block="1375799105" data-blocktype="text">
                                    <table border="0" cellpadding="0" cellspacing="0" class="kmTextBlock" width="100%">
                                        <tbody class="kmTextBlockOuter">
                                            <tr>
                                                <td class="kmTextBlockInner" style="" valign="top">
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmTextContentContainer" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td class="kmTextContent" style="padding-top:9px;padding-bottom:9px;padding-left:100px;padding-right:100px;" valign="top">
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);"><span style="font-family: arial, helvetica, sans-serif;">Your <b><span class="template_variable" title=" '.$plan_type.'"> '.$plan_type.'</span>&nbsp;</b></span><span style="font-family: arial, helvetica, sans-serif;">subscription with unlimited talk, text, and&nbsp;data has been purchased.</span></div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);">&nbsp;</div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);"><span style="font-family: arial, helvetica, sans-serif;"></span></div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); margin-left: 0px;"><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"><strong>Order:</strong></span><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"> <span class="template_variable" title=" '.$order_number.' ">'.$order_number.' </span></span></div>
                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); margin-left: 0px;">&nbsp;</div>
                                                                    <div style="font-size: 14px; color: rgb(0, 0, 0);">&nbsp;</div>
                                                                    <div style="font-size: 14px; color: rgb(0, 0, 0);">
                                                                        You should\'ve also received an email with the phone number for your device.&nbsp;<span style="font-family: arial, helvetica, sans-serif; font-style: inherit; font-variant-ligatures: inherit; font-variant-caps: inherit; font-weight: inherit; white-space: pre-wrap;">If you need help with these steps, please visit our </span><a href="https://cosmotogether.com/pages/support" style="color:#15c; font-weight:inherit; text-decoration:underline; font-family:arial, helvetica, sans-serif; font-style:inherit; font-variant-ligatures:inherit; font-variant-caps:inherit; white-space:pre-wrap">support page</a><span style="font-family: arial, helvetica, sans-serif; font-style: inherit; font-variant-ligatures: inherit; font-variant-caps: inherit; font-weight: inherit; white-space: pre-wrap;"> or email us at support@cosmotogether.com</span>
                                                                        <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;">&nbsp;</div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                <div class="template_block ui-droppable" data-block="1375799109" data-blocktype="spacer">
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
                                <div class="template_block ui-droppable" data-block="1375799107" data-blocktype="button_bar">
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
                                                                                                 
                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="padding-right:10px;" valign="top">
                                                                                                                    <a href="https://www.instagram.com/cosmotogether/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/instagram_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                 
                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="padding-right:10px;" valign="top">
                                                                                                                    <a href="https://www.pinterest.com/cosmotogether/_saved/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/pinterest_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                
                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="" valign="top">
                                                                                                                    <a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/youtube_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
</table>
        ';

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject("Plan Purchase Confirmation!");
        $email->addTo($to);
        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            return $response->statusCode();
            //print $response->statusCode() . "\n";
           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }











    public function sendConfirmationMail1($to,$order_number,$plan_type)
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
          echo  "/".$mail->Host       = SMTPHOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
          echo  "/".$mail->Username   = SMTPUSERNAME;                     //SMTP username
          echo "/".  $mail->Password   = SMTPPASSWORD;                               //SMTP password
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
           $mail->Body    = '<table border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="max-width: 100%;border-collapse: collapse;"><tbody><tr>
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
                                                                                                 

                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="padding-right:10px;" valign="top">
                                                                                                                    <a href="https://www.instagram.com/cosmotogether/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/instagram_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                   

                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="padding-right:10px;" valign="top">
                                                                                                                    <a href="https://www.pinterest.com/cosmotogether/_saved/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/pinterest_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                  

                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" style="" valign="top">
                                                                                                                    <a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/youtube_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                   
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
          

           //$mail->Body='hello'; 
            $res=$mail->send();
           // print_r($res);
               echo 'Message has been sent';
            return $res;
         //   echo 'Message has been sent';
        } catch (Exception $e) {
            echo "{$mail->ErrorInfo}";
        }
    }


}
?>