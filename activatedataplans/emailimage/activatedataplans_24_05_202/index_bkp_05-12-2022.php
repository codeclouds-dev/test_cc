<?php

unset($_SESSION);
@session_start();
@ob_start();

//print_r($_SESSION);
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

$ua = strtolower($_SERVER["HTTP_USER_AGENT"]);
$isMob = is_numeric(strpos($ua, "mobile"));
//echo "///////////".$isMob;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
<!--     <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" /> -->
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="COSMO Smart Watch For Kids">
    <meta property="og:title" content="COSMO Smart Watch For Kids">
    <meta property="og:description" content="COSMO Smart Watch For Kids">
    <meta property="og:image" content="">
    <meta property="og:type" content="website">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="<?= IMAGE_PATH.'favicon.png' ?>" type="image/png">
    <link rel="icon" href="asset/images/favicon.png" type="image/png">
	<title>Enter IMEI</title>
	<!-- Stylesheets -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
	<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'bootstrap.min.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'main-style.css' ?>">
	<link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'style.css' ?>">

    <style>
        .error_popup .error_popup_box .try_btn{
            font-family: 'Neuzeit Grotesk', sans-serif !important;
        }
        @media not all and (min-resolution:.001dpcm) {
          @media {
              .error_popup .error_popup_box .try_btn{
                padding: 17px 30px 12px 30px !important;
                font-family: 'Neuzeit Grotesk', sans-serif !important;
              }
              
            }
        }
        @media screen and (max-width: 480px) {
            .error_popup .error_popup_box .try_btn{
                padding: 17px 30px 12px 30px !important;
            }
        }
        @media not all and (min-resolution:.001dpcm) {
          @media screen and (max-width: 767px) {
              .error_popup .error_popup_box .try_btn{
                padding: 17px 30px 12px 30px !important;
              }
            }
        }
        
    </style>
    <?php 
       include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'custom-script.php';


    ?>
