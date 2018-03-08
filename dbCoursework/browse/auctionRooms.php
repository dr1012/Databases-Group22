<?php include("../dashboard/baseHead.php"); ?>

<link href="../resources/css/auctionRooms.css" rel="stylesheet">

  <body>

    <?php include('../dashboard/baseHeader.php'); ?>

    <?php include('../dashboard/sideMenu.php'); ?>


    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


        <?php


            if (isset($_GET['itemID'])) {
                $result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items  WHERE itemID = " . $_GET['itemID']);
                $data1 = $result->fetch();
                $itemID = $data1['itemID'];
                $title = $data1['title'];
                $description = $data1['description'];
                $photo = $data1['photo'];
                $date = $data1['endDate'];
                $startPrice = $data1['startPrice'];

                echo '<div class="col-sm-offset-5 col-md-offset-5"><img src="' . $photo . '" width="200" height="200" class="img" alt="Generic placeholder thumbnail" data-toggle="modal" data-target="#myModal' . $modalReference . '">
                                  <a  data-toggle="modal" data-target="#myModal' . $modalReference . '">
                                  <h4>' . $title . '
                                  </h4>
                                  <span class="text-muted">  ' . $description . ' </span>
                                  </a> </div>';


                # Get last 20 bids
                $result2 = $conn->prepare("SELECT bidID, bidDate, bidAmount, users.username FROM bids JOIN users on bids.buyerID = users.userID WHERE itemID = ? ORDER BY bidDate DESC");
                $result2->execute([$_GET['itemID']]);

                $rows = $result2->rowCount();
                $res = $result2->fetchAll()

                ?>

        <table class="table table-dark" >
            <thead>
            <tr scope="row">
                <th scope="col">
                    Bid Date
                </th>
                <th scope="col">
                    Bid Amount
                </th>
                <th scope="col">
                    User
                </th>
            </tr>
            </thead>
            <tbody id="bidTable">

                <?php

                $highestBid = 0;
                $count = 0;

                foreach ($res as $row) {

                    if ($count == 0) {
                        $highestBid = $row['bidAmount'];
                        $count++;
                    }

                    include "bidsRow.php";
                }

                    ?>

            </tbody>
        </table>



<!--                    if ($i < 10) {-->
<!---->
<!--                    } else if ($i < 20) {-->
<!---->
<!--                    } else if ($i < 30) {-->
<!---->
<!--                    }-->
<!---->
<!--                }-->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!--            }-->
<!---->
<!--            ?>-->

    <container>
        <?php include('carousel.php');

        printCarousel($_GET['itemID'], $conn);
        ?>
    </container>

    </div>




    <?php include("../dashboard/baseFooter.php");

    ;?>

      </body>

    <script>

            //console.log(<?php //echo json_encode($res); ?>//);
            var res=<?php echo json_encode($res); ?>;


            var hBid = <?php echo $highestBid;?>;
            console.log(hBid);

        $(function () {
           setInterval(function() {
               $.ajax({

                   url: "realtimeBids.php",
                   type: "POST",
                   data: {"itemID":<?php echo $_GET['itemID'];?>, "highestBid":hBid},
                   success: function(response) {

                       console.log("caca");
                       console.log(response);
                       console.log(response.newHighest);
                       console.log(response.newRows);


                       if (response.newHighest != 0) {
                           hBid = response.newHighest;

                           $("#bidTable").prepend(response.newRows.toString());
                       }


               }, error: function (request, status, error) {
                       alert(request.responseText);
                   },


                   dataType: "json"});
            }, 5000);
        });

        </script>



    </html>
<?php } ?>