
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tickets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css"> -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery-3.1.1.min.js"></script>
	<!-- <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script> -->
    <script src="js/main.js"></script>
</head>
<body>
    <div class="header">
        <div class="wrapper">
    <h1>eGrabber Helpdesk</h1>
        <div class = "tickets-form">
            <label for="serarchlabel">Search</label>
            <input type="text" name="Search" class="search_txt" autocapitalize="off" tabindex="1" id="search_box" placeholder="Enter Name (or) Email (or) Ticket Id" autofocus="autofocus" dir="ltr">
            <input tabindex="1" id="search-submit" class="search submit-button" type="submit" value="search">
        </div>
   
        </div>
    </div>
    <div id="loader">
    <div class="loader-spin"></div>
    </div>
    <div id="order_table"> 
    
    </div>
    <!-- The Modal -->
<div id="viewModal" class="modal">
<div class="modal-wrapper modal-sm-wid" id="box">
<!--Header Starts-->
<div class="modal-header">
<div class="header-lft">
Message
</div>

<div class="header-rgt close">
X
</div>
</div>
<!--Header Ends-->
<!--Body Starts-->
<div class="modal-body">
<!-- Rows Starts-->

<div class="rows" align="right">

<textarea rows="40" cols="77">

</textarea>

</div>
<!-- Rows Ends-->
</div>

<div class="modal-footer">

<button type="button" id="close-mod" name="run">Close</button>
</div>

<!--Body Starts-->
</div>
<!--Modal Wrapper Ends-->
</div>
   
    
</body>
</html>
<script type="text/javascript">

var modal = document.getElementById('viewModal');
var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
    document.getElementById('viewModal').style.display = "none";
}
window.onclick = function(event) {
    if (event.target == document.getElementById('viewModal')) {
        document.getElementById('viewModal').style.display = "none";    
    }
}

     document.getElementById("loader").style.display = "none";
  
    </script>

