<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		
			<div class="navbard-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#toCollapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="../home/index.php"><span class="logo">People's Greatest</span></a>
			</div>
			
		<div class="collapse navbar-collapse" id="toCollapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../home/index.php">Home</a></li>
				<li><a href="../pickTable/index.php">Picks</a></li>
				<li><a href="../about/index.php">About Us</a></li>
			</ul>
			
			<div class="col-sm-3 col-md-3 pull-right">
					<div class="input-group">
						<div class="input-group-btn">
							<button class="btnCustom"><i style="font-size: 1.45em" class="glyphicon glyphicon-search"></i></button>
						</div>
						<input type="text" id="srch-term" class="form-control" placeholder="Search" name="srch-term">
					</div>
			</div>
			
			
			<ul class="nav navbar-nav navbar-left" id="left">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<?php  if(isset($_SESSION['loggedIn'])): ?>
					<b><?php echo $_SESSION['username']; ?></b>
					<?php else: ?>
					<b>Login</b>
					<?php endif; ?>
					<span class="caret"></span></a>
					<ul id="login-dp" class="dropdown-menu">
						<li>
							<div class="row">
								<?php if(isset($_SESSION['loggedIn'])): ?>
								<div class="col-md-12">
									<ul class="loginDrop">
										<li><a href="../profile/index.php">Profile</a></li>
										<li><a href="../pickIndex/index.php">My Picks</a></li>
										<li><?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/logout.inc.html.php'; ?></li>
									</ul>
								</div>
								<?php else: ?>
								<div class="col-md-12">
								Login
									<form class="form" method="post" action="" accept-charset="UTF-8" id="login-nav">
										<div class="form-group">
											<label class="sr-only" for="email">Email address</label>
											<input type="email" class="form-control" name="email" id="email" placeholder="Email address" required>
										</div>
										<div class="form-group">
											<label class="sr-only" for="password">Password</label>
											<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
											<div class="help-block text-right"><a href="#">Forgotten password?</a></div>
										</div>
										<div class="form-group">
											<input type="hidden" name="action" value="login">
											<input type="submit" class="btn btn-primary btn-block" value="Sign In">
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox">Keep me logged-in
											</label>
										</div>
									</form>
								</div>
								<div class="bottom text-center">
									Need an account ? <a href="../register/index.php"><b>Register here</b></a>
								</div>
							<?php endif; ?>
							</div>
						</li>
					</ul>
				</li>
				<li id="loginError">
					<?php if(!empty($_SESSION['error'])) {echo $_SESSION['error']; unset($_SESSION['error']);} ?>
				</li>
			</ul>
		</div>
	</div>
	</nav>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$(".btnCustom").click(function(){
				var term = $("#srch-term").val();
				
				if(term == '')
				{
					alert("Please enter a pollname to search for");
				}
				else
				{
					$.redirect('../pickTable/index.php', {searchPoll: term});
				}
			});
		});
	</script>