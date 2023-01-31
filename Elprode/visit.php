<!--container 5: visit-->
<div class="container">
  <h1 id="visit">Hospital Visit</h1>
  <div class="row">

    <div id="heatmap-navigation" class="col-sm-12 col-md-12 mx-auto">    
      <button id="heatmap-previous" style="margin-bottom: 5px; width: 20px; height: 20px; padding: 0; font-size:0.8em;" class="btn btn-secondary">
        <
      </button>    
      <button id="heatmap-next" style="margin-bottom: 5px; width: 20px; height: 20px; padding: 0; font-size:0.8em;" class="btn btn-secondary">
        >
      </button>
    </div> 

    <div id="cal-heatmap" >  
    </div> 

  </div>    

  <button type="button" class="btn btn-outline-secondary float-right" data-toggle="modal" data-target="#editVisitModal"> Add </button> <br>	
</div>

<!--popup: add visit form-->
  <div class="modal fade" id="editVisitModal" tabindex="-1" role="dialog" aria-labelledby="editVisitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editVisitModalLabel"> Add a Patient Visit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form method="post" action="">
            <div class="form-group">
              <label for="checkin">Check-In Date:</label>
                <input type="text" id="checkin" name="checkin" class="form-control" placeholder="dd-mm-yyyy"  pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" required>
              <label for="checkout">Check-Out Date:</label>
                <input type="text" id="checkout" name="checkout" class="form-control" placeholder="dd-mm-yyyy" pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" required><br>
            
            <input type=submit class="btn btn-outline-secondary float-right"> 
            </div>
          </form> 
        </div>
      </div>
    </div>
  </div>
 


<!--add new visit php-->
<?php
  if(isset($_POST['checkin']) && isset($_POST['checkout'])) {
    $patientid = $_GET['patientid'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
  

    // check if record already exists
    $check_query = "SELECT * FROM hospital WHERE patientid = :patientid AND checkin = :checkin AND checkout = :checkout";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bindParam(':patientid', $patientid);
    $check_stmt->bindParam(':checkin', $checkin);
    $check_stmt->bindParam(':checkout', $checkout);
    $check_stmt->execute();
    $result = $check_stmt->fetch();
    if ($result) {
      echo "<script>alert('Error: This hospital visit already exists')</script>";
      echo "<script>window.location.href='home.php?patientid=$patientid'</script>";
    } else {
        // insert new record
        $query = "INSERT INTO hospital (patientid, checkin, checkout) VALUES (:patientid, :checkin, :checkout)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':patientid', $patientid);
        $stmt->bindParam(':checkin', $checkin);
        $stmt->bindParam(':checkout', $checkout);
    
        if($stmt->execute()) {
          echo "<script>alert('Patients hospital visit added successfully!')</script>";
          echo "<script>window.location.href='home.php?patientid=$patientid'</script>";
        } else {
           //error
            echo "Error: " . implode(',',$stmt->errorInfo());
        }
    }
  }
?>


