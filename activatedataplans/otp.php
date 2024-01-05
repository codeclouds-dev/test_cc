<?php
@session_start();
print_r($_SESSION);

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charSet="utf-8"/>
      <title>COSMO Connect . Verify Email Address</title>
      <meta name="viewport" content="initial-scale=1, viewport-fit=cover, width=device-width"/>
      <link rel="shortcut icon" href="images/icon-180x180-08f3b9876667.png" type="image/x-icon">
      <!--css-->
      <link rel="stylesheet" href="<?= CSS_PATH.'register.css' ?>"/>
      <link rel="stylesheet" href="<?= CSS_PATH.'main.css' ?>"/>
   </head>
   <input type="text" name="email" id="email" value="<?=$_SESSION['userDtls']['email'];?>">
   <body class="text-gray-800">
      <div id="__next">
         <div class="sc-jIkXHa jElBwA">
            <main class="sc-gKclnd hmgNPn">
               <div class="sc-iCfMLu kVlbxJ">
                  <div class="sc-caiLqq bQYhvz">
                     <div class="sc-iUKqMP fNNbHR">
                        <div class="sc-cTAqQK gfQyJg">
                           <div class="sc-dkPtRN hNBCZE">
                              <svg width="24px" viewBox="0 0 24 25" fill="#000022" xmlns="http://www.w3.org/2000/svg" color="#000022">
                                 <path fill-rule="evenodd" clip-rule="evenodd" d="M15.707 4.297a1 1 0 010 1.414l-6.293 6.293 6.293 6.293a1 1 0 01-1.414 1.414l-7-7a1 1 0 010-1.414l7-7a1 1 0 011.414 0z" fill="currentColor"></path>
                              </svg>
                           </div>
                        </div>
                        <div class="sc-efQSVx bMgScO">Verify Email Address</div>
                        <div class="sc-jObWnj cnsYCp"></div>
                     </div>
                  </div>
                  <div class="sc-jeraig fiCoxp">
                     <p class="sc-jgrJph fnPDCN">Please enter the code we sent to<br><?=$_SESSION['userDtls']['email'];?></p>
                     <form class="sc-giYglK byxnZb" method="post" id="otpform">
                        <div class="sc-gSQFLo Akbdk">
                           <div class="sc-bBHHxi ffkkyP">
                              <div class="sc-khQegj fVOegv">
                                 <div class="sc-hUpaCq hpxZsK"></div>
                              </div>
                              <div class="sc-cNKqjZ iYhizq">
                                 <input aria-label="verification-code-0" name="otp[]" id="otp1" type="tel" maxlength="1" class="sc-AjmGg bBYiqD inputs required" value="" style="width: 42px; height: 48px;"  onkeypress="return isNumber(event)">
                                 <input aria-label="verification-code-1" name="otp[]"  id="otp2" type="tel" maxlength="1" class="sc-AjmGg bBYiqD inputs required" value="" style="width: 42px; height: 48px;"  onkeypress="return isNumber(event)" >
                                 <input aria-label="verification-code-2" name="otp[]" id="otp3" type="tel" maxlength="1" class="sc-AjmGg bBYiqD inputs required" value="" style="width: 42px; height: 48px;"  onkeypress="return isNumber(event)">
                                 <input aria-label="verification-code-3" name="otp[]" id="otp4" type="tel" maxlength="1" class="sc-AjmGg bBYiqD inputs required" value="" style="width: 42px; height: 48px;"  onkeypress="return isNumber(event)">
                                 <input aria-label="verification-code-4" name="otp[]" id="otp5" type="tel" maxlength="1" class="sc-AjmGg bBYiqD inputs required" value="" style="width: 42px; height: 48px;"  onkeypress="return isNumber(event)">
                                 <input aria-label="verification-code-5" name="otp[]" id="otp6" type="tel" maxlength="1" class="sc-AjmGg bBYiqD inputs required" value="" style="width: 42px; height: 48px;"  onkeypress="return isNumber(event)">

                                 <!--<input type="tel" name="otp" id="otp" class="hBuAsr required" maxlength="6" minlength="6" pattern="[0-9]*">-->

                              </div>
                           </div>
                        </div>
                        <button type="button" class="sc-bdvvtL llgOpg" id="submitform">
                           <div class="sc-gsDKAQ dSjqwF">
                              <svg width="100%" height="100%" stroke="#fff" viewBox="0 0 38 38" class="svg-loaders-svg">
                                 <g transform="translate(1 1)" stroke-width="2" fill="none" fill-rule="evenodd">
                                    <circle stroke-opacity="0.5" cx="18" cy="18" r="18"></circle>
                                    <path d="M36 18c0-9.94-8.06-18-18-18">
                                       <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform>
                                    </path>
                                 </g>
                              </svg>
                           </div>
                           Verify
                        </button>
                     </form>
                     <div class="sc-lbhJGD dotxbT"><button class="sc-iNGGcK hsGcqx" onclick="resendOTP()" style="cursor:pointer;">Resend security code</button></div>
                  </div>
               </div>
            </main>

            <div></div>

            <div class="sc-pVTFL cYosFl" id="incorrect_msg_block" style="display: none;">
               <div class="sc-jrQzAO bSuipU">
                  <div class="sc-kDTinF fqlkth">
                     <div class="sc-iqseJM dKTPEg" id="message">The security code is empty or incorrect</div>
                     <div class="sc-crHmcD dPPCDC"><button class="sc-egiyK gxhdhz" onclick="hideIncorrect()">DISMISS</button></div>
                  </div>
               </div>
            </div>
            


         </div>
      </div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.js"></script>


<script src="asset/js/otp.js"></script>
<script type="text/javascript">
  


 // $('.inputs').keyup(function(e)
 // {
 //   if(e.keyCode == 8)
 //   {
 //      $(this).prev('.inputs').focus();
 //   }

 // });

</script>

   </body>
</html>