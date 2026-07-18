<?php
require_once '../../auth/auth.php';
require_once '../../phpqrcode/qrlib.php';

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "qr_attendance"
);

if(isset($_POST['update_professor'])){


    $id = $_POST['id'];

    $first_name = $_POST['first_name'];

    $middle_name = $_POST['middle_name'];

    $last_name = $_POST['last_name'];

    $email = $_POST['email'];

    $phone = $_POST['phone'];



    $stmt=$conn->prepare("

    UPDATE professors SET

    first_name=?,
    middle_name=?,
    last_name=?,
    email=?,
    phone=?

    WHERE id=?

    ");



    $stmt->bind_param(

        "sssssi",

        $first_name,
        $middle_name,
        $last_name,
        $email,
        $phone,
        $id

    );


   if($stmt->execute()){
    header("Location: professor_list.php?updated=1");
    exit;
}else{
    echo $stmt->error;
}

    exit;


}

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

$result = $conn->query("

    SELECT 
        p.*,

        GROUP_CONCAT(
            ps.subject_code 
            SEPARATOR ', '
        ) AS subjects

    FROM professors p

    LEFT JOIN professor_subjects ps
    ON p.id = ps.professor_id

    GROUP BY p.id

    ORDER BY p.last_name ASC

");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Professor List</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../../assets/css/list.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">
<script src="../../JS/professor_list.js" defer></script>
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            <img class="logo-img" src="../../pictures/PWU LOGO.png" width="80">
            <h2>PWU CDCEC</h2>
            <span>QR Attendance</span>
        </div>

        <ul class="menu">

            <li>
                <a href="../dashboard.php">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </a>
            </li>

            <li class="menu-title">
                STUDENT MANAGEMENT
            </li>

            <li>
                <a href="../students/student_registration.php">
                    <i class="fa-solid fa-user-plus"></i>
                    Student Registration
                </a>
            </li>

            <li>
                <a href="../students/student_list.php">
                    <i class="fa-solid fa-users"></i>
                    Student List
                </a>
            </li>

            <li class="menu-title">
                PROFESSOR MANAGEMENT
            </li>

            <li>
                <a href="../professors/professor_registration.php">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Professor Registration
                </a>
            </li>

            <li class="active">
                <a href="../professors/professor_list.php">
                    <i class="fa-solid fa-user-tie"></i>
                    Professor List
                </a>
            </li>

            <li class="menu-title">
                SYSTEM MODULES
            </li>

            <li>
                <a href="../cloud.php">
                    <i class="fa-solid fa-cloud"></i>
                    Cloud Integration
                </a>
            </li>

            <li>
                <a href="../attendance.php">
                    <i class="fa-solid fa-qrcode"></i>
                    Attendance
                </a>
            </li>

            <li>
                <a href="../courses.php">
                    <i class="fa-solid fa-book-open"></i>
                    Course Management
                </a>
            </li>

            <li>
                <a href="../reports.php">
                    <i class="fa-solid fa-chart-pie"></i>
                    Reports
                </a>
            </li>

            <li>
                <a href="../spreadsheet.php">
                    <i class="fa-solid fa-file-excel"></i>
                    Spreadsheet Import
                </a>
            </li>

            <li>
                <a href="../auth/logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="glass-card">

            <h1 class="student_h1">Professor List</h1>

          <div class="table-container">

                    <table>

                    <thead>

                    <tr>

                        <th>QR Code</th>
                        <th>Employee ID</th>
                        <th>Professor Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subjects</th>
                        <th>Status</th>
                        <th>Actions</th>

                    </tr>

                    </thead>


                    <tbody>


                    <?php if($result && $result->num_rows > 0): ?>


                    <?php while($row = $result->fetch_assoc()): ?>


                    <tr>


                    <!-- QR CODE -->

                    <td>

                    <?php if(!empty($row['qr_code'])): ?>

                    <img 
                    src="<?= htmlspecialchars($row['qr_code']); ?>"
                    class="profile-qr"
                    >

                    <?php else: ?>

                    <span class="no-data">
                    No QR
                    </span>

                    <?php endif; ?>


                    </td>



                    <!-- EMPLOYEE ID -->

                    <td>

                    <?= htmlspecialchars($row['employee_id']); ?>

                    </td>



                    <!-- NAME -->

                    <td>

                    <div class="user-info">


                    <div class="avatar">

                    <i class="fa-solid fa-user-tie"></i>

                    </div>


                    <div>

                    <strong>

                    <?= htmlspecialchars($row['last_name']); ?>,
                    <?= htmlspecialchars($row['first_name']); ?>

                    </strong>


                    <br>


                    <span>

                    Professor

                    </span>


                    </div>


                    </div>


                    </td>



                    <!-- EMAIL -->

                    <td>

                    <?= htmlspecialchars($row['email']); ?>

                    </td>



                    <!-- PHONE -->

                    <td>

                    <?= htmlspecialchars($row['phone']); ?>

                    </td>



                    <!-- SUBJECT -->

                    <td>

                    <?php

                    if(!empty($row['subjects'])){

                    echo htmlspecialchars($row['subjects']);

                    }else{

                    echo "No Subject Assigned";

                    }

                    ?>

                    </td>



                    <!-- STATUS -->

                    <td>

                    <span class="status-active">

                    <i class="fa-solid fa-circle"></i>

                    Active

                    </span>


                    </td>




                    <!-- ACTIONS -->

                    <td>

    <!-- View -->
                            <a href="view_professor.php?id=<?= $row['id']; ?>"
                            class="action-btn view">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <!-- Edit -->
                            <button
                                type="button"
                                class="action-btn edit"
                                onclick="openEditModal(
                                    '<?= $row['id']; ?>',
                                    '<?= htmlspecialchars($row['employee_id'], ENT_QUOTES); ?>',
                                    '<?= htmlspecialchars($row['first_name'], ENT_QUOTES); ?>',
                                    '<?= htmlspecialchars($row['middle_name'], ENT_QUOTES); ?>',
                                    '<?= htmlspecialchars($row['last_name'], ENT_QUOTES); ?>',
                                    '<?= htmlspecialchars($row['email'], ENT_QUOTES); ?>',
                                    '<?= htmlspecialchars($row['phone'], ENT_QUOTES); ?>'
                                )">

                                <i class="fa-solid fa-pen"></i>

                            </button>

                            <!-- Delete -->
                            <a href="delete_professor.php?id=<?= $row['id']; ?>"
                            class="action-btn delete"
                            onclick="return confirm('Delete this professor?')">

                                <i class="fa-solid fa-trash"></i>

                            </a>

                        </td>


                    </tr>


                    <?php endwhile; ?>


                    <?php else: ?>


                    <tr>

                    <td colspan="8" class="empty">

                    No professors registered.

                    </td>

                    </tr>


                    <?php endif; ?>


                    </tbody>


                    </table>

                    </div>

        </div>

    </div>

</div>

<!-- =====================
 EDIT PROFESSOR MODAL
===================== -->


<div id="editModal" class="modal">


<div class="modal-box">


<h2>

<i class="fa-solid fa-user-pen"></i>

Edit Professor

</h2>



<form method="POST">


<input 
type="hidden"
id="edit_id"
name="id">



<div class="grid">


<div class="input-group">

<label>Employee ID</label>

<input
type="text"
id="edit_employee"
readonly>

</div>



<div class="input-group">

<label>First Name</label>

<input
type="text"
id="edit_first"
name="first_name"
required>

</div>




<div class="input-group">

<label>Middle Name</label>

<input
type="text"
id="edit_middle"
name="middle_name">

</div>




<div class="input-group">

<label>Last Name</label>

<input
type="text"
id="edit_last"
name="last_name"
required>

</div>




<div class="input-group">

<label>Email</label>

<input
type="text"
id="edit_phone"
name="phone"
required>

</div>




<div class="input-group">

<label>Phone</label>

<input 
id="edit_phone"
name="phone"
required>

</div>


</div>



<button
class="submit-btn"
name="update_professor">

<i class="fa-solid fa-save"></i>

Save Changes

</button>


<button
type="button"
onclick="closeEditModal()"
class="cancel-btn">

Cancel

</button>



</form>


</div>


</div>

</body>
</html>