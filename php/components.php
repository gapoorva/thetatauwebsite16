<?php  
	function head_section($js_files = array(), $css_files = array()) {
?>
	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">

	  <!-- JavaScript -->
	  <script src="js/jquery-1.12.3.min.js"></script>
	  <script src="js/bootstrap.min.js"></script>
	  <script src="js/main.js"></script>
<?php 
	foreach ($js_files as $file) {
		echo "<script type='text/javascript' src='".$file."'></script>";
	}
?>

	  <!-- CSS -->
	  <link href="css/bootstrap.min.css" rel="stylesheet">
	  <link href="css/bootstrap-theme.min.css" rel="stylesheet">
	  <link href="css/main.css" rel="stylesheet">

<?php 
	foreach($css_files as $file) {
		echo "<link href='".$file."' rel='stylesheet'>";
	}
?>

	  <!-- favicon -->
	  <link rel="shortcut icon" href="images/crest.png" type="image/x-icon">

	  <meta name="author" content="Justin Parus, Apoorva Gupta, Diego Holt">
	  <meta name="description" content="Theta Tau - Theta Gamma">
	  <meta property="og:url" content="http://www.thetatauthetagamma.com" />
	  <meta property="og:title" content="Theta Tau - Theta Gamma" />
	  <meta property="og:description" content="Theta Tau - Theta Gamma" />
	  <meta property="og:site_name" content="Theta Tau - Theta Gamma" />

	  <title>Theta Tau - Theta Gamma</title>
	</head>
<?php
	}

	function nav_section() {
?>
		<!-- navbar -->
		<nav class="navbar navbar-fixed-top">
		  <div class="container-fluid">
		    
		    <!-- navbar header with optional button -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
		         <span class="icon-bar"></span>
		         <span class="icon-bar"></span>
		         <span class="icon-bar"></span>                        
		      </button>
		      <a class="navbar-brand" href="index.php">Theta Tau</a>
		    </div>
		    <!-- end header -->

		    <!-- standard nav -->
		    <div class="collapse navbar-collapse" id="navbar">
		      <ul class="nav navbar-nav">
		        <li><a href="rush.php">Rush</a></li>
		        <li><a href="members.php">Members</a></li>
		        <li><a href="photogallery.php">Photo Gallery</a></li>
		        <li><a href="login.php">Login</a></li>
		      </ul>
		    </div>
		    <!-- end standard nav -->

		  </div>
		</nav>
		<!-- End navbar -->
<?php 
	}

	function footer_section() {
?>
		<!-- footer -->
		<div id="footer" class="footer">
		  <div id="footer-row" class="row">
		    <div class="col-sm-12">
		      <p class="text-center">Feedback for the website? Tell us about it <a href="mailto:tht-web.committee@umich.edu?Subject=Theta%20Gamma%20Website%20Feedback">here</a>. 
		      </p>
		    </div>
		  </div>
		</div>
		<!-- End footer -->
<?php

	}
?>