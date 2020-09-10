<?php
date_default_timezone_set('Asia/Calcutta');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) 
{

 case 'POST': 

      $data = json_decode(file_get_contents('php://input'), true);  // true means you can convert data to array
    // print_r($data);
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


function postOperation($data)
{

  
    include "../config/database.php";


      $firstname=$data['full_name'];
      $email=$data['email'];
      $mobile=$data['mobile'];
      $address=$data['address'];
      $password=$data['password'];
      

    
      $mres = mysqli_query($conn,"SELECT mobile from user_profile where mobile='$mobile'");
      $mcount=mysqli_num_rows($mres);


      $mrese = mysqli_query($conn,"SELECT email from user_profile where email='$email'");
      $mcounte=mysqli_num_rows($mrese);


        $ok="1";

        if($mcounte > 0)
        {
            $fmessage="Email is already exist";
            $ok = "0";
        }

        if($mcount > 0)
        {
          if($mcounte>0)
          {
              $ok = "0";
              $fmessage="Email id and mobile number already exist";
          }
          else
          {
              $ok = "0";
              $fmessage="Mobile number already exist";
          }
        }

        // print_r($mobile);
       echo json_encode($mobile);

        if($ok==0)
        {
          $status = "Failed";
          echo json_encode(array("response"=>$status,"message"=>$fmessage));
          $ok = "0";
        }else if(!empty($mobile)) {

            $otp  = rand(1000,9999);
            sms($otp,$mobile);
            $response["response"] = "success";
            $response["result"]["full_name"] = $firstname;
            $response["result"]["email"] = $email;
            $response["result"]["mobile"] = $mobile;
            $response["result"]["address"] = $address;
            $response["result"]["password"] = $password;
            $response["result"]["otp"] = $otp;
            echo json_encode($response);
       }
       else{
          $response= array("response"=>"Failed","message"=>"Oops! something went wrong.");
          echo json_encode($response);
       }
}





  function sms($otp,$number)
  {
  
    // Authorisation details.
    // $username = "priyagsatechworld@gmail.com";TXTLCL
    // $hash = "3eddc367af2dfc08574b5096ee0b3f93a01d5158e287aeca461ed17ab2b7b03d";


    $username = "accgsatechworld@gmail.com";
    $hash = "3cb3f5b607b1e2468fbd73d215dddb06b4719c29ce043d126ae17aab9cc668fd";

      
    // Config variables. Consult http://api.textlocal.in/docs for more info.
    $test = "0";

    // Data for text message. This is the text message data.
            $sender = "ZWTTFH"; // This is who the message appears to be from.
            $numbers = $number; // A single number or a comma-seperated list of numbers
            $message = "OTP :".$otp;
    // 612 chars or less
    // A single number or a comma-seperated list of numbers
    $message = urlencode($message);
    $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
    $ch = curl_init('http://api.textlocal.in/send/?');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch); // This is the result from the API
    curl_close($ch);

     return $result;
  }







