<?php
date_default_timezone_set('Asia/Calcutta');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) 
{

 case 'POST': 

      $data = json_decode(file_get_contents('php://input'), true);  // true means you can convert data to array
    //print_r($data);
      postOperation($data);

      break;

    case 'GET': // read data
          getOperation();
        break;

  case 'PUT': // update data
      $data = json_decode(file_get_contents('php://input'), true);  // true means you can convert data to array
      putOperation($data);
      break;

  case 'DELETE': // delete data
      $data = json_decode(file_get_contents('php://input'), true);  // true means you can convert data to array
          deleteOperation($data);
        break;

  default:
        print('{"result": "Requested http method not supported here."}');

}


function getOperation()
{

    include "../database/config.php";

    $id = $_GET['id'];

    $sql="SELECT * FROM user_registration WHERE id='$id'";
    $result = mysqli_query($con, $sql);
   	if (mysqli_num_rows($result) > 0) 
    {
      
      $rowse["response"] = "success";
      while($r = mysqli_fetch_assoc($result)) 
      {
           
           $rowse["result"]= $r;
      }
      echo json_encode($rowse);
    } 
    else 
    {
        $response= array("response"=>"Failed","message"=>"Oops! something went wrong." );
        echo json_encode($response);
    }

}
