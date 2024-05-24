<?php
// session_start();
// include('dbconnection.php');

// $response = array();

// if (isset($_POST['email']) && isset($_POST['password'])) {
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     // Prepare statement to select user data
//     $stmt = $con->prepare("SELECT id, username, password FROM users WHERE email = ?");
//     $stmt->bind_param("s", $email);
//     $stmt->execute();
//     $stmt->store_result();

//     if ($stmt->num_rows > 0) {
//         $stmt->bind_result($id, $username, $hashed_password);
//         $stmt->fetch();

//         // Verify the password
//         if (password_verify($password, $hashed_password)) {
//             $_SESSION['username'] = $username;
//             $_SESSION['user_id'] = $id;
//             $response['status'] = 'success';
//             $response['message'] = 'Login successful!';
//         } else {
//             $response['status'] = 'error';
//             $response['message'] = 'Invalid email or password.';
//         }
//     } else {
//         $response['status'] = 'error';
//         $response['message'] = 'Invalid email or password.';
//     }
    
//     $stmt->close();
// } else {
//     $response['status'] = 'error';
//     $response['message'] = 'Invalid request.';
// }

// echo json_encode($response);
// $con->close();

session_start();
include('dbconnection.php');

$response = array();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare statement to select user data
    $stmt = $con->prepare("SELECT id, username, password FROM sign_up WHERE email = ?");
    if ($stmt === false) {
        $response['status'] = 'error';
        $response['message'] = 'Database error: ' . htmlspecialchars($con->error);
        echo json_encode($response);
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $id;
            $response['status'] = 'success';
            $response['message'] = 'Login successful!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid email or password.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid email or password.';
    }
    
    $stmt->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
}

echo json_encode($response);
$con->close();

?>
