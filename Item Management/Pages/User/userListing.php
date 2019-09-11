<?php
include_once '../../header.php';
include_once '../../Actions/UserAction.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    die();
}
$funObj = new UserAction();
$users = $funObj->GetUsers();

?>

<br />
<div class="mb-2"> <a class="btn btn-secondary mb-3 float-left" href="createUser.php" role="button">Create User</a>
    <h3 class="float-right">Users Listing</h3>
</div>
<br>
<table class="table table-striped table-hover table-bordered">
    <thead class="thead-light">
        <tr>
            <th scope="col">S.N</th>
            <!-- <th scope="col">Username</th> -->
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">Phone</th>
           
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
        <!-- <td><php echo $row["username"]; ?></td> -->
        <td><?php echo $row["email"]; ?></td>
        <td><?php echo $row["role"]; ?></td>
        <td><?php echo $row["name"]; ?></td>
        <td><?php echo $row["address"]; ?></td>
        <td><?php echo $row["phone"]; ?></td>
       
        <td>
            <?php if (strtolower($_SESSION["role"]) == "superadmin" || strtolower($_SESSION["role"]) == "admin" || $_SESSION["email"] == $row["email"]) {
    if (!(strtolower($_SESSION["role"]) == "admin" && strtolower($row["role"]) == "superadmin")) {?>
            <a href="createUser.php?id=<?php echo $row["id"]; ?>">Edit</a>
            <?php }
}
    ?>
        </td>
        <td>
            <?php if (strtolower($_SESSION["role"]) == "superadmin" || strtolower($_SESSION["role"]) == "admin") {
        if (strtolower($row["role"]) != "superadmin") {?>
            <a onclick="return confirm('Delete this record?'); return false;"
                href="deleteUser.php?id=<?php echo $row["id"]; ?>">Delete</a>
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