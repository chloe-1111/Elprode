<!--container 3: property-->
<div class="container " id="property-container">
	<h1 id="property" >Property  </h1>

    <!--show property list from database--> 
    <?php
      $patientid = $_GET['patientid'];
      $sql = "SELECT property.propertyname FROM patient
              JOIN patientproperty ON patient.patientid = patientproperty.patientid
              JOIN property ON patientproperty.propertyid = property.propertyid
              WHERE patient.patientid = :patientid";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':patientid', $patientid);
      $stmt->execute();
      $propertynames = $stmt->fetchAll(PDO::FETCH_COLUMN);
      if($propertynames){
    ?>

      <ul>
        <?php 
            foreach($propertynames as $propertyname) {
                echo "<li>" . $propertyname . "</li>";
            }
        ?>
      </ul>

    <?php
    }else{
        echo '<p> This patients property list is empty  </p>';
    }
    ?>
    
  <button type="button" class="btn btn-outline-secondary float-right" data-toggle="modal" data-target="#editPropertyModal">Edit </button> <br>	
</div>

<!--popup: edit property-->
<div class="modal fade" id="editPropertyModal" tabindex="-1" role="dialog" aria-labelledby="editPropertyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPrpertyModalLabel">Edit Property List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="home.php?patientid=<?php echo $patientid; ?>" method="POST">
          <input type="hidden" name="patientid" value="<?php echo $patientid; ?>">
          
            <?php
              // Get all properties
              $sql = "SELECT * FROM property";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $properties = $stmt->fetchAll();
              // Get patient's properties
              $sql = "SELECT * FROM patientproperty WHERE patientid = :patientid";
              $stmt = $conn->prepare($sql);
              $stmt->bindValue(':patientid', $patientid);
              $stmt->execute();
              $patient_properties = $stmt->fetchAll();
              // Create an array to store patient's property IDs
              $patient_property_ids = array();
              foreach($patient_properties as $patient_property) {
                $patient_property_ids[] = $patient_property['propertyid'];
              }
              // Create a checklist with all properties and check the ones that the patient has
              foreach($properties as $property) {
                $checked = in_array($property['propertyid'], $patient_property_ids) ? "checked" : "";
                echo "<input type='checkbox' name='propertyids[]' value='" . $property['propertyid'] . "' " . $checked . ">" . $property['propertyname'];
                echo "<br>";
              }
            ?>
          
          <input type="submit" name="updateproperties" value="Update Properties" class="btn btn-outline-secondary float-right">
        </form>
      </div>
    </div>
  </div>
</div>


<!--edit property-->
<?php
  if (isset($_POST['updateproperties'])) {
    $patientid = $_POST['patientid'];
    $propertyids = $_POST['propertyids'];

    // Delete existing patient properties
    try{$sql = "DELETE FROM patientproperty WHERE patientid = :patientid";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':patientid', $patientid);
    $stmt->execute();

      // Insert new patient properties
      if (isset($propertyids)) {
        $sql = "INSERT INTO patientproperty (patientid, propertyid) VALUES (:patientid, :propertyid)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':patientid', $patientid);
        foreach ($propertyids as $propertyid) {
          $stmt->bindValue(':propertyid', $propertyid);
          $stmt->execute();
        }
      }
      echo "<script>alert('Patient property list updated successfully!')</script>";
      echo "<script>window.location.href='home.php?patientid=$patientid'</script>";
      exit();
    } catch (PDOException $e) {
      //Exception
      echo "Error: " . $e->getMessage();
    }
  }
?>

