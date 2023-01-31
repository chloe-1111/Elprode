<?php
  // Get the patient's current notes and urgency from the database
  try {
      $sql = "SELECT notes, urgency FROM notes WHERE patientid = :patientid";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':patientid', $patientid);
      $stmt->execute();
    
      //if patient notes in database are empty
      $result = $stmt->fetch();
      if ($result !== false) {
        $notes = $result['notes'];
        $urgency = $result['urgency'];
    } else {
        $notes = NULL;
        $urgency = null;
    }
      
  } catch (PDOException $e) {
      // exception
      echo "Error: " . $e->getMessage();
  }
  
?>

<!-- container6: textbox behaviour-->
<div class="container" id="behaviour-container">  
  <h1> Behavioural and Characteristic Notes</h1>

    <form action="home.php?patientid=<?php echo $patientid; ?>"  method="POST">
      <div class="form-group">
        <!-- notes-->
        <textarea id="notes" name="notes" class="form-control" style="height:200px; border-width: 4px;<?php if($urgency == 1) echo 'border-color: rgba(76, 175, 80, 0.4);'; elseif($urgency == 2) echo 'border-color: rgba(255, 206, 86, 0.4);'; elseif($urgency == 3) echo 'border-color: rgba(183, 28, 28, 0.4)';?>"><?php echo htmlspecialchars($notes);?></textarea>

        <!-- patientid-->
        <input type="hidden" id="patientid" name="patientid" value="<?php echo $patientid;?>"><br>

        <!-- urgency-->
        <label for="urgency" class="form-label">Urgency level:</label><br>
            <input type="radio" id="urgency1" name="urgency" value="1"  required <?php if($urgency == 1) echo 'checked';?>>Low
            <input type="radio" id="urgency2" name="urgency" value="2"  required <?php if($urgency == 2) echo 'checked';?>>Medium
            <input type="radio" id="urgency3" name="urgency" value="3"  required <?php if($urgency == 3) echo 'checked';?>>High
            <br>
            <button type="submit" name="updatebehaviour" class="btn btn-outline-secondary float-right" > Submit </button> <br> <br>
      </div>
    </form>
</div>

<?php
if (isset($_POST['updatebehaviour'])) {
  $patientid = $_POST['patientid'];
  $notes = $_POST['notes'];
  $urgency = $_POST['urgency'];

  if (!empty($notes)) {
    try {
        // Check if the patient id exists in the notes table
        $sql = "SELECT * FROM notes WHERE patientid = :patientid";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':patientid', $patientid);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            // Update the notes if the patient id exists in the notes table
            $sql = "UPDATE notes SET notes = :notes, urgency = :urgency WHERE patientid = :patientid";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':notes', $notes);
            $stmt->bindValue(':urgency', $urgency);
            $stmt->bindValue(':patientid', $patientid);
            $stmt->execute();

            echo "<script>alert('Patient behavioural notes updated successfully!')</script>";
            echo "<script>window.location.href='home.php?patientid=$patientid'</script>";
        } else {
            // Insert a new row into the notes table if the patient id does not exist
            $sql = "INSERT INTO notes (patientid, notes, urgency) VALUES (:patientid, :notes, :urgency)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':patientid', $patientid);
            $stmt->bindValue(':notes', $notes);
            $stmt->bindValue(':urgency', $urgency);
            $stmt->execute();

            echo "<script>alert('Patient behavioural notes added successfully!')</script>";
            echo "<script>window.location.href='home.php?patientid=$patientid'</script>";
        }
    } catch (PDOException $e) {
        // Exception
        echo "Error: " . $e->getMessage();
    }
  }
}
?>




