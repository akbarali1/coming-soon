<?php
$servername = "localhost";
$username = "<USERNAME>";
$password = "<PASSWORD>";
$dbname = "<DB_NAME>";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['email'])) {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $vaqt = time();
    $browser = isset($_POST['agent']) ? trim($_POST['agent']) : '';
    $sql = "INSERT INTO soon (time, email, useragent) VALUES ('" . $vaqt . "', '" . $email . "', '" . $browser . "')";
    $sql2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email FROM soon where email = '" . $email . "' LIMIT 1"));
    if ($sql2) {
        $out = array('error' => array('xatolik' => "Bazada bunday pochta mavjud, Siz qayta saqlashingiz shart emas"));
        echo json_encode($out, JSON_FORCE_OBJECT);
        exit();
    }
    if (mysqli_query($conn, $sql)) {
        $out = array('success' => array('javob' => "Hammasi yaxshi biz pochtangizni saqlab qoldik"));
        echo json_encode($out, JSON_FORCE_OBJECT);
    } else {
        $out = array('error' => 'Sql yuborib bo\'lmadi', 'sql' => "Error: " . $sql . "<br>" . mysqli_error($conn));
        echo json_encode($out);
    }
}
mysqli_close($conn);
?>