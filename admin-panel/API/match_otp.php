
<?php  
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

function postOperation($data){
  
      include "../config/database.php";

     
      $firstname=$data['full_name'];
      $email=$data['email'];
      $mobile=$data['mobile'];
      $address=$data['address'];
      $password=$data['password'];
      $otp=$data['otp'];
      $confirm_otp=$data['confirm_otp'];//otp from user
   
   

    if($otp==$confirm_otp)
    {
      
     $query=mysqli_query($conn,"INSERT into user_profile(full_name,email,mobile,address,password) values('$firstname','$email','$mobile','$address','$password')");

           
            if ($query) {
                $id=mysqli_insert_id($conn);
                $response["response"] ="success";
                $response["message"] = "Registered successfully.";
                $response["result"]["userid"] = $id;
                $response["result"]["first_name"] = $firstname;
                $response["result"]["email"] = $email;
                $response["result"]["telephone"] = $mobile;
                $response["result"]["address"] = $address;
                $response["result"]["password"] = $password;
                $response["result"]["otp"] = $otp;
                echo json_encode($response);
            }
              else
            {
                $response= array("response"=>"Failed","message"=>"Oops! something went wrong." );
                echo json_encode($response);
            }

 }
else
{
    $status="OTP not matched";

echo json_encode(array("response"=>$status));

}

}
 
?>