</head>
<body>
	<!-- Main Starts Here -->
	<main>
		
        <?php 
        if(!$isMob)
        {

           // echo "string";
        ?>
		<!-- Enter IMEI Section Starts Here -->
        <div class="scanner_desktop1 scanner_content">
		<section class="enter_imei_sec scanner_content">
			<div class="container">
				<div class="enter_imei_custom_cont">
					<div class="row">
						<div class="col-12">
							<div class="enter_imei_box">
								<p class="txt1">Enter IMEI number</p>
								<p class="txt2">Enter the 15-digit number on the back of your watch.</p>
								<img src="<?= IMAGE_PATH.'scan_hologram.png' ?>" alt="Scan Hologram" class="img-fluid d-block mx-auto">

								 <form method="post" id="basic-form">
									<input type="tel" name="imei_no" placeholder="Enter IMEI" id="imei_no" maxlength="15"  minlength="15" class="form-control numberonly required">
									<span id="imei_msg" style="display:none; color:red;  "></span>
									<p style="text-align: center; display: none;" class="loading mt-3"><i class="fa-2x fa-solid fa-spinner fa-spin" id="variant1" style="color: blue;"></i></p>

									<div class="btn_box d-flex justify-content-between" id="btn_block">
										<button type="button" value="cancel" class="cancel_btn" onclick="window.location='https://cosmotogether.com/pages/mission-control-app-download'">Cancel</button>
										<button type="button" value="connect" class="connect_btn" id="submitform">Connect</button>
									</div>

								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
        </div>
		<!-- Enter IMEI Section Ends Here -->

        <?php 
        }
        if($isMob)
        {

           // echo "string";
        ?>
            <div class="scanner_mobile1 scanner_content">
             <section class="container px-0" id="demo-content" class="scanner_content">
                    <!-- <h1 class="title">Scan QR Code </h1> -->

                    <div class="scan_page_box d-flex align-items-center position-relative">
                        <div class="scan_imei_box mx-auto">
                            <div>
                                <video id="video" width="300" height="200" autoplay="true" muted="true" playsinline="true" class="d-block mx-auto border"></video>
                            </div>
                            <button class="manual-btn d-block mx-auto mt-3" onclick="showImeiBox()">Enter code manually</button>
                        </div>

                        <div class="scan-fxdbtn">
                            <button class="text-left mr-4 px-3" onclick="window.location.href='https://cosmotogether.com/pages/mission-control-app-download'"><i class='fas fa-arrow-left'></i> Back</button>
                        </div>

                        <div id="sourceSelectPanel" style="display:none">
                            <label for="sourceSelect">Change video source:</label>
                            <select id="sourceSelect" style="max-width:400px"></select>
                        </div>

                        <div style="display:none;">
                            <label>Result:</label>
                            <pre><code id="result"></code></pre>
                        </div>

                        <div class="manual_imei_box updated_manual position-fixed">
                            <div class="container">
                                <p class="text-center">Enter code manually</p>
                                            
                                <!-- <div class="imei_box_btns d-flex justify-content-between"> -->
                                    <!-- <button type="button" class="cancel_btn">Cancel</button> -->

                                    <form method="post" id="basic-form">
                                        <input type="tel" name="imei_no" id="imei_no" maxlength="15"  minlength="15" class="numberonly form-control required " value="" placeholder="Enter IMEI" >
                                        <span id="imei_msg" style="display:none; color:red;  "></span>
                                        <div class="imei_box_btns d-flex justify-content-between" id="btn_block">
                                            <button type="button" class="cancel_btn">Cancel</button>
                                            <button type="button" class="connect_btn" style="transform: none;" id="submitform">Connect</button>
                                        </div>
                                        <p style="text-align: center; display: none;" class="loading"><i class="fa-2x fa-solid fa-spinner fa-spin" id="variant1" style="color: blue;"></i></p>
                                    </form>

                                <!-- </div> -->
                                           
                            </div>
                        </div>
                    </div>

             </section>
            </div>
        <?php
        }
        ?>
	      <!-- Error Content Start -->
            <div class="error_content" style="display:none;">
                <!-- Error Main Body Start -->
                <section class="error_main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-md-4 pt-sm-4 pt-4 text-lg-center text-md-left">
                                <img src="<?= IMAGE_PATH.'logo-white.png' ?>" srcset="<?= IMAGE_PATH.'logo-white@2x.png 2x' ?>, <?= IMAGE_PATH.'logo-white@3x.png 3x' ?>" alt="logo-white" class="img-fluid white-logo mb-lg-3 mb-2">
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Error Main Body End -->
                <!-- Error Popup Start -->
                <div class="error_popup">
                    <div class="error_popup_box">
                        <div class="popup-info text-center px-2" id="contact_custspt">
                            <img src="<?= IMAGE_PATH.'link_broken.png' ?>" srcset="<?= IMAGE_PATH.'link_broken@2x.png 2x' ?>, <?= IMAGE_PATH.'link_broken@3x.png 3x' ?>" alt="signal-icon" class="img-fluid signal-icon">
                            <h4>Oh no, something went wrong</h4>
                            <p class="p1" id="error_message"></p>
                            <!-- <p class="p2"><a onclick="location.reload();" style="color:blue; cursor: pointer;" id="scan_link">Enter IMEI Again</a></p> -->
                            <a onclick="location.reload();"  style="color:white; cursor: pointer;" id="scan_link" class="try_btn">Try Again</a>
                            <!-- <p class="p2">Not activating?</p> -->
                            <p class="p3"><a href="javascript:void(0);" class="support_popup_btn" id="contact_btn">Contact customer support for assistance.</a></p>
                        </div>
                        <div class="error_support_popup_box d-none d-md-block" >
                            <div class="error_support_popup">
                                <div class="container">
                                    <p class="text-center popup_hd">Contact customer support</p>
                                    <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="desk_phone1">
                                    </div>
                                    <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                        <div class="txt">
                                            <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                            <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                        </div>
                                        <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon" id="desk_email1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="error_support_popup_box d-block d-md-none" >
                        <div class="error_support_popup">
                            <div class="container">
                                <p class="text-center popup_hd">Contact customer support</p>
                                <div class="support_dtls support_dtls1 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'call_icon.png' ?>" srcset="<?= IMAGE_PATH.'call_icon.png 1x' ?>, <?= IMAGE_PATH.'call_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'call_icon@3x.png 3x' ?>" alt="Call Assistance" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Call us<span class="d-block"><a href="tel:(877) 215-4741">(877) 215-4741</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon"  id="mob_phone1">
                                </div>
                                <div class="support_dtls support_dtls2 d-flex justify-content-between align-items-center">
                                    <div class="txt">
                                        <img src="<?= IMAGE_PATH.'mail_icon.png' ?>" srcset="<?= IMAGE_PATH.'mail_icon.png 1x' ?>, <?= IMAGE_PATH.'mail_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'mail_icon@3x.png 3x' ?>" alt="Email Support" class="img-fluid d-inline-block align-middle icon">
                                        <p class="d-inline-block align-middle">Email us<span class="d-block"><a href="mailto:support@cosmotogether.com">support@cosmotogether.com</a></span></p>
                                    </div>
                                    <img src="<?= IMAGE_PATH.'arrow_icon.png' ?>" srcset="<?= IMAGE_PATH.'arrow_icon.png 1x' ?>, <?= IMAGE_PATH.'arrow_icon@2x.png 2x' ?>, <?= IMAGE_PATH.'arrow_icon@3x.png 3x' ?>" alt="Arrow" class="img-fluid arrow_icon"  id="mob_email1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Error Popup End -->
            </div>
            <!-- Error Content End -->
            
	</main>
	<!-- Main Ends Here -->

	<!-- Scripts -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script type="text/javascript" src="asset/js/newqr.js?version=<?= time() ?>"></script>

