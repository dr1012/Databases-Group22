<?php


try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

    $itemID = $_GET['itemID'];


    $conn->query("UPDATE items SET itemViewCount = itemViewCount + 1  WHERE itemID = ".$itemID."; ");



    


?>