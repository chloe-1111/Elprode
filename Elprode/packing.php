<!--container 2: list--> 
<div class="container " id="list-container">
	<h1 id="list">Packing List</h1>

    <!--show packing list from database--> 
    <?php
      $patientid = $_GET['patientid'];
      $sql = "SELECT packing.itemname FROM patient
              JOIN patientpacking ON patient.patientid = patientpacking.patientid
              JOIN packing ON patientpacking.itemid = packing.itemid
              WHERE patient.patientid = :patientid";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':patientid', $patientid);
      $stmt->execute();
      $itemnames = $stmt->fetchAll(PDO::FETCH_COLUMN);
      if($itemnames){
    ?>

        <ul>
          <?php 
              foreach($itemnames as $itemname) {
                  echo "<li>" . $itemname . "</li>";
              }
          ?>
        </ul>

    <?php
    }else{
        echo '<p> This patients packing list is empty </p>';
    }
    ?>

  <button type="button" class="btn btn-outline-secondary float-right" data-toggle="modal" data-target="#editPackingModal">Edit </button> <br>	
</div>

<!--popup: edit property-->
	<div class="modal fade" id="editPackingModal" tabindex="-1" role="dialog" aria-labelledby="editPackingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPackingModalLabel">Edit Property List</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
	      <div class="modal-body">
          <form action="home.php?patientid=<?php echo $patientid; ?>" method="POST">
            <input type="hidden" name="patientid" value="<?php echo $patientid; ?>">
          
            <?php
              // Get all properties
              $sql = "SELECT * FROM packing";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $items = $stmt->fetchAll();
              // Get patient's properties
              $sql = "SELECT * FROM patientpacking WHERE patientid = :patientid";
              $stmt = $conn->prepare($sql);
              $stmt->bindValue(':patientid', $patientid);
              $stmt->execute();
              $patient_items = $stmt->fetchAll();
              // Create an array to store patient's property IDs
              $patient_item_ids = array();
              foreach($patient_items as $patient_item) {
                $patient_item_ids[] = $patient_item['itemid'];
              }
              // Create a checklist with all properties and check the ones that the patient has
              foreach($items as $item) {
                $checked = in_array($item['itemid'], $patient_item_ids) ? "checked" : "";
                echo "<input type='checkbox' name='itemids[]' value='" . $item['itemid'] . "' " . $checked . ">" . $item['itemname'];
                echo "<br>";
              }
            ?>
          
          <input type="submit" name="updatepacking" value="Update Packing" class="btn btn-outline-secondary float-right">
        </form>
      </div>
    </div>
  </div>
</div>


<?php
  if (isset($_POST['updatepacking'])) {
    $patientid = $_POST['patientid'];
    $itemids = $_POST['itemids'];

    // Delete existing patient properties
    try { $sql = "DELETE FROM patientpacking WHERE patientid = :patientid";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':patientid', $patientid);
    $stmt->execute();

      // Insert new patient properties
      if (isset($itemids)) {
        $sql = "INSERT INTO patientpacking (patientid, itemid) VALUES (:patientid, :itemid)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':patientid', $patientid);
        foreach ($itemids as $itemid) {
          $stmt->bindValue(':itemid', $itemid);
          $stmt->execute();
        }
      }
      echo "<script>alert('Patient packing list updated successfully!')</script>";
      echo "<script>window.location.href='home.php?patientid=$patientid'</script>";
      
    } catch (PDOException $e) {
      //Exception
      echo "Error: " . $e->getMessage();
    }
  }

?>

