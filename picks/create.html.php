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
	<link rel="stylesheet" type="text/css" href="../css/picksCreateCss.css">
	<link rel = "icon" href = "images/pgLogo2.jpg">
	<script type="text/javascript">
		
		var picks = new Array();
		
		function addCard()
		{
			$(".addCard").remove();
			var input = "<li class='poll shadow'><input name='addTitle[]' placeholder='Add title'></input><input name='addText[]' placeholder='Add your description here'></input><input type='hidden' name='pickId[]' value='new'></input></li>";
			$(".flex-container").append(input);
			checkCards();
		}
		
		function checkCards()
		{
			var target = $(".flex-container");
			var cardMax = $(".flex-container li").size();
			if (cardMax < 5)
			{
				target.append("<div class='addCard'></div>");
				$("#finish").css('opacity' ,'0.5');
				$('.upload').prop('disabled', true);
			}
			else
			{
				$("#finish").css('opacity', '1');
				$('.upload').prop('disabled', false);
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
		
		$(".flex-container").delegate(".removePick", "click", function() {
			var result = confirm("Discard?");
			if (result)
			{
			var id = $(this).attr('id');
			
			$.redirect('index.php', {deletePick: id});
			}
		});
		
		$(".flex-container").delegate(".addCard", "click", (function() {
			addCard();
		}));

		
		$("#viewCards").click(function(){
			$("div.flex-container").addClass("viewStyle");
		});
		
		$("#viewList").click(function(){
			$("div.flex-container").removeClass("viewStyle");
		});
		
		$("#sideArrow").click(function() {
			$(".side-wrapper").toggleClass("toggled");
		});
		
		$("#wrench").click(function(){
			$(this).toggleClass('highlight');
			removePick();
		});
		
		var form = document.getElementById('mainForm');
		
		$('#saveDraft').click(function(){
			$('#saveType').val('0');
			form.submit();
		});
		
		$('#finalise').click(function(){
			var ready = confirm('Once finalised the poll cannot be edited. Continue?');
			if(ready)
			{
				$('#saveType').val('1');
				form.submit();
			}
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
							<button type="button" class="btn btn-secondary">Finish</button>
						</div>
					</ul>
			</div>
		</div>
		
	
	
<div class="mainWrapper">
		<h2>Create your picks....</h2>
		<div class="row">
			<div class="col-md-offset-10 col-md-2 viewStyleButtons">
				<span class="glyphicon glyphicon-th" id="viewCards"></span>
				<span class="glyphicon glyphicon-th-list" id="viewList"></span>
			</div>
		</div>
		
		<form action="?<?php if(picksExist($_SESSION['pollId'])){echo 'updatePoll';}else{echo 'addPicks';};?>" method="post" onsubmit="return confirm('Are you sure about that?');" id="mainForm">
			<ul class="flex-container viewStyle">
				<?php if(picksExist($_SESSION['pollId'])): ?>
						<?php foreach($picks as $pick): ?>
							<?php $pickId = $pick['id']; $pickName = $pick['pickname']; $pickText= $pick['picktext']; ?>
							<li class='poll shadow'>
								<input name='addTitle[]' value="<?php htmlout($pickName); ?>"></input><input name='addText[]' value="<?php htmlout($pickText); ?>"></input>
								<input type="hidden" name="pickId[]" value="<?php htmlout($pickId); ?>">
								<span id="<?php htmlout($pickId); ?>" class="glyphicon glyphicon-remove removePick"></span>
							</li>
						<?php endforeach; ?>
						<input type="hidden" name="pollId" value="<?php htmlout($_SESSION['pollId']); ?>">
				<?php endif; ?>
			</ul>
			<input type="hidden" value="id" id="<?php htmlout($_SESSION['id']); ?>">
			<input type="hidden" name="saveType" value="" id="saveType">
			<button type="button" name="saveDraft" id="saveDraft">Save Draft</button>
			<button type="button" name="finalise" id="finalise">Finalise</button>
		</form>

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