<?php



unset($_SESSION);

@session_start();

@ob_start();



//print_r($_SESSION);

require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/'.'Config.php';
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'activatedataplans/library/barebone/'.'Database.php';

   use Application\Database;



$db=new Database();

if(isset($_POST['submit']))

{

    $imeis=$_POST['fut_imeis'];

    $textDataOrder=PHP_EOL. $imeis;

    $result="<p class='normal-head'>"."Input IMEI: ".$imeis."</p>";

    $explode_imei=explode(',', $imeis);

    //print_r($explode_imei);

    for($i=0;$i<count($explode_imei);$i++)

    {

        //echo $explode_imei[$i];
        if($explode_imei[$i]!="")
        {
            $user_arr=array();

                $user_arr['table']=DEVICETABLE;

                $user_arr['selector']="id";

                $user_arr['condition']="where imei='".$explode_imei[$i]."' and product='JT3' and status not in('2','5')";



                $getUserDtls=$db->Select($user_arr);

               // print_r($getUserDtls);

                if(count($getUserDtls)>0)

                {

                    //echo "string";

                            $db->Update(DEVICETABLE,array('product'=>'FUT'),array("where id='".$getUserDtls[0]['id']."'"));

                            $textDataOrder.=PHP_EOL. $explode_imei[$i]. " updated successfully to FUT";

                             $result.="<p class='green'> ".$explode_imei[$i]. " updated successfully to FUT </p>";

                }

                else

                {

                        //echo "string2";

                            $textDataOrder.= $explode_imei[$i]. " not exist";

                            $result.="<p class='red'> ".$explode_imei[$i]. " not exist </p>";



                }

        }
                
    }





      



     $orderfile = fopen("../fut.txt", "a") or die("Unable to open file!");

     fwrite($orderfile, $textDataOrder);

     fclose($orderfile);

}

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

    <title>Enter FUT</title>

    <!-- Stylesheets -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/style.css"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />



    <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'bootstrap.min.css' ?>">

    <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'main-style1.css' ?>">

    <link rel="stylesheet" type="text/css" href="<?= CSS_PATH.'style1.css' ?>">

    <style>
        .formwrapper {
            max-width: 600px;
            margin: 0 auto;
            min-height: 100vh;
            padding: 10px 15px;
        }
        .innerform-wrapper p {
            margin-bottom: 10px !important;
            text-align: center;
            text-align: left;
            font-weight: 500;
        }
        .innerform-wrapper p.cst-head {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 20px !important;
        }
        .innerform-wrapper input.form-control.form-control-lg.submit-btn {
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
            width: 100%;
            font-size: 22px;
            font-weight: 600;
            height: auto;
            padding: 8px 15px;
            display: inline-block;
            line-height: 35px;
            text-transform: uppercase;
        }
        .innerform-wrapper p.red {
            color: red !important;
        }
        .innerform-wrapper p.green {
            color: green !important;
        }
    </style>



 

    <?php 

       include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'custom-script.php';





    ?>

</head>

<body>

    <div class="d-flex align-items-center justify-content-center formwrapper">
        <div class="innerform-wrapper">

            <p class="cst-head">Please eneter IMEIs comma seperated.</p>

            

           <form method="post">

                <input class="form-control form-control-lg mb-3" type="text" name="fut_imeis" id="fut_imeis" required>

                <input class="form-control form-control-lg submit-btn" type="submit" name="submit" id="submit" value="Submit">

           </form>
                       <p><?php if($result!=""){ echo $result; } ?></p>

        </div>
    </div>

    <!-- Scripts -->



<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>





        



<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>





  

</body>

</html>