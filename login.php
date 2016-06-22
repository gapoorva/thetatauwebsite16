<?php 
	include "php/DB.php";


	// already logged in and token is set.
	if (isset($_COOKIE['token'])) {
		$auth = validate_token();
		if ($auth) header("Location: members.php");
	}

	$login_failed = false;

	// post request - logging in
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$userid = $_REQUEST['userid'];
		$pw = $_REQUEST['password'];
		$auth = login($userid, $pw); // authenticates and then sets token and other important info
		if ($auth) header("Location: members.php");
		else $login_failed = true; // couldn't authenticate
	}

	// we know it's a GET REQUEST
	include "php/components.php"; // saves some overhead including here
?>
<!DOCTYPE html>
<html>
	<?php head_section(array(), array("css/login.css")); ?>
	<body>
		<?php nav_section(); ?>

		<div class="container" id="login-form">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-sm-offset-4">
					<h3>Member Login</h3>
				<?php
					if ($login_failed) {
				?>
					<div class="alert alert-danger fade in">Your username and password don't match! <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
				<?php
					}
				?>
					<form role="form" method="POST">
						<div class="form-group">
							<label for="userid">Username</label>
							<input type="userid" class="form-control input-tht" id="userid" name="userid" placeholder="Username">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control input-tht" id="password" name="password" placeholder="Password">
						</div>
						<button type="submit" class="btn btn-tht">Login</button>
					</form>
				</div>
			</div>
		</div>

	</body>
</html>