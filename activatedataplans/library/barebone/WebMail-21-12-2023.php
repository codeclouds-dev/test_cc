<?php


namespace Application;

/**
 * 
 */


require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/vendor/'.'PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/vendor/'.'SMTP.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/vendor/'.'Exception.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/vendor/sendgrid-php'. DIRECTORY_SEPARATOR .'sendgrid-php.php';

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

    public function sendrefurbedPlanPurchaseConfirmationMail($to,$first_name,$order_number,$product_arr)
    {
        $var='';
        $price=0;
        $save='';
        if(!empty($product_arr))
        {
             $variant_img=array("43891885899997"=>'black.png',"44018048172253"=>'black.png',"43891885932765"=>'blue.png',"44018048205021"=>'blue.png',"43891885965533"=>'pink.png',"44018048237789"=>'pink.png',"43795278954717"=>'activation_fee.png',"43869694591197"=>'monthly_contract.png',"44032465305821"=>'monthly_contract.png',"43197496787165"=>'warranty.png');
            foreach ($product_arr as $val) {
                $price=$price+$val['original_price'];


                if($val['shopify_product_id']==8078383022301)
                {

                    $save='<span style="color: #777777;font-weight: 500;font-size: 20px">You saved <span style="color: #555555">$49.99</span></span>';
                     $var.='    <tr>
                    <td rowspan="2" align="left" style="padding: 10px 0;"><img src="'.EMAILIMAGE_PATH.$variant_img[$val['shopify_variant_id']].'" alt="cosmo-icon" style="width: 70px;height:auto;    margin-right: 10px;"></td>
                    <td align="left" style="padding: 10px 0 0;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 600;font-size: 20px">'.$val['product_title'].' × '.$val['quantity'].'</td>
                    <td align="right" style="padding: 10px 0 0;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 500;font-size: 18px"><del>$49.99</del></td>
                  </tr>    <tr style="border-bottom: 1px solid #dfdfdf;">
                    <td align="left" style="padding: 0px 0 10px;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 500;font-size: 18px"><img src="'.EMAILIMAGE_PATH."discount-icon.jpg".'" alt="discount" style="margin-right: 3px;    width: auto;    height: 18px;">  DISCOUNT (-100%)</td>
                    <td align="right" style="padding: 0px 0 10px;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 20px">$0.00</td>
                  </tr>';
                   
                }
                else if($val['shopify_product_id']==8162587869405)
                {
                    $save='';
                     $var.='    <tr>
                    <td rowspan="2" align="left" style="padding: 10px 0;"><img src="'.EMAILIMAGE_PATH.$variant_img[$val['shopify_variant_id']].'" alt="cosmo-icon" style="width: 70px;height:auto;    margin-right: 10px;"></td>
                    <td align="left" style="padding: 10px 0 0;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 600;font-size: 20px">'.$val['product_title'].' × '.$val['quantity'].'</td>
                    <td align="right" style="padding: 10px 0 0;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 500;font-size: 18px"><del>$99.99</del></td>
                  </tr>    <tr style="border-bottom: 1px solid #dfdfdf;">
                   
                    <td align="right" style="padding: 0px 0 10px;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 20px"></td>
                    <td style="color:#555555;font-family:neuzeit-grotesk,&quot;Trebuchet MS&quot;,&quot;Lucida Grande&quot;,&quot;Lucida Sans Unicode&quot;,&quot;Lucida Sans&quot;,Tahoma,sans-serif;text-align:right;font-weight:600;font-size:20px">$7.49</td>
                  </tr>';
                }
                else
                {
                    $var.='  <tr style="border-bottom: 1px solid #dfdfdf;">
                    <td align="left" style="padding: 10px 0;"><img src="'.EMAILIMAGE_PATH.$variant_img[$val['shopify_variant_id']].'" alt="cosmo-icon" style="width: 70px;height:auto;    margin-right: 10px;"></td>
                    <td align="left" style="padding: 10px 0;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 600;font-size: 20px">'.$val['product_title'].' × '.$val['quantity'].'</td>
                    <td align="right" style="padding: 10px 0;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 20px">$'.$val['original_price'].'</td>
                  </tr>' ;
                }
                
            }
           

        }
        
         $message    = '  <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 660px;width: 100%;margin: 0 auto;    padding: 20px 0;     letter-spacing: -0.4px;">
        <thead>
            <tr>
                <th align="left" style="padding: 0px 0px 21px;">
                    <img height="auto" src="'.EMAILIMAGE_PATH."logo-dark.png".'" alt="logo" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;max-width: 200px;" width="200">
                </th>
                 <th align="right" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;  font-size: 20px; color: #777777;font-weight: 500">ORDER #'.$order_number.'</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="left" colspan="2"  style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 600; font-size: 26px; color: #000000; line-height: 28px;padding-top: 20px">Thank you for your purchase!</td>
            </tr>
            <tr>
                <td align="left" colspan="2" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: #777777;padding: 16px 0;    line-height: 26px;">Hi '.$first_name.', your order has been received and processed. We will notify when it is available for shipping. Thank you for shopping with COSMO!
                </td>
            </tr>
        
            <tr>
                <td align="left" colspan="2"  style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 500; font-size: 23px; color: #000000; line-height: 28px;padding-top: 50px;padding-bottom: 20px">Order summary</td>
            </tr>
            <tr>
              <td colspan="2">
                <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;border-collapse: collapse;">
                  
              '.$var.'

                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <table border="0" cellpadding="0" cellspacing="0" style="width:60%;box-sizing: border-box;border-collapse: collapse;float: right;">
                  <tr>
                    <td style="padding: 25px 0 8px;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 500;font-size: 18px">Subtotal</td>
                    <td style="padding: 25px 0 8px;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 20px">$'.$price.'</td>
                  </tr>
                  <tr>
                    <td style="padding: 0px;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 500;font-size: 18px">Shipping</td>
                    <td style="padding: 0px;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 20px">$0.00</td>
                  </tr>
                  <tr>
                    <td style="padding: 8px 0 25px;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 500;font-size: 18px">Taxes</td>
                    <td style="padding: 8px 0 25px;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 20px">$0.00</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="height: 2px;width: 100%;background: #e5e5e5;"></td>
                  </tr>
                  <tr>
                    <td style="padding: 25px 0 25px;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 500;font-size: 18px">Total</td>
                    <td style="padding: 25px 0 25px;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 30px;line-height: 28px;">$'.$price.' USD <br>'.$save.'</td>
                  </tr>
                </table>
              </td>
            </tr>



             <tr style="background: #2D2F2F;color: #fff;">
              <td colspan="2" style="padding:25px 10px;text-align: center;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;">
                <table style="width: 100%">
                <tr>
                   <td><h4 style="font-size: 16px;line-height: 20px;margin: 0;    margin-bottom: 8px;">COSMO Technologies, Inc.</h4></td>
                </tr>
                <tr>
                  <td><a href="www.cosmotogether.com" style="color: #fff;text-decoration: underline;font-size: 11px;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;">www.cosmotogether.com</a></td>
                </tr>
              
                <tr>
                  <td><p style="font-size: 11px;margin-bottom: 0">700 Colorado Blvd. #238, Denver, CO, 80206</p></td>
                </tr>
              </table>
              </td>
             </tr>

        
            
            
        </tbody>
    </table>        ';

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

    public function sendAlertSetActivation($dev_arr,$network_res)
    {

       
        $message="<p>User: ".$dev_arr['email']."</p><p>IMEI: ".$dev_arr['imei']."</p><p>ICCID: ".$dev_arr['iccid']."</p>";
        $message.="Error Details(".$network_res['api'].")";
        $message.="<p>Set Activation</p>";
        
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject("Set Activation Error");
        $email->addTo("shil@cosmotogether.com");
       $email->addTo("dev@codeclouds.biz");
        // $email->addCc("hayley@cosmotogether.com");
        // $email->addCc("russell@saganglobal.com");
           $email->addCc("ex@cosmotogether.com");
                $email->addCc("waleed@cosmotogether.com");
        $email->addCc("jure.lampe@senlab.io");
        $email->addCc("denis.feratovic@senlab.io");
                $email->addCc("brigid@cosmotogether.com");
        $email->addCc("kaitlyn@cosmotogether.com");
                $email->addCc("laeeq@cosmotogether.com");


    //   $email->addCc("dev@codeclouds.biz");
                $email->addCc("matevz.jecl@senlab.io");

        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }

  /*  public function sendAlertTelnyx($dev_arr,$telnyx_res)
    {

       
        $message="<p>User: ".$dev_arr['email']."</p><p>IMEI: ".$dev_arr['imei']."</p><p>ICCID: ".$dev_arr['iccid']."</p>";
        $message.="Error Details(".$telnyx_res['api'].")";
        //$message.="<p>".$telnyx_res['errors'][0]['detail']."</p>";
         if(isset($telnyx_res['errors']))
        {
                   $message.="<p>".$telnyx_res['errors'][0]['detail']."</p>"; 
        }
        else if(isset($telnyx_res['data']))
        {
                    $message.="<p>".$telnyx_res['data'][0]['invalid_detail']."</p>";

        }
        else if(isset($telnyx_res['statuscode']))
        {
           $message.="<p>".$telnyx_res['statuscode']."</p>";
 
        }
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject($dev_arr['subject']);
       $email->addTo("shil@cosmotogether.com");
       $email->addTo("dev@codeclouds.biz");
        // $email->addCc("hayley@cosmotogether.com");
        // $email->addCc("russell@saganglobal.com");
          $email->addCc("ex@cosmotogether.com");
                $email->addCc("waleed@cosmotogether.com");
        $email->addCc("jure.lampe@senlab.io");
        $email->addCc("denis.feratovic@senlab.io");
        $email->addCc("matevz.jecl@senlab.io");
     $email->addCc("brigid@cosmotogether.com");
        $email->addCc("kaitlyn@cosmotogether.com");
                        $email->addCc("laeeq@cosmotogether.com");

        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }

    */
     public function sendAlertTelnyx($dev_arr,$telnyx_res)
    {

       
        $message="<p>User: ".$dev_arr['email']."</p><p>IMEI: ".$dev_arr['imei']."</p><p>ICCID: ".$dev_arr['iccid']."</p>";
        $message.="Error Details(".$telnyx_res['api'].")";
        //$message.="<p>".$telnyx_res['errors'][0]['detail']."</p>";
         if(isset($telnyx_res['errors']))
        {
                   $message.="<p>".$telnyx_res['errors'][0]['detail']."</p>"; 
        }
        else if(isset($telnyx_res['data']))
        {
                    $message.="<p>".$telnyx_res['data'][0]['invalid_detail']."</p>";

        }
        else if(isset($telnyx_res['statuscode']))
        {
           //$message.="<p>".$telnyx_res['statuscode']."</p>";
           $error=$telnyx_res['error_message'];
            //print_r($error);
           if(is_array($error))
           {
                if(array_key_exists('error', $error))
                {
                   
                    $error_message=$error['error']['detail'];
                }
           }
            
            else
            {
              
                $error_message=$telnyx_res['error_message'];
            }
                       $message.="<p>".$telnyx_res['statuscode']."</p><p>".$error_message."</p>";

        }
         else
        {
          //  print_r($telnyx_res['error_message']);
           $error=$telnyx_res['error_message'];
            //print_r($error);
           if(is_array($error))
           {
                if(array_key_exists('error', $error))
                {
                   
                    $error_message=$error['error']['detail'];
                }
           }
            
            else
            {
              
                $error_message=$telnyx_res['error_message'];
            }
                       $message.="<p>".$telnyx_res['statuscode']."</p><p>".$error_message."</p>";

        }
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject($dev_arr['subject']);
       $email->addTo("shil@cosmotogether.com");
       $email->addTo("dev@codeclouds.biz");
        // $email->addCc("hayley@cosmotogether.com");
        // $email->addCc("russell@saganglobal.com");
          $email->addCc("ex@cosmotogether.com");
                $email->addCc("waleed@cosmotogether.com");
        $email->addCc("jure.lampe@senlab.io");
        $email->addCc("denis.feratovic@senlab.io");
        $email->addCc("matevz.jecl@senlab.io");
     $email->addCc("brigid@cosmotogether.com");
        $email->addCc("kaitlyn@cosmotogether.com");
                        $email->addCc("laeeq@cosmotogether.com");

        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }
    public function sendAlertDataplan($to,$dataplan_arr)
    {  
        $middle_para = "";

        if(($dataplan_arr['product_id']=='8054644113629') || ($dataplan_arr['product_id']=='8075971166429')){
          $middle_para = '<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 20px;">Your prepaid plan is set to renew for another term of the same length as your original term, paid upfront for the same amount as your first plan. This means you\'ll continue to receive uninterrupted COSMO service with unlimited talk, text, & data, and access to all of your COSMO features.</td></tr>';

        } else {
          $middle_para = '<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 20px;">By default, your prepaid plan will switch to month-to-month going forward, following the end of your ('.$dataplan_arr['product_name'].') plan. This means you\'ll continue to receive uninterrupted COSMO service with unlimited talk, text, data, and access to all your COSMO features, billed monthly at $19.99/mo.</td></tr>';
        }


        $message='<!DOCTYPE html>
        <html>
         <head>
            <title>Cosmo</title>
            <style>
                .down_btn_img{
                    display: none !important;
                    visiblility: hidden !important;
                }
                 a [class="down_btn_img"]{
                  display: none !important;visiblility: hidden !important;
                }

                @media screen and (max-width: 767px){
                    .qr_btn_img{
                        display: none !important;
                        visiblility: hidden !important;
                    }
                      img [class="qr_btn_img"]{
                  display: none !important;visiblility: hidden !important;
                }
                    .down_btn_img{
                        display: block !important;
                        visiblility: visible !important;
                    }
                    a [class="down_btn_img"]{
                  display: block !important;visiblility: visible !important;
                }
                }

                @media screen and (max-width: 575px){
                    .phone_number{
                        font-size: 20px !important;
                    }
                }
                @media screen and (max-width: 575px){
                    .phone_number{
                        font-size: 18px !important;
                    }
                }
            </style>
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
                    <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: bold; font-size: 26px; color: rgb(45, 50, 65);">Your membership plan is about to renew</td>
                </tr>
                <tr>
                    <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 16px 0;">Thanks for being a valued COSMO customer! We wanted to let you know that your '.$dataplan_arr['product_name'].' COSMO Membership plan will end/renew on '.$dataplan_arr['scheduled_at'].'.</td>
                </tr>'.$middle_para.'
                <tr>
                    <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 0 0 16px 0;">If you have any questions or would like to make changes to your COSMO Membership, please contact our support team at <a href="tel:(877) 215-4741">(877) 215-4741</a> or reach out via our <a href="https://cosmotogether.com/pages/support" style="color:#2b85c2;">Support Page</a> .</td>
                </tr>
                <tr>
                    <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 20px;">Thanks for choosing COSMO!</td>
                </tr>
                <tr>
                    <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: bold; font-size: 20px; color: rgb(45, 50, 65);">--The COSMO Team</td>
                </tr>
                <tfoot align="center">
                    <tr>
                        <td align="center" style="padding-top: 30px;"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 0;margin-top: 16px;">©2022 COSMO Technologies, Inc.</p></td>
                    </tr>
                    <tr>
                        <td align="center"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">700 Colorado Blvd #238</p></td>
                    </tr>
                    <tr>
                        <td align="center"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">Denver, CO 80206</p></td>
                    </tr>
                    <tr>
                        <td align="center"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 21px 0 0 0;">All rights reserved.</p></td>
                    </tr>
                    <tr>
                    <td style="padding-top: 10px;">
                        <table>
                            <tr>
                                <td style="padding-right: 10px;"><a href="https://www.facebook.com/CosmoSW.Tech/"><img src="'.EMAILIMAGE_PATH."facebook_96_new.png".'" alt="facebook" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
                                <td style="padding-right: 10px;"><a href="https://www.instagram.com/cosmotogether"><img src="'.EMAILIMAGE_PATH."instagram_96_new.png".'" alt="instagram" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
                                <td style="padding-right: 10px;"><a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg"><img src="'.EMAILIMAGE_PATH."youtube_96_new.png".'" alt="youtube" width="32" style="box-sizing: border-box;max-width:100%;"></a></td>
                                <td style="padding-right: 10px;"><a href="https://www.pinterest.com/cosmotogether/_saved"><img src="'.EMAILIMAGE_PATH."pinterest_96_new.png".'" alt="pinterest" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
                                <td style="padding-right: 10px;"><a href="https://www.linkedin.com/company/cosmo-technologies"><img src="'.EMAILIMAGE_PATH."linkedin_96_new.png".'" alt="linkedin" width="32" style="box-sizing: border-box;max-width:32px;"></a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </tfoot>
            </tbody>
            </table>
           </body>
        </html>';
     
       
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject("Your membership plan is about to renew");
        $email->addTo($to);
       
        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
            return  $response->statusCode() ;

           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }




     public function sendAlertDataplan_12_12_22($to,$dataplan_arr)
    {

       
        $message='<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COSMO</title>
</head>
<body style="margin: 0; padding: 0;">
  <table width="600" cellspacing="0" cellpadding="0" align="center" border="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <img src="'.EMAILIMAGE_PATH."cosmoblue-big.png".'" alt="COSMO SmartWatch" width="200">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <p style="margin: 0;color: #2d3241;font-weight: bold;font-size: 24px;font-family: Arial, Helvetica, sans-serif;">Your membership plan is about to renew 
</p>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <p style="margin: 0;color: #2d3241;font-size: 16px;font-family: Arial, Helvetica, sans-serif;">Thanks for being a valued COSMO customer! We wanted to let you know that your ('.$dataplan_arr['product_name'].') COSMO Membership plan will end/renew on (End/Renewal Date). By default, your plan will switch to a month to month billing cycle going forward with no change in the pricing structure. This means you\'ll continue to receive the ('.$dataplan_arr['product_name'].') plan\'s discounted rate, just billed monthly instead of every (6 months or year). That\'s the flexibility of monthly, but with the savings of the ('.$dataplan_arr['product_name'].')! 
If you have any questions or would like to make changes to your COSMO Membership, please contact our support team at <a href="#">(877) 215-4741</a> or reach out via our <a href="#">Contact Page. </a></p>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <p style="margin: 0;color: #767676;font-size: 14px;font-family: Arial, Helvetica, sans-serif;text-align: center;">
          &copy;2022 COSMO Technologies, Inc.<br>
          700 Colorado Blvd #238<br>
          Denver, CO 80206
        </p>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <p style="margin: 0;color: #767676;font-size: 14px;font-family: Arial, Helvetica, sans-serif;text-align: center;">All rights reserved.</p>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <table width="200" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td valign="middle">
              <a href="https://www.facebook.com/CosmoSW.Tech" target="_blank" title="Facebook">
                <img src="'.EMAILIMAGE_PATH."facebook_96_new.png".'" alt="Facebook" width="24">
              </a>
            </td>
            <td valign="middle">
              <a href="https://www.instagram.com/cosmotogether/" target="_blank" title="Instagram">
                <img src="'.EMAILIMAGE_PATH."instagram_96_new.png".'" alt="Instagram" width="24">
              </a>
            </td>
            <td valign="middle">
              <a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg" target="_blank" title="YouTube">
                <img src="'.EMAILIMAGE_PATH."youtube_96_new.png".'" alt="YouTube" width="24">
              </a>
            </td>
            <td valign="middle">
              <a href="https://www.pinterest.com/cosmotogether/_saved/" target="_blank" title="Pinterest">
                <img src="'.EMAILIMAGE_PATH."pinterest_96_new.png".'" alt="Pinterest" width="24">
              </a>
            </td>
            <td valign="middle">
              <a href="https://www.linkedin.com/company/cosmo-technologies" target="_blank" title="LinkedIn">
                <img src="'.EMAILIMAGE_PATH."linkedin_96_new.png".'" alt="LinkedIn" width="24">
              </a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</body>
</html>';
     
       
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject("Your membership plan is about to renew");
        $email->addTo($to);
       
        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
            return  $response->statusCode() ;

           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }



     public function activationPending($to)
    {
       
      

        $message='<body style="margin: 0; padding: 0;">
    <table width="600" cellspacing="0" cellpadding="0" align="center" border="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <img src="'.EMAILIMAGE_PATH."cosmoblue-big.png".'" alt="COSMO SmartWatch" width="200">
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0;color: #2d3241;font-weight: bold;font-size: 24px;font-family: Arial, Helvetica, sans-serif;">You\'re in the activation queue!</p>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0;color: #2d3241;font-size: 16px;font-family: Arial, Helvetica, sans-serif;">No need to worry! Due to high demand, we\'re seeing lots of activations and it\'s taking a bit longer to get all devices activated. You\'re in the queue and your device will be activated in the next few hours. We\'ll send you an email as soon as it\'s ready!</p>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0;color: #767676;font-size: 14px;font-family: Arial, Helvetica, sans-serif;text-align: center;">
                    &copy;2022 COSMO Technologies, Inc.<br>
                    700 Colorado Blvd #238<br>
                    Denver, CO 80206
                </p>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0;color: #767676;font-size: 14px;font-family: Arial, Helvetica, sans-serif;text-align: center;">All rights reserved.</p>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="200" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td valign="middle">
                            <a href="https://www.facebook.com/CosmoSW.Tech/" target="_blank" title="Facebook">
                                <img src="'.EMAILIMAGE_PATH."facebook_96_new.png".'" alt="Facebook" width="24">
                            </a>
                        </td>
                        <td valign="middle">
                            <a href="https://www.instagram.com/cosmotogether" target="_blank" title="Instagram">
                                <img src="'.EMAILIMAGE_PATH."instagram_96_new.png".'" alt="Instagram" width="24">
                            </a>
                        </td>
                        <td valign="middle">
                            <a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg" target="_blank" title="YouTube">
                                <img src="'.EMAILIMAGE_PATH."youtube_96_new.png".'" alt="YouTube" width="24">
                            </a>
                        </td>
                        <td valign="middle">
                            <a href="https://www.pinterest.com/cosmotogether/_saved/" target="_blank" title="Pinterest">
                                <img src="'.EMAILIMAGE_PATH."pinterest_96_new.png".'" alt="Pinterest" width="24">
                            </a>
                        </td>
                        <td valign="middle">
                            <a href="https://www.linkedin.com/company/cosmo-technologies" target="_blank" title="LinkedIn">
                                <img src="'.EMAILIMAGE_PATH."linkedin_96_new.png".'" alt="LinkedIn" width="24">
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>';

      

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject("You're in the activation queue!");
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



     public function sendAlert($to,$dev_arr,$speedtalk_res,$endpoint)
    {

       if(isset($speedtalk_res['retmess']))
       {
            $retmess=$speedtalk_res['retmess'];
       }
       else
       {
            $retmess="NULL";
       }
    
        $message="<p>User: ".$dev_arr['email']."</p><p>IMEI: ".$dev_arr['imei']."</p><p>ICCID: ".$dev_arr['iccid']."</p>";
        $message.="Error Details(".$endpoint.")";
        //$message.="<p>Response Id: ".$speedtalk_res['ret']."</p><p>Response Text: ".$speedtalk_res['retmess']."</p>";
        $message.="<p>Response Id: ".$speedtalk_res['ret']."</p><p>Response Text: ".$retmess."</p>";
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject("Speedtalk Error");
        $email->addTo($to);
        // $email->addCc("hayley@cosmotogether.com");
        // $email->addCc("russell@saganglobal.com");
        $email->addCc("ryan@cosmosmartwatch.com");
        
        $email->addCc("ex@cosmotogether.com");
                $email->addCc("waleed@cosmotogether.com");
        $email->addCc("jure.lampe@senlab.io");
        $email->addCc("denis.feratovic@senlab.io");

        $email->addCc("matevz.jecl@senlab.io");

     $email->addCc("brigid@cosmotogether.com");
        $email->addCc("kaitlyn@cosmotogether.com");
                $email->addCc("laeeq@cosmotogether.com");




        $email->addCc("dev@codeclouds.biz");
        
        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }
    public function sendMail($to)
    {

        $otp=mt_rand(100000,999999);
        $_SESSION['otp']=$otp;

        //$message="Your 6 Digits OTP for COSMO Verification is: ".$otp;
        $message='
    <!doctype html>
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
      <head>
        <title>
          
        </title>
      
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
      
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
          #outlook a { padding:0; }
          body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
          table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
          img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
          p { display:block;margin:13px 0; }
        </style>
      
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet" type="text/css">
        <style type="text/css">
          @import url(https://fonts.googleapis.com/css?family=Lato:400,700);
@import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
@import url(https://fonts.googleapis.com/css?family=Cabin:400,700);
@import url(https://fonts.googleapis.com/css?family=Poppins:400,700);
        </style>
   

    
        
    <style type="text/css">
      @media only screen and (max-width:480px) {
        .mj-column-per-100 { width:100% !important; max-width: 100%; }
      }
    </style>
    
  
        <style type="text/css">
        
        

    @media only screen and (max-width:480px) {
      table.full-width-mobile { width: 100% !important; }
      td.full-width-mobile { width: auto !important; }
    }
  
        </style>
        <style type="text/css">.hide_on_mobile { display: none !important;} 
        @media only screen and (min-width: 480px) { .hide_on_mobile { display: block !important;} }
        .hide_section_on_mobile { display: none !important;} 
        @media only screen and (min-width: 480px) { 
            .hide_section_on_mobile { 
                display: table !important;
            } 

            div.hide_section_on_mobile { 
                display: block !important;
            }
        }
        .hide_on_desktop { display: block !important;} 
        @media only screen and (min-width: 480px) { .hide_on_desktop { display: none !important;} }
        .hide_section_on_desktop { 
            display: table !important;
            width: 100%;
        } 
        @media only screen and (min-width: 480px) { .hide_section_on_desktop { display: none !important;} }
        
          p, h1, h2, h3 {
              margin: 0px;
          }

          ul, li, ol {
            font-size: 11px;
            font-family: Ubuntu, Helvetica, Arial;
          }

          a {
              text-decoration: none;
              color: inherit;
          }

          @media only screen and (max-width:480px) {

            .mj-column-per-100 { width:100%!important; max-width:100%!important; }
            .mj-column-per-100 > .mj-column-per-75 { width:75%!important; max-width:75%!important; }
            .mj-column-per-100 > .mj-column-per-60 { width:60%!important; max-width:60%!important; }
            .mj-column-per-100 > .mj-column-per-50 { width:50%!important; max-width:50%!important; }
            .mj-column-per-100 > .mj-column-per-40 { width:40%!important; max-width:40%!important; }
            .mj-column-per-100 > .mj-column-per-33 { width:33.333333%!important; max-width:33.333333%!important; }
            .mj-column-per-100 > .mj-column-per-25 { width:25%!important; max-width:25%!important; }

            .mj-column-per-100 { width:100%!important; max-width:100%!important; }
            .mj-column-per-75 { width:100%!important; max-width:100%!important; }
            .mj-column-per-60 { width:100%!important; max-width:100%!important; }
            .mj-column-per-50 { width:100%!important; max-width:100%!important; }
            .mj-column-per-40 { width:100%!important; max-width:100%!important; }
            .mj-column-per-33 { width:100%!important; max-width:100%!important; }
            .mj-column-per-25 { width:100%!important; max-width:100%!important; }
        }</style>
        
      </head>
      <body style="background-color:#FFFFFF;">
        
        
      <div style="background-color:#FFFFFF;">
        
   
    
      
      <div style="margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:9px 0px 9px 0px;text-align:center;">
              
            
      <div class="mj-column-per-100 outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
        
            <tr>
              <td align="center" style="font-size:0px;padding:0px 0px 0px 11px;word-break:break-word;">
                
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
        <tbody>
          <tr>
            <td style="width:138px;">
              
      <img height="auto" src="https://s3.us-west-1.amazonaws.com/wthmedia/plugin-assets/8315/94963/Logo%20%281%29.png" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="138">
    
            </td>
          </tr>
        </tbody>
      </table>
    
              </td>
            </tr>
          
            <tr>
              <td align="left" style="font-size:0px;padding:15px 15px 15px 15px;word-break:break-word;">
                
      <div style="font-family:Ubuntu, Helvetica, Arial;font-size:11px;line-height:1.5;text-align:left;color:#000000;"><p style="font-family: Ubuntu, Helvetica, Arial; font-size: 11px; text-align: center;"><span style="font-family: Lato, Tahoma, sans-serif;"><span style="font-size: 13px;">Your 6-digit COSMO verification code is:</span></span></p></div>
    
              </td>
            </tr>
          
            <tr>
              <td align="left" style="font-size:0px;padding:0px 15px 0px 15px;word-break:break-word;">
                
      <div style="font-family:Ubuntu, Helvetica, Arial;font-size:11px;line-height:1.5;text-align:left;color:#000000;"><p style="font-family: Ubuntu, Helvetica, Arial; font-size: 11px; text-align: center;"><span style="font-size: 30px; font-family: Poppins, sans-serif;"><strong>'.$otp.'</strong></span></p></div>
    
              </td>
            </tr>
          
            <tr>
              <td align="left" style="font-size:0px;padding:4px 15px 15px 15px;word-break:break-word;">
                
      <div style="font-family:Ubuntu, Helvetica, Arial;font-size:11px;line-height:1.5;text-align:left;color:#000000;"><p style="font-family: Ubuntu, Helvetica, Arial; font-size: 11px;">&nbsp;</p>
<p style="font-family: Ubuntu, Helvetica, Arial; font-size: 11px; text-align: center;"><span style="font-size: 13px; font-family: Lato, Tahoma, sans-serif;"><strong>COSMO Technologies, Inc.</strong></span></p></div>
    
              </td>
            </tr>
          
            <tr>
              <td align="center" style="font-size:0px;padding:0px 10px 0px 10px;word-break:break-word;">
                
      
  
              <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="float:none;display:inline-table;">
                
      <tr>
        <td style="padding:4px;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:transparent;border-radius:3px;width:35px;">
            <tr>
              <td style="font-size:0;height:35px;vertical-align:middle;width:35px;">
                <a href="https://www.facebook.com/CosmoSW.Tech" target="_blank" style="color: #0000EE; font-family: Ubuntu, Helvetica, Arial;">
                    <img alt="facebook" height="35" src="https://s3-eu-west-1.amazonaws.com/ecomail-assets/editor/social-icos/ikony-black/outlinedblack/facebook.png" style="border-radius:3px;display:block;" width="35">
                  </a>
                </td>
              </tr>
          </table>
        </td>
        
      </tr>
    
              </table>
          
              <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="float:none;display:inline-table;">
                
      <tr>
        <td style="padding:4px;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:transparent;border-radius:3px;width:35px;">
            <tr>
              <td style="font-size:0;height:35px;vertical-align:middle;width:35px;">
                <a href="https://www.instagram.com/cosmotogether" target="_blank" style="color: #0000EE; font-family: Ubuntu, Helvetica, Arial;">
                    <img alt="instagram" height="35" src="https://s3-eu-west-1.amazonaws.com/ecomail-assets/editor/social-icos/ikony-black/outlinedblack/instagram.png" style="border-radius:3px;display:block;" width="35">
                  </a>
                </td>
              </tr>
          </table>
        </td>
        
      </tr>
    
              </table>
         
    
    
              </td>
            </tr>
          
            <tr>
              <td style="font-size:0px;padding:10px 10px;padding-top:10px;word-break:break-word;">
                
      <p style="font-family: Ubuntu, Helvetica, Arial; border-top: solid 1px #000000; font-size: 1; margin: 0px auto; width: 100%;">
      </p>
      
  
    
    
              </td>
            </tr>
          
            <tr>
              <td align="left" style="font-size:0px;padding:15px 15px 15px 15px;word-break:break-word;">
                
      <div style="font-family:Ubuntu, Helvetica, Arial;font-size:11px;line-height:1.5;text-align:left;color:#000000;"><p style="font-family: Ubuntu, Helvetica, Arial; font-size: 11px; text-align: center;"><span style="font-size: 13px; font-family: Lato, Tahoma, sans-serif;">700 Colorado Boulevard #238</span></p>
<p style="font-family: Ubuntu, Helvetica, Arial; font-size: 11px; text-align: center;"><span style="font-size: 13px; font-family: Lato, Tahoma, sans-serif;">Denver, CO 80206</span></p>
<p style="font-family: Ubuntu, Helvetica, Arial; font-size: 11px; text-align: center;">&nbsp;</p>
<p style="font-family: Ubuntu, Helvetica, Arial; font-size: 11px; text-align: center;"><span style="font-size: 13px; font-family: Lato, Tahoma, sans-serif;"><em>Need help? </em></span></p>
<p style="font-family: Ubuntu, Helvetica, Arial; font-size: 11px; text-align: center;"><span style="font-size: 13px; font-family: Lato, Tahoma, sans-serif;">support@cosmotogether.com</span></p>
<p style="font-family: Ubuntu, Helvetica, Arial; font-size: 11px; text-align: center;"><span style="font-size: 13px; font-family: Lato, Tahoma, sans-serif;">(877)-215-4741</span></p>
<p style="font-family: Ubuntu, Helvetica, Arial; font-size: 11px; text-align: center;"><span style="font-size: 13px; font-family: Lato, Tahoma, sans-serif;">www.cosmotogether.com</span></p></div>
    
              </td>
            </tr>
          
      </table>
    
      </div>
    
      
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
     
    
    
      </div>
    
      </body>
    </html>';

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(SMTPSENDEREMAIL, "COSMO");
        $email->setSubject("COSMO Verification");
        $email->addTo($to);
        $email->addContent("text/html", $message);
      
        $sendgrid = new \SendGrid(SENDGRIDKEY);
       
        try {
            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
           // print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }


// public function sendConfirmationMailNew($to,$plan_type,$watch_phone_number,$refurbed)
// {

//      // if($provider=='speedtalk')
//      // {
//      //     $phn1=substr($watch_phone_number,0,3);
//      //     $phn2=substr($watch_phone_number,3,3);
//      //     $phn3=substr($watch_phone_number,6,4);
//      //     $phone_format= "+1 (".$phn1.") ".$phn2."-".$phn3;
//      // }
//      // else
//      // {
//      //     $phn1=substr($watch_phone_number,0,2);
//      //     $phn2=substr($watch_phone_number,2,3);
//      //     $phn3=substr($watch_phone_number,5,3);
//      //     $phn4=substr($watch_phone_number,8,4);
//      //     $phone_format=$phn1. " ($phn2) " .$phn3."-".$phn4;
//      // }


//      $phn1=substr($watch_phone_number,0,3);
//          $phn2=substr($watch_phone_number,3,3);
//          $phn3=substr($watch_phone_number,6,4);
//           $phone_format= "+1 (".$phn1.") ".$phn2."-".$phn3;


//  if(!empty($refurbed) && ($refurbed == "1")){
//         $refurbed_msg = '<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 20px 0 0 0;">You can get a head start on setting up your watch by downloading the parent app linked below and creating an account. When your watch arrives, just pair it with the app and you\'re good to go!</td></tr>';
//     } else if(!empty($refurbed) && ($refurbed == "0")){
//         $refurbed_msg = "";
//     } else {
//         $refurbed_msg = "";
//     }

//          $message    = '<!DOCTYPE html>
// <html>
// <head>
//     <title>Cosmo</title>
//     <style>
//         .down_btn_img{
//             display: none !important;
//             visiblility: hidden !important;
//         }
//          a [class="down_btn_img"]{
//           display: none !important;visiblility: hidden !important;
//         }

//         @media screen and (max-width: 767px){
//             .qr_btn_img{
//                 display: none !important;
//                 visiblility: hidden !important;
//             }
//               img [class="qr_btn_img"]{
//           display: none !important;visiblility: hidden !important;
//         }
//             .down_btn_img{
//                 display: block !important;
//                 visiblility: visible !important;
//             }
//             a [class="down_btn_img"]{
//           display: block !important;visiblility: visible !important;
//         }
//         }

//         @media screen and (max-width: 575px){
//             .phone_number{
//                 font-size: 20px !important;
//             }
//         }
//         @media screen and (max-width: 575px){
//             .phone_number{
//                 font-size: 18px !important;
//             }
//         }
//     </style>
// </head>
// <body>
//     <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 600px;width: 100%;margin: 0 auto;    padding: 20px 0;">
//         <thead>
//             <tr>
//                 <th align="left" style="padding: 0px 0px 21px;">
//                     <img height="auto" src="'.EMAILIMAGE_PATH."cosmoblue-big.png".'" alt="logo" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;max-width: 200px;" width="200">
//                 </th>
//             </tr>
//         </thead>
//         <tbody>
//             <tr>
//                 <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: bold; font-size: 26px; color: rgb(45, 50, 65);">Success!</td>
//             </tr>
//             <tr>
//                 <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 16px 0;">We successfully activated your <span style="font-weight: bold;">'.$plan_type.'</span> with unlimited talk, text, and data.</td>
//             </tr>
//             <tr>
//                 <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 20px;">Your JrTrack phone number is below - go ahead and add it to your contacts and copy it for pairing with the app!</td>
//             </tr>
//             <tr>
//                 <td align="center" style="background-color: rgb(245, 244, 245);padding: 23px 52px; word-break: break-word;font-size: 26px; font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: bold; color: rgb(75, 75, 75);">'.$phone_format.'</td>
//             </tr>'.$refurbed_msg.'
//             <tr>
//                 <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 35px 0 16px 0;">Now it\'s time to pair the watch with the parent app! Download the free Mission Control parent app linked below, create an account, and follow the steps in the app to pair.&nbsp;</td>
//             </tr>
//             <tr>
//                 <td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 30px;">If you need help pairing, email us at <span style="color: rgb(0, 79, 235);">support@cosmotogether.com</span></td>
//             </tr>
//             <tr>
//                 <td style="box-sizing: border-box;padding: 9px 25px;">
//                   <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;">
//                     <tbody><tr>
//                       <td style="padding-right:15px;box-sizing: border-box;">
//                         <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;">
//                           <tbody><tr>
//                            <td style="box-sizing: border-box;">
//                                 <img src="'.EMAILIMAGE_PATH."appstoreqr.png".'" alt="app-store" style="box-sizing: border-box;max-width:100%;" class="qr_btn_img">
//                                 <a href="https://apps.apple.com/us/app/cosmo-mission-control/id1580600845" target="_blank" class="down_btn_img">
//                                     <img src="'.EMAILIMAGE_PATH."app_store_btn_new.png".'" alt="app-store" style="box-sizing: border-box;max-width:100%;">
//                                 </a>
//                             </td>
//                           </tr> 
//                         </tbody></table>
//                       </td>

//                       <td style="padding-left:15px;box-sizing: border-box;">
//                         <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;">
//                           <tbody><tr>
//                             <td style="box-sizing: border-box;">
//                                 <img src="'.EMAILIMAGE_PATH."googleplayqr.png".'" alt="google-play" style="box-sizing: border-box;max-width:100%;" class="qr_btn_img">
//                                 <a href="https://play.google.com/store/apps/details?id=com.cosmo.missioncontrol" target="_blank" class="down_btn_img">
//                                     <img src="'.EMAILIMAGE_PATH."google_play_btn_new.png".'" alt="google-play" style="box-sizing: border-box;max-width:100%;">
//                                 </a>
//                             </td>
//                           </tr> 
//                         </tbody></table>
//                       </td>
//                     </tr>
//                   </tbody></table>
//                 </td>
//              </tr>

//              <tr>
//                <td style="background-color:#fff;padding: 20px 0 0;box-sizing: border-box;">
//                   <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;">
//                      <tbody>
//                         <tr>
//                            <td style="width: 48%; border: 0px; padding: 0px;">
//                               <img src="'.EMAILIMAGE_PATH."cosmo-logo-email.png".'" width="150" alt="logo" style="max-width: 100%;">
//                            </td>
//                            <td align="right" style="box-sizing: border-box;width: 50%;" align="right">
//                               <span style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 300;">
//                                 <a href="https://cosmotogether.com/" style="color: rgb(11, 11, 38);font-size: 12px;">Website</a>&nbsp; &nbsp; &nbsp; 
//                                 <a href="https://cosmotogether.com/blogs/news" style="color: rgb(11, 11, 38);font-size: 12px;">Blog</a>&nbsp; &nbsp; &nbsp; 
//                                 <a href="https://cosmotogether.com/pages/support" style="color: rgb(11, 11, 38);font-size: 12px;">Support</a>&nbsp; &nbsp; &nbsp;
//                                 <a href="https://cosmotogether.com/pages/our-mission" style="color: rgb(11, 11, 38);font-size: 12px;">About</a>&nbsp; </span>
//                            </td>
//                         </tr>
//                      </tbody>
//                   </table>
//                </td>
//             </tr>

//             <tr>
//                 <td style="padding-top: 10px;">
//                     <table>
//                         <tr>
//                             <td style="padding-right: 10px;"><a href="https://www.facebook.com/CosmoSW.Tech"><img src="'.EMAILIMAGE_PATH."facebook_96_new.png".'" alt="facebook" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
//                             <td style="padding-right: 10px;"><a href="https://www.instagram.com/cosmotogether/"><img src="'.EMAILIMAGE_PATH."instagram_96_new.png".'" alt="instagram" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
//                             <td style="padding-right: 10px;"><a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg"></a><img src="'.EMAILIMAGE_PATH."youtube_96_new.png".'" alt="/youtube" width="32" style="box-sizing: border-box;max-width:100%;"></td>
//                             <td style="padding-right: 10px;"><a href="https://www.pinterest.com/cosmotogether/_saved/"><img src="'.EMAILIMAGE_PATH."pinterest_96_new.png".'" alt="pinterest" width="32" style="box-sizing: border-box;max-width:32px"></a></td>
//                             <td style="padding-right: 10px;"><a href="https://www.linkedin.com/company/cosmo-technologies"><img src="'.EMAILIMAGE_PATH."linkedin_96_new.png".'" alt="linkedin" width="32" style="box-sizing: border-box;max-width:32px;"></a></td>
//                         </tr>
//                     </table>
//                 </td>
//             </tr>

//             <tfoot align="center">
//                 <tr>
//                     <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 0;margin-top: 16px;">©2022 COSMO Technologies, Inc.</p></td>
//                 </tr>
//                 <tr>
//                     <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">700 Colorado Blvd #238</p></td>
//                 </tr>
//                 <tr>
//                     <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">Denver, CO 80206</p></td>
//                 </tr>
//                 <tr>
//                     <td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 21px 0 0 0;">All rights reserved.</p></td>
//                 </tr>
//             </tfoot>
            
            
//         </tbody>
//     </table>
// </body>
// </html>
//         ';

//         $email = new \SendGrid\Mail\Mail();
//         $email->setFrom(SMTPSENDEREMAIL, "COSMO");
//         $email->setSubject("Congratulations, Your Cosmo Plan is Activated!");
//         $email->addTo($to);
//         $email->addContent("text/html", $message);
      
//         $sendgrid = new \SendGrid(SENDGRIDKEY);
       
//         try {
//             $response = $sendgrid->send($email);
//             return $response->statusCode();
//             //print $response->statusCode() . "\n";
//            // print_r($response->headers());
//             //print $response->body() . "\n";
//         } catch (Exception $e) {
//             echo 'Caught exception: '. $e->getMessage() ."\n";
//         }

//     }


//      public function sendConfirmationMailNew_08_06_2022($to,$order_number,$plan_type,$phone_number)
//     {

       
//          $message    = '
// <table border="0" cellpadding="0" cellspacing="0" class="templateRow row_container" width="600" align="center">
//     <tbody>
//         <tr>
//             <td class="rowContainer kmFloatLeft column_container single_column ui-sortable" data-section="2" valign="top">
//                 <div class="template_block ui-droppable" data-block="1425686045" data-blocktype="full_image">
//                     <table border="0" cellpadding="0" cellspacing="0" class="kmImageBlock kmDesktopOnly" style="min-width:100%" width="100%">
//                         <tbody class="kmImageBlockOuter">
//                             <tr>
//                                 <td class="kmImageBlockInner" style="padding:9px;padding-left:160px;padding-right:160px;" valign="top">
//                                     <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmImageContentContainer" style="min-width:100%" width="100%">
//                                         <tbody>
//                                             <tr>
//                                                 <td class="kmImageContent" style="padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;text-align: center;" valign="top">
//                                                     <img align="center" alt="" class="kmImage" src="'.EMAILIMAGE_PATH."cosmo-logo-email.png".'" style="max-width:2640px;padding:0;border-width:0;" width="244">
//                                                 </td>
//                                             </tr>
//                                         </tbody>
//                                     </table>
//                                 </td>
//                             </tr>
//                         </tbody>
//                     </table>
//                     <div class="template_block_controls">
//                         <div class="template_block_triangle"></div>
//                         <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
//                         <div class="divider"></div>
//                         <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
//                         <div class="divider"></div>
//                         <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
//                     </div>
//                     <div class="template_block_controls_spacer"></div>
//                 </div>
//                 <div class="template_block ui-droppable" data-block="1374149363" data-blocktype="text">
//                     <table border="0" cellpadding="0" cellspacing="0" class="kmTextBlock" width="100%">
//                         <tbody class="kmTextBlockOuter">
//                             <tr>
//                                 <td class="kmTextBlockInner" style="" valign="top">
//                                     <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmTextContentContainer" width="100%">
//                                         <tbody>
//                                             <tr>
//                                                 <td class="kmTextContent" style="padding-top:9px;padding-bottom:9px;padding-left:100px;padding-right:100px;" valign="top">
//                                                     <p>&nbsp;</p>
//                                                     <p><span style="font-family:trebuchet ms,helvetica,sans-serif;"><span style="color: rgb(0, 0, 0); font-size: 14px;">We successfully activated your&nbsp;</span><span style="color: rgb(0, 0, 0); font-size: 14px;"><b style="color: rgb(0, 0, 0); font-family: arial, helvetica, sans-serif; font-size: 14px; text-align: center;"><span class="template_variable" title=" '.$plan_type.' "> '.$plan_type.' </span>&nbsp;</b>plan with unlimited data.&nbsp;</span></span></p>
//                                                     <div style="font-size: 14px; color: rgb(0, 0, 0);"><font face="arial, helvetica, sans-serif">Your JrTrack 2 phone number is:&nbsp;&nbsp;</font></div>
//                                                     <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);"><strong><span style="font-family: inherit;"><span class="template_variable" title="'.$phone_number.'"> '.$phone_number.' </span></span></strong></div>
//                                                     <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);">&nbsp;</div>
//                                                     <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);"><strong style="font-size: 20px; font-family: inherit;">Now its time to pair with your watch!</strong></div>
//                                                     <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);">&nbsp;</div>
//                                                     <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);">Simply download the free Mission Control&nbsp;Parent App linked below, create an account and follow the steps to pair.&nbsp;</div>
//                                                     <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);">&nbsp;</div>
//                                                     <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0);"><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;">If you need help with these steps, please visit our <a href="https://cosmotogether.com/pages/support" style="color:#15c; font-weight:normal; text-decoration:underline">support page</a> or email us at support@cosmotogether.com</span></div>
//                                                 </td>
//                                             </tr>
//                                         </tbody>
//                                     </table>
//                                 </td>
//                             </tr>
//                         </tbody>
//                     </table>
//                     <div class="template_block_controls">
//                         <div class="template_block_triangle"></div>
//                         <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
//                         <div class="divider"></div>
//                         <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
//                         <div class="divider"></div>
//                         <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
//                     </div>
//                     <div class="template_block_controls_spacer"></div>
//                 </div>
//                 <div class="template_block ui-droppable small_block" data-block="1425689560" data-blocktype="spacer">
//                     <table border="0" cellpadding="0" cellspacing="0" class="kmDividerBlock kmMobileOnly" width="100%">
//                         <tbody class="kmDividerBlockOuter">
//                             <tr>
//                                 <td class="kmDividerBlockInner" style="padding-top:20px;">
//                                     <table border="0" cellpadding="0" cellspacing="0" class="kmDividerContent" width="100%">
//                                         <tbody>
//                                             <tr>
//                                                 <td><span></span></td>
//                                             </tr>
//                                         </tbody>
//                                     </table>
//                                 </td>
//                             </tr>
//                         </tbody>
//                     </table>
//                     <div class="template_block_controls">
//                         <div class="template_block_triangle"></div>
//                         <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
//                         <div class="divider"></div>
//                         <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
//                         <div class="divider"></div>
//                         <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
//                     </div>
//                     <div class="template_block_controls_spacer"></div>
//                 </div>
              
//                 <div class="template_block ui-droppable" data-block="1374149368" data-blocktype="full_image">
//                     <table border="0" cellpadding="0" cellspacing="0" class="kmImageBlock" style="min-width:100%" width="100%">
//                         <tbody class="kmImageBlockOuter">
//                             <tr>
//                                 <td class="kmImageBlockInner" style="padding:9px;padding-left:190px;padding-right:190px;" valign="top">
//                                     <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmImageContentContainer" style="min-width:100%" width="100%">
//                                         <tbody>
//                                             <tr>
//                                                 <td class="kmImageContent" style="padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;" valign="top">
//                                                     <img align="left" alt="" class="kmImage" src="'.EMAILIMAGE_PATH."Mission-Control.png".'" style="max-width:1920px;padding:0;border-width:0;" width="184">
//                                                 </td>
//                                             </tr>
//                                         </tbody>
//                                     </table>
//                                 </td>
//                             </tr>
//                         </tbody>
//                     </table>
//                     <div class="template_block_controls">
//                         <div class="template_block_triangle"></div>
//                         <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
//                         <div class="divider"></div>
//                         <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
//                         <div class="divider"></div>
//                         <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
//                     </div>
//                     <div class="template_block_controls_spacer"></div>
//                 </div>
//                 <div class="template_block ui-droppable" data-block="1374149366" data-blocktype="split">
//                     <table border="0" cellpadding="0" cellspacing="0" class="kmSplitBlock kmDesktopOnly" width="100%">
//                         <tbody class="kmSplitBlockOuter">
//                             <tr>
//                                 <td class="kmSplitBlockInner" style="padding-top:9px;padding-bottom:9px;padding-left:100px;padding-right:110px;" valign="top">
//                                     <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmSplitContentOuter" width="100%">
//                                         <tbody>
//                                             <tr>
//                                                 <td class="kmSplitContentInner" valign="top">
//                                                     <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmSplitContentLeftContentContainer" width="193">
//                                                         <tbody>
//                                                             <tr>
//                                                                 <td class="kmImageContent" style="padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;" valign="top">
//                                                                     <a href="https://apps.apple.com/us/app/cosmo-mission-control/id1580600845" target="_self">
//                                                                     <img align="left" alt="" class="kmImage" src="'.EMAILIMAGE_PATH."appstoreqr.png".'"  style="max-width:611px;" width="157">
//                                                                     </a>
//                                                                 </td>
//                                                             </tr>
//                                                         </tbody>
//                                                     </table>
//                                                     <table align="right" border="0" cellpadding="0" cellspacing="0" class="kmSplitContentRightContentContainer" width="194">
//                                                         <tbody>
//                                                             <tr>
//                                                                 <td class="kmImageContent" style="padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;text-align: center;" valign="top">
//                                                                     <a href="https://play.google.com/store/apps/details?id=com.cosmo.missioncontrol&amp;hl=en_US&amp;gl=US&amp;showAllReviews=true" target="_self">
//                                                                     <img align="center" alt="" class="kmImage" src="'.EMAILIMAGE_PATH."googleplayqr.png".'" style="max-width:611px;" width="158">
//                                                                     </a>
//                                                                 </td>
//                                                             </tr>
//                                                         </tbody>
//                                                     </table>
//                                                 </td>
//                                             </tr>
//                                         </tbody>
//                                     </table>
//                                 </td>
//                             </tr>
//                         </tbody>
//                     </table>
//                     <div class="template_block_controls">
//                         <div class="template_block_triangle"></div>
//                         <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
//                         <div class="divider"></div>
//                         <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
//                         <div class="divider"></div>
//                         <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
//                     </div>
//                     <div class="template_block_controls_spacer"></div>
//                 </div>
//                 <div class="template_block ui-droppable" data-block="1374149367" data-blocktype="spacer">
//                     <table border="0" cellpadding="0" cellspacing="0" class="kmDividerBlock" width="100%">
//                         <tbody class="kmDividerBlockOuter">
//                             <tr>
//                                 <td class="kmDividerBlockInner" style="padding-top:20px;">
//                                     <table border="0" cellpadding="0" cellspacing="0" class="kmDividerContent" width="100%">
//                                         <tbody>
//                                             <tr>
//                                                 <td><span></span></td>
//                                             </tr>
//                                         </tbody>
//                                     </table>
//                                 </td>
//                             </tr>
//                         </tbody>
//                     </table>
//                     <div class="template_block_controls">
//                         <div class="template_block_triangle"></div>
//                         <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
//                         <div class="divider"></div>
//                         <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
//                         <div class="divider"></div>
//                         <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
//                     </div>
//                     <div class="template_block_controls_spacer"></div>
//                 </div>
//                 <div class="template_block ui-droppable" data-block="1374149365" data-blocktype="button_bar">
//                     <table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarBlock" width="100%">
//                         <tbody class="kmButtonBarOuter">
//                             <tr>
//                                 <td align="center" class="kmButtonBarInner" style="padding-top:9px;padding-bottom:9px;background-color:#7C46F7;padding-left:9px;padding-right:9px;" valign="top">
//                                     <table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarContentContainer" width="100%">
//                                         <tbody>
//                                             <tr>
//                                                 <td align="center" style="padding-left:9px;padding-right:9px;">
//                                                     <table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarContent">
//                                                         <tbody>
//                                                             <tr>
//                                                                 <td align="center" valign="top">
//                                                                     <table border="0" cellpadding="0" cellspacing="0">
//                                                                         <tbody>
//                                                                             <tr>
//                                                                                 <td valign="top">
//                                                                                     <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
//                                                                                         <tbody>
//                                                                                             <tr>
//                                                                                                 <td align="center" style="padding-right:10px;" valign="top">
//                                                                                                     <a href="https://www.facebook.com/CosmoSW.Tech/" target="_blank"><img alt="Button Text" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/facebook_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
//                                                                                                 </td>
//                                                                                             </tr>
//                                                                                         </tbody>
//                                                                                     </table>
                                                                                   
//                                                                                     <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
//                                                                                         <tbody>
//                                                                                             <tr>
//                                                                                                 <td align="center" style="padding-right:10px;" valign="top">
//                                                                                                     <a href="https://www.instagram.com/cosmotogether/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/instagram_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
//                                                                                                 </td>
//                                                                                             </tr>
//                                                                                         </tbody>
//                                                                                     </table>
                                                                                
//                                                                                     <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
//                                                                                         <tbody>
//                                                                                             <tr>
//                                                                                                 <td align="center" style="padding-right:10px;" valign="top">
//                                                                                                     <a href="https://www.pinterest.com/cosmotogether/_saved/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/pinterest_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
//                                                                                                 </td>
//                                                                                             </tr>
//                                                                                         </tbody>
//                                                                                     </table>
                                                                              
//                                                                                     <table align="left" border="0" cellpadding="0" cellspacing="0" class="">
//                                                                                         <tbody>
//                                                                                             <tr>
//                                                                                                 <td align="center" style="" valign="top">
//                                                                                                     <a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtleinverse/youtube_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
//                                                                                                 </td>
//                                                                                             </tr>
//                                                                                         </tbody>
//                                                                                     </table>
                                                                                 
//                                                                                 </td>
//                                                                             </tr>
//                                                                         </tbody>
//                                                                     </table>
//                                                                 </td>
//                                                             </tr>
//                                                         </tbody>
//                                                     </table>
//                                                 </td>
//                                             </tr>
//                                         </tbody>
//                                     </table>
//                                 </td>
//                             </tr>
//                         </tbody>
//                     </table>
//                     <div class="template_block_controls">
//                         <div class="template_block_triangle"></div>
//                         <a title="Delete Block" href="#" class="template_block_delete"><i class="icon-trash"></i></a>
//                         <div class="divider"></div>
//                         <a title="Clone Block" href="#" class="template_block_clone"><i class="icon-copy"></i></a>
//                         <div class="divider"></div>
//                         <a title="Add to Saved Blocks" href="#" class="create_saved_block"><i class="icon-star"></i></a>
//                     </div>
//                     <div class="template_block_controls_spacer"></div>
//                 </div>
               
//             </td>
//         </tr>
//     </tbody>
// </table>
//         ';

//         $email = new \SendGrid\Mail\Mail();
//         $email->setFrom(SMTPSENDEREMAIL, "COSMO");
//         $email->setSubject("Congratulations, Your Cosmo Plan is Activated!");
//         $email->addTo($to);
//         $email->addContent("text/html", $message);
      
//         $sendgrid = new \SendGrid(SENDGRIDKEY);
       
//         try {
//             $response = $sendgrid->send($email);
//             return $response->statusCode();
//             //print $response->statusCode() . "\n";
//            // print_r($response->headers());
//             //print $response->body() . "\n";
//         } catch (Exception $e) {
//             echo 'Caught exception: '. $e->getMessage() ."\n";
//         }
// }


public function sendConfirmationMailNew($to,$plan_type,$watch_phone_number,$refurbed)
    {

    // if($provider=='speedtalk')
    // {
    //     $phn1=substr($watch_phone_number,0,3);
    //     $phn2=substr($watch_phone_number,3,3);
    //     $phn3=substr($watch_phone_number,6,4);
    //     $phone_format= "+1 (".$phn1.") ".$phn2."-".$phn3;
    // }
    // else
    // {
    //     $phn1=substr($watch_phone_number,0,2);
    //     $phn2=substr($watch_phone_number,2,3);
    //     $phn3=substr($watch_phone_number,5,3);
    //     $phn4=substr($watch_phone_number,8,4);
    //     $phone_format=$phn1. " ($phn2) " .$phn3."-".$phn4;
    // }


    $phn1=substr($watch_phone_number,0,3);
    $phn2=substr($watch_phone_number,3,3);
    $phn3=substr($watch_phone_number,6,4);
    $phone_format = "+1 (".$phn1.") ".$phn2."-".$phn3;
    $refurbed_msg = "";
    $refurbed_msg_new = "";
    $refurbed_footer  = "";
    $mail_subject = "";

    /* Mail-template Content Areas for Refurbed */
    if(!empty($refurbed) && ($refurbed == "1")){
        $mail_subject = 'Congratulations! Your COSMO Membership plan is ready';

        $refurbed_msg_new = '<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: bold; font-size: 26px; color: rgb(45, 50, 65);">Here\'s your new phone number!</td></tr>'.'<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 16px 0;">Thanks for joining COSMO! This email confirms purchase of your COSMO Mobile plan: <span style="font-weight: bold;">'.$plan_type.'</span>. Your COSMO Mobile plan gives your watch unlimited talk, text, and data + FREE device insurance!</td></tr><tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 20px;">Your JrTrack watch phone number is below. Go ahead and add it to your phone contacts.</td></tr>';

        $refurbed_msg = '<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65); padding: 35px 0 16px 0;">While your JrTrack watch is on its way, you can get a head start by downloading the COSMO Mission Control parent app and setting up your account.</td></tr>'.'<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 30px;">We’re always here to help! If you need any assistance, please email our service pros at <span style="color: rgb(0, 79, 235);">support@cosmotogether.com</span></td></tr>';

        $refurbed_footer  = '<tr style="background: #2D2F2F;color: #fff;"><td style="padding:25px 10px;text-align: center;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;"><table style="width: 100%"><tr><td><h4 style="font-size: 16px;line-height: 20px;margin: 0;    margin-bottom: 8px;">COSMO Technologies, Inc.</h4></td></tr><tr><td><a href="www.cosmotogether.com" style="color: #fff;text-decoration: underline;font-size: 11px;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;">www.cosmotogether.com</a></td></tr><tr><td><p style="font-size: 10px;margin: 0; margin-bottom: 6px;">No longer want to receive these emails? {% unsubscribe %}. </p></td></tr><tr><td><p style="font-size: 11px;margin-bottom: 0">700 Colorado Blvd. #238, Denver, CO, 80206</p></td></tr></table></td></tr>';

         

    /* Mail-template Content Areas for Non-Refurbed */
    } else if(!empty($refurbed) && ($refurbed == "0")){
        $mail_subject = 'Congratulations, Your Cosmo Plan is Activated!';

        $refurbed_msg_new = '<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: bold; font-size: 26px; color: rgb(45, 50, 65);">Success!</td></tr>'.'<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 16px 0;">We successfully activated your <span style="font-weight: bold;">'.$plan_type.'</span> with unlimited talk, text, and data.</td></tr><tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 20px;">Your JrTrack phone number is below - go ahead and add it to your contacts and copy it for pairing with the app!</td></tr>';

        $refurbed_msg = ''.'<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 16px 0 16px 0;">Now it\'s time to pair the watch with the parent app! Download the free Mission Control parent app linked below, create an account, and follow the steps in the app to pair.&nbsp;</td></tr><tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 30px;">If you need help pairing, email us at <span style="color: rgb(0, 79, 235);">support@cosmotogether.com</span></td></tr>';

        $refurbed_footer  = '<tr><td style="background-color:#fff;padding: 20px 0 0;box-sizing: border-box;"><table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;"><tbody><tr><td style="width: 48%; border: 0px; padding: 0px;"><img src="'.EMAILIMAGE_PATH."cosmo-logo-email.png".'" width="150" alt="logo" style="max-width: 100%;"></td><td align="right" style="box-sizing: border-box;width: 50%;" align="right"><span style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 300;"><a href="https://cosmotogether.com/" style="color: rgb(11, 11, 38);font-size: 12px;">Website</a>&nbsp; &nbsp; &nbsp;<a href="https://cosmotogether.com/blogs/news" style="color: rgb(11, 11, 38);font-size: 12px;">Blog</a>&nbsp; &nbsp; &nbsp;<a href="https://cosmotogether.com/pages/support" style="color: rgb(11, 11, 38);font-size: 12px;">Support</a>&nbsp; &nbsp; &nbsp;<a href="https://cosmotogether.com/pages/our-mission" style="color: rgb(11, 11, 38);font-size: 12px;">About</a>&nbsp; </span></td></tr></tbody></table></td></tr><tr><td style="padding-top: 10px;"><table><tr><td style="padding-right: 10px;"><a href="https://www.facebook.com/CosmoSW.Tech"><img src="'.EMAILIMAGE_PATH."facebook_96_new.png".'" alt="facebook" width="32" style="box-sizing: border-box;max-width:32px"></a></td><td style="padding-right: 10px;"><a href="https://www.instagram.com/cosmotogether/"><img src="'.EMAILIMAGE_PATH."instagram_96_new.png".'" alt="instagram" width="32" style="box-sizing: border-box;max-width:32px"></a></td><td style="padding-right: 10px;"><a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg"></a><img src="'.EMAILIMAGE_PATH."youtube_96_new.png".'" alt="/youtube" width="32" style="box-sizing: border-box;max-width:100%;"></td><td style="padding-right: 10px;"><a href="https://www.pinterest.com/cosmotogether/_saved/"><img src="'.EMAILIMAGE_PATH."pinterest_96_new.png".'" alt="pinterest" width="32" style="box-sizing: border-box;max-width:32px"></a></td><td style="padding-right: 10px;"><a href="https://www.linkedin.com/company/cosmo-technologies"><img src="'.EMAILIMAGE_PATH."linkedin_96_new.png".'" alt="linkedin" width="32" style="box-sizing: border-box;max-width:32px;"></a></td></tr></table></td></tr><tfoot align="center"><tr><td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 0;margin-top: 16px;">©2022 COSMO Technologies, Inc.</p></td></tr><tr><td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">700 Colorado Blvd #238</p></td></tr><tr><td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">Denver, CO 80206</p></td></tr><tr><td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 21px 0 0 0;">All rights reserved.</p></td></tr></tfoot>';


    /* Mail-template Content Areas for Non-Refurbed and others */
    } else {
        $mail_subject = 'Congratulations, Your Cosmo Plan is Activated!';

        $refurbed_msg_new = '<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: bold; font-size: 26px; color: rgb(45, 50, 65);">Success!</td></tr>'.'<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 16px 0;">We successfully activated your <span style="font-weight: bold;">'.$plan_type.'</span> with unlimited talk, text, and data.</td></tr><tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 20px;">Your JrTrack phone number is below - go ahead and add it to your contacts and copy it for pairing with the app!</td></tr>';

        $refurbed_msg = ''.'<tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding: 16px 0 16px 0;">Now it\'s time to pair the watch with the parent app! Download the free Mission Control parent app linked below, create an account, and follow the steps in the app to pair.&nbsp;</td></tr><tr><td align="left" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: rgb(45, 50, 65);padding-bottom: 30px;">If you need help pairing, email us at <span style="color: rgb(0, 79, 235);">support@cosmotogether.com</span></td></tr>';

        $refurbed_footer  = '<tr><td style="background-color:#fff;padding: 20px 0 0;box-sizing: border-box;"><table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;"><tbody><tr><td style="width: 48%; border: 0px; padding: 0px;"><img src="'.EMAILIMAGE_PATH."cosmo-logo-email.png".'" width="150" alt="logo" style="max-width: 100%;"></td><td align="right" style="box-sizing: border-box;width: 50%;" align="right"><span style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 300;"><a href="https://cosmotogether.com/" style="color: rgb(11, 11, 38);font-size: 12px;">Website</a>&nbsp; &nbsp; &nbsp;<a href="https://cosmotogether.com/blogs/news" style="color: rgb(11, 11, 38);font-size: 12px;">Blog</a>&nbsp; &nbsp; &nbsp;<a href="https://cosmotogether.com/pages/support" style="color: rgb(11, 11, 38);font-size: 12px;">Support</a>&nbsp; &nbsp; &nbsp;<a href="https://cosmotogether.com/pages/our-mission" style="color: rgb(11, 11, 38);font-size: 12px;">About</a>&nbsp; </span></td></tr></tbody></table></td></tr><tr><td style="padding-top: 10px;"><table><tr><td style="padding-right: 10px;"><a href="https://www.facebook.com/CosmoSW.Tech"><img src="'.EMAILIMAGE_PATH."facebook_96_new.png".'" alt="facebook" width="32" style="box-sizing: border-box;max-width:32px"></a></td><td style="padding-right: 10px;"><a href="https://www.instagram.com/cosmotogether/"><img src="'.EMAILIMAGE_PATH."instagram_96_new.png".'" alt="instagram" width="32" style="box-sizing: border-box;max-width:32px"></a></td><td style="padding-right: 10px;"><a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg"></a><img src="'.EMAILIMAGE_PATH."youtube_96_new.png".'" alt="/youtube" width="32" style="box-sizing: border-box;max-width:100%;"></td><td style="padding-right: 10px;"><a href="https://www.pinterest.com/cosmotogether/_saved/"><img src="'.EMAILIMAGE_PATH."pinterest_96_new.png".'" alt="pinterest" width="32" style="box-sizing: border-box;max-width:32px"></a></td><td style="padding-right: 10px;"><a href="https://www.linkedin.com/company/cosmo-technologies"><img src="'.EMAILIMAGE_PATH."linkedin_96_new.png".'" alt="linkedin" width="32" style="box-sizing: border-box;max-width:32px;"></a></td></tr></table></td></tr><tfoot align="center"><tr><td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 0;margin-top: 16px;">©2022 COSMO Technologies, Inc.</p></td></tr><tr><td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">700 Colorado Blvd #238</p></td></tr><tr><td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 4px 0 0 0;">Denver, CO 80206</p></td></tr><tr><td align="left"><p style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; color: rgb(118, 118, 118);font-size: 14px;margin: 21px 0 0 0;">All rights reserved.</p></td></tr></tfoot>';  
    }


    /* Email-Template-Content Main Area */
    $message    = '<!DOCTYPE html>
    <html>
    <head>
        <title>Cosmo</title>
        <style>
            .down_btn_img{
                display: none !important;
                visiblility: hidden !important;
            }
             a [class="down_btn_img"]{
              display: none !important;visiblility: hidden !important;
            }

            @media screen and (max-width: 767px){
                .qr_btn_img{
                    display: none !important;
                    visiblility: hidden !important;
                }
                  img [class="qr_btn_img"]{
              display: none !important;visiblility: hidden !important;
            }
                .down_btn_img{
                    display: block !important;
                    visiblility: visible !important;
                }
                a [class="down_btn_img"]{
              display: block !important;visiblility: visible !important;
            }
            }

            @media screen and (max-width: 575px){
                .phone_number{
                    font-size: 20px !important;
                }
            }
            @media screen and (max-width: 575px){
                .phone_number{
                    font-size: 18px !important;
                }
            }
        </style>
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
            <tbody>'.$refurbed_msg_new.'<tr>
                    <td align="center" style="background-color: rgb(245, 244, 245);padding: 23px 52px; word-break: break-word;font-size: 26px; font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: bold; color: rgb(75, 75, 75);">'.$phone_format.'</td>
                </tr>'.$refurbed_msg.'<tr>
                    <td style="box-sizing: border-box;padding: 9px 25px;">
                      <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;">
                        <tbody><tr>
                          <td style="padding-right:15px;box-sizing: border-box;">
                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;">
                              <tbody><tr>
                               <td style="box-sizing: border-box;">
                                    <img src="'.EMAILIMAGE_PATH."appstoreqr.png".'" alt="app-store" style="box-sizing: border-box;max-width:100%;" class="qr_btn_img">
                                    <a href="https://apps.apple.com/us/app/cosmo-mission-control/id1580600845" target="_blank" class="down_btn_img">
                                        <img src="'.EMAILIMAGE_PATH."app_store_btn_new.png".'" alt="app-store" style="box-sizing: border-box;max-width:100%;">
                                    </a>
                                </td>
                              </tr> 
                            </tbody></table>
                          </td>

                          <td style="padding-left:15px;box-sizing: border-box;">
                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;">
                              <tbody><tr>
                                <td style="box-sizing: border-box;">
                                    <img src="'.EMAILIMAGE_PATH."googleplayqr.png".'" alt="google-play" style="box-sizing: border-box;max-width:100%;" class="qr_btn_img">
                                    <a href="https://play.google.com/store/apps/details?id=com.cosmo.missioncontrol" target="_blank" class="down_btn_img">
                                        <img src="'.EMAILIMAGE_PATH."google_play_btn_new.png".'" alt="google-play" style="box-sizing: border-box;max-width:100%;">
                                    </a>
                                </td>
                              </tr> 
                            </tbody></table>
                          </td>
                        </tr>
                      </tbody></table>
                    </td>
                 </tr>'.$refurbed_footer.'</tbody>
        </table>
    </body>
    </html>
            ';

            $email = new \SendGrid\Mail\Mail();
            $email->setFrom(SMTPSENDEREMAIL, "COSMO");
            $email->setSubject($mail_subject);
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


public function sendPlanPurchaseConfirmationMail($to,$order_number,$plan_type,$encrypted_email)
    {
        
         $message    = '<table width="600" cellspacing="0" cellpadding="0" align="center" border="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <img src="'.EMAILIMAGE_PATH."cosmoblue-big.png".'" alt="COSMO SmartWatch" width="200">
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0;color: #2d3241;font-weight: bold;font-size: 24px;font-family: Arial, Helvetica, sans-serif;">Welcome!</p>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0;color: #2d3241;font-size: 17px;font-family: Arial, Helvetica, sans-serif; line-height: 24px; margin-bottom: 15px;">Thanks for your purchase of a <b>'.$plan_type.'</b> with unlimited talk, text, and data. This email is for your records and includes your service plan order number.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0;color: #2d3241;font-size: 17px;font-family: Arial, Helvetica, sans-serif; line-height: 24px; margin-bottom: 15px;">If you have any question or concerns, please don\'t hesitate to reach out to our team at support@cosmotogether.com or by phone at (877) 215-4741.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0;color: #2d3241;font-size: 17px;font-family: Arial, Helvetica, sans-serif; line-height: 24px; margin-bottom: 15px;"><b>Order number: '.$order_number.'</b></p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0;color: #2d3241;font-size: 17px;font-family: Arial, Helvetica, sans-serif; line-height: 24px; margin-bottom: 15px;">Once your plan is successfully activated, you\'ll receive an email with steps to download the Mission Control parent app and pair your watch.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0;color: #2d3241;font-size: 17px;font-family: Arial, Helvetica, sans-serif; line-height: 24px; margin-bottom: 30px;">Thanks for joining the COSMO family!</p>
            </td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #ddd;">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="200" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td valign="middle">
                            <a href="https://www.facebook.com/CosmoSW.Tech" target="_blank" title="Facebook">
                                <img src="'.EMAILIMAGE_PATH."facebook.png".'" alt="Facebook" width="24">
                            </a>
                        </td>
                        <td valign="middle">
                            <a href="https://www.instagram.com/cosmotogether" target="_blank" title="Instagram">
                                <img src="'.EMAILIMAGE_PATH."instagram.png".'" alt="Instagram" width="24">
                            </a>
                        </td>
                        <td valign="middle">
                            <a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg" target="_blank" title="YouTube">
                                <img src="'.EMAILIMAGE_PATH."youtube.png".'" alt="YouTube" width="24">
                            </a>
                        </td>
                        <td valign="middle">
                            <a href="https://www.pinterest.com/cosmotogether/_saved" target="_blank" title="Pinterest">
                                <img src="'.EMAILIMAGE_PATH."pinterest.png".'" alt="Pinterest" width="24">
                            </a>
                        </td>
                        <td valign="middle">
                            <a href="https://www.linkedin.com/company/cosmo-technologies" target="_blank" title="LinkedIn">
                                <img src="'.EMAILIMAGE_PATH."linkedin.png".'" alt="LinkedIn" width="24">
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="background: #2D2F2F; padding-top: 30px;">
                <h2 style="margin: 0;color: #fff;font-size: 22px;font-family: Arial, Helvetica, sans-serif;text-align: center; padding-bottom: 15px;">
                    COSMO Technologies, Inc.
                </h2>
            </td>
        </tr>
        <tr>
            <td style="background: #2D2F2F;">
                <p style="margin: 0;color: #fff;font-size: 14px;font-family: Arial, Helvetica, sans-serif;text-align: center; line-height: 24px;">
                    <a style="color:#fff;" href="https://www.cosmotogether.com">www.cosmotogether.com</a><br>
                    No longer want to receive these emails? <a href="https://activate.cosmotogether.com/activatedataplans/unsubscribe_klaviyo.php?p='.$encrypted_email.'">Unsubscribe</a>.
                </p>
            </td>
        </tr>
        <tr>
            <td style="background: #2D2F2F;">&nbsp;</td>
        </tr>
        <tr>
            <td style="background: #2D2F2F; padding-bottom: 30px;">
                <p style="margin: 0;color: #fff;font-size: 14px;font-family: Arial, Helvetica, sans-serif;text-align: center;">700 Colorado Blvd. #238, Denver, CO, 80206</p>
            </td>
        </tr>
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


public function sendRefurbPlanPurchaseConfirmationMail($to,$order_number,$plan_type,$encrypted_email)
{
        
    $message = '<!DOCTYPE html>
        <html>
        <head>
            <title>Cosmo</title>
            <style>
                .down_btn_img{
                    display: none !important;
                    visiblility: hidden !important;
                }
                 a [class="down_btn_img"]{
                  display: none !important;visiblility: hidden !important;
                }

                @media screen and (max-width: 767px){
                    .qr_btn_img{
                        display: none !important;
                        visiblility: hidden !important;
                    }
                      img [class="qr_btn_img"]{
                  display: none !important;visiblility: hidden !important;
                }
                    .down_btn_img{
                        display: block !important;
                        visiblility: visible !important;
                    }
                    a [class="down_btn_img"]{
                  display: block !important;visiblility: visible !important;
                }
                }

                @media screen and (max-width: 575px){
                    .phone_number{
                        font-size: 20px !important;
                    }
                }
                @media screen and (max-width: 575px){
                    .phone_number{
                        font-size: 18px !important;
                    }
                }
            </style>
        </head>
        <body>
            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 660px;width: 100%;margin: 0 auto;    padding: 20px 0;">
                <thead>
                    <tr>
                        <th align="left" style="padding: 0px 0px 21px;">
                            <img height="auto" src="./logo-dark.png" alt="logo" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;max-width: 200px;" width="200">
                        </th>
                         <th align="right" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;  font-size: 20px; color: #777777;font-weight: 500">ORDER #9999</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="left" colspan="2"  style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 600; font-size: 26px; color: #000000; line-height: 28px;padding-top: 20px">Thank you for your purchase!</td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 400; font-size: 18px; color: #777777;padding: 16px 0;    line-height: 26px;">Hi John, your order has been received and processed. We will notify when it is available for shipping. Thank you for shopping with COSMO!
                        </td>
                    </tr>
                    <tr>
                      <td align="left" colspan="2" valign="middle">
                        <a href="#" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-decoration: none;text-align: center;background: #1f4ee2;color: #fff;font-size: 18px;padding: 20px 35px;border-radius: 5px;float: left;">View your order</a>
                        <a href="#" style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-decoration: none;text-align: left;color: #000000;font-size: 18px;float: left;padding: 20px 15px;"> or <span style="color: #1f4ee2;">Visit our store</span></a>
                        <div style="overflow: auto;"></div>
                      </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2"  style="font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif; font-weight: 500; font-size: 23px; color: #000000; line-height: 28px;padding-top: 50px;padding-bottom: 20px">Order summary</td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;box-sizing: border-box;border-collapse: collapse;">
                          <tr style="border-bottom: 1px solid #dfdfdf;">
                            <td align="left" style="padding: 10px 0;"><img src="./cosmo-icon.png" alt="cosmo-icon" style="width: auto;height:70px;    margin-right: 10px;"></td>
                            <td align="left" style="padding: 10px 0;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 600;font-size: 20px">Cosmo 4G Watch Data Plan - ($1/day) × 1</td>
                            <td align="right" style="padding: 10px 0;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 600;font-size: 20px">$30.00</td>
                          </tr>
                          <tr>
                            <td rowspan="2" align="left" style="padding: 10px 0;"><img src="./cosmo-icon.png" alt="cosmo-icon" style="width: auto;height:70px;    margin-right: 10px;"></td>
                            <td align="left" style="padding: 10px 0 0;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 600;font-size: 20px">Cosmo 4G Watch Data Plan - ($1/day) Auto renew × 1</td>
                            <td align="right" style="padding: 10px 0 0;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 500;font-size: 18px"><del>$30.00</del></td>
                          </tr>
                          <tr style="border-bottom: 1px solid #dfdfdf;">
                            <td align="left" style="padding: 0px 0 10px;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 500;font-size: 18px"><img src="./discount-icon.jpg" alt="discount" style="margin-right: 3px;    width: auto;    height: 18px;">  DISCOUNT (-$5.00)</td>
                            <td align="right" style="padding: 0px 0 10px;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 20px">$25.00</td>
                          </tr>

                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <table border="0" cellpadding="0" cellspacing="0" style="width:60%;box-sizing: border-box;border-collapse: collapse;float: right;">
                          <tr>
                            <td style="padding: 25px 0 8px;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 500;font-size: 18px">Subtotal</td>
                            <td style="padding: 25px 0 8px;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 20px">$55.00</td>
                          </tr>
                          <tr>
                            <td style="padding: 0px;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 500;font-size: 18px">Shipping</td>
                            <td style="padding: 0px;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 20px">$10.00</td>
                          </tr>
                          <tr>
                            <td style="padding: 8px 0 25px;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 500;font-size: 18px">Taxes</td>
                            <td style="padding: 8px 0 25px;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 20px">$0.00</td>
                          </tr>
                          <tr>
                            <td colspan="2" style="height: 2px;width: 100%;background: #e5e5e5;"></td>
                          </tr>
                          <tr>
                            <td style="padding: 25px 0 25px;color: #777777;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: left;font-weight: 500;font-size: 18px">Total</td>
                            <td style="padding: 25px 0 25px;color: #555555;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;text-align: right;font-weight: 600;font-size: 30px;line-height: 28px;">$65.00 USD <br><span style="color: #777777;font-weight: 500;font-size: 20px">You saved <span style="color: #555555">$5.00</span></span></td>
                          </tr>
                        </table>
                      </td>
                    </tr>



                     <tr style="background: #2D2F2F;color: #fff;">
                      <td colspan="2" style="padding:25px 10px;text-align: center;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;">
                        <table style="width: 100%">
                        <tr>
                           <td><h4 style="font-size: 16px;line-height: 20px;margin: 0;    margin-bottom: 8px;">COSMO Technologies, Inc.</h4></td>
                        </tr>
                        <tr>
                          <td><a href="www.cosmotogether.com" style="color: #fff;text-decoration: underline;font-size: 11px;font-family: neuzeit-grotesk, &quot;Trebuchet MS&quot;, &quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, Tahoma, sans-serif;">www.cosmotogether.com</a></td>
                        </tr>
                        <tr>
                          <td><p style="font-size: 10px;margin: 0;    margin-bottom: 6px;">No longer want to receive these emails? {% unsubscribe %}. </p></td>
                        </tr>
                        <tr>
                          <td><p style="font-size: 11px;margin-bottom: 0">700 Colorado Blvd. #238, Denver, CO, 80206</p></td>
                        </tr>
                      </table>
                      </td>
                     </tr>

                
                    
                    
                </tbody>
            </table>
        </body>
        </html>';

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


 public function sendPlanPurchaseConfirmationMail_23_03_2023($to,$order_number,$plan_type)
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
        $email->setSubject("Plan Purchase Confirmation");
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









  public function sendPlanPurchaseConfirmationMail_08_06_2022($to,$order_number,$plan_type)
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
        $email->setSubject("Plan Purchase Confirmation");
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





    public function sendConfirmationMail($to,$order_number,$plan_type,$phone_number)
    {

       
         $message    = '


                <table border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="max-width: 100%;border-collapse: collapse;">
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
                                                                                    <img align="center" alt="" class="kmImage" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/banner.png" style="max-width:1920px;padding:0;border-width:0;" width="546">
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
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;"><span style="font-family: arial, helvetica, sans-serif;">Your <b><span class="template_variable">'.$plan_type.'</span>&nbsp;</b></span><span style="font-family: arial, helvetica, sans-serif;">subscription with unlimited talk, text, and&nbsp;data has been purchased.</span></div>
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;">&nbsp;</div>
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;"><span style="font-family: arial, helvetica, sans-serif;"></span></div>
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); margin-left: 0px; text-align: center;"><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"><strong>Order:</strong></span><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"> <span class="template_variable"> '.$order_number.'</span></span></div>
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); margin-left: 0px; text-align: center;"><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"><strong>Phone Number:</strong></span><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"> <span class="template_variable" title=""> '.$phone_number.' </span></span></div>
                                                                                    <div style="font-size: 14px; color: rgb(0, 0, 0); text-align: center;">&nbsp;</div>
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;"><span style="font-size:20px;"><strong>Now it is time to pair with your watch!</strong></span></div>
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
                                                                                    <img align="left" alt="" class="kmImage" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/logo.png" style="max-width:1920px;padding:0;border-width:0;" width="184">
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
                                                                                                    <img align="left" alt="" class="kmImage" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/AppStore.png" style="max-width:767px;" width="157">
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
                                                                                                    <img align="center" alt="" class="kmImage" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/GPlay.png" style="max-width:1004px;" width="158">
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
                                                                                                                                    <a href="https://www.facebook.com/CosmoSW.Tech/" target="_blank"><img alt="Button Text" class="kmButtonBlockIcon" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/facebook_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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
                                                                                                                                    <a href="https://www.instagram.com/cosmotogether/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/instagram_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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
                                                                                                                                    <a href="https://www.pinterest.com/cosmotogether/_saved/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/pinterest_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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
                                                                                                                                    <a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/youtube_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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

	public function sendMailtwo($to)
    {
    //echo "string";
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
            $mail->Port       = SMTPPORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
          //  $mail->setFrom('vijaya.jha@codeclouds.in', 'COSMO');
             $mail->setFrom(SMTPSENDEREMAIL, 'COSMO');
            $mail->addAddress($to, '');     //Add a recipient
         //   $mail->addAddress('vijaya.jha@codeclouds.in');               //Name is optional
            $mail->addReplyTo(SMTPSENDEREMAIL, '');
          

          

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


    public function sendConfirmationMail2($to,$order_number,$plan_type,$phone_number)
    {

        // echo $to;
        // echo $order_number;
        // echo $plan_type;
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
            $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(SMTPUSERNAME, 'Support Cosmotogether');

            // $mail->addAddress($to, '');     //Add a recipient
            $mail->addAddress($to);               //Name is optional
            //$mail->addReplyTo($to, '');
          
            $mail->addReplyTo(SMTPUSERNAME);


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Congratulation Your Cosmo Plan is Activated!';
            $mail->Body    = '


                <table border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="max-width: 100%;border-collapse: collapse;">
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
                                                                                    <img align="center" alt="" class="kmImage" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/banner.png" style="max-width:1920px;padding:0;border-width:0;" width="546">
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
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;"><span style="font-family: arial, helvetica, sans-serif;">Your <b><span class="template_variable">'.$plan_type.'</span>&nbsp;</b></span><span style="font-family: arial, helvetica, sans-serif;">subscription with unlimited talk, text, and&nbsp;data has been purchased.</span></div>
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;">&nbsp;</div>
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;"><span style="font-family: arial, helvetica, sans-serif;"></span></div>
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); margin-left: 0px; text-align: center;"><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"><strong>Order:</strong></span><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"> <span class="template_variable"> '.$order_number.'</span></span></div>
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); margin-left: 0px; text-align: center;"><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"><strong>Phone Number:</strong></span><span style="box-sizing: border-box; padding: 0px; margin: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; border-width: 0px; border-style: initial; border-color: initial; white-space: pre-wrap; font-family: arial, helvetica, sans-serif;"> <span class="template_variable" title=""> '.$phone_number.' </span></span></div>
                                                                                    <div style="font-size: 14px; color: rgb(0, 0, 0); text-align: center;">&nbsp;</div>
                                                                                    <div style="font-family: inherit; font-size: 14px; color: rgb(0, 0, 0); text-align: center;"><span style="font-size:20px;"><strong>Now it is time to pair with your watch!</strong></span></div>
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
                                                                                    <img align="left" alt="" class="kmImage" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/logo.png" style="max-width:1920px;padding:0;border-width:0;" width="184">
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
                                                                                                    <img align="left" alt="" class="kmImage" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/AppStore.png" style="max-width:767px;" width="157">
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
                                                                                                    <img align="center" alt="" class="kmImage" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/GPlay.png" style="max-width:1004px;" width="158">
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
                                                                                                                                    <a href="https://www.facebook.com/CosmoSW.Tech/" target="_blank"><img alt="Button Text" class="kmButtonBlockIcon" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/facebook_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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
                                                                                                                                    <a href="https://www.instagram.com/cosmotogether/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/instagram_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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
                                                                                                                                    <a href="https://www.pinterest.com/cosmotogether/_saved/" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/pinterest_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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
                                                                                                                                    <a href="https://www.youtube.com/channel/UCQTVNg3PDIRjd6Sqew157qg" target="_blank"><img alt="Custom" class="kmButtonBlockIcon" src="https://activate.cosmotogether.com/activate_dataplans/emailimage/youtube_96.png" style="width:48px; max-width:48px; display:block;" width="48"></a>
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
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>

                            ';
            

            //$mail->Body='<h1>test</h1>'; 
            $res=$mail->send();
           // print_r($res);
            return $res;
         //   echo 'Message has been sent';
        } catch (Exception $e) {
            echo "{$mail->ErrorInfo}";
        }
    }


}
?>