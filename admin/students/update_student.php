    <?php
$conn = new mysqli(
    "localhost",
    "root",
    "",
    "qr_attendance"
);

if($conn->connect_error){
    die("Connection failed");
}

$stmt = $conn->prepare("
    UPDATE students
    SET
        first_name=?,
        middle_name=?,
        last_name=?,
        course=?,
        year_level=?,
        spreadsheet_class=?
    WHERE id=?
");

$stmt->bind_param(
    "sssssssi",
    $_POST['first_name'],
    $_POST['middle_name'],
    $_POST['last_name'],
    $_POST['course'],
    $_POST['year_level'],
    $_POST['spreadsheet_class'],
    $_POST['id']
);

$stmt->execute();

header("Location: student_list.php");
exit();
?>