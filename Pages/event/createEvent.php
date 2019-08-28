<?php
include_once '../../index.php';
include_once '../../Actions/eventAction.php';

$funObj = new eventAction();
$eventId = '';
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
}
$event = $funObj->GetEventByID($eventId);

if (isset($_POST["createEvent"])) {
    $organization =  $funObj->escape_string($_POST['organization']);
    $event_title =  $funObj->escape_string($_POST['event_title']);
    $event_description =  $funObj->escape_string($_POST['event_description']);
    $event_location =  $funObj->escape_string($_POST['event_location']);
    $event_presenter =  $funObj->escape_string($_POST['event_presenter']);
    $event_date =  $funObj->escape_string($_POST['event_date']);
    $event_type =  $funObj->escape_string($_POST['event_type']);

  
    $field = array(  
        'organization'     =>     $organization,  
        'event_title'     =>     $event_title  
   ); 
    if ($funObj->required_validation($field)) {
        $event = $funObj->CreateEvent($eventId,$organization,$event_title,$event_description,$event_location,$event_presenter,$event_date,$event_type);
        if ($event) {
            // Registration Success
            header("location:eventListing.php");
        } else {
            $message = $funObj->error;
        }
    } else {
        $message = $funObj->error;
    }
}

?>
<!-- <h3 class="float-right">Create event</h3><br />   -->
<br>
<form method="post" class="float-left w-50">
    <?php  
                if(isset($message))  
                {  
                     echo '<br><label class="text-danger bs-linebreak">'.$message.'</label><br>';  
                }  
                ?>

<label>Organization</label>
    <input type="text" name="organization"
        value="<?php echo isset($_POST["organization"]) ? $_POST["organization"] :  $event["organization"] ?>"
        class="form-control" placeholder="Enter Organization" />
    <br />                
    <label>Event Title</label>
    <input type="text" name="event_title"
        value="<?php echo isset($_POST["event_title"]) ? $_POST["event_title"] :  $event["event_title"] ?>"
        class="form-control" placeholder="Enter Event Title" />
    <br />
    <label>Event Description</label>
    <input type="text" name="event_description" rows="4"
        value="<?php echo isset($_POST["event_description"]) ? $_POST["event_description"] : $event["event_description"]?>" class="form-control"
        placeholder="Enter Event Description" />
    <br />
    <label>Event Location</label>
    <input type="text" name="event_location"
        value="<?php echo isset($_POST["event_location"]) ? $_POST["event_location"] :  $event["event_location"]?>"
        class="form-control" placeholder="Enter Event Location" />
    <br />
    <label>Event Presenter</label>
    <input type="text" name="event_presenter" value="<?php echo isset($_POST["event_presenter"]) ? $_POST["event_presenter"] :  $event["event_presenter"]?>"
        class="form-control" placeholder="Enter Event Presenter" />
    <br />
    <label>Event Date</label>
    <input type="text" name="event_date" value="<?php echo isset($_POST["event_date"]) ? $_POST["event_date"] : $event["event_date"]?>"
        class="form-control" placeholder="Enter Event Date" />
        
    <br />
    <label>Event Type</label>
    <!-- <input type="text" name="event_type" value="<?php echo isset($_POST["event_type"]) ? $_POST["event_type"] : $event["event_type"]?>"
        class="form-control" placeholder="Enter Event Date" /> -->
        <select name="event_type" class="form-control">
        <option value="Show" <?php if( $event["event_type"]=="Show") echo "selected";?>>Show</option>
        <option value="Seminar" <?php if( $event["event_type"]=="Seminar") echo "selected";?>>Seminar</option>
        <option value="Talk" <?php if( $event["event_type"]=="Talk") echo "selected";?>>Talk</option>
    </select>
    
    
    <br />

    <input type="submit" name="createEvent" class="btn btn-info"
        value="<?php if( $eventId == "") echo "Create Event"; else echo "Update Event";?>" />
</form>
</div>
<br />
</body>

</html>