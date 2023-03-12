<!DOCTYPE html>
<html>

<head>
    <title>User List</title>
</head>

<body>
    <h2>User List</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Profile Picture</th>
            <th>Date Added</th>
        </tr>
        <?php
		$file = fopen("users.csv", "r");
		while (($data = fgetcsv($file)) !== false) {
			echo "<tr>";
			echo "<td>" . $data[0] . "</td>";
			echo "<td>" . $data[1] . "</td>";
			echo "<td><img src='uploads/" . $data[2] . "' width='50' height='50'></td>";
			echo "<td>" . $data[3] . "</td>";
			echo "</tr>";
		}
		fclose($file);
		?>
    </table>
</body>

</html>