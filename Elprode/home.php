<html>
<head>
	<meta charset="UTF 8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
	
	<!--title-->
	<title> Elprode </title>

	<!--style sheets-->
	<link rel="shortcut icon" href="images/logo.png" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="http://cdn.jsdelivr.net/cal-heatmap/3.3.10/cal-heatmap.css" />    
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="http://cdn.jsdelivr.net/cal-heatmap/3.3.10/cal-heatmap.css" /> 
	<link rel="stylesheet" href="custom/custom.css" />

	<!--java script-->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script> 
	<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>    
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>    
    <script type="text/javascript" src="http://d3js.org/d3.v3.min.js"></script>    
    <script type="text/javascript" src="http://cdn.jsdelivr.net/cal-heatmap/3.3.10/cal-heatmap.min.js"></script>    
</head>


<header>
	<!--header image-->
	<div id="header-img" style="background-image: url(images/header2.png);"></div>
	
	<!--nav bar-->
	<nav class="navbar navbar-expand-lg navbar-light bg-white d-none d-md-block">
		<div class="container d-flex justify-content-center">

			<a href="#list-container" class="navbar-brand d-flex align-items-center">
				<img src="images/list.png" width="40" height="40" class="mr-3 d-none d-md-block" alt="list icon">
				<span class="navbar-text d-none d-lg-block">Packing List</span>
			</a>
			<a href="#property-container" class="navbar-brand d-flex align-items-center ml-5">
				<img src="images/property.png" width="40" height="40" class="mr-3 d-none d-md-block" alt="property icon">
				<span class="navbar-text d-none d-lg-block">Property</span>
			</a>
			<a href="#medicine-container" class="navbar-brand d-flex align-items-center ml-5">
				<img src="images/medicine.png" width="40" height="40" class="mr-3 d-none d-md-block" alt="medicine icon">
				<span class="navbar-text d-none d-lg-block">Medicine</span>
			</a>
			<a href="#visit-container" class="navbar-brand d-flex align-items-center ml-5">
				<img src="images/calendar.png" width="40" height="40" class="mr-3 d-none d-md-block" alt="calendar icon">
				<span class="navbar-text d-none d-lg-block">Hospital Visit</span>
			</a>
			<a href="#behaviour-container" class="navbar-brand d-flex align-items-center ml-5">
				<img src="images/behaviour.png" width="50" height="50" class="mr-3 d-none d-md-block" alt="calendar icon">
				<span class="navbar-text d-none d-lg-block">Behaviour</span>
			</a>
			
		</div>
	</nav>
</header>
<br>

<!--Inlcude database, patientid and json-->
<?php
	ob_start();
	include( "templates/conn.php" );
	include ("data.php")
?>
 
<body>
<!--Buttons-->
<div class="container"> 
	<a href="search.php" class="btn btn-outline-secondary"> Return to Search</a>
	<button type="button" class="btn btn-outline-secondary float-right" data-toggle="modal" data-target="#qrcode"> Show patient QR code </button> <br>	
</div>

<!--popup: show qr code-->
<div class="modal fade" id="qrcode" tabindex="-1" role="dialog" aria-labelledby="qrcodeLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qrcodeLabel"> <?php echo $patient['firstname'] . " " . $patient['lastname'];?> QR Code </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
	  <div class="modal-body d-flex justify-content-center">
		<div id="qr-display"  class="qrcode-center">
		</div>
	  </div>		
	</div>
  </div>
</div>


<!--container 1: patient info-->
<?php
    include( "patient.php" );
  ?>


<!--container 2: packing list-->
<?php
    include( "packing.php" );
  ?>


<!--container 3: property list-->
  <?php
    include( "property.php" );
  ?>


<!--container 4: medicine-->
<?php
    include( "medicine.php" );
  ?>


<!--container 5: visit-->
<?php
    include( "visit.php" );
?>


<!-- container 6: behaviour-->
<?php
    include( "notes.php" );
?>

<!-- footer-->
<?php
    include( "footer.php" );
?>


