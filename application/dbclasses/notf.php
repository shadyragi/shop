<?php


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src='jquery.min.js'></script>
	<script type="text/javascript">
		setInterval(function(){
			
			$.ajax({
				url: 'notifier.php',
				type: 'post',
				datatype: 'json',
				success: function(data) {
					for(var i = 0; i < 3; ++i)
					{
						alert(data[i]);
					}
				}
			});
			console.log("hi there");
		}, 5000);
	</script>>
</head>
<body>

</body>
</html>>