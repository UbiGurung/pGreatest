<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create Picks</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="../includes/slip-master/slip.js"></script>
	<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
	<script src="../includes/jquery.redirect.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../css/mainCss.css">
	<link rel="stylesheet" type="text/css" href="../css/picksIndex.css">
	<link rel = "icon" href = "images/pgLogo2.jpg">
	<script type="text/javascript">
		
		var picks = new Array();
		
		function addCard()
		{
			$(".addCard").remove();
			var input = "<li class='newPoll'><div class='poll shadow'><input name='addTitle[]' placeholder='Add title'></input><input name='addText[]' placeholder='Add your description here'></input><select name='category'><option value='1'>Sports</option><option value='2'>Gaming</option><option value='3'>Music</option><option value='4'>Movies</option><option value='5'>Lifestyle</option></select>Select a thumbnail:<input type='file' id='upload' name='upload'></div></br><div><input type='hidden' name='action' value='upload'><input type='submit' value='Create' id='create'><input type='button' value='Cancel' id='cancel'></div></li>";
			$(".drafts").append(input);
		}
		
		function checkCards()
		{
			var target = $(".drafts");
			var cardMax = $(".drafts li").size();
			if (cardMax < cardMax + 1)
			{
				target.append("<div class='addCard'></div>");
			}
			
		}
					
		function removePick()
		{
			if($("#wrench").hasClass('highlight'))
			{
				$("img", ".picks").each(function() {
					$(this).show();
				});
			}
			else
			{
				$("img", ".picks").each(function() {
					$(this).hide();
				});
			}
		}
		
		
		$(document).ready(function() {
		
		checkCards();
		
		$(".flex-container").delegate(".removePoll", "click", function() {
			var result = confirm("Confirm deletion");
			if (result)
			{
			var id = $(this).attr('id');
			
			$.redirect('index.php', {deletePoll: id});
			}
		});
		
		$(".drafts").delegate(".editPoll", "click", function() {
			var result = confirm("Confirm edit");
			if (result)
			{
			var id = $(this).attr('id');
			
			$.redirect('index.php', {editPoll: id});
			}
		});
			
		$(".drafts").delegate(".addCard", "click", (function() {
			addCard();
		}));

		
		$("#viewCards").click(function(){
			$("div.drafts").addClass("viewStyle");
		});
		
		$("#viewList").click(function(){
			$("div.drafts").removeClass("viewStyle");
		});
		
		$("#sideArrow").click(function() {
			$(".side-wrapper").toggleClass("toggled");
		});
		
		$("#wrench").click(function(){
			$(this).toggleClass('highlight');
			removePick();
		});
		
		$(".drafts").delegate("#cancel", "click", function(){
			$(".newPoll").remove();
			checkCards();
		});
		
	});

	
	</script>

</head>

<header>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/header.html.php'; ?>
</header>

<body>
	<div class="container mainContent shadowSide">

		<div class="side-wrapper">
			<span class="glyphicon glyphicon-chevron-left" id="sideArrow"></span>
			<div id="sidebar-wrapper">
					<ul class="sidebar-nav">
						<li class="sidebar-brand">
							<a href="#">Your Picks</a>
							<span class="glyphicon glyphicon-wrench" id="wrench"></span>
						</li>
						
						<li>
							<ul class="sortable-list">
							
							</ul>
						</li>
						<div class="pickSubmit">
							<button type="button" class="btn btn-secondary">Finished</button>
						</div>
					</ul>
			</div>
		</div>
		
	
	
<div class="mainWrapper">
		<h2>Create your greatest picks...</h2>
		<div class="row">
			<div class="col-md-offset-10 col-md-2 viewStyleButtons">
				<span class="glyphicon glyphicon-th" id="viewCards"></span>
				<span class="glyphicon glyphicon-th-list" id="viewList"></span>
			</div>
		</div>
		
		
		<?php if(pollExist($_SESSION['id'])): ?>
		<form action="" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure about that?');">
			<ul class="flex-container drafts viewStyle">
						<?php foreach($polls as $poll): ?>
							<?php if($poll['visible'] == 0):?>
								<?php $pollTitle = $poll['pollname']; $pollDesc = $poll['pollText']; $pollId = $poll['id'];?>
								<li>
									<div style="float:left;"class="poll shadow">
										<div style="float:right" class="edit">
											<span id="<?php htmlout($pollId); ?>" class="glyphicon glyphicon-pencil editPoll"></span></br>
											<span id="<?php htmlout($pollId); ?>" class="glyphicon glyphicon-remove removePoll"></span>
										</div>
										<div class="pollText">
											<p>Title:<?php htmlout($pollTitle);?></p>
											<p>Text:<?php htmlout($pollDesc); ?></p>
										</div>
									</div>
								</li>
						<?php endif;?>
					<?php endforeach; ?>
				</ul>
			</form>
		
		
		<div>
			<h2>Your uploads</h2>
			<ul class="flex-container uploads viewStyle">
				<?php foreach($polls as $poll): ?>
					<?php if($poll['visible'] == 1):?>
						<?php $pollTitle = $poll['pollname']; $pollDesc = $poll['pollText']; $pollId = $poll['id'];?>
						<li>
							<div style="float:left;" class="poll shadow">
								<div style="float:right" class="edit">
									<span id="<?php htmlout($pollId); ?>" class="glyphicon glyphicon-remove removePoll"></span>
								</div>
							
								<div class="pollText">
									<p>Title:<?php htmlout($pollTitle);?></p>
									<p>Text:<?php htmlout($pollDesc); ?></p>
								</div>
							</div>
						</li>
					<?php endif;?>
				<?php endforeach;?>
			</ul>
		</div>
		<?php endif;?>
</div>


	
	<script type="text/javascript">
		var ul = document.querySelector("ul.sortable-list");

ul.addEventListener('slip:beforereorder', function(e){
  if (/demo-no-reorder/.test(e.target.className)) {
    e.preventDefault();
  }
}, false);

ul.addEventListener('slip:beforeswipe', function(e){
  if (e.target.nodeName == 'INPUT' || /no-swipe/.test(e.target.className)) {
    e.preventDefault();
  }
}, false);

ul.addEventListener('slip:beforewait', function(e){
  if (e.target.className.indexOf('instant') > -1) e.preventDefault();
}, false);



ul.addEventListener('slip:reorder', function(e){
  e.target.parentNode.insertBefore(e.target, e.detail.insertBefore);
  return false;
}, false);

ul.addEventListener('slip:swipe', function(e)	{
	var title = e.target.id;
	$(title).show();
	e.target.parentNode.removeChild(e.target);
	if($(".sortable-list li").size() == 9)
	{
		$("#pickSubmit").css("opacity", "0");
	}
});

new Slip(ul);
		
	</script>
</body>
</html>