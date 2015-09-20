<?php
	function getContent() {
		return '<p id="liveSession">' . $obj->liveSession->browser . '@' . $obj->liveSession->ip '</p>' . 
			 '<p id="currentSession">' . $obj->currentSession->browser . '@' . $obj->currentSession->ip .'</p>';
	}
?>
<html>
<head>
	<title>Hack[IN] 2015</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Favicon -->
    <link rel="icon" href="img/favicon.png" type="image/png" sizes="32x32">

	<style>
		@import url(http://fonts.googleapis.com/css?family=Aldrich);
		body
		{
			background: url(img/multiple.jpg) no-repeat center center fixed; 
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}
		*
		{
			font-family: 'Aldrich';
			text-shadow: 1px 1px #FFF;
		}
		#oops
		{
			font-size: 72px;
		}
		#oops-text
		{
			font-size:24px;
		}
		.voffset
		{
			margin-top:30%;
		}
		button
		{
			font-size: 24px;
		}
		#disclaimer
		{
			font-size: 32px;
		}
		.voffset1
		{
			margin-top:15px;
		}
	</style>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center" id="oops">
				Oops..
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 text-center" id="oops-text">
				it looks like we have more than one bird on the wire.
			</div>
		</div>
		<div class="row voffset">
			<div class="col-lg-12 text-center" id="disclaimer">Do you want to kill all other sessions and continue?</div>
		</div>
		<div class="row">
			<div class="col-lg-12 text-center">
				<p id="error-msg">Live Session: Firefox, 134:72:1:1</p>
				<p id="error-msg">Current Session: Chrome, 134:72:1:1</p>
			</div>
		</div>
		<div class="row voffset1">
			<div class="col-lg-12 text-center">
				<button class="btn btn-success" href="">Agree</button>
				<button class="btn btn-danger">Decline</button>
			</div>
		</div>
	</div>
</body>
</html>