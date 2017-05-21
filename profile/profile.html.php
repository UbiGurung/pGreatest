<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create Picks</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/47585/slip.js"></script>
	<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
	<script src="../includes/jquery.redirect.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../css/mainCss.css">
	<link rel="stylesheet" type="text/css" href="../css/profile.css">
	<link rel = "icon" href = "images/pgLogo2.jpg">

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
				<h1>Timeline</h1>
			</div>
			
			<div class="top-center-menu">
				<table class="top-table">
					<tr>
						<td width="10px"></td>
						<td width="200px">
							<div class="displayPic">
								<div class="dp">
									<img src="<?php if($dp != ''){htmlout($dp);}else{htmlout($dpDefault);}?>">
									<form>
										<label for="upload" id="changeDp"><span class="glyphicon glyphicon-pencil"></span></label>
										<input type="file" id="upload" name="changeDp" onchange="this.form.submit();">
									</form>
								</div>
							</div>
						</td>
						<td width="500px">
							<h1 class="username" id="<?php htmlout($_SESSION['username']); ?>"><?php htmlout($_SESSION['username']); ?></h1>
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
	if($('.username').text() == "<?php htmlout($_SESSION['username']); ?>")
	{
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
	}



	//$(document).ready(function() {
	//	$('#changeDp').click(function() {
	//		
	//	});
	//});
	</script>
</body>
</html>