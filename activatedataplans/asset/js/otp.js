$( document ).ready(function() {
   $("#otp1").focus();
});


$(document).keyup(function(event) {




    if (event.which === 13) {
      

	var otp1= $("#otp1").val();
	var otp2=$("#otp2").val();
	var otp3=$("#otp3").val();
	var otp4=$("#otp4").val();
	var otp5=$("#otp5").val();
	var otp6=$("#otp6").val();
	
	var str=otp1+otp2+otp3+otp4+otp5+otp6;
	//alert(str);

if(str.length==6)
{


	$("#submitform").click();
}
    }
});
   $(document).ready(function() {




/*$("#otp1").bind("paste", function(e){

	var pastedData = e.originalEvent.clipboardData.getData('text');
	//alert(pastedData.length);
	//alert(!isNaN(pastedData));

	if(isNaN(pastedData))
	{
		return false;
	}
	if (5 < pastedData.length && !isNaN(pastedData)) {
	
	

	$("#otp1").val( pastedData[0]);
	$("#otp2").val( pastedData[1]);
	$("#otp3").val( pastedData[2]);
	$("#otp4").val( pastedData[3]);
	$("#otp5").val( pastedData[4]);
	$("#otp6").val( pastedData[5]);
	//return false;

	$("#submitform").click();
	}

	
});
*/

$('#otp1').on('paste', function(e) {
var pastedData = e.originalEvent.clipboardData.getData('text');

	if(isNaN(pastedData) || pastedData.length<6)
	{
		return false;
	}
	if (5 < pastedData.length && !isNaN(pastedData)) {
	
	

	$("#otp1").val( pastedData[0]);
	$("#otp2").val( pastedData[1]);
	$("#otp3").val( pastedData[2]);
	$("#otp4").val( pastedData[3]);
	$("#otp5").val( pastedData[4]);
	$("#otp6").val( pastedData[5]);
	//return false;

	$("#submitform").click();
	}


});




          $("#incorrect_msg_block").hide();

             $( "#submitform" ).on('click', function(){

                   validateInput();




             });


            $('input').on('focus', function(){

               $(this).prev('label').addClass('crRanX');

                 
            });

            $('input').on('blur', function(){

               if($(this).val() == ''){

                  $(this).prev('label').removeClass('crRanX');
               }
               
                 
            });




   });


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}


$(".inputs").keyup(function () {
    if (this.value.length == this.maxLength) {
      $(this).next('.inputs').focus();
    }
});


   function validateInput(){

       var validClass = 'no-error';
       var errorClass = 'has_error';
       var errors = new Array();

       $('input').each(function(index){ 
           var input = $(this);
           if(input.hasClass('required')==true)
           {
               if(input.val().trim()=='')
               {
                   
                   input.addClass(errorClass).removeClass(validClass);
                   
                   errors.push('error');
                   $(this).next('div').css("opacity", "1");
               }
               else
               {
                   input.addClass(validClass).removeClass(errorClass);
                   $(this).next('div').css("opacity", "0");
                   if(input.attr('name')=='email')
                   {
                       if(!isValidEmail($('input[name=email]').val()))
                       {

                           input.addClass(errorClass).removeClass(validClass);
                            errors.push('error');
                       } 
                       else
                       {
                          input.addClass(validClass).removeClass(errorClass);
                       }               
                   }
                   // input.next("span").remove();         
               }
           }
       });

      // console.log(errors)

          if(errors.length==0)
             {

               $('#submitform').addClass('fppiTo');

               $('#loader').addClass('iluFlH');

               //createUser();
	       validateOTP();
                 
             }
   }


   function isValidEmail(emailText)
   {
       var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
       return pattern.test(emailText);
   };


   function validateOTP(){


        //var otp=$("#otp").val();
       var otp1=$("#otp1").val();
       var otp2=$("#otp2").val();
       var otp3=$("#otp3").val();
       var otp4=$("#otp4").val();
       var otp5=$("#otp5").val();
       var otp6=$("#otp6").val();
       
        //console.log(otp);

        $.ajax({

                  url : 'library/App.php',
                  type:'POST',
                  data : {
                      'otp1' : otp1,
		      'otp2':otp2,
		       'otp3':otp3,
			'otp4':otp4,
			'otp5':otp5,
			'otp6':otp6,

                      'functionName': 'validateOTP',
                  },
                  dataType:'json',
                  success : function(data) {      

                    
			
			//console.log(data);
			if(data.response==true)
			{

				localStorage.setItem("email", data.email);
				//console.log(localStorage.getItem('email'));
				window.location.href='verify.php';
			}
			else if(data.response==false)
			{
                                
				$("#message").text(data.message);
				$("#incorrect_msg_block").show();
				$("#otp1").val('');
				$("#otp2").val('');
				$("#otp3").val('');
				$("#otp4").val('');
				$("#otp5").val('');
				$("#otp6").val('');
					
				
			}
                        else
			{
				window.location='user_dashboard.php';
			}
                      

                  },
                  error : function(request,error)
                  {
			//console.log(error);
                       $('#submitform').removeClass('fppiTo');

                       $('#loader').removeClass('iluFlH');

                     // alert("Request: "+JSON.stringify(request));
                      
                  }
              });


   }




   function hideIncorrect()
   {
      $("#incorrect_msg_block").hide();
   }

$("#resend").on('click', function(){
resendOTP();

});
   function resendOTP()
   {

	var mail=$("#email").val();
	//alert(mail);
	$.ajax({

                  url : 'library/App.php',
                  type:'POST',
                  data : {
                      'mail' : mail,
                      'functionName': 'resendMail',
                  },
                  dataType:'text',
                  success : function(data) {      

                     $("#message").text('Verification code sent to: '+mail);
                       $("#incorrect_msg_block").css('display','flex');
			//alert('OTP SENT');
			//console.log('success');
			//console.log(data);
			
                      

                  },
                  error : function(request,error)
                  {
			//console.log(error);
                  
                     // alert("Request: "+JSON.stringify(request));
                      
                  }
              });

   }
