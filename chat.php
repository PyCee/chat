<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Chat program</title>
		<meta charset="UTF-8">
		
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" 
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
        <link rel="stylesheet" type="text/css" href="style.css">
		<style>
			.dataList {
				text-align: left;
				border: 2px solid black;
				border-radius: 20px;
				height: 500px;
				width: 90%;
				overflow-y: auto;
				overflow-x: hidden;
				padding: 10px;
				margin: 10px auto;
			}
			#nameList {
			}
			#chatDisplay {
			}
			#messageEntry {
				width: 90%;
				margin: 10px auto;
			}
		</style>
	</head>
	<body>
		<section class="container">
			<section class="row" style="text-align: center;">
				<h1>Chat</h1>
			</section>
			<section class="row">
				<div class="col-md-5 col-sm-12">
					<div id="nameList" class="dataList"></div>
				</div>
				<div class="col-md-7 col-sm-12">
					<div id="chatDisplay" class="dataList"></div>
					<input type="text" id="messageEntry" placeholder="Type message here">
					<button id="chatButton">Send message</button>
				</div>
			</section>
		</section>
	</body>
	

	<script src="ajaxInterface.js"></script>
	<script>
		var sendRequest;
		var updateChatRequest;
		var updateNameListRequest;
		var lastTimestamp = "99999999";
		var currentNameList = [];

		var username = "DEFAULT_USERNAME";
		
		function setName(){
			username = "<?php 
				if(isset($_POST['username']) &&	
					isset($_POST['nameColor']) &&
					strlen($_POST['username']) > 0) {
					$name = "<span style='color: " . $_POST['nameColor'] . "'>" . $_POST['username'] . "</span>";
					echo addslashes($name); 
				} else {
					echo "DEFAULT_USERNAME";
				}
			?>";
			
			if(username === "DEFAULT_USERNAME"){
				window.location.replace("index.html");
			} else {
				addSelfToNameList();
			}
		}
		
		// jquery to run function on button press
		setInterval(checkForNewMessage, 200);
		updateNameList();
		setInterval(updateNameList, 1000);

		$(document).ready(function(){
			setName();
			
			$("#chatButton").click(function(){
				sendMessage();
			});
			$("#messageEntry").keypress(function(e){
  				if(e.keyCode == 13){
					sendMessage();
				}
			});
			window.onbeforeunload = function(e){
				removeSelfFromNameList();
			};
		});
	</script>
</html>