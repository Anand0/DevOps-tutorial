
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tickets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" /> -->
    <!-- <script type="text/javascript" language="javascript" src="jquery-3.1.1.min.js"></script> -->
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
    <script src="js/main.js"></script>
</head>
<body>
    <div class="header">
        <div class="wrapper">
    <!-- <h1>Tickets</h1> -->
    <!-- <form class = "tickets-form" action="" method="POST"> -->
        <div class = "tickets-form">
            <label for="serarchlabel">Search</label>
            <input type="text" name="Search" class="search_txt" autocapitalize="off" tabindex="1" id="search_box" placeholder="Enter Name (or) Email (or) Ticket Id" autofocus="autofocus" dir="ltr">
            <!-- <p> Or </p>
            <input type="text" name="Search" class="ticket_txt" autocapitalize="off" tabindex="1" id="search_box" placeholder="Enter Tickets id" autofocus="autofocus" dir="ltr"> -->
            <input tabindex="1" id="search-submit" class="search submit-button" type="submit" value="search">
        </div>
    <!-- </form> -->
        </div>
    </div>
    <div id="loader"></div>
    <div id="order_table"> 
    <!-- <button>More</button> -->
    
    </div>
    <!-- <input type="button" id="more_btn" value="More"> -->
    
</body>
</html>
<script>
     document.getElementById("loader").style.display = "none";
    //  document.getElementById("more_btn").style.display = "none";
    </script>

