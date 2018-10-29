<?php



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
     

    if (isset($_REQUEST['user'])){
      $userIp = (isset($_REQUEST['user'])) ? (trim($_REQUEST['user'])) : '';
      $query = "";
      if (strpos($userIp, '@') !== false) {
        $query = "SELECT DISTINCT ticket_id FROM thread WHERE thread_replyto = '$userIp'";
        // $query = "SELECT DISTINCT ticket_id FROM user INNER JOIN ticket_audit_log ON ticket_audit_log.user_id = user.user_id WHERE user_email = '$userIp'";
    }else if (strpos($userIp, '-') !== false){
      // $query = "SELECT DISTINCT ticket_id FROM user INNER JOIN ticket_audit_log ON ticket_audit_log.user_id = user.user_id WHERE user_name = '$userIp'";
      $query = "SELECT DISTINCT ticket_id FROM thread WHERE thread_subject LIKE '%$userIp%'";
      // print ($query);
    }else{
      $query = "SELECT DISTINCT ticket_id FROM thread WHERE thread_replyto LIKE '%$userIp%'";
    }
     
      $results = mysqli_query($conn, $query);
      $totalData = mysqli_num_rows($results);
	    $totalFiltered = $totalData;
     
      $data = array();
      
      // $output .= '<table id="table"><thead><tr><th width="20%">ticket_id</th><th width="20%">thread_id</th></thead><th width="30%">thread_content_part</th></tr>';  
      if(mysqli_num_rows($results) > 0)  
      { 
      while( $row=mysqli_fetch_array($results) )
  	{
		// preparing an array
    

    $nestedData[] = $row["ticket_id"];
    $data[] = $row["ticket_id"];
   
      }
  }else{
    $output .= '<tr><td colspan="5">Data not found</td></tr>'; 
    $output .= '</table>';  
    echo $output; 
    exit();
  }

// echo "<pre>";
// print count($data);

  if (count($data)>0){
  //  echo end($data);
  ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    $inital = 0;
    $final = 10;
   $data1 = array_slice($data, $inital, $final);
    // echo "<pre>";
    // echo end($data1);
    // $stmt = $conn->prepare("SELECT * FROM thread INNER JOIN thread_content_part ON thread_content_part.thread_id = thread.thread_id WHERE ticket_id = ?");

    $lastVal = end($data1);
  $output .= '<table id="table"><thead><tr><th width="10%">Ticket Id</th><th width="20%">Subject</th><th width="30%">Content</th></tr></thead>';
  foreach ($data as $value) {

    $contentquery = "SELECT * FROM thread INNER JOIN thread_content_part ON thread_content_part.thread_id = thread.thread_id WHERE ticket_id = $value ";
    $contentresults = mysqli_query($conn, $contentquery);
    $checkThreadId = 0;
    $content = "";


  
  if($contentresults->num_rows === 0) {

  }else{
 
  while($rows=mysqli_fetch_array($contentresults) )
    {
    

if ($rows["thread_id"] == $checkThreadId){
  continue;
}else{
  
  $output .= '<tr><td>'. $rows["ticket_id"] .'</td><td>'. $rows["thread_subject"] .'</td><td>'. $rows["thread_content_part"] .'</td></tr>';
  $checkThreadId = $rows["thread_id"];
  
}
  
      }
    }
  } 
  }
  $output .= '</table>';  
      echo $output; 
  $json_data = array(
    // "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal"    => intval( $totalData ),  // total number of records
    "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data   // total data array
    );
    
    // echo
    //  json_encode($json_data);  // send data as json format

    }
    else if (isset($_REQUEST['ticket_id'])){
      $ticket_id = (isset($_REQUEST['ticket_id'])) ? (trim($_REQUEST['ticket_id'])) : '';

    // $stmt = $conn->prepare("SELECT * FROM thread INNER JOIN thread_content_part ON thread_content_part.thread_id = thread.thread_id WHERE ticket_id = ?");

    $output .= '<table id="table"><thead><tr><th width="10%">Ticket Id</th><th width="20%">Subject</th><th width="30%">Content</th></tr></thead>';
// SELECT DISTINCT thread_content_part, thread_subject, ticket_id
    // $contentquery = "SELECT * FROM thread INNER JOIN thread_content_part ON thread_content_part.thread_id = thread.thread_id WHERE ticket_id = $ticket_id";
    $contentquery = "SELECT DISTINCT thread_content_part, thread_subject, ticket_id FROM thread INNER JOIN thread_content_part ON thread_content_part.thread_id = thread.thread_id WHERE ticket_id = $ticket_id";
    $contentresults = mysqli_query($conn, $contentquery);
    $checkThreadId = 0;
    $content = "";
  
  if($contentresults->num_rows === 0) {
    $output .= '<tr><td colspan="5">Data not found</td></tr>'; 
    $output .= '</table>';  
    echo $output; 
    exit();
  }

  
 
  while($rows=mysqli_fetch_array($contentresults) )
    {


if ($rows["thread_id"] == $checkThreadId){
  continue;
}else{
  
  $output .= '<tr><td>'. $rows["ticket_id"] .'</td><td>'. $rows["thread_subject"] .'</td><td>'. $rows["thread_content_part"] .'</td></tr>';
  $checkThreadId = $rows["thread_id"];
  
}
  
      }
    
  $output .= '</table>';  
      echo $output; 
  
    }
?>