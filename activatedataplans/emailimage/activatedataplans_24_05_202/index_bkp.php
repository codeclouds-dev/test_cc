<?php

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charSet="utf-8"/>
      <title>COSMO Connect . Register</title>
      <meta name="viewport" content="initial-scale=1, viewport-fit=cover, width=device-width"/>
      <link rel="shortcut icon" href="images/icon-180x180-08f3b9876667.png" type="image/x-icon">
      <!--css-->

       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

      <!-- Optional theme -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">



      <link rel="stylesheet" href="<?= CSS_PATH.'register.css' ?>"/>
      <link rel="stylesheet" href="<?= CSS_PATH.'main.css' ?>"/>
   </head>

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
                        <div class="sc-efQSVx bMgScO" id="pagetitle">Register</div>
                        <div class="sc-jObWnj cnsYCp"></div>
                     </div>
                  </div>
                  
                  <div class="sc-kfPuZi nZPWp">
                     <div class="sc-jRQBWg sc-fKVqWL XgQax bSBlpa">Let's get started!</div>
                  </div>

                  <form class="sc-giYglK byxnZb" id="basic-form" action="javascript:void(0);" method="post">
                     <!-- <div class="sc-ezbkAF chsHjJ" id="fnamebox">
                        <div class="sc-jJoQJp jWzbvv">
                           <div class="sc-gWXbKe jqcrni">
                              <label for="fullName" class="sc-cCcXHH eqiPxk">Full Name</label>
                                <input name="fullName" type="text" autocomplete="name" id="fullName" class="sc-hiCibw hBuAsr required" >
                              <div class="sc-jcFjpl hIESFj">Required</div>
                           </div>
                           <p class="sc-cidDSM fRmzlX"></p>
                        </div>
                     </div> -->
                     <div class="sc-ezbkAF chsHjJ">
                        <div class="sc-jJoQJp jWzbvv">
                           <div class="sc-gWXbKe jqcrni">
                              <label for="email" class="sc-cCcXHH eqiPxk">Email</label>
                                 <input name="email" type="email" autocomplete="email" id="email" class="sc-hiCibw hBuAsr required">
                              <div class="sc-jcFjpl hIESFj" style="opacity: 0;">Required</div>
                           </div>
                           <p class="sc-cidDSM fRmzlX"></p>
                        </div>
                     </div>
                     <!-- <input type="checkbox" name="terms_cond" id="terms_cond" class="required" value="" onchange="changeval()"> -->
                      <div class="sc-ezbkAF sc-eJwWfJ chsHjJ bMgiWU" id="checkbox_div">
                        <label class="MuiFormControlLabel-root jss2">
                           <span class="MuiButtonBase-root MuiIconButton-root jss11 MuiCheckbox-root jss8 MuiCheckbox-colorSecondary jss12 Mui-checked MuiIconButton-colorSecondary" aria-disabled="false">
                              <span class="MuiIconButton-label">
                                 <input type="checkbox" name="terms_cond" id="terms_cond" class="required customcheck" value="1" checked="checked" style="display:none;">
                                 <div></div>
                                 <div class="sc-iJKOTD dHyrMW" id="chkboxs" onclick="showHide()">
                                    <div class="sc-dkPtRN hNBCZE" id="chkbox2">
                                       <svg width="12px" height="12px" viewBox="0 0 12 10" fill="white" xmlns="http://www.w3.org/2000/svg" color="white">
                                          <path fill-rule="evenodd" clip-rule="evenodd" d="M11.294 1.6a1 1 0 10-1.6-1.2L4.386 7.478 2.201 5.293A1 1 0 00.787 6.707l3 3A1 1 0 005.294 9.6l6-8z" fill="currentColor"></path>
                                       </svg>
                                    </div>
                                 </div> 
                              </span>
                           </span>
                           <span class="MuiTypography-root MuiFormControlLabel-label jss3 MuiTypography-body1">
                              <p class="sc-bBHxTw sc-iwjdpV gPzeVN hlpubN">I have read and agree to the<a href="javascript:void(0);">Terms of Service</a> and <a href="javascript:void(0);">Privacy Policy</a></p>
                              <p class="sc-bBHxTw sc-iwjdpV sc-cxpSdN gPzeVN hlpubN dyRZAG" id="errortermcond" style="display:none;">You have to accept the Terms of Service and Privacy Policy.</p>
                           </span>
                        </label>
                     </div> 

                     <div class="sc-ikJyIC fZlxnp">
                      
                        <button type="button" class="sc-bdvvtL llgOpg " style="transform: none;" id="submitform">
                           <div class="sc-gsDKAQ dSjqwF " id="loader">
                              <svg width="100%" height="100%" stroke="#fff" viewBox="0 0 38 38" class="svg-loaders-svg">
                                 <g transform="translate(1 1)" stroke-width="2" fill="none" fill-rule="evenodd">
                                    <circle stroke-opacity="0.5" cx="18" cy="18" r="18"></circle>
                                    <path d="M36 18c0-9.94-8.06-18-18-18">
                                       <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform>
                                    </path>
                                 </g>
                              </svg>
                           </div>
                           Register
                        </button>

                        <button type="button" class="sc-bdvvtL llgOpg " style="transform: none; display:none;" id="submitLoginform">
                           <div class="sc-gsDKAQ dSjqwF " id="loader">
                              <svg width="100%" height="100%" stroke="#fff" viewBox="0 0 38 38" class="svg-loaders-svg">
                                 <g transform="translate(1 1)" stroke-width="2" fill="none" fill-rule="evenodd">
                                    <circle stroke-opacity="0.5" cx="18" cy="18" r="18"></circle>
                                    <path d="M36 18c0-9.94-8.06-18-18-18">
                                       <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform>
                                    </path>
                                 </g>
                              </svg>
                           </div>
                           Login
                        </button>


                     </div>

                  </form>
                  <p class="sc-bBHxTw gPzeVN" onclick="performLogin()" id="login_box">Already a customer? <a href="#">Sign in</a></p>
                  <p class="sc-bBHxTw gPzeVN" onclick="register()" style="display:none;" id="newuser_box">New User? <a href="#">Register</a></p>
                  
               </div>
            </main>

            <div></div>

            <div class="sc-pVTFL cYosFl" id="userexist" style="display:none;">
               <div class="sc-jrQzAO bSuipU">
                  <div class="sc-kDTinF fqlkth">
                     <div class="sc-iqseJM dKTPEg" id="usertext">User already exists.</div>
                     <div class="sc-crHmcD dPPCDC"><button class="sc-egiyK gxhdhz" onclick="hideUserExist()">DISMISS</button></div>
                  </div>
               </div>
            </div>

         </div>
      </div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="asset/js/index_js/index.js"></script>

   </body>
</html>
