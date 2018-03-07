
<?php
    $siteroot = '/Databases-Group22/dbCoursework/';
    include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHead.php";

?>

<body>

<?php
    include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHeader.php";

    //include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/sideMenu.php";

    // Check if advanced search has been made:
    if (isset($_GET['filteredSubmit'])){
        $searchTerm = $_GET['searchTerm'];
        $parentCategory = $_GET['parentCat'];
        // Check if subcategory has been submitted:
        if (isset($_GET['subCat'])){
            $subCategory = $_GET['subCat'];
        } else{
            $subCategory = 0; // Default "Any" subcategory is numbered 0
        }
        $condition = $_GET['itemCondition'];
        $minPrice = $_GET['minPrice'];
        $maxPrice = $_GET['maxPrice'];

        // Set the min price if there is one, otherwise set it = to 0.
        if (empty($minPrice)) {
            print("Minimum price was NOT chosen. ");
            $minPrice = 0;
        } else{
            print("Minimum price is £".$minPrice.". ");
        }

        // Same with the max price
        if (empty($maxPrice)){
            print("Maximum price was NOT chosen. ");
            $maxPrice = 10000000000;
        } else {
            print("Maximum price is £".$maxPrice.". ");
        }




        /**
        INCLUDE PARAMETERS FOR SORTING THE SEARCH RESULTS LATER.
        ALSO NEED TO HANDLE PARENT CATEGORY LATER AND PRICES
        **/

        // CASE: subcategory was picked.
        if (!$subCategory == 0){
            print("Subcategory was chosen. ");

            // CASE: item condition was picked:
            if (!$condition == 0){
                print("Item condition was chosen. ");
                $sql_query = "SELECT *
                                FROM items i
                                INNER JOIN (
                                	SELECT b.itemID, b.bidAmount, b.bidDate
                                	FROM bids b
                                	INNER JOIN (
                                		SELECT itemID, MAX(bidAmount) bidAmount
                                		FROM bids
                                		GROUP BY itemID
                                	) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                                ) d ON i.itemID = d.itemID
                                WHERE (i.title LIKE '%".$searchTerm."%' OR i.description LIKE '%".$searchTerm."%')
                                	AND i.itemCondition = '".$condition."'
                                    AND d.bidAmount BETWEEN ".$minPrice."  AND ".$maxPrice."
                                    AND i.categoryID = ".$subCategory."
                                ORDER BY i.endDate ASC;";

                print("SQL Query is: ".$sql_query." ");
                $statement = $conn->prepare($sql_query);

            } else {
                print("Item condition was NOT chosen. ");
                // CASE: item condition NOT picked
                $sql_query = "SELECT *
                                FROM items i
                                INNER JOIN (
                                	SELECT b.itemID, b.bidAmount, b.bidDate
                                	FROM bids b
                                	INNER JOIN (
                                		SELECT itemID, MAX(bidAmount) bidAmount
                                		FROM bids
                                		GROUP BY itemID
                                	) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                                ) d ON i.itemID = d.itemID
                                WHERE (i.title LIKE '%".$searchTerm."%' OR i.description LIKE '%".$searchTerm."%')
                                    AND d.bidAmount BETWEEN ".$minPrice."  AND ".$maxPrice."
                                    AND i.categoryID = ".$subCategory."
                                ORDER BY i.endDate ASC;";
                print("SQL Query is: ".$sql_query." ");
                $statement = $conn->prepare($sql_query);

            }

        } else {
            print("Subcategory was NOT chosen. ");

            // Parent Category WAS chosen
            if (!$parentCategory == 0){
                print("But parent category WAS chosen. ");

                // Check if condition was chosen:
                if (!$condition == 0){
                    print("Item condition was chosen. ");
                    $sql_query = "SELECT *
                                    FROM items i
                                    INNER JOIN (
                                    	SELECT b.itemID, b.bidAmount, b.bidDate
                                    	FROM bids b
                                    	INNER JOIN (
                                    		SELECT itemID, MAX(bidAmount) bidAmount
                                    		FROM bids
                                    		GROUP BY itemID
                                    	) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                                    ) d ON i.itemID = d.itemID
                                    WHERE (i.title LIKE '%".$searchTerm."%' OR i.description LIKE '%".$searchTerm."%')
                                        AND i.itemID IN (SELECT i.itemID FROM items i, categories c
                                                        WHERE i.categoryID = c.categoryID
                                                        AND c.parentCategory = '".$parentCategory."')
                                        AND d.bidAmount BETWEEN ".$minPrice."  AND ".$maxPrice."
                                    ORDER BY i.endDate ASC;";
                    print("SQL Query is: ".$sql_query." ");
                    $statement = $conn->prepare($sql_query);
                } else {
                    print("Item condition was NOT chosen. ");
                    // No condition was chosen -->
                    $sql_query = "SELECT *
                                    FROM items i
                                    INNER JOIN (
                                    	SELECT b.itemID, b.bidAmount, b.bidDate
                                    	FROM bids b
                                    	INNER JOIN (
                                    		SELECT itemID, MAX(bidAmount) bidAmount
                                    		FROM bids
                                    		GROUP BY itemID
                                    	) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                                    ) d ON i.itemID = d.itemID
                                    WHERE (i.title LIKE '%".$searchTerm."%' OR i.description LIKE '%".$searchTerm."%')
                                        AND i.itemID IN (SELECT i.itemID FROM items i, categories c
                                                            WHERE i.categoryID = c.categoryID
                                                            AND c.parentCategory = '".$parentCategory."')
                                        AND d.bidAmount BETWEEN ".$minPrice."  AND ".$maxPrice."
                                    ORDER BY i.endDate ASC;";
                    $statement = $conn->prepare($sql_query);
                    print("SQL Query is: ".$sql_query." ");

                }

            } // Parent Category WAS NOT chosen
            else {
                print("Parent Category ALSO NOT chosen. ");

                // Check if condition was chosen:
                if (!$condition == 0){
                    $sql_query = "SELECT *
                                    FROM items i
                                    INNER JOIN (
                                    	SELECT b.itemID, b.bidAmount, b.bidDate
                                    	FROM bids b
                                    	INNER JOIN (
                                    		SELECT itemID, MAX(bidAmount) bidAmount
                                    		FROM bids
                                    		GROUP BY itemID
                                    	) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                                    ) d ON i.itemID = d.itemID
                                    WHERE (i.title LIKE '%".$searchTerm."%' OR i.description LIKE '%".$searchTerm."%')
                                    	AND i.itemCondition = '".$condition."'
                                        AND d.bidAmount BETWEEN ".$minPrice."  AND ".$maxPrice."
                                    ORDER BY i.endDate ASC;";
                    $statement = $conn->prepare($sql_query);
                    print("SQL Query is: ".$sql_query." ");

                } else {
                    print("Item condition was NOT chosen. ");
                    // No condition was chosen -->
                    $sql_query = "SELECT *
                                    FROM items i
                                    INNER JOIN (
                                    	SELECT b.itemID, b.bidAmount, b.bidDate
                                    	FROM bids b
                                    	INNER JOIN (
                                    		SELECT itemID, MAX(bidAmount) bidAmount
                                    		FROM bids
                                    		GROUP BY itemID
                                    	) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                                    ) d ON i.itemID = d.itemID
                                    WHERE (i.title LIKE '%".$searchTerm."%' OR i.description LIKE '%".$searchTerm."%')
                                        AND d.bidAmount BETWEEN ".$minPrice."  AND ".$maxPrice."
                                    ORDER BY i.endDate ASC;";
                    $statement = $conn->prepare($sql_query);
                    print("SQL Query is: ".$sql_query." ");

                }

            }


        }

        $statement->execute();
        $res = $statement->fetchAll();
        $url = 'search_result_page.php?searchTerm='.$searchTerm.'&parentCategory='.$parentCategory.'&subCategory='.$subCategory.'&condition='.$condition;



    } else if (isset($_GET['searchBarSubmit'])) { // Search was made using the search bar only

        $searchTerm = $_GET['searchTerm']; // get the search term

        $sql_query = 'SELECT *
                        FROM items i
                        WHERE (i.title LIKE :searchTerm OR i.description LIKE :searchTerm)
                        ORDER BY i.endDate ASC';
        $statement = $conn->prepare($sql_query);
        $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');

        $statement->execute();
        $res = $statement->fetchAll();
        $url = 'search_result_page.php?searchTerm='.$searchTerm;

    } else {
        // No search was made -->
        $sql_query = 'SELECT *
                        FROM items i
                        ORDER BY i.endDate ASC';
        $statement = $conn->prepare($sql_query);
        $statement->execute();
        $res = $statement->fetchAll();
        $url = 'search_result_page.php';
    }

 ?>

 <h1 class="page-header">Search Results:</h1>



 <div class="row placeholders">



     <?php # begin php
     $rownumber = 0;

     foreach ($res as $searchResult) {
         if (new DateTime($searchResult['endDate']) > new DateTime()) {

             # Get the bid information:
             $bidInfo = $conn->query("SELECT bidAmount, bidDate FROM bids WHERE itemID = " . $searchResult['itemID'] . " ORDER BY bidAmount LIMIT 1");

             $bid = $bidInfo->fetch();

             $chaine = '<div class="col-xs-6 col-sm-3 placeholder">

                 <!-- Modal -->
                 <div id="myModal' . $rownumber . '" class="modal fade" role="dialog">
                     <div class="modal-dialog">

                         <!-- Modal content-->
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 <h2 class="modal-title">' . $searchResult['title'] . '</h4>
                             </div>
                             <div class="modal-body">
                                 <img src="' . $searchResult['photo'] . '" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail"
                                 <p>' . $searchResult['description'] . '</p>
                                 <h3 id="countdown"> PLACEHOLDER </h3>
                                 <h3 > Start Price: ' . $searchResult['startPrice'] . ' </h2>
                                 <h3> Current Price: ' . $searchResult['bidAmount'] . ' </h2>
                                 <h3> Last Bid: ' . $searchResult['bidDate'] . ' </h2>
                             </div>
                             <div class="modal-footer">
                                 <div class="form-group pull-left">
                                     <input type="text" name="bid" id="inputBid" >
                                 </div>
                                 <button type="button" class="btn btn-default pull-left" action="addBid()" >Bid</button>
                                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                             </div>
                         </div>

                     </div>
                 </div>

                 <img src="' . $searchResult['photo'] . '" width="200" height="200" class="img" alt="Generic placeholder thumbnail" data-toggle="modal" data-target="#myModal' . $rownumber . '">
                 <a  data-toggle="modal" data-target="#myModal' . $rownumber . '">
                     <h4>' . $searchResult['title'] . '
                     </h4>
                     <span class="text-muted">  ' . $searchResult['description'] . ' </span>
                 </a>
             </div>';

             echo $chaine;
             $rownumber += 1;

         }
     }
     # end php ?>


 </div>
</body>
 <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>
