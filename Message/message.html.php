<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Messages</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/head.html.php'; ?>
	<link rel="stylesheet" type="text/css" href="../css/message.css">
</head>

<header>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/header.html.php'; ?>
</header>

<body>
	<div class="container mainContent shadowSide">
		<div class="mainWrapper">
			<h1>Messages</h1>
			<table class="messageBox">
				<tr class="topButtons">
					<td width="10%" id="composeMail">Compose</td>
					<td>All Contacts</td>
					<td>Favourites</td>
					<td>Blocked</td>
					<td></td>
				</tr>
				<tr height="10%">
					<td class="sideButtons">
						<h2>Inbox</h2>
						<ul class="inboxSubBtns">
							<li id="all">All</li>
							<li>Favourites</li>
							<li>Junk</li>
						</ul>
					</td>
					<td class="messageContent" colspan="5" rowspan="2">
						<ul class="message">
							<?php if($messageAll): ?>
								<?php foreach($messageAll as $message): ?>
									<li>
										<img src="<?php htmlout($message['displayPicture']); ?>">
										<h3><?php htmlout($message['username']); ?></h3>
										<p><?php htmlout($message['subject']); ?></p>
									</li>
								<?php endforeach; ?>
							<?php else: ?>
								<li>No messages</li>
							<?php endif; ?>
						</ul>

						<ul class="selMessage" style="list-style: none;">
							<li>
								<p>This is your selected message</p>
							</li>
						</ul>

						<ul class="writeMessage" style="list-style: none;">
							<li>
								<form action="?messageSend" method="post" id="messageForm">
									<?php if($preSend): ?>
										<p>To: <input type="text" placeholder="Username" id="toName" name="username" value="<?php htmlout($toName); ?>"></p>
									<?php else: ?>
										<p>To: <input type="text" name="username" id="toName" placeholder="Username"></p>
									<?php endif; ?>
									<span id="userErrorMessage"></span>
									<p>Subject: <input type="text" id="subject" name="subject"placeholder="Subject"></p>
									<textarea name="messageContent" id="message"></textarea>
									<input type="button" value="Send" onclick="checkUserExists();" id="send">							
								</form>
							</li>
						</ul>

					</td>
				</tr>
				<tr><td></td></tr>
			</table>	
		</div>
	</div>

	<script type="text/javascript">

		function checkUserExists()
		{
			var xmlhttp = new XMLHttpRequest();
			var username = $('#toName').val();
			var subject = $("#subject").val();
			var message = $("#message").val();


			if(username != "" && subject != "" && message != "")
			{
				xmlhttp.onreadystatechange = function() {
					if(this.readyState == 4 && this.status == 200){
						document.getElementById("userErrorMessage").innerHTML = this.responseText;

						if(this.responseText != "")
						{
							alert("You have an error");
						}
						else
						{
							$("#messageForm").submit();
							allM.show();
							selM.hide();
							writeM.hide();
						}
					}
				};

				xmlhttp.open("GET", "messageChecklist.php?toName="+username, true);
				xmlhttp.send();
			}
			else
			{
				alert("Either username, subject or message values are empty!");
			}
		}

		var allM = $(".message");
		var selM = $(".selMessage");
		var writeM = $(".writeMessage");

		selM.hide();
		writeM.hide();

		<?php if($preSend): ?>
			allM.hide();
			selM.hide();
			writeM.show();

			unset($_POST['toName']);
			$preSend = false;
		<?php endif; ?>

		$("#all").on("click", function(){

			selM.hide();
			writeM.hide();
			allM.show();
		});

		$(".message li").on("click", function(){

			allM.hide();
			writeM.hide();
			selM.show();
		});

		$("#composeMail").on("click", function(){
			allM.hide();
			writeM.show();
			selM.hide();
		})
	</script>
</body>