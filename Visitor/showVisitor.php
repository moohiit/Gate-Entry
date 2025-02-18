<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("Location: ../index.php");
  exit();
}
include '../database.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="showVisitor.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gate Entry System</title>
  <link rel="stylesheet" href="../styles.css">
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name" style="margin-left:1px"><img src="../logo.png" alt="KCMT" /></span>
      <h5>Gate Entry System</h5>
    </div>
    <ul class="nav-links">
      <?php
      // Check if the user is an admin
      if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'hod') {
        ?>
        <li class="nav-link">
          <a href="../dashboard/dashboard.php">
            <i class="bx bx-home-alt icon"></i>
            <span class="text nav-text">Dashboard</span>
          </a>
        </li>
      <?php } ?>
      <li class="nav-link">
        <a href="../Search/search.php">
          <i class="bx bx-search icon"></i>
          <span class="text nav-text">Search Student</span>
        </a>
      </li>
      <?php
      if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'hod') {
        ?>
        <li class="nav-link">
          <a href="../addStudent/addStudent.php">
            <i class="bx bx-user-plus icon"></i>
            <span class="text nav-text">Add Student</span>
          </a>
        </li>
      <?php } ?>
      <?php
      // Check if the user is an admin
      if ($_SESSION['role'] == 'admin') {
        ?>
        <li class="nav-link">
          <a href="../Analytics/analytics.php">
            <i class="bx bx-bar-chart icon"></i>
            <span class="text nav-text">Analytics</span>
          </a>
        </li>
    
        <li class="nav-link">
          <a href="../Visitor/Visitor.php">
            <i class='bx bx-group icon'></i>
            <span class="text nav-text">Visitor Section</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="../mail/mail.php">
            <i class="bx bx-mail-send icon"></i>
            <span class="text nav-text">Send Report</span>
          </a>
        </li>
      <?php } ?>
      <li class="log_out nav-link">
        <a href="../logout.php">
          <i class='bx bx-log-out bx-fade-left-hover'></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <!-- Navbar start Here -->
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Visitor Report</span>
      </div>
    </nav>
    <!-- Navbar ends Here -->
    <div class="home-content">
      <!-- Main Content Goes Here   -->
      <div class="main-content">
        <div class="heading">
          <h1>Visitor Report</h1>
        </div>
        <div class="table">
          <form class="form" method="post">
            <div class="form-row">
              <label for="from">From:</label>
              <input id="from" type="date" name="from">
            </div>
            <div class="form-row">
              <label for="to">To:</label>
              <input id="to" type="date" name="to">
            </div>
            <div class="form-row">
              <input type="submit" class="btn" name="btn">
            </div>
          </form>
          <?php
          // Initialize $fromDate and $toDate
          $fromDate = null;
          $toDate = null;
          if (isset($_POST["btn"])) {
            $fromDate = $_POST['from'] ?? null;
            $toDate = $_POST['to'] ?? null;
          }
          ?>
          <table>
            <thead>
              <tr>
                <th>Sr.No</th>
                <th>Name</th>
                <th>Contact No.</th>
                <th>Reason</th>
                <th>Time</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include '../database.php';
              if ($fromDate && $toDate) {
                $sql = "SELECT * FROM visitor WHERE `date` BETWEEN '$fromDate' AND '$toDate'";
              } else {
                $sql = "SELECT * from visitor where date=CURRENT_DATE";
              }
              $result = mysqli_query($conn, $sql);
              $i = 1;
              while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                  <td>
                    <?php echo $i ?>
                  </td>
                  <td>
                    <?php echo $row["name"] ?>
                  </td>
                  <td>
                    <?php echo $row["mobile"] ?>
                  </td>
                  <td>
                    <?php echo $row["reason"] ?>
                  </td>
                  <td>
                    <?php echo $row["time"] ?>
                  </td>
                  <td>
                    <?php echo $row["date"] ?>
                  </td>
                </tr>
                <?php
                $i++;
              } ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Main Content Ends Here -->
    </div>
    <footer>
      <p>&copy; Gate Entry System <br> Developed by Mohit Patel and Raman Goyal</p>
    </footer>
  </section>
  <script src="../scripts.js"></script>
</body>

</html>