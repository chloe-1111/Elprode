<html>
<head>
	<meta charset="UTF 8" />
	<meta name="viewport" ccontent="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
	
	<!--title-->
	<title>Search</title>

	<!--style sheets-->
	<link rel="shortcut icon" href="images/logo.png" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="custom/custom.css" />
		
	<!--java-->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>


<!--header image-->
<header>
	<div id="header-img" style="background-image: url(images/header2.png);"></div>
</header>


<!--include db connection-->
<?php
  session_start();
  include( "templates/conn.php" );
?>

<body>
<!--search function -->
<div class="container">
	<form action="home.php?patientid=" method="POST" onsubmit="appendPatientID();">
		<h1> Search </h1>
		  <label for="patientid" class="form-label">Enter the patients ID below or use the camera to scan the patients QR code:</label>
			<input type="text" class="form-control" id="patientid" name="patientid" required><br>
		<input type="submit" class="btn btn-outline-secondary float-right" name="search" value="Search"><a href="home.php"></a>
	</form>
	
  
<!--add entered patient id to the URL -->
    <script>
      function appendPatientID() {
        var patientID = document.getElementById("patientid").value;
        var currentURL = document.forms[0].action;
        document.forms[0].action = currentURL + patientID;
      }
    </script>


<!--add function -->
    <h1> Add a New Patient </h1> 
    <button type="button" class="btn btn-outline-secondary " data-toggle="modal" data-target="#addPatientModal"> Add </button> <br><br>
  </div>
  
  
<!--popup: add patient information-->
<div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPatientModalLabel"> Add new Patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div class="form-group">
          <label for="patientid">Patient ID:</label>
            <input type="text" id="patientid" name="patientid" class="form-control" placeholder="7 digits" pattern="[0-9]{7}" required  >
          <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" class="form-control" required >
          <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" class="form-control" required>
          <label for="birthdate">Birthdate:</label>
            <input type="text" id="birthdate" name="birthdate" class="form-control"  placeholder="dd-mm-yyyy" pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" required>
          <label for="sex" class="form-label">Sex:</label><br>
                  <input type="radio" id="sex" name="sex" value="Male" > Male
                  <input type="radio" id="sex2" name="sex" value="Female"  > Female
                  <input type="radio" id="sex3" name="sex" value="Other" > Other 
          <br><label for="nationality">Nationality:</label>
            <input type="text" id="nationality" name="nationality" class="form-control" >
          <label for="insuranceprovider">Insurance Provider:</label>
            <input type="text" id="insuranceprovider" name="insuranceprovider" class="form-control" required>
          <label for="insuranceid">Insurance ID:</label>
            <input type="text" id="insuranceid" name="insuranceid" class="form-control" required>
          <label for="address">Address:</label>
            <input type="text" id="address" name="address" class="form-control" >
          <label for="phone">Phone number:</label>
            <input type="phone" id="phone" name="phone" class="form-control" >
          <label for="emergencycontact">Emergency Contact:</label>
            <input type="text" id="emergencycontact" name="emergencycontact" class="form-control"><br>
          <input type=submit name="addpatient" class="btn btn-outline-secondary float-right"> 
          </div>       
        </form> 
      </div>
    </div>
  </div>
</div>


<!--php: add patient information-->
<?php
  if (isset($_POST['addpatient']))  {
    $patientid = $_REQUEST['patientid'];
    $firstname = $_REQUEST['firstname'];
    $lastname = $_REQUEST['lastname'];
    $birthdate = $_REQUEST['birthdate'];
    $sex = $_REQUEST['sex'];
    $nationality = $_REQUEST['nationality'];
    $insuranceprovider = $_REQUEST['insuranceprovider'];
    $insuranceid = $_REQUEST['insuranceid'];
    $address = $_REQUEST['address'];
    $phone = $_REQUEST['phone'];
    $emergencycontact = $_REQUEST['emergencycontact'];
    
    try {
      $add = "INSERT INTO patient (patientid, firstname, lastname, birthdate, sex, nationality, insuranceprovider, insuranceid, address, phone, emergencycontact) VALUES (:patientid, :firstname, :lastname, :birthdate, :sex, :nationality, :insuranceprovider, :insuranceid, :address, :phone, :emergencycontact)" ;
      $stmt = $conn->prepare($add);
    $stmt->bindValue(':patientid', $patientid);
      $stmt->bindValue(':firstname', $firstname);
      $stmt->bindValue(':lastname', $lastname);
      $stmt->bindValue(':birthdate', $birthdate);
      $stmt->bindValue(':sex', $sex);
      $stmt->bindValue(':nationality', $nationality);
      $stmt->bindValue(':insuranceprovider', $insuranceprovider);
      $stmt->bindValue(':insuranceid', $insuranceid);
      $stmt->bindValue(':address', $address);
      $stmt->bindValue(':phone', $phone);
      $stmt->bindValue(':emergencycontact', $emergencycontact);

      $stmt->execute();
      echo "<script>alert('Patient added successfully!')</script>";
    echo "<script>window.location.href='home.php?patientid=$patientid'</script>";
      exit();
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
?>


</body>
</html>