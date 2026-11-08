<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Name: Ny'Asia Dixon | Date: November 8, 2026 -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>

<h1>Search Results</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $conn = mysqli_connect("localhost", "root", "", "taus_data");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT firstName, lastName, email FROM tbl_student WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);

        echo "<div class='message'>";
        echo "Student found: " . htmlspecialchars($student["firstName"] . " " . $student["lastName"]);
        echo "<br>Email: " . htmlspecialchars($student["email"]);
        echo "</div>";
    } else {
        echo "<div class='message'>Email was not found.</div>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<p><a href="index.php">Return to Search</a></p>

</body>
</html>