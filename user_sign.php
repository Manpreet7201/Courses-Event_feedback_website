<?php 
include('dbconnection.php');

$response = array();

if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['number']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    
    $ret = mysqli_query($con, "SELECT email FROM sign_up WHERE email='$email' || number='$number'");
    $result = mysqli_fetch_array($ret);
    
    if($result > 0) {
        $response['status'] = 'error';
        $response['message'] = 'This email or contact number is already associated with another account.';
    } else {
        $query = mysqli_query($con, "INSERT INTO sign_up(username, email, number, password) VALUES('$username', '$email', '$number', '$password')");
        
        if ($query) {
            $response['status'] = 'success';
            $response['message'] = 'You have successfully registered';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong. Please try again.';
        }
    }
    echo json_encode($response);
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
    echo json_encode($response);
}
?>

