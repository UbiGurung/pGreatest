<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<html>
<head>
	<title>People's Greatest Home Page</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/head.html.php'; ?>
	<link rel="stylesheet" type="text/css" href="../css/homeCss.css">
	<link rel = "icon" href = "images/pgLogo2.jpg">
	
</head>

<header>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/header.html.php'; ?>
</header>
<body>		
	<div class="container mainContent shadowSide">
	
				<div class="hotPicks">
					<div id="hotPickCarousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#hotPickCarousel" data-slide-to="0" class="active"></li>
							<li data-target="#hotPickCarousel" data-slide-to="1"></li>
							<li data-target="#hotPickCarousel" data-slide-to="2"></li>
						</ol>
						<div class="carousel-inner" role="listbox">
							<div class="item active" id="<?php htmlout($topPolls[0]['id']); ?>">
							<img src="<?php htmlout($topPolls[0]['thumbnailURL']); ?>">
								<div class="ribbon2">
									<span><?php htmlout($topPolls[0]['pollname']); ?></span>
								</div>
								<div class="jumboContent hotPickBg">
									<p><?php htmlout($topPolls[0]['pollText']); ?></p>
								</div>
							</div>
							
							<div class="item" id="<?php htmlout($topPolls[1]['id']); ?>">
								<img src="<?php htmlout($topPolls[1]['thumbnailURL']); ?>">
								<div class="ribbon2">
									<span><?php htmlout($topPolls[1]['pollname']); ?></span>
								</div>
								<div class="jumboContent hotPickBg">
									<p><?php htmlout($topPolls[1]['pollText']); ?></p>
								</div>
							</div>
							
							<div class="item" id="<?php htmlout($topPolls[2]['id']); ?>">
								<img src="<?php htmlout($topPolls[2]['thumbnailURL']); ?>">
								<div class="ribbon2">
									<span><?php htmlout($topPolls[2]['pollname']); ?></span>
								</div>
								<div class="jumboContent hotPickBg">
									<p><?php htmlout($topPolls[2]['pollText']); ?></p>
								</div>
							</div>
						
						<a class="left carousel-control" href="#hotPickCarousel" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						
						<a class="right carousel-control" href="#hotPickCarousel" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
				
				
		<div class="mainWrapper">
		
			<div class="recommended">
				<h3>Recommended</h3>
					<div class="row subWrapper">
						<div class="swiper-container">
							<div class="swiper-wrapper">
								<?php foreach(getRandPoll("2") as $key => $poll): ?>
								<div class="swiper-slide">
									<div class="box" id="<?php htmlout($poll['id']); ?>">
										<h1><?php htmlout($poll['pollname']);?></h1>
										<img src="<?php htmlout($poll['thumbnailURL']); ?>">
										<p><?php htmlout($poll['pollText']); ?></p>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							<div class="swiper-button-next"></div>
							<div class="swiper-button-prev"></div>
						</div>
					</div>
			</div>
			
			<div class="movies/tv">
				<h3>Movies/TV</h3>
					<div class=" row subWrapper">
						<div class="swiper-container">
							<div class="swiper-wraper">
								<?php foreach(getRandPoll("4") as $key => $poll): ?>
								<div class="swiper-slide">
									<div class="box" id="<?php htmlout($poll['id']); ?>">
										<h1><?php htmlout($poll['pollname']);?></h1>
										<img src="<?php htmlout($poll['thumbnailURL']); ?>">
										<p><?php htmlout($poll['pollText']); ?></p>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							<div class="swiper-button-next"></div>
							<div class="swiper-button-prev"></div>
						</div>
					</div>
			</div>
			
			<div class="games">
				<h3>Games</h3>
					<div class="row subWrapper">
						<div class="swiper-container">
							<div class="swiper-wrapper">
								<?php foreach(getRandPoll("2") as $key => $poll): ?>
								<div class="swiper-slide">
									<div class="box" id="<?php htmlout($poll['id']); ?>">
										<h1><?php htmlout($poll['pollname']);?></h1>
										<img src="<?php htmlout($poll['thumbnailURL']); ?>">
										<p><?php htmlout($poll['pollText']); ?></p>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							<div class="swiper-button-next"></div>
							<div class="swiper-button-prev"></div>
						</div>
					</div>
			</div>
			
			<div class="sports">
				<h3>Sports</h3>
					<div class="row subWrapper">
						<div class="swiper-container">
							<div class="swiper-wrapper">
								<?php foreach(getRandPoll("1") as $key => $poll): ?>
								<div class="swiper-slide">
									<div class="box" id="<?php htmlout($poll['id']); ?>">
										<h1><?php htmlout($poll['pollname']);?></h1>
										<img src="<?php htmlout($poll['thumbnailURL']); ?>">
										<p><?php htmlout($poll['pollText']); ?></p>
									</div>
								</div>
								<?php endforeach; ?>
							<div class="swiper-button-next"></div>
							<div class="swiper-button-prev"></div>
						</div>
					</div>
			</div>
			
			<div class="music">
				<h3>Music</h3>
					<div class="row subWrapper">
						<div class="swiper-container">
							<div class="swiper-wrapper">
								<?php foreach(getRandPoll("3") as $key => $poll): ?>
								<div class="swiper-slide">
									<div class="box" id="<?php htmlout($poll['id']); ?>">
										<h1><?php htmlout($poll['pollname']);?></h1>
										<img src="<?php htmlout($poll['thumbnailURL']); ?>">
										<p><?php htmlout($poll['pollText']); ?></p>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							<div class="swiper-button-next"></div>
							<div class="swiper-button-prev"></div>
						</div>
					</div>
			</div>
			
			<div class="culture">
				<h3>Culture</h3>
					<div class="row subWrapper">
						<div class="swiper-container">
							<div class="swiper-wrapper">
								<?php foreach(getRandPoll("5") as $key => $poll): ?>
								<div class="swiper-slide">
									<div class="box">
										<h1><?php htmlout($poll['pollname']);?></h1>
										<img src="<?php htmlout($poll['thumbnailURL']); ?>">
										<p><?php htmlout($poll['pollText']); ?></p>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							<div class="swiper-button-next"></div>
							<div class="swiper-button-prev"></div>
						</div>
					</div>
			</div>
		</div>
	</div>


	
	<script type="text/javascript">
	$(document).ready(function(){
		$("#hotPickCarousel").hover(function(){
			$(".hotPickBg").css("opacity", "1");
		}, function(){
			$(".hotPickBg").css("opacity", "0");

		});
		
		$(".box").on("click", function(){
				var id = $(this).attr('id');
				
				$.redirect('../pickTable/search.php', {name: id});
		});
		
		$(".item").click(function(){
			var id = $(this).attr('id');
			
			$.redirect("../pickTable/search.php", {name: id});
		});
	});
	
	var swiper = new Swiper('.swiper-container', {
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        slidesPerView: 4,
        centeredSlides: false,
        paginationClickable: false,
        spaceBetween: -50,
		breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 40
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            400: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
	});
	</script>
	
</body>
</html>