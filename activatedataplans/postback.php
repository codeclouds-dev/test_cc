<script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>

<script type="text/javascript">
  
        $.ajax({
          url: "https://postback.trackcb.com/custom-event/?event_type=cart_add&site_key=4228247636e14d29be024f8f94a514b1&oid=169&transaction_id={s2Value}&amount={productAmount}&adv_sub={clickID}&currency=USD",
          type: 'GET',
          dataType: 'jsonp',
          crossDomain: true ,
          headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Headers': '*'
          },     

        
          success: function (data){
            console.log(data);
         
          },
          error: function(data)
          {
            console.log(data);
          }
        })

</script>