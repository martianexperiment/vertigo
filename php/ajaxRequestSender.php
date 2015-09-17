
<html>
<head>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	function sendAjaxRequest(){
		$.ajax( "./ajaxRequestReceiver.php"). done(function(data){
			alert(data);
		});
	}

</script>
</head>

<body>

<input type="button" name="click" value="Button" onclick="sendAjaxRequest()"></input>


</body>
</html>
