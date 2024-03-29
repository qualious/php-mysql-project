<html>
    <head>
        <title>Processing information...</title>
    </head>
    <body>

    <?php
        $userName = $_POST['username'];
        $password1 = $_POST['password1'];
        $password2= $_POST['password2'];
        if($password1 != $password2){
            echo "Passwords don't match!";
            header('refresh:2; url=index.html');
			exit();

        }
        if($userName == '' || $password1 == '' || $password2 == ''){
            echo "<h2>Username or password can't be blank!</h2>";
            exit();
        }


    	session_start();
    	$_SESSION['username'] = $userName;
    	require_once('../Project/mysqli_connect.php');

        $query = $conn->prepare("SELECT * from consumer where user_name=?");
        $query->bind_param("s", $userName);
        $query->execute();
        $query->store_result();
        $countRows = $query->num_rows;
        if($countRows>=1){
            //if username exists, send user to index.html
            echo "Username $userName already exists, please try again!";
            header('refresh:2; url=index.html');
			exit;
        }else{
            $query2 = $conn->prepare("INSERT into consumer (user_name, user_password) VALUES (?, ?)");
            $query2->bind_param("ss", $userName, $password1);
            if($query2->execute()){
                echo "Registration complete";
                //if registration is complete, send user to logged.html
                header('refresh:2; url=logged.html');
				exit;

            }
            else{
                echo "Connection error " . $conn->error;
                //if connection error occurs, send user to index.html
                header('refresh:2; url=index.html');
				exit;

            }
        }
    $conn->close();
    header("Location:reserve.php?userName=userName");
    ?>

    </body>
</html>

