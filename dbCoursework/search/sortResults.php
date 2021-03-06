<?php
// Site root:
$siteroot = '/Databases-Group22/dbCoursework/';

try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// User variables:
if(isset($_SESSION['user_ID'])){
    $buyerID = $_SESSION['user_ID'];
} else {
    $buyerID = NULL;
}

$sort = $_POST['sort'];

$res = $_POST['res'];

// Perform sort based on criteria:
if ($sort == 0){
    function cmp($a, $b){
        return strcmp($a['endDate'], $b['endDate']);
    }
    usort($res, "cmp");
} else if ($sort == 1){
    function cmp($a, $b){
        return strcmp($b['endDate'], $a['endDate']);
    }
    usort($res, "cmp");
} else if ($sort == 2){
    function cmp($a, $b){
        return($a['bidAmount'] < $b['bidAmount']) ? -1 : 1;
    }
    usort($res, "cmp");
} else if ($sort == 3){
    function cmp($a, $b){
        return($a['bidAmount'] > $b['bidAmount']) ? -1 : 1;
    }
    usort($res, "cmp");
}

// Generate html:
$rownumber = 0;

foreach ($res as $searchResult) {
    if (new DateTime($searchResult['endDate']) > new DateTime()) {

        $itemID = $searchResult['itemID'];
        $title = $searchResult['title'];
        $photo = $searchResult['photo'];
        $description = $searchResult['description'];
        $startPrice = $searchResult['startPrice'];
        $currentPrice= $searchResult['bidAmount'];
        $lastBid = $searchResult['bidDate'];

        $current_date =  new DateTime();

        $bid_end_date =  new DateTime($searchResult['endDate']);
        $interval = $current_date->diff($bid_end_date);
        $elapsed = $interval->format('%y y %m m %a d %h h %i min %s s');

        // MODAL:
        include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/commonElements/itemModal.php";
        $rownumber += 1;

    }
}





?>
