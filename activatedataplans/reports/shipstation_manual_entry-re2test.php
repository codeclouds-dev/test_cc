<?php
    @session_start();
    @ob_start();

    //print_r($_SESSION);
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/'.'Config.php';
    require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/barebone/'.'Database.php';

    use Application\Database;
    $db=new Database();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Refurbed Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
  <script type="text/javascript">

        // const timezonePhp = Intl.DateTimeFormat().resolvedOptions().timeZone;
        // $.ajax({
        //         url: 'manual_webhook_session.php',
        //         type: 'POST',
        //         dataType:"json",
        //         cache: false,
        //         data: {
        //             timezonePhp: timezonePhp,
        //             fnName : 'set',
        //         },
        //         success: function(data){
        //             console.log(data);
        //         }
        //     });
  </script>

  <?php
  //fix for onload time zone issuue
  // if (empty($_SESSION["timezonePhp"])){
  //     header("Refresh:0");
  // }
  ?>

  <style>
    body {
        font-family: 'Poppins', sans-serif;
    }
    form.cust-form .col-md-4.pl-0 {
        padding-left: 0;
    }
    form.cust-form {
        margin-top: 2rem;
    }
    .ext-mrg {
        margin-top: 2rem;
    }
    button#export {
        color: #fff;
        padding: 0.6rem 1.875rem;
        font-size: 1.4rem;
        background: #004FEB;
        border: transparent;
        border-radius: 4px;
        font-weight: 700;
    }
    input#submit {
        color: #000;
        padding: 0.6rem 1.875rem;
        font-size: 1.4rem;
        background: #ddd;
        border: transparent;
        border-radius: 4px;
        font-weight: 700;
    }

    .col-md-12.scroll-page {
        overflow-x: scroll;
    }

    @media (max-width: 670px){
       form.cust-form .col-md-4 {
        margin-bottom: 2rem;
       }
        form.cust-form .col-md-4 {
        margin-bottom: 2rem;
        text-align: center;
       }
       .col-md-4.col-12.text-right.ext-mrg {
          text-align: center;
       }
    }

    .px-30{padding-right: 15px;padding-left: 15px}
    @media (min-width: 991px){
     .px-30{padding-right: 30px;padding-left: 30px}
    }

    form#manual_entry_form button#form_submit {
        background: #004feb;
        font-size: 0.875rem;
        font-weight: 500;
        border: transparent;
        border-radius: 0.313rem;
        color: #fff;
        padding: 0.5rem 2rem;
        transition: all 0.3s linear;
    }
    form#manual_entry_form button#form_submit:hover {
        background: #0a3c9b;
    }
    .form_wrap {
        width: 100%;
        height: 100dvh;
        background: #f5f5f7;
    }
  </style>
</head>
<body>
<div class="form_wrap pt-5">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 col-lg-6">
                <form action="" id="manual_entry_form" method="post">
                    <b>Order Number :</b> <input type="text" name="order_number" id="order_number" value="" placeholder="Enter Order Number" class="form-control my-3">
                    <!-- <input type="submit" name="submit" id="form_submit"> -->
                    <button type="button" id="form_submit">Submit</button>
                </form>
            </div>
        </div>  
    </div>
</div>

<?php
    // function UTCtoLocal ($dateTime){
    //     if (empty($_SESSION["timezonePhp"])) { 
    //         return $dateTimeUTC = $dateTime;
    //     } else {
    //         $dateTime = $dateTime; 
    //         $tz_from = $_SESSION["timezonePhp"]; 
    //         $newDateTime = new DateTime($dateTime, new DateTimeZone($tz_from)); 
    //         $newDateTime->setTimezone(new DateTimeZone("UTC")); 
    //         return $dateTimeUTC = $newDateTime->format("Y-m-d H:i:s");
    //     }
    // }
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
<script src="../asset/js/jquery-dateformat.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        // const timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        // $("#form_submit").submit(function(e) {
        $('body').on('click', '#form_submit', function(e){
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#form_submit').attr('disabled','disabled');
            var form = $(this);
            var actionUrl   = 'https://activate.cosmotogether.com/activatedataplans/shipstation_webhook_manual.php';
            var orderNumber = $('#order_number').val();

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: {order_number: orderNumber},
                success: function(response){
                    //console.log(response); // show response from the php script.
                    $('#form_submit').removeAttr('disabled');
                    if($.trim(response) == "success"){
                        alert("Order saved successfully");
                    } else if($.trim(response) == "exists"){
                        alert("Order already exists");
                    } else {
                        alert("Error. Please try again");
                    }
                }
        	});
        });

});
</script>

</body>
</html>



