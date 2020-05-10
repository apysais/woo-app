<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo admin_url('admin.php?page=app-dashboard');?>">Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo admin_url('admin.php?page=orders');?>">Orders Done Prepare</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo admin_url('admin.php?page=orders&_method=complete-orders');?>">Orders Complete</a>
      </li>
    </ul>
  </div>
</nav>
