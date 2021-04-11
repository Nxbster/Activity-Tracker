<!--Header inspired by: view-source:https://getbootstrap.com/docs/4.1/examples/pricing/-->
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h3 class="my-0 mr-md-auto font-weight-bold" style="color:black"><?php echo $_SESSION['user']?> 's Eating Log</h3>
    <nav class="my-2 my-md-0 mr-md-3">
      <a class="p-2 text-dark" href="eat_log.php">Eating Log</a>
      <a class="p-2 text-dark" href="activity_log.php">Activity Log</a>
      <a class="p-2 text-dark" href="dashboard.php">Dashboard</a>
    </nav>
    <a class="btn btn-outline-secondary" href="logout.php">Log out</a>
  </div>