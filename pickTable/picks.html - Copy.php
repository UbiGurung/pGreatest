<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>People's Greatest</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="../includes/slip-master/slip.js"></script>
	<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
	<script src="../includes/jquery.redirect.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../css/mainCss.css">
	<link rel="stylesheet" type="text/css" href="../css/picksCss.css">
	<link rel = "icon" href = "images/pgLogo2.jpg">
	<script type="text/javascript">
		
		var picks = new Array();
		
		
		$(document).ready(function() {
		
		$(".flex-container").delegate('.poll', 'dblclick', (function() {
			
			if($(".sortable-list li").size() < 10)
			{
				var className = $(this).attr("class");
				var pollId = $(this).attr('id');
				var selectPoll = "#" + pollId + "";
			
				var title = $("h1", this);
				var titleCopy = "<li class='pick' id='" + pollId + "'>" + title.clone().text() + "<span class='handle instant glyphicon glyphicon-menu-hamburger'/></li>";
				
				$(selectPoll).fadeOut("slow");
				$(selectPoll).delay(800).queue(function() { $(selectPoll).hide()});
				$(selectPoll).dequeue();
				
				$(titleCopy).delay(1000).queue(function() { $(titleCopy).appendTo(".sortable-list") });
				$(titleCopy).dequeue();
				
				if($(".sortable-list li").size() >= 4)
				{
					$("#pickSubmit").css("opacity", "1");
				}
			}
				
				removePick();
		}));
		
		$("#pickSubmit").on('click', function() {
				var maxList = $(".sortable-list li").size();
				var pollId = <?php htmlout($pollId); ?>;
				var pickPos = new Array();
				var points = 10;
				for (var i = 0; i < maxList; i++)
				{
					var targetId = $('.sortable-list li').eq(i).attr('id');
					pickPos.push({'id': "" + targetId + "", 'points': "" + points + ""});
					points -= 2;
				}
				$.redirect('uploadPick.php', {uploadPoll: pollId, data: pickPos});
			});
		
		$(".sortable-list").delegate("li", 'click', (function(){
				var titleId = $(this).attr('id');
				$(titleId).show();
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
	});

			
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
		

	
	</script>

</head>

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
							<button type="button" class="btn btn-secondary" id="pickSubmit">Finished</button>
						</div>
					</ul>
			</div>
		</div>
		
<header>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/header.html.php'; ?>
</header>
	
<div class="mainWrapper">
		<h2>Pick your greatest...</h2>
		<div class="row">
			<div class="col-md-offset-10 col-md-2 viewStyleButtons">
				<span class="glyphicon glyphicon-th" id="viewCards"></span>
				<span class="glyphicon glyphicon-th-list" id="viewList"></span>
			</div>
		</div>
	
		<ul class="flex-container viewStyle">
			<?php foreach($picks as $pick): ?>
				<?php $pickId = $pick['id']; $pickName = $pick['pickname']; $pickText= $pick['picktext']; ?>
				<li>
					<div class='poll shadow' id="<?php htmlout($pickId);?>"><h1 id="<?php htmlout($pickId);?>"><?php htmlout($pickName); ?></h1><p><?php htmlout($pickText); ?></p></div>
				</li>
			<?php endforeach; ?>
		</ul>
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
	if($(".sortable-list li").size() < 5)
	{
		$("#pickSubmit").css("opacity", "0");
	}
});

new Slip(ul);
		
	</script>
</body>
</html>