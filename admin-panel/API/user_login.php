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


      $user_id=$_GET['user_id'];
      $c_id=$_GET['pwd'];
      $token = $_GET['token'];
      
     $sql1="SELECT * FROM  user_registration  where userid_mobile='$user_id'";
     $result1 = mysqli_query($con,$sql1);
     if (mysqli_num_rows($result1)<1) 
      { 
          $response['response']="Failed";
          $response['result'] = array("message"=>"Phone/Email is not registered" );
          echo json_encode($response);
        
     }else{

         $sql11="SELECT * FROM  user_registration  where userid_mobile='$user_id' AND password='$c_id' AND status='active'";

         $result11 = mysqli_query($con, $sql11);
         $rrr = mysqli_fetch_assoc($result11);
         $sta = $rrr['status'];

         if (mysqli_num_rows($result11)<1) 
         { 

           $sql111="SELECT * FROM  user_registration  where userid_mobile='$user_id' AND password='$c_id'";

            $result111 = mysqli_query($con, $sql111);

            if(mysqli_num_rows($result111)<1){

              $response['response']="Failed";
              $response['result'] = array("message"=>"Login credentials wrong!!" );
              echo json_encode($response);


            }else{

              $response['response']="Failed";
              $response['result'] = array("message"=>"Sorry your signup not activated by admin...." );
              echo json_encode($response);

           }

         }else{

            if(!empty($token)){
            $update = mysqli_query($con,"UPDATE user_registration SET token='$token' WHERE userid_mobile='$user_id' AND password='$c_id'");
            }
            $response['response']="Success";
            $rrr['message'] = "Loggedin successfully";
            $response['result'] = $rrr;
            echo json_encode($response);
         }
   }                                                                                           

}
