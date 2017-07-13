<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Messages</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/head.html.php'; ?>
	<link rel="stylesheet" type="text/css" href="../css/message.css">

	<script type="text/javascript">
		var preSend = <?php htmlout(isset($_POST['toId'])); ?>;
	</script>
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
					<td width="10%"></td>
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
										<p>To: <input type="text" placeholder="Username" name="username" value="<?php htmlout($toName); ?>"></p>
									<?php else: ?>
										<p>To: <input type="text" name="username" placeholder="Username"></p>
									<?php endif; ?>
									<p>Subject: <input type="text" name="subject"placeholder="Subject"></p>
									<textarea name="messageContent"></textarea>
									<input type="submit" value="Send" id="send">							
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

		var allM = $(".message");
		var selM = $(".selMessage");
		var writeM = $(".writeMessage");

		<?php if($preSend): ?>
			allM.hide();
			selM.hide();
			writeM.show();
		<?php endif; ?>

		$("#all").on("click", function(){

			<?php if($preSend){unset($_POST['toName']); $preSend=false;} ?>

			selM.hide();
			writeM.hide();
			allM.show();
		});

		$(".message li").on("click", function(){

			<?php if($preSend){unset($_POST['toName']); $preSend=false;} ?>

			allM.hide();
			writeM.hide();
			selM.show();
		});
	</script>
</body>