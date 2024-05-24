
<?php 

//     include('dbconnection.php');

// if(isset($_POST['submit']))
//   {
//     $username=$_POST['username'];
//     $email=$_POST['email'];
//     $number=$_POST['number'];
//     $password=md5($_POST['password']);
    
//     $ret=mysqli_query($con, "select email from sign_up where email='$email' || number='$number'");
//     $result=mysqli_fetch_array($ret);
//     if($result>0){
//         echo "<script>alert('This email or Contact Number already associated with another account');</script>";
//         echo "<script>window.location.href ='sign_up.html'</script>";

//     }
//     else{
//         $query=mysqli_query($con, "insert into sign_up(username, email, number, password) value('$username', '$email', '$number' , '$password' )");
//         if ($query) {
//             echo "<script>alert('You have successfully sign up');</script>";
//             echo "<script>window.location.href ='home_page.html'</script>";
//         }
//         else
//         {
//             echo "<script>alert('Something Went Wrong. Please try again');</script>";
//             echo "<script>window.location.href ='sign_up.html'</script>";
//         }
//     }
// }
 ?>

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

