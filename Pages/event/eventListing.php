<?php
include_once '../../index.php';
include_once '../../Actions/EventAction.php';

$funObj = new EventAction();
$users = $funObj->GetEvents();

?>

<br />
<div class="mb-2"> <a class="btn btn-secondary mb-3 float-left" href="createEvent.php" role="button">Create Event</a>
    <h3 class="float-right">Events Listing</h3>
</div>
<br>
<table class="table table-striped table-hover table-bordered">
    <thead class="thead-light">
        <tr>
            <th scope="col">S.N</th>
            <th scope="col">Organization</th>
            <th scope="col">Event Title</th>
            <th scope="col">Detail</th>
            <th scope="col">Location</th>
            <th scope="col">Presenter</th>
            <th scope="col">Date</th>
            <th scope="col">Event Type</th>
            <th scope="col">Created By</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php

$count = 1;

//return $result->fetch_assoc();
while ($row = $users->fetch_assoc()) {?>
        <td><?php echo $count; ?></td>
        <td><?php echo $row["organization"]; ?></td>
        <td><?php echo $row["event_title"]; ?></td>
        <td><?php echo $row["event_description"]; ?></td>
        <td><?php echo $row["event_location"]; ?></td>
        <td><?php echo $row["event_presenter"]; ?></td>
        <td><?php echo $row["event_date"]; ?></td>
        <td><?php echo $row["event_type"]; ?></td>
        <td><?php echo $row["created_by"]; ?></td>

        <td>
            <?php if (strtolower($_SESSION["role"]) == "superadmin" || strtolower($_SESSION["role"]) == "admin" || $_SESSION["username"] == $row["created_by"]) {
    if (!(strtolower($_SESSION["role"]) == "admin" && strtolower($row["created_by"]) == "superadmin")) {?>
            <a href="createEvent.php?id=<?php echo $row["id"]; ?>">Edit</a>
            <?php }
}
    ?>
        </td>
        <td>
            <?php if (strtolower($_SESSION["role"]) == "superadmin" || strtolower($_SESSION["role"]) == "admin" || $_SESSION["username"] == $row["created_by"]) {
    if (!(strtolower($_SESSION["role"]) == "admin" && strtolower($row["created_by"]) == "superadmin")) {?>
            <a onclick="return confirm('Delete this record?'); return false;"
                href="deleteEvent.php?id=<?php echo $row["id"]; ?>">Delete</a>

            <?php }
}
    ?>
        </td>
        </tr>
        <?php $count++;}?>
    </tbody>
</table>
</div>
</body>

</html>