<!--container 4: medicine--> 
<div class="container" id="medicine-container">
  <h1 id="currentmedicine" >Current Medication</h1>
  <canvas id="myChart" width="100%" height="50px"></canvas>
  <button class="btn btn-outline-secondary float-right" data-toggle="modal" data-target="#editMedicineModal"> Add </button> <br>
</div>


<!--popup: edit medication form-->
<div class="modal fade" id="editMedicineModal" tabindex="-1" role="dialog" aria-labelledby="editMedicineModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMedicineModalLabel">Edit Patients Medication</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <div class="form-group">
            <!--Date, medication and dosage-->
            <label for="date">Date:</label> 
              <input type="text" id="date" name="date" class="form-control" placeholder="dd-mm-yyyy"pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" required>
            <label for="medicationid">Medication </label><br>
              <select class="form-control" id="medicationid" name="medicationid" required >
                <option value="" disabled selected>Select a Medication</option>
                  <?php
                  $query = "SELECT medicationid, medication FROM medicine";
                  $stmt = $conn->prepare($query);
                  $stmt->execute();
                  $medications = $stmt->fetchAll();
                  foreach ($medications as $medication) {
                      echo '<option value="'.$medication['medicationid'].'">'.$medication['medication'].'</option>';
                  }
                  ?>
              </select><br>
            <label for="dosage">Dosage:</label>
              <input type="text" id="dosage" name="dosage" class="form-control" required><br>
            
            <input type=submit class="btn btn-outline-secondary float-right"> 
        </form> 
      </div>
    </div>
  </div>
</div>

 
<!--add new medication php-->
<?php
  if(isset($_POST['date']) && isset($_POST['medicationid']) && isset($_POST['dosage'])) {
    $patientid = $_GET['patientid'];
    $date = $_POST['date'];
    $medicationid = $_POST['medicationid'];
    $dosage = $_POST['dosage'];

    // check if record already exists
    $check_query = "SELECT * FROM patientmedicine WHERE patientid = :patientid AND medicationid = :medicationid AND date = :date";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bindParam(':patientid', $patientid);
    $check_stmt->bindParam(':medicationid', $medicationid);
    $check_stmt->bindParam(':date', $date);
    $check_stmt->execute();
    $result = $check_stmt->fetch();
    if ($result) {
      echo "<script>alert('Error: This medication record already exists')</script>";
      echo "<script>window.location.href='home.php?patientid=$patientid'</script>";
    } else {
        // insert new record
        $query = "INSERT INTO patientmedicine (patientid, medicationid, dosage, date) VALUES (:patientid, :medicationid, :dosage, :date)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':patientid', $patientid);
        $stmt->bindParam(':medicationid', $medicationid);
        $stmt->bindParam(':dosage', $dosage);
        $stmt->bindParam(':date', $date);

        if($stmt->execute()) {
        echo "<script>alert('Patient mediciation added successfully!')</script>";
        echo "<script>window.location.href='home.php?patientid=$patientid'</script>";
        
        } else {
          echo "Error: " . $e->getMessage();
          }
    }
  }
?>
</div> 


