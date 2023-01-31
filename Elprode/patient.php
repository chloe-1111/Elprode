<!--container 1: patient information -->
<div class="container">
  <h1><?php echo $patient['firstname'] . " " . $patient['lastname'];?></h1>
  <table class="table" id="patienttable">
    <tr>
      <td>First name</td>
      <td> <?php echo $patient['firstname']; ?> </td>
    </tr>
    <tr>
      <td>Last name</td>
      <td> <?php echo $patient['lastname']; ?> </td>
    </tr>
    <tr>
      <td>Patient ID</td>
      <td> <?php echo $patient['patientid']; ?> </td>
    </tr>
    <tr>
      <td>Birthdate</td>
      <td> <?php echo $patient['birthdate']; ?> </td>
    </tr>
    <tr>
      <td>Sex</td>
      <td> <?php echo $patient['sex']; ?> </td>
    </tr>
    <tr>
      <td>Nationality</td>
      <td> <?php echo $patient['nationality']; ?></td>
    </tr>
    <tr>
      <td>Insurance Provider</td>
      <td> <?php echo $patient['insuranceprovider']; ?> </td>
    </tr>
    <tr>
      <td>Insurance Card ID</td>
      <td> <?php echo $patient['insuranceid']; ?> </td>
    </tr>
    <tr>
      <td>Address</td>
      <td> <?php echo $patient['address']; ?> </td>
    </tr>
    <tr>
      <td>Phone Number</td>
      <td> <?php echo $patient['phone']; ?> </td>
    </tr>
    <tr>
      <td> Emergency contact </td>
      <td> <?php echo $patient['emergencycontact']; ?> </td>
    </tr>

  </table>

  <button type="button" class="btn btn-outline-secondary float-right" data-toggle="modal" data-target="#editPatientModal">Edit </button> <br><br>
</div>

<!--popup: edit patient information-->
<div class="modal fade" id="editPatientModal" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="home.php?patientid=<?php echo $patientid; ?>" method="POST">
          <div class="form-group">
          <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $patient['firstname']; ?>">
          <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo $patient['lastname']; ?>">
          <label for="birthdate">Birthdate:</label>
            <input type="text" id="birthdate" name="birthdate" class="form-control" value="<?php echo $patient['birthdate']; ?>" pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}">
          <label for="sex" class="form-label">Sex:</label><br>
                  <input type="radio" id="sex" name="sex" value="Male" <?= $sex == 'Male' ? 'checked' : ''; ?>  > Male
                  <input type="radio" id="sex2" name="sex" value="Female" <?= $sex == 'Female' ? 'checked' : ''; ?> > Female
                  <input type="radio" id="sex3" name="sex" value="Other" <?= $sex == 'Other' ? 'checked' : ''; ?> > Other 
          <br><label for="nationality">Nationality:</label>
            <input type="text" id="nationality" name="nationality" class="form-control" value="<?php echo $patient['nationality']; ?>">
          <label for="insuranceprovider">Insurance Provider:</label>
            <input type="text" id="insuranceprovider" name="insuranceprovider" class="form-control"value="<?php echo $patient['insuranceprovider']; ?>">
          <label for="insuranceid">Insurance ID:</label>
            <input type="text" id="insuranceid" name="insuranceid" class="form-control" value="<?php echo $patient['insuranceid']; ?>">
          <label for="address">Address:</label>
            <input type="text" id="address" name="address" class="form-control" value="<?php echo $patient['address']; ?>">
          <label for="phone">Phone number:</label>
            <input type="phone" id="phone" name="phone" class="form-control" value="<?php echo $patient['phone']; ?>">
          <label for="emergencycontact">Emergency Contact:</label>
            <input type="text" id="emergencycontact" name="emergencycontact" class="form-control" value="<?php echo $patient['emergencycontact']; ?>"><br>
          <input type=submit name="updatepatient" class="btn btn-outline-secondary float-right"> 
          </div>
        </form> 
	    </div>
	  </div>
  </div>
</div>


<!--php: edit patient information-->
  <?php

  if (isset($_POST['updatepatient']))  {
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
    
    //update patient info
    try {
      $sql = "UPDATE patient SET firstname = :firstname, lastname = :lastname, birthdate = :birthdate, sex = :sex, nationality = :nationality, insuranceprovider = :insuranceprovider, insuranceid = :insuranceid, address = :address, phone = :phone, emergencycontact = :emergencycontact WHERE patientid = :patientid";
      $stmt = $conn->prepare($sql);
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
      $stmt->bindValue(':patientid', $patientid);
      $stmt->execute();
      echo "<script>alert('Patient information updated successfully!')</script>";
      echo "<script>window.location.href='home.php?patientid=$patientid'</script>";
      
    } catch (PDOException $e) {
      //Exception
      echo "Error: " . $e->getMessage();
    }
  }
?>

