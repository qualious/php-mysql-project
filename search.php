<html>
    <head>
        <title>Showing events based on filters...</title>
    </head>
    <body>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
		<table class="table table-responsive">
		<thread>
			<tr>
				<th>Reserve</th>
				<th>Title</th>
				<th>Date</th>
				<th>Showroom</th>
				<th>Capacity</th>
				<th>Reserved</th>
				<th>Activity Type</th>
			</tr>
	    </thead>
	    <tbody>
	    <form action="reserve.php" method="post">

		<?php 
    		require_once('../Project/mysqli_connect.php');
	        $day1 = $_POST['day1'];
	        $month1 = $_POST['month1'];
	        $year1 = $_POST['year1'];
			$string1 = $year1 . "-" . $month1 . "-" . $day1;

	        $day2 = $_POST['day2'];
	        $month2 = $_POST['month2'];
	        $year2 = $_POST['year2'];
			$string2 = $year2 . "-" . $month2 . "-" . $day2;

	        $city = $_POST['city'];
			$activity_type = $_POST['type'];

			$query = "	SELECT activity_id, title,event_date, activity.showroom, capacity,fullness,activity_type,city_name
						FROM activity
						INNER JOIN showroom ON activity.showroom = showroom.showroom
						INNER JOIN city ON showroom.city_id = city.city_id 
						WHERE event_date BETWEEN '$string1-00:00:00' AND  '$string2-23:59:59'
						AND city.city_id = '$city'
						AND activity.activity_type = '$activity_type'
					 ";

			$result = @mysqli_query($conn,$query);
			if (!$result) {
		    	printf("\n\nError: %s\n", mysqli_error($conn));
	    		exit();
			}
			while($row = mysqli_fetch_array($result)){
		?>
		<tr>
			<td>
	        	<div class="radio">
	            	<label><input type="radio" id='regular' name="optradio" value=<?php echo $row['activity_id']?>> </label>
	            </div>
	        </td>
	        <td>
	        <div class="radiotext">
	            <label for='regular'><?php echo $row['title']?></label>
	        </div>
	        </td>
	        <td>
	        <div class="radiotext">
	            <label for='regular'><?php echo $row['event_date']?></label>
	        </div>
	        </td>
	        <td>
	        <div class="radiotext">
	            <label for='regular'><?php echo $row['showroom']?></label>
	        </div>
	        </td>
	        <td>
	        <div class="radiotext">
	            <label for='regular'><?php echo $row['capacity']?></label>
	        </div>
	        </td>
	        <td>
	        <div class="radiotext">
	            <label for='regular'><?php echo $row['fullness']?></label>
	        </div>
	        </td>
	        <td>
	        <div class="radiotext">
	            <label for='regular'><?php echo $row['activity_type']?></label>
	        </div>
	        </td>
	    </tr>
	    <?php 
            }
            $conn->close();
        ?>
		<tr>
			<td colspan="2" align="center"><input type="submit" value="Submit"/></td>
		</tr>
	    </form>
	    </tbody>
	</table>

    </body>
</html>