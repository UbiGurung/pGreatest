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
					<td width="10%"></td>
					<td>All Contacts</td>
					<td>Favourites</td>
					<td>Blocked</td>
					<td></td>
				</tr>
				<tr height="10%">
					<td class="sideButtons">
						<h2>Recent</h2>
						<ul class="inboxSubBtns">
							<li>Example 1</li>
							<li>Example 2</li>
							<li>Example 3</li>
							<li>Example 4</li>
						</ul>
					</td>
					<td class="messageContent" colspan="5" rowspan="2">
						<ul class="message">
							<?php if($messageAll[0] > 0): ?>
								<?php foreach($messageAll as $message): ?>
									<li>
										<img src="<?php htmlout($message['displayPicture']); ?>">
										<?php htmlout($message['username']); ?>
									</li>
								<?php endforeach; ?>
							<?php else: ?>
								<li>No messages</li>
							<?php endif; ?>
						</ul>
					</td>
				</tr>
				<tr><td></td></tr>
			</table>	
		</div>
	</div>
</body>