<?php 
 function netChecker($sCheckHost = "www.google.com"){
    return(bool) @fsockopen($sCheckHost,80,$ierrno,$errstr,5);
 }
 //create check internet connection 
 $checkInternetConnection = netChecker();
 //create  inernet connection condition loop 
  $connection = ($checkInternetConnection) ? '<div class ="successconnection">
   <img src="'. base_url('images/logo/wifi.png').'" alt="image" >
   
   
   </div>' : '<div class ="Failedconnection"><img src="'. base_url('images/logo/no-internet.png').'" alt="image" ></div>';

?>

<!doctype html>
<html lang="en">
<head>
    <title>Raw Material</title>
    <style type="text/css">
        .successconnection, .Failedconnection {
            text-align: right;
            margin-top: 20px;
        }
        .successconnection img {
            width: 50px;
        }
        .Failedconnection img {
            width: 50px;
        }
    </style>
</head>
<body>
<div class="internetconnectionstatuts">
    <?php
    echo $connection ; ?>

   
</div>    
</body>
</html>
