<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create Picks</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/head.html.php'; ?>
	<link rel="stylesheet" type="text/css" href="../css/picksIndex.css">
	<script type="text/javascript">
		
		var picks = new Array();
		
		
		$(document).ready(function() {

		
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
							<button type="button" class="btn btn-secondary" id="pickSubmit">Finished</button>
						</div>
					</ul>
			</div>
		</div>
		
	
	
<div class="mainWrapper">
		<h2>Here are the top picks for this poll...</h2>
		<div class="row">
			<div class="col-md-offset-10 col-md-2 viewStyleButtons">
				<span class="glyphicon glyphicon-th" id="viewCards"></span>
				<span class="glyphicon glyphicon-th-list" id="viewList"></span>
			</div>
		</div>
		
		<ul class="flex-container viewStyle">
						<?php foreach($topPicks as $pick): ?>
						<?php $pickTitle = $pick['pickname']; $pickDesc = $pick['picktext']; $pickPoints = $pick['points'];?>
						<li>
							<div style="float:left;"class="poll shadow">
								<p><?php htmlout($pickTitle);?></p>
								<p><?php htmlout($pickDesc); ?></p>
								<p><?php htmlout($pickPoints);?></p>
							</div>
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
	if($(".sortable-list li").size() == 9)
	{
		$("#pickSubmit").css("opacity", "0");
	}
});

new Slip(ul);
		
	</script>
</body>
</html>