<?php
        try {
            $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                            "team22@ibe-database",
                            "ILoveCS17");
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


       $currentPrice =  $_GET['currentPrice'];
       $buyerID = $_GET['buyerID'];
       $itemID = $_GET['itemID'];




            if(!isset($buyerID) ||  $buyerID == NULL){
                echo '<script type="text/javascript">';
                echo 'alert("You have to login or register first");';
                echo 'window.location.href = "auctionRooms.php?itemID='.$itemID.'";';
                echo '</script>';
            }

            else{



            if (!empty($_POST["bid"]) && $currentPrice < $_POST["bid"]) {

                // HERE GOES THE LOGIC TO EMAIL NOTIFY THE PREVIOUS HIGH BIDDER THAT THEY HAVE BEEN OUTBID
                // - sql query the bids table to find the highest bid on the item (before the new bid is placed in the table)
                // - send email to user
                // ALSO POTENTIALLY THE LOGIC TO EMAIL NOTIFY THE SELLER THAT THEIR ITEM HAS A NEW BID
                // - sql query the items table to find the sellerID
                // - send email to seller
                $date = new DateTime();
                $result = $date->format('Y-m-d H:i:s');
                $currentPrice = $_POST["bid"];
                $conn->query("INSERT INTO bids (itemID, buyerID, bidAmount) VALUES (" . $itemID . "," . $buyerID . "," . $_POST["bid"] . " ) ");
                $message = "Your bid has been registered. Thank you!";
                echo "<script type='text/javascript'>alert('$message');
                window.location.href = 'auctionRooms.php?itemID=".$itemID."';
                </script>";
            }
            elseif(empty($_POST["bid"])){
                $message = "The bid field cannot be empty!";
                echo "<script type='text/javascript'>alert('$message');
                window.location.href = 'auctionRooms.php?itemID=".$itemID."';
                </script>";
            }
            elseif(!empty($_POST["bid"]) && $currentPrice >= $_POST["bid"]){
                $message = "Your bid must be bigger than the current bid";
                echo "<script type='text/javascript'>alert('$message');
                window.location.href = 'auctionRooms.php?itemID=".$itemID."';
                </script>";
            }
            else{
                $message = "Please enter a valid number!";
                echo "<script type='text/javascript'>alert('$message');
                window.location.href = 'auctionRooms.php?itemID=".$itemID."';
                </script>";

            }


        }


?>