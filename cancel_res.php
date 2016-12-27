<html>
    <head>
        <title>Editing reservation...</title>
    </head>
    <body>
    <?php 

/*
ILK IKI KUTUCUKTAKI DEGER DONDURULUYOR ID VE RES COUNT UPDATE'E
*/

   		if(!isset($_POST['optradio'])){
   			echo "Please don't forget to select the activity that you want to update or cancel!";
			header('refresh:2; url=userPage.php');
			exit;
   		}
    	require_once('../Project/mysqli_connect.php');
    	session_start();
    	$id = $_POST['optradio'];
   		$userName = $_SESSION['username'];
   		$res_count = $_SESSION['res_count'];
     	$query = "SELECT * FROM activity WHERE activity_id = '$id'";
     	$result = mysqli_query($conn,$query);
     	if (!$result) {
		   	echo "I'm sorry, but it seems like there is a problem with database. Please try again later!";
			header('refresh:2; url=userPage.php');
			exit;
		}
		else{
			if (isset($_POST['btnCancel'])) {
				$sqlUpdate = "UPDATE activity SET fullness = fullness - '$res_count' WHERE activity_id = '$id'";
				$sqlReserve = "DELETE FROM `reserve` WHERE user_name = '$userName' AND activity_id = '$id'";
				$resultUpdate = mysqli_query($conn,$sqlUpdate);
				$resultReserve = mysqli_query($conn,$sqlReserve);
				if (!$resultUpdate || !$resultReserve) {
			    	printf("\n\nError: %s\n", mysqli_error($conn));
		    		exit();
				}
				else{
					echo "Reservation has been cancelled!";
					header('refresh:2; url=userPage.php');
					exit;
				}
			}
			else{
				//check the capacity
   				$res_count_update = $_POST['res_count_update'];	//5

		     	// echo $res_count_update."<br>";
		     	// echo $_POST['x'][1] . "<br>";
				$sqlUpdate = "UPDATE activity SET fullness = fullness - ('$res_count' - '$res_count_update') WHERE activity_id = '$id'";
				$sqlReserve = "UPDATE `reserve` SET res_count = '$res_count_update' WHERE user_name = '$userName' AND activity_id = '$id'";
				$resultUpdate = mysqli_query($conn,$sqlUpdate);
				$resultReserve = mysqli_query($conn,$sqlReserve);
				if (!$resultUpdate || !$resultReserve) {
			    	printf("\n\nError: %s\n", mysqli_error($conn));
		    		exit();
				}
				else{
					echo "Reservation has been updated!";
					$_SESSION['res_count'] = $res_count_update;
					if($res_count_update == 0){
						$sqlReserve = "DELETE FROM `reserve` WHERE user_name = '$userName' AND activity_id = '$id'";
						$resultReserve = mysqli_query($conn,$sqlReserve);
						if(!$resultReserve){	
					    	printf("\n\nError: %s\n", mysqli_error($conn));
				    		exit();
						}
					}
					header('refresh:2; url=userPage.php');
					exit;
				}
			}
		}
   		$conn->close();
    ?>
    </body>
</html>