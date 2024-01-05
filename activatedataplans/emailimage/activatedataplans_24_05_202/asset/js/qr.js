
   $(document).ready(function() {
$("#imei_msg").hide();
$("#imei_no").focus();
             $( "#submitform" ).on('click', function(){

                   validateInput();




             });


          



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
                   
               }
               else
               {
                   input.addClass(validClass).removeClass(errorClass);
                   //$(this).next('div').css("opacity", "0");
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
		   if(input.val().length!=15)
		   {
			input.addClass(errorClass).removeClass(validClass);
                            errors.push('error');
			$("#imei_msg").text('IMEI should be 15 digits');
			$("#imei_msg").css({'display':'block','margin-top':'-25px'});
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
$("#btn_block").removeClass("d-flex").addClass("d-none");
$(".loading").show();
              //$('#basic-form').submit();
		checkImeiExists();
		              

             }
   }


   function isValidEmail(emailText)
   {
       var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
       return pattern.test(emailText);
   };

   /*$("#submitform").on('click',function(){
			
		checkImeiExists();
	});*/
function checkImeiExists()
{


	var imei_no=$("#imei_no").val();

  $.ajax({

                  url : 'library/App.php',
                  type:'POST',
                  data : {
                      
                      'imei_no':imei_no,
                      'functionName': 'checkImeiExists',
                  },
                  dataType:'json',
                  success : function(data) {      

                     
			console.log(data);
			if(data.response==true)
			{
				//alert('if');
				window.location='user.php';
			}
			else
			{
				//alert('else');
				if(data.message=='gigs')
				{
					window.location='https://cosmo-connect.gigs.tel/';
				}
				else
				{
					$(".scanner_content").hide();
					//$("#demo-content").hide();
					$("#error_message").text(data.message);
					$(".error_content").show();
				}
				
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



