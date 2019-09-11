<?php
include_once '../../header.php';
include_once '../../Actions/ItemAction.php';

$funObj = new ItemAction();
$itemId = '';
if (isset($_GET['id'])) {
    $itemId = $_GET['id'];
}

$item = $funObj->GetItemByID($itemId);

if (isset($_POST["createItem"])) {
    $description =  $funObj->escape_string($_POST['description']);
    $location =  $funObj->escape_string($_POST['location']);
    $coordinates =  $funObj->escape_string($_POST['coordinates']);
    $make =  $funObj->escape_string($_POST['make']);
    $model =  $funObj->escape_string($_POST['model']);

  
    $field = array(  
        'description'     =>     $description,  
        'location'     =>     $location  
   ); 
    if ($funObj->required_validation($field)) {
        $item = $funObj->CreateItem($itemId,$description,$location,$coordinates,$make,$model);
        if ($item) {
            // Registration Success
            header("location:itemListing.php");
        } else {
            $message = $funObj->error;
        }
    } else {
        $message = $funObj->error;
    }
}

?>
<!-- <h3 class="float-right">Create item</h3><br />   -->
<br>
<form method="post" class="float-left w-50">
    <?php  
                if(isset($message))  
                {  
                     echo '<br><label class="text-danger bs-linebreak">'.$message.'</label><br>';  
                }  
                ?>
    <label>Description</label>
    <input type="text" name="description"
        value="<?php echo isset($_POST["description"]) ? $_POST["description"] :  $item["description"] ?>"
        class="form-control" placeholder="Enter Description" />
    <br />
    <label>Location</label>
    <input type="text" name="location"
        value="<?php echo isset($_POST["location"]) ? $_POST["location"] : $item["location"]?>" class="form-control"
        placeholder="Enter Location" />
    <br />
    <label>Coordinates</label>
    <input type="text" name="coordinates"
        value="<?php echo isset($_POST["coordinates"]) ? $_POST["coordinates"] :  $item["coordinates"]?>"
        class="form-control" placeholder="Enter Coordinates" />
    <br />
    <label>Make</label>
    <input type="text" name="make" value="<?php echo isset($_POST["make"]) ? $_POST["make"] :  $item["make"]?>"
        class="form-control" placeholder="Enter Make" />
    <br />
    <label>Model</label>
    <input type="text" name="model" value="<?php echo isset($_POST["model"]) ? $_POST["model"] : $item["model"]?>"
        class="form-control" placeholder="Enter Model" />
    <br />
    <input type="submit" name="createItem" class="btn btn-info"
        value="<?php if( $itemId == "") echo "Create Item"; else echo "Update Item";?>" />
</form>
</div>
<br />
</body>

</html>