<script type="text/javascript" src="asset/js/bodyScrollLock.js"></script>
<?php 
if($isMob)
{
?>
   <script type="text/javascript">
            function decodeOnce(codeReader, selectedDeviceId) {
              codeReader.decodeFromInputVideoDevice(selectedDeviceId, 'video').then((result) => {
                console.log(result)
                document.getElementById('result').textContent = result.text
              }).catch((err) => {
                console.error(err)
                document.getElementById('result').textContent = err
              })
            }

            function decodeContinuously(codeReader, selectedDeviceId) {
              codeReader.decodeFromInputVideoDeviceContinuously(selectedDeviceId, 'video', (result, err) => {
                if (result) {
                  // properly decoded qr code
                 // console.log('Found QR code!', result);
                 // alert(result);
                   // checkImeiExists();
                         $('#imei_no').val(result);

                            if ($('#imei_no').val() !== null) {

                                //$('#basic-form').submit();
                                checkImeiExists();
                            }
                  document.getElementById('result').textContent = result.text
                }

                if (err) {
                  // As long as this error belongs into one of the following categories
                  // the code reader is going to continue as excepted. Any other error
                  // will stop the decoding loop.
                  //
                  // Excepted Exceptions:
                  //
                  //  - NotFoundException
                  //  - ChecksumException
                  //  - FormatException

                  if (err instanceof ZXing.NotFoundException) {
                    console.log('No QR code found.')
                  }

                  if (err instanceof ZXing.ChecksumException) {
                    console.log('A code was found, but it\'s read value was not valid.')
                  }

                  if (err instanceof ZXing.FormatException) {
                    console.log('A code was found, but it was in a invalid format.')
                  }
                }
              })
            }

            window.addEventListener('load', function () {
              let selectedDeviceId;
              const codeReader = new ZXing.BrowserQRCodeReader()
              console.log('ZXing code reader initialized')

              codeReader.getVideoInputDevices()
                .then((videoInputDevices) => {
                  const sourceSelect = document.getElementById('sourceSelect')
                 // selectedDeviceId = videoInputDevices[0].deviceId
                  if (videoInputDevices.length >= 1) {
                    videoInputDevices.forEach((element) => {
                      const sourceOption = document.createElement('option')
                      //alert(element);
                      console.log(element.label);
                      var label=element.label;

                      if(label.includes("back"))
                      {
                         selectedDeviceId = element.deviceId;
                        sourceOption.text = element.label
                          sourceOption.value = element.deviceId
                          sourceSelect.appendChild(sourceOption)
                      }
                     // alert(selectedDeviceId);
                      // sourceOption.text = element.label
                      // sourceOption.value = element.deviceId
                      // sourceSelect.appendChild(sourceOption)
                    })

                    sourceSelect.onchange = () => {
                      selectedDeviceId = sourceSelect.value;
                    };

                  //  const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                   // sourceSelectPanel.style.display = 'block'
                  }

                 
                  //  const decodingStyle = document.getElementById('decoding-style').value;
                    const decodingStyle='continuously';
                    if (decodingStyle == "once") {
                      decodeOnce(codeReader, selectedDeviceId);
                    } else {
                      decodeContinuously(codeReader, selectedDeviceId);
                    }

                    console.log(`Started decode from camera with id ${selectedDeviceId}`)
                 

              

                })
                .catch((err) => {
                  console.error(err);
                  alert(err);
                })
            });

            $('#imei_no').on('focus', function(){

                const targetElement = document.querySelector('.manual_imei_box');
                bodyScrollLock.disableBodyScroll(targetElement);
                console.log('hi');

            });

        </script>

<?php
    }
