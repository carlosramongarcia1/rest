<?php
include_once('../includes/clase_configuracion.php');
$confi = NEW Configuracion();
  echo '<div class="brand">
    <a href="index.html">
      '.$confi->nombre.'
    </a>
  </div><!--/.brand -->
  <div class="container-fluid">
    <div class="navbar-btn">
      <button type="button" class="btn-toggle-fullwidth">
        <i class="lnr lnr-arrow-left-circle"></i>
      </button>
    </div><!--/.navbar-btn -->

    <div class="navbar-menu">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
            <i data-feather="bell"></i>
            <span class="badge badge-bg-1">2</span>
          </a>
          <ul class="dropdown-menu notifications">
            <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
            <li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
            <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
            <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
            <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
            <li><a href="#" class="more">See all notifications</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
            <i data-feather="mail"></i>
            <span class="badge badge-bg-1">3</span>
          </a>
          <ul class="dropdown-menu notifications">
            <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
            <li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
            <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
            <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
            <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
            <li><a href="#" class="more">See all notifications</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="assets/images/parson.png" class="img-circle" alt="parson-img">
            <i class="icon-submenu fa fa-angle-down"></i>
          </a>
          <ul class="dropdown-menu">
            <!--<li><a href="#"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>-->
            <li><a href="#"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li>
            <li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
            <li><a href="#" onclick="salirsession()"><i class="lnr lnr-exit"></i> <span>Salir</span></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div><!--/.container-fluid -->

  ';
?>
