<?php 
    include ("../assets/config/db_config.php");

    if(isset($_POST["linkId"]))
    {
        $query = $connection->prepare("UPDATE sites SET clicks = clicks + 1 WHERE id=:id");
        $query->bindParam(":id", $_POST["linkId"]);
        $query->execute();
    }
    else echo "No link passed to page";
?>