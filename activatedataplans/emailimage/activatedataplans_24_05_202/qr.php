<?php
@session_start();
@ob_start();

//print_r($_SESSION);
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'GlobalFunctions.php';

// include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'barebone' . DIRECTORY_SEPARATOR . 'Database.php';

// use Application\Database;

$checkuserexists=checkUserActive();
if(!$checkuserexists)
{
  
    header('location: index.php');
    exit();

}
// if(isset($_SESSION['userActive']) and $_SESSION['userActive']==$_GET['uid'])
// {
//     if(!isset($_GET['uid']))
//     {
//        header('Location: index.php');
       
//     }
//     else
//     {
        
//         $db=new Database();
        
//         $user_dtls_arr=array();
//         $user_dtls_arr['table']='user_mstr';
//         $user_dtls_arr['selector']='count(id) as count';
//         $user_dtls_arr['condition']="where md5(id)='".$_GET['uid']."'";

//         $isValidUser=$db->Select($user_dtls_arr);
//         //print_r($isValidUser);
//         if($isValidUser[0]['count']==0)
//         {
//             header('Location: index.php');
//         }

//     }

// }
// else
// {
//     header('Location: index.php');
// }

?>
<html>
<head>
    <title>Qrcode</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

      <link rel="stylesheet" href="<?= CSS_PATH.'register.css' ?>"/>
      <link rel="stylesheet" href="<?= CSS_PATH.'main.css' ?>"/>


    <style type="text/css">
        body {
            font-family: 'Lato', sans-serif;
        }
     
        .qrcode_box p:nth-child(1) {
            font-size: 24px;
            line-height: normal;
            font-weight: bold;
        }
        .qrcode_box p:nth-child(2) {
            margin-bottom: 60px;
            font-size: 18px;
            line-height: normal;
        }

        .qrcode_box {
            display: flex;
            width: 100%;
            height: 100vh;
            align-items: center;
            flex-direction: column;
        }
        #qr-reader {
            margin: 0 auto;
        }
    </style>
<body>

   <div class="qrcode_box"> 
    <p>Scan Your Device</p>
    <p>Please place the QR code in front of the camera that is present on back of the watch.</p>

    <div id="qr-reader" style="width:500px"></div>

    <p onclick="showImeiBox()" style="cursor: pointer;">Enter Manually</p>
    <div id="imeiBox" style="display:none;">
        <form method="post" id="basic-form" action="verify.php">
            <input type="text" name="imei_no" id="imei_no" maxlength="19" class="required hBuAsr " value="">
            <button type="button" class="sc-bdvvtL llgOpg " style="transform: none;" id="submitform">Submit</button>
        </form>
    </div>
    </div>


    
</body>
<!-- <script src="https://unpkg.com/html5-qrcode"></script> -->
<script src="asset/js/html5-qrcode.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="asset/js/qr.js"></script>

<script>
   // A $( document ).ready() block.
    $( document ).ready(function() {


        $("#qr-reader__dashboard_section_swaplink").hide();
       // $("#qr-reader__dashboard_section_csr").children('span').eq(1).children('button').eq(1).attr('id','stop_scanning');
        $("#qr-reader__dashboard_section_csr").children('span').eq(1).children('button').eq(1).attr('id','ssss');

    //     $('#stop_scanning').on('click',function(){

    //     $("#qr-reader__dashboard_section_swaplink").hide();

    // });
    });





    function  showImeiBox() {
        $("#imeiBox").show();
    }
    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete"
            || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                console.log(`Scan result ${decodedText}`, decodedResult);

                if(decodedText != null){


                    $('#imei_no').val(decodedText);

                    if ($('#imei_no').val() !== null) {

                        $('#basic-form').submit();
                    }
                }

            }
        }

        function onScanError(errorMessage) {
            
            console.log('Something went wrong! Please type the IMI number manually')
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 200, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    });




</script>
</head>
</html>