<?php
require_once '../../auth/auth.php';

/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION
|--------------------------------------------------------------------------
*/
$conn = new mysqli(
    "localhost",
    "root",
    "",
    "qr_attendance"
);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

/*
|--------------------------------------------------------------------------
| FETCH STUDENTS
|--------------------------------------------------------------------------
*/
$sql = "SELECT * FROM students ORDER BY last_name ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.8/css/dataTables.dataTables.min.css">

    <!-- Custom CSS -->
   <link rel="stylesheet" href="../../assets/css/list.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <!-- Custom JS -->
    <script src="../../JS/student_list.js" defer></script>
</head>

<body>

<div class="container">

    <!-- ========================================================= -->
    <!-- SIDEBAR -->
    <!-- ========================================================= -->
    <aside class="sidebar">

        <div class="logo">
            <img class="logo-img" src="../../pictures/PWU LOGO.png" width="80" alt="PWU Logo">
            <h2>PWU CDCEC</h2>
            <span>QR Attendance</span>
        </div>

        <ul class="menu">

            <li>
                <a href="dashboard.php">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </a>
            </li>

            <li class="menu-title">STUDENT MANAGEMENT</li>

            <li>
                <a href="../students/student_registration.php">
                    <i class="fa-solid fa-user-plus"></i>
                    Student Registration
                </a>
            </li>

            <li class="active">
                <a href="../students/student_list.php">
                    <i class="fa-solid fa-users"></i>
                    Student List
                </a>
            </li>

            <li class="menu-title">PROFESSOR MANAGEMENT</li>

            <li>
                <a href="../professors/professor_registration.php">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Professor Registration
                </a>
            </li>

            <li>
                <a href="../professors/professor_list.php">
                    <i class="fa-solid fa-user-tie"></i>
                    Professor List
                </a>
            </li>

            <li class="menu-title">SYSTEM MODULES</li>

            <li>
                <a href="cloud.php">
                    <i class="fa-solid fa-cloud"></i>
                    Cloud Integration
                </a>
            </li>

            <li>
                <a href="attendance.php">
                    <i class="fa-solid fa-qrcode"></i>
                    Attendance
                </a>
            </li>

            <li>
                <a href="courses.php">
                    <i class="fa-solid fa-book-open"></i>
                    Course Management
                </a>
            </li>

            <li>
                <a href="reports.php">
                    <i class="fa-solid fa-chart-pie"></i>
                    Reports
                </a>
            </li>

            <li>
                <a href="spreadsheet.php">
                    <i class="fa-solid fa-file-excel"></i>
                    Spreadsheet Import
                </a>
            </li>

            <li>
                <a href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- ========================================================= -->
    <!-- MAIN CONTENT -->
    <!-- ========================================================= -->
    <main class="main-content">

        <div class="glass-card">

            <h1 class="student_h1">Student List</h1>

            <table id="studentsTable" class="display">
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Spreadsheet Class</th>
                        <th>QR Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php while ($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($row['student_number']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['last_name']) ?>,
                            <?= htmlspecialchars($row['first_name']) ?>
                            <?= htmlspecialchars($row['middle_name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['course']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['year_level']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['spreadsheet_class']) ?>
                        </td>

                        <!-- QR BUTTON -->
                        <td>
                            <button
                                type="button"
                                class="view-qr"
                                data-student="<?= htmlspecialchars($row['student_number']) ?>"
                                data-name="<?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>"
                                data-qr="<?= htmlspecialchars($row['qr_code']) ?>"
                            >
                                <i class="fa-solid fa-qrcode"></i>
                            </button>
                        </td>

                        <!-- ACTIONS -->
                        <td class="action-buttons">

                            <button
                                type="button"
                                class="edit-btn"

                                data-id="<?= $row['id'] ?>"
                                data-first="<?= htmlspecialchars($row['first_name']) ?>"
                                data-middle="<?= htmlspecialchars($row['middle_name']) ?>"
                                data-last="<?= htmlspecialchars($row['last_name']) ?>"
                                data-course="<?= htmlspecialchars($row['course']) ?>"
                                data-year="<?= htmlspecialchars($row['year_level']) ?>"
                                data-spreadsheet="<?= htmlspecialchars($row['spreadsheet_class']) ?>"
                            >
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            <a href="delete_student.php?id=<?= $row['id'] ?>"
                               class="delete"
                               onclick="return confirm('Delete this student?')">

                                <i class="fa-solid fa-trash"></i>

                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>
            </table>

        </div>

    </main>

</div>


<!-- ========================================================= -->
<!-- EDIT STUDENT MODAL -->
<!-- ========================================================= -->
<div id="editModal" class="modal">

    <div class="modal-content">

        <span class="close">&times;</span>

        <h2>Edit Student</h2>

        <form action="update_student.php" method="POST">

            <input type="hidden" name="id" id="edit_id">

            <input type="text"
                   name="first_name"
                   id="edit_first"
                   placeholder="First Name"
                   required>

            <input type="text"
                   name="middle_name"
                   id="edit_middle"
                   placeholder="Middle Name">

            <input type="text"
                   name="last_name"
                   id="edit_last"
                   placeholder="Last Name"
                   required>

            <select name="course" id="edit_course" required>
                <option value="BSIT">BSIT</option>
                <option value="BSBA">BSBA</option>
                <option value="BSHM">BSHM</option>
                <option value="BSTM">BSTM</option>
                <option value="BEED">BEED</option>
                <option value="BSED">BSED</option>
            </select>

            <select name="year_level" id="edit_year" required>
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>
            </select>

            <select name="spreadsheet_class" id="edit_spreadsheet" required>
                <option value="IT1">IT1</option>
                <option value="IT2">IT2</option>
                <option value="IT3">IT3</option>
                <option value="IT4">IT4</option>
            </select>

            <button type="submit">
                Update Student
            </button>

        </form>

    </div>

</div>


<!-- ========================================================= -->
<!-- QR CODE MODAL -->
<!-- ========================================================= -->
<div id="qrModal" class="modal">

    <div class="modal-content qr-modal">


        <h2>Student QR Code</h2>

        <h3 id="qrStudentName"></h3>

        <div class="qr-container">
            <img id="studentQRImage" src="" alt="Student QR Code">
        </div>

        <p id="qrStudentNumber"></p>
        <br>

        <span class="close-qr">CLOSE</span>
    </div>

</div>


</body>
</html>

<?php
$conn->close();
?>