 $(document).ready(function() {
    var x;
     var productid = $("#productid").html();
     var price = $("#price").html();
     var qty = $("#qty").val();
     $.ajax({
     url: "checkcart.php",
     type: "post",
     data: "productid=" + productid,
     success: function(data) {
       x = data;
       
       if(data == "found")
       {
        $("#addtocart").css("disabled", "disabled");
        $("#addtocart").css("background-color", "green");
        $("#addtocart").html("ADDED");
       }
     }
     

    });
    
     


    $("#addtocart").click(function() {
    
    var text = $("#addtocart").html();
    if( text != "ADDED")
{
     $.ajax({
     url: "addtocart.php",
     type: "post",
     data: "productid=" + productid + "&price=" + price + "&qty=" + qty,
     success: function(data) {
        alert(data);
     $("#addtocart").html("ADDED");
      $("#addtocart").css("background-color", "green");
      $("#addtocart").attr("disabled", "disabled");
  
     }
     });
     } 

    });
});