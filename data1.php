<?php
	//error_reporting(E_ALL);
	//ini_set('display_errors','ON');
	

	if(!isset($_REQUEST['user']) && !isset($_REQUEST['ticket_id']))
    { 
        echo 'Invalid Call'; exit();
    }

    $userIp = "";
    $ticket_id = 0;
    $output = "";

    $conn = mysqli_connect('celcius.egrabbersupport.com', 'celcius_ro', 'M9kRcrv62HUv', 'celcius_helpdesk_database');
    if (!$conn){
      die("Connection failed : " . $conn->connect_error);
    }

	$columns = array(
		// datatable column index  => database column name
		0 => 'ticket_id',
		1=> 'thread_id',
		2 =>'thread_content_part', 
		
	);


	if (isset($_REQUEST['user'])){
		$userIp = (isset($_REQUEST['user'])) ? (trim($_REQUEST['user'])) : '';

		$query = "SELECT ticket_id FROM user INNER JOIN ticket_audit_log ON ticket_audit_log.user_id = user.user_id WHERE user_name = '$userIp' OR user_email = '$userIp'";
		$results = mysqli_query($conn, $query);
		$totalData = mysqli_num_rows($results);
		$totalFiltered = $totalData;

		$sql = "SELECT * FROM egrabber_seo_tracking_system WHERE 1=1";
	if( !empty($requestData['search']['value']) )
	{   // if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( post_id LIKE '".$requestData['search']['value']."%' ";
		// $sql.=" OR egrabber_userid LIKE '".$requestData['search']['value']."%' ";
		$sql.=" OR egrabber_username LIKE '".$requestData['search']['value']."%' ";      
		$sql.=" OR post_hosting_source LIKE '".$requestData['search']['value']."%' ";
		$sql.=" OR prospect_country LIKE '".$requestData['search']['value']."%' ";
		$sql.=" OR post_redirec_url LIKE '".$requestData['search']['value']."%' )";
	}
	

}	
	
	
	
	$sql = "SELECT * FROM egrabber_seo_tracking_system WHERE 1=1";
	if( !empty($requestData['search']['value']) )
	{   // if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( post_id LIKE '".$requestData['search']['value']."%' ";
		// $sql.=" OR egrabber_userid LIKE '".$requestData['search']['value']."%' ";
		$sql.=" OR egrabber_username LIKE '".$requestData['search']['value']."%' ";      
		$sql.=" OR post_hosting_source LIKE '".$requestData['search']['value']."%' ";
		$sql.=" OR prospect_country LIKE '".$requestData['search']['value']."%' ";
		$sql.=" OR post_redirec_url LIKE '".$requestData['search']['value']."%' )";
	}
	$query=mysqli_query($conn, $sql) or die("egrabber-data.php: get data");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
	$query=mysqli_query($conn, $sql) or die("egrabber-data.php: get data");
	
	$data = array();
	while( $row=mysqli_fetch_array($query) )
	{
		// preparing an array
		$nestedData=array(); 
		$redirect = urldecode($row["post_redirec_url"]);
		// $nestedData[] = $row["egrabber_userid"];
		$nestedData[] = ucfirst($row["egrabber_username"]);
		$nestedData[] = ucfirst($row["post_id"]);
		$nestedData[] = $row["post_created_datetime"];
		$nestedData[] = ucfirst($row["post_hosting_source"]);
		$nestedData[] = "<a href='$redirect' target='_internalbackground' title='$redirect'>$redirect</a>" ;
		$nestedData[] = "<span class='col-click' style='color:#0080ff;font-weight:bold;font-size:14px'>".$row['post_view_count']."</span>";
		$nestedData[] = "<span class='col-view' style='color:#0080ff;font-weight:bold;font-size:14px'>".$row['post_click_count']."</span>";
		$nestedData[] = "<span class='col-download' style='color:#0080ff;font-weight:bold;font-size:14px'>".$row['post_downloaded_count']."</span>";
		$nestedData[] = $row["created_datetime"];
		
		$nestedData[] = $row["id"];
		$data[] = $nestedData;
	}
	
	
	$json_data = array(
	"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval( $totalData ),  // total number of records
	"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
	);
	
	echo json_encode($json_data);  // send data as json format
?>
