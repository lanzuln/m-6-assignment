<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>
    <h2>Register</h2>
    <form action="register.php" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="profile-picture">Profile Picture:</label><br>
        <input type="file" id="profile-picture" name="profile-picture" accept="image/*" required><br>
        <input type="submit" value="Submit">
    </form>





    <!-- form registration  -->
    <?php
// Validate form inputs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $profile_picture = $_FILES["profile-picture"];
    $errors = array();

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if ($profile_picture["error"] != 0) {
        $errors[] = "Error uploading profile picture";
    } else if (!in_array($profile_picture["type"], array("image/jpeg", "image/png"))) {
        $errors[] = "Profile picture must be a JPEG or PNG file";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    } else {
        // Save profile picture to server with unique filename
        $filename = uniqid() . "_" . $profile_picture["name"];
        move_uploaded_file($profile_picture["tmp_name"], "uploads/" . $filename);

        // Save user data to CSV file
        $user_data = array($name, $email, $filename, date("Y-m-d H:i:s"));
        $file = fopen("users.csv", "a");
        fputcsv($file, $user_data);
        fclose($file);

        // Set session and cookie
        session_start();
        $_SESSION["name"] = $name;
        setcookie("name", $name, time() + (86400 * 30), "/"); // Cookie expires in 30 days

        // Redirect to success page
        header("Location: success.php");
        exit();
    }
}
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Error</title>
    </head>

    <body>
        <a href="form.html">Back to form</a>
    </body>

    </html>

</body>

</html>