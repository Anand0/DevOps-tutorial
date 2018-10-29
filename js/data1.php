<?php
	//error_reporting(E_ALL);
	//ini_set('display_errors','ON');
	
	session_start();ob_start();
	
	if(!isset($_REQUEST['promodata']))
	{ 
		
		echo 'Invalid Call'; exit();
	}
	
	$rootpath = $_SERVER['DOCUMENT_ROOT'];
	
	//Local - 1 ; Server - 0
	define('TESTING', 0);          
	if(TESTING)
	{
		
	$cssConnection = mysqli_connect('localhost','root','');
	mysqli_select_db($cssConnection,'essentials');
	
	include_once($rootpath.'/trunk/dependencies/phpmailer/class.phpmailer.php');	
	}
	else
	{        
	include($rootpath.'/scripts/dependencies/confreader_v3.php');
	global $connectionResponse;
	$connectionResponse = 1;
	$conn = connectMYSQL('[essentials]');
	include_once($rootpath.'/scripts/dependencies/phpmailer/class.phpmailer.php');	
	}

	// $conn = mysqli_con
	nect("localhost", "root", "root", "php_data");
  

	// storing  request (ie, get/post) global array to a variable  
	$requestData= $_REQUEST;

	$columns = array(
		// datatable column index  => database column name
		0 => 'egrabber_username',
1=> 'post_id',
2 =>'post_created_datetime', 
3 => 'post_hosting_source',
4=> 'post_redirec_url',
5 =>'post_view_count', 
6 => 'post_click_count',
7=> 'post_downloaded_count',
8 =>'created_datetime',
	);
	
	// getting total number records without any search
	$sql = "SELECT * FROM egrabber_seo_tracking_system";
	$query = mysqli_query($conn, $sql) ;
	$totalData = mysqli_num_rows($query);
	$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
	
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
