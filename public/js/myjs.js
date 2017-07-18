$(document).ready(function() {
   var x;
   var lessarr = [];
   $.ajax(
   {
    url: 'loadcontent.php',
    success: function(data) {
    	x = data;

    	for(i = 0; i < 500; ++i)
    	{
     $('#contentdiv').prepend(data[i]);
       
      }

  }
    });

    $("#mybtn").on("click", function() {
   
     
     if($(this).val() == "more")
     {
     	
     for(i = 500; i < x.length; ++i)
     {
     	$("#contentdiv").append(x[i]);
     	
     }
        $('#contentdiv').after(this);
     	$(this).val("less");
 }
 else if ($(this).val() == "less") {
 	    for(y = 0; y < 500; ++y)
 	    {
          lessarr[y] = x[y];
 	    }
 	     
 	    $('#contentdiv').empty();
 	    $('#contentdiv').append(lessarr);
 	    $('#contentdiv').after(this);
 	    $(this).val("more");
 	    
 }

    }); 
 
 
});