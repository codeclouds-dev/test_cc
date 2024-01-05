
   $(document).ready(function() {
//alert('dd');


$("#email").focus();

		$("#userexist").hide();
             $( "#submitform" ).on('click', function(){

                   validateInput(this.id);




             });
	
		$( "#submitLoginform" ).on('click', function(){
		
			//alert(this.id);
			
                        validateInput(this.id);




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

   	function performLogin()
	{
		//$("#fullName").hide();
		$("#fnamebox").hide();
		//$("#fullName").next('div').hide();
		//$("#fullName").removeClass('required');
		$("#submitform").hide();
		$("#submitLoginform").show();
		$("#pagetitle").text('Login');
		$("#newuser_box").show();
		$("#login_box").hide();
		$("#checkbox_div").hide();
		$("#terms_cond").removeClass('required');

	}
	function register()
	{
		//$("#fullName").show();
		$("#fnamebox").show();
		//$("#fullName").addClass('required');
		$("#submitform").show();
		$("#submitLoginform").hide();
		$("#pagetitle").text('Register');
		$("#login_box").show();
		$("#newuser_box").hide();
		$("#checkbox_div").show();
		$("#terms_cond").addClass('required');

	}

   function validateInput(action){
//alert('ss');
       var validClass = 'no-error';
       var errorClass = 'has_error';
       var errors = new Array();

	
       $('[id=basic-form] .required').each(function(index){ 
           var input = $(this);
		//alert(input.type);
           if(input.hasClass('required')==true)
           {
               if(input.val().trim()=='')
               {
                   //alert('ss');
		   if(input.hasClass('customcheck')==false)
		   {
			input.addClass(errorClass).removeClass(validClass);

	           }
                   else{
			$("#chkboxs").addClass('sc-llYSUQ dhnWug');
			}

                 //  input.addClass(errorClass).removeClass(validClass);
                   //$("#chkboxs").addClass('sc-llYSUQ dhnWug');

                   errors.push('error');
                   $(this).next('div').css("opacity", "1");
               }
               else
               {
                   input.addClass(validClass).removeClass(errorClass);

if(input.hasClass('customcheck')==false)
		   {
			input.addClass(validClass).removeClass(errorClass);

	           }
                   else{
			$("#chkboxs").removeClass('sc-llYSUQ dhnWug');
			}


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
		if(action=='submitLoginform')
		{
			loginUser();
		}
		else
		{
			createUser();
		}
               

                 
             }
   }


   function isValidEmail(emailText)
   {
       var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
       return pattern.test(emailText);
   };

   function hideUserExist()
   {
	$("#userexist").hide();
   }
   function changeval()
   {
	if($("#terms_cond").prop('checked') == true){
   		 $("#terms_cond").val(1);
	}
	else
	{
		$("#terms_cond").val(0);
	}

   }


/*function showHide()
{

	if($("#terms_cond").prop('checked') == true){

   		 $("#terms_cond").val(1);
		$("#errortermcond").hide();
		$("#chkbox2").show();
		$("#chkboxs").addClass('sc-iJKOTD dHyrMW');
		$("#chkboxs").removeClass('sc-llYSUQ iFuFfU');

	}
	else
	{
		$("#chkbox2").hide();
		$("#chkboxs").addClass('sc-llYSUQ iFuFfU');
		$("#chkboxs").removeClass('sc-iJKOTD dHyrMW');

		
		$("#terms_cond").val('');
		$("#errortermcond").show();
		
	}
}*/

function showHide()
{

	if($("#terms_cond").prop('checked') == true){

	$("#chkbox2").hide();
		$("#chkboxs").addClass('sc-llYSUQ iFuFfU');
		$("#chkboxs").removeClass('sc-iJKOTD dHyrMW');

		
		$("#terms_cond").val('');
		$("#errortermcond").show();


	}
	else
	{
		
   		 $("#terms_cond").val(1);
		$("#errortermcond").hide();
		$("#chkbox2").show();
		$("#chkboxs").addClass('sc-iJKOTD dHyrMW');
		$("#chkboxs").removeClass('sc-llYSUQ iFuFfU');
		$("#chkboxs").removeClass('dhnWug');
		
	}
}

   function loginUser()
   {
	
        var email=$("#email").val();
       // console.log(email);

        $.ajax({

                  url : 'library/App.php',
                  type:'POST',
                  data : {
                     
                      'email':email,
                      'loginUser':1,
                      'functionName': 'sendMail',
                  },
                  dataType:'json',
                  success : function(data) {      

                      //alert('Data: '+data['success']);
                     // alert('OTP SENT');
			console.log('success');
			console.log(data);
			if(data.response==true)
			{
				window.location='verification.php';
			}
			else
			{
				$("#userexist").show();
				$("#usertext").text('User does not exist');
			}
                      

                  },
                  error : function(request,error)
                  {
			console.log(error);
                       $('#submitform').removeClass('fppiTo');

                       $('#loader').removeClass('iluFlH');

                     // alert("Request: "+JSON.stringify(request));
                      
                  }
              });
	}


   function createUser(){


       // var fname=$("#fullName").val();
        var email=$("#email").val();
                var channel=$("#channel").val();

       // console.log(fname);

        $.ajax({

                  url : 'library/App.php',
                  type:'POST',
                  data : {
                      //'fname' : fname,
                      'email':email,
                      'channel': channel,

                      'functionName': 'sendMail',
                  },
                  dataType:'json',
                  success : function(data) {      

                      //alert('Data: '+data['success']);
                     // alert('OTP SENT');
			console.log('success');
			console.log(data);
			if(data.response==true)
			{

				localStorage.setItem("email", data.email);
console.log(localStorage.getItem("email"));
				//window.location='verification.php';
				window.location='verify.php';
			}
			/*else
			{
				$("#userexist").show();
			}*/
                      

                  },
                  error : function(request,error)
                  {
			console.log(error);
                       $('#submitform').removeClass('fppiTo');

                       $('#loader').removeClass('iluFlH');

                     // alert("Request: "+JSON.stringify(request));
                      
                  }
              });


   }




