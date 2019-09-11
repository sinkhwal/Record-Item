<?php
include_once '../../header.php';
include_once '../../Actions/ItemAction.php';

$funObj = new ItemAction();
$users = $funObj->GetItems();

?>

<br />
<div class="mb-2"> <a class="btn btn-secondary mb-3 float-left" href="createItem.php" role="button">Create Item</a>
    <h3 class="float-right">Items Listing</h3>
</div>
<br>
<table class="table table-striped table-hover table-bordered">
    <thead class="thead-light">
        <tr>
            <th scope="col">S.N</th>
            <th scope="col">Description</th>
            <th scope="col">Location</th>
            <th scope="col">coordinates</th>
            <th scope="col">Make</th>
            <th scope="col">Model</th>
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
        <td><?php echo $row["description"]; ?></td>
        <td><?php echo $row["location"]; ?></td>
        <td><?php echo $row["coordinates"]; ?></td>
        <td><?php echo $row["make"]; ?></td>
        <td><?php echo $row["model"]; ?></td>
        <td><?php echo $row["created_by"]; ?></td>

        <td>
            <?php if (strtolower($_SESSION["role"]) == "superadmin" || strtolower($_SESSION["role"]) == "admin" || $_SESSION["email"] == $row["created_by"]) {
    if (!(strtolower($_SESSION["role"]) == "admin" && strtolower($row["created_by"]) == "superadmin")) {?>
            <a href="createItem.php?id=<?php echo $row["id"]; ?>">Edit</a>
            <?php }
}
    ?>
        </td>
        <td>
            <?php if (strtolower($_SESSION["role"]) == "superadmin" || strtolower($_SESSION["role"]) == "admin" || $_SESSION["email"] == $row["created_by"]) {
    if (!(strtolower($_SESSION["role"]) == "admin" && strtolower($row["created_by"]) == "superadmin")) {?>
            <a onclick="return confirm('Delete this record?'); return false;"
                href="deleteItem.php?id=<?php echo $row["id"]; ?>">Delete</a>

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