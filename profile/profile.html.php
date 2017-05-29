<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create Picks</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/head.html.php'; ?>
	<link rel="stylesheet" type="text/css" href="../css/profile.css">

	<style>
		body{
			background: url(<?php htmlout(random_pic()); ?>);
			background-size: cover;
		}
	</style>

	<script type="text/javascript">
		$(document).ready(function(){
			$(".userUploads").delegate(".poll", "click", function(){
				var pollId = $(this).attr('id');
				$.redirect('../includes/search.php', {name:pollId});
			});
		});
	</script>
</head>

<header>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/header.html.php'; ?>
</header>

<body>
	<div class="mainWrapper">

		<div class="profile-wrapper">
			<div class="left-menu">
				<h1>History</h1>
				<ul id="history">
					<?php if(checkHistory($id)): ?>
						<?php foreach($pollHisSearch as $pollHis): ?>
							<li id="<?php htmlout($pollHis['id']); ?>">
								<h2><?php htmlout($pollHis['pollname']); ?></h2>
								<img src="<?php htmlout($pollHis['thumbnailURL']); ?>">
								<p><?php htmlout($pollHis['voteDate']); ?></p>
							</li>
						<?php endforeach; ?>
					<?php else: ?>
						<li><p>No history found...</p></li>
					<?php endif; ?>
				</ul>
			</div>
			
			<div class="top-center-menu">
				<table class="top-table">
					<tr>
						<td width="10px"></td>
						<td width="200px">
							<div class="displayPic">
								<div class="dp">
									<img src="<?php if($dp != ''){htmlout($dp);}else{htmlout($dpDefault);}?>">
									<?php if(isset($_SESSION['id']) AND $_SESSION['id'] === $userId): ?>
										<form id="picChange">
											<label for="upload" id="changeDp"><span class="glyphicon glyphicon-pencil"></span></label>
											<input type="file" id="upload" name="changeDp" onchange="this.form.submit();">
										</form>
									<?php endif; ?>
								</div>
							</div>
						</td>
						<td width="500px">
							<h1 class="username" id="<?php htmlout($userId); ?>"><?php htmlout($username); ?></h1>
							<div class="profileDesc">
								<form action="" method="post">
									<div class="infoWrapper">
										<div class="infoMask"></div>
									<textarea name="newInfo" id="info"><?php if($profileInfo === ""): ?>No Description<?php else:htmlout($profileInfo); endif;?></textarea>
									</div>
									<input class="btn-info change" name="action" type="submit" value="Change" disabled onclick="changeInfo();">
									<input class="btn-info cancel" type="button" value="Cancel" disabled>
								</form>
							</div>
						</td>
						<td width="10px"></td>
					</tr>
					<tr height="10px"></tr>
				</table>
			</div>

			<div class="bottom-center-menu">
				<div class="innerWrap">
					<h1>Uploads</h1>
					<div>
						<?php if(pollExist($userId)): ?>
							<ul class="userUploads">
							<?php foreach($polls as $poll): ?>
								<li class="poll" id="<?php htmlout($poll['id']); ?>">
									<h2><?php htmlout($poll['pollname']); ?></h2>
									<img src="<?php htmlout($poll['thumbnailURL']); ?>">
									<p><?php htmlout($poll['pollText']); ?></p>
								</li>
							<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<script type="text/javascript">

	<?php if(isset($_SESSION['id']) AND $_SESSION['id'] === $userId): ?>

			var curText = $('#info').text();

			$('.infoWrapper').on('click', function(){
				$('.infoMask').css('display', 'none');
				$('.btn-info').prop('disabled', false);
				$('.btn-info').css('opacity', 1);
			});

			$('.cancel').on('click', function(){
				$('#info').val(curText);
				$('.infoMask').css('display', 'inline');
				$('.btn-info').prop('disabled', true);
				$('.btn-info').css('opacity', 0);
			});

	<?php endif; ?>

	$(document).ready(function() {
		$('#history li').click(function(){
			var pollId = $(this).attr('id');

			$.redirect('../includes/search.php', {'name': pollId});
		});
	});


	//$(document).ready(function() {
	//	$('#changeDp').click(function() {
	//		
	//	});
	//});
	</script>
</body>
</html>