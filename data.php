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
        $query = "SELECT DISTINCT ticket_id FROM thread WHERE thread_replyto LIKE '%$userIp%'";
    
    }else if (strpos($userIp, '-') !== false){
    
      $query = "SELECT DISTINCT ticket_id FROM thread WHERE thread_subject LIKE '%$userIp%'";
   
    }else{
      $query = "SELECT DISTINCT ticket_id FROM thread WHERE thread_replyto LIKE '%$userIp%'";
    }
     
      $results = mysqli_query($conn, $query);
      $totalData = mysqli_num_rows($results);
	    $totalFiltered = $totalData;
     
      $data = array();
      
      if(mysqli_num_rows($results) > 0)  
      { 
      while( $row=mysqli_fetch_array($results) )
  	{
   
    $nestedData[] = $row["ticket_id"];
    $data[] = $row["ticket_id"];
   
      }
  }else{
    $output .= '<tr><td colspan="5">Data not found</td></tr>'; 
    $output .= '</table>';  
    echo $output; 
    exit();
  }


  if (count($data)>0){

  ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    $inital = 0;
    $final = 10;
   $data1 = array_slice($data, $inital, $final);
    
    $lastVal = end($data1);
  $output .= '<table id="table"><thead><tr><th width="20%">Subject</th><th width="30%">Content</th></tr></thead>';
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
  
  $output .= '<tr><td class="nr">'. $rows["thread_id"] .'</td><td>'. $rows["thread_subject"] .'</td><td>'. $rows["thread_content_part"] .'</td></tr>';
  $checkThreadId = $rows["thread_id"];
  
}

}
    }
  } 
  }
  $output .= '</table>';  
      echo $output; 


    }
    else if (isset($_REQUEST['ticket_id'])){
      $ticket_id = (isset($_REQUEST['ticket_id'])) ? (trim($_REQUEST['ticket_id'])) : '';

      $contentquery = "SELECT thread_content_part FROM thread_content_part WHERE thread_id = $ticket_id";

    $contentresults = mysqli_query($conn, $contentquery);
    $checkThreadId = 0;
    $content = "";
  
  if($contentresults->num_rows === 0) {
    $output .= 'Data not found'; 
    echo $output; 
    exit();
  }

  
 
  while($rows=mysqli_fetch_array($contentresults) )
    {

  $output .= $rows["thread_content_part"];
  
  
      }

      echo $output; 
  
    }
?>