?>
        

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="asset/js/qr.js<?= VERSION ?>"></script>    

  <script>


$(document).click(function(e) {

  // check that your clicked
  // element has no id=info

  if( e.target.id != 'contact_btn' && e.target.id != 'desk_phone1' && e.target.id != 'desk_email1' && e.target.id != 'mob_phone1' && e.target.id != 'mob_email1'  ) {
  console.log('wwwwwww',e.target);

    $('.error_support_popup_box').removeClass('active');
                    $('.error_support_popup').css('bottom','-100%');

  }
});


// $(".error_support_popup_box").on('blur',function(){
//       $('.error_support_popup_box').removeClass('active');
//                     $('.error_support_popup').css('bottom','-100%');
// });

            function  showImeiBox() {

               // $("#imei_no").focus();
                //$("#imeiBox").show();
            }


            $(document).ready(function(){
             
                    // codeReader.reset();
                    // codeReader.stopContinuousDecode();
//alert('sssss');
                $('.support_popup_btn').click(function(e){
                     e.preventDefault();
                    $('.error_support_popup_box').addClass('active');
                    $('.error_support_popup').css('bottom','0');
                    
                });


                $('.manual_imei_box').css('bottom','-100%');
                $('.manual-btn').click(function(){
                    // $('.manual_imei_box').css('bottom','0');
                    $('.manual_imei_box').css({
                        'bottom':'0',
                        'opacity':'1',
                        'visibility':'visible',
                        
                    });

                    setTimeout(function(){ $("#imei_no").focus(); },500);


                });
                

                $('.cancel_btn').click(function(){
                    // $('.manual_imei_box').css('bottom','-100%');
                    $('.manual_imei_box').css({
                        'bottom':'-100%',
                        'opacity':'0',
                        'visibility':'hidden',
                       
                    });
                });

                 $('.numberonly').keypress(function (e) {    
    
                var charCode = (e.which) ? e.which : event.keyCode    
    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
    
                    return false;                        
    
            });    


            });
        </script>

	<script src="asset/js/jquery-3.6.0.min.js" type="text/javascript"></script>
	<script src="asset/js/bootstrap.bundle.min.js" type="text/javascript"></script>
	<script>
		// First we get the viewport height and we multiple it by 1% to get a value for a vh unit
		let vh = window.innerHeight * 0.01;
		// Then we set the value in the --vh custom property to the root of the document
		document.documentElement.style.setProperty('--vh', `${vh}px`);

		// We listen to the resize event
		window.addEventListener('resize', () => {
			// We execute the same script as before
			let vh = window.innerHeight * 0.01;
			document.documentElement.style.setProperty('--vh', `${vh}px`);
		});
	</script>
    <script src="//fw-cdn.com/2239608/2902551.js" chat="true"></script>


</body>
</html>