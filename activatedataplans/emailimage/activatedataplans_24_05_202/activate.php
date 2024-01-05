<?php 
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Config.php';

if(isset($_GET['charge_id']) and $_GET['charge_id']!="")
{
	echo $charge_id=$_GET['charge_id'];
}
else
{
	?>

	<p>Something went wrong!</p>
	<?php
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		Activate
	</title>
</head>
<body>

<p><button id="activate_btn" onclick="activateDataplan()">Activate Dataplan Now</button></p>

<p id="loading" style="display: none;"><img src="<?= IMAGE_PATH.'loader.gif'?>" alt="loader"></p>

<div id="success" style="display: none;">
	<p>Plan Activated</p>
	<p id="phone_number"> </p>
</div>
<div id="error" style="display: none;">
	<p id="error_msg"></p>
	<p id="retry" onclick="activateDataplan()" style="display:none;">Retry</p>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<script type="text/javascript">
	
	// $( document ).ready(function() {
    	
 //    	activateDataplan();

	// });

function activateDataplan()
{
	var charge_id='<?=$charge_id?>';
	$("#loading").show();
	$("#activate_btn").hide();
   $.ajax({
            type: 'POST',
            url: 'activateDataplan.php',
            data: {"charge_id":charge_id},
            dataType: 'json',
           // crossDomain:true,
            
            success: function(data) { 
            	$("#loading").hide();
				//console.log(data);
				//alert(data.phone);
				if(data.response==true)
				{
					$("#phone_number").text(data.phone);
					$("#success").show();
				}
				else
				{
					$("#error_msg").text(data.message);
					$("#error").show();
				}
				
            },

             error : function(request,error)
	         {
	         		
	                alert(error);
	 				
	               
	              
	               
	         }



          });
}

</script>

</body>
</html>
