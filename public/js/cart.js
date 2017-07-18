$(document).ready(function() {
  alert("hi there");
  var productandqty = [];
  var searchresult = "not found";
  $("[type='number']").change(function() {
  	for(i = 0; i < productandqty.length; ++i)
  	{
  		if(productandqty[i].attr("id") == $(this).attr("id"))
  		{
  			productandqty[i] = $(this);
  			searchresult = "found";
  		}

  	}
  	
  	if(searchresult != "found")
  	{
  		productandqty.push($(this));
  	}
  	
  

  
  });


$("#savechanges").click(function() {

  var sum = 0;
  var qty = [];
  var price = [];
  var shipping = 10;
  $("[type='number']").each(function() {
    
    qty.push($(this).val());
  }); 
  
  $("[id='price']").each(function() {
  
  price.push($(this).html());
  });
 
  for(i = 0; i < qty.length; ++i)
  {
  	sum = sum + (qty[i] * price[i]);
  }
  $("#subtotal").html('$'+sum);
  $("#total").html('$'+ (sum + 10));
  
  for(i = 0; i < productandqty.length; ++i)
   
  {
     
      $.ajax({
   url:"updatecart.php",
   type:"post",
   data:"pid=" + productandqty[i].attr("id") + "&qty=" + productandqty[i].val(),
   success: function(data) {
   	alert(data);
   }


  });

  }
  productandqty = [];
   
 


});


});