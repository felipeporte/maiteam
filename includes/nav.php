<!-- includes/nav.php -->
<?php $actual = basename($_SERVER['PHP_SELF']); ?>
<nav class="main-menu">
  <h1>Mai App</h1>
  <img class="logo" src="/0mai/maiteam/asset/img/asset1.png" alt="" />
  <ul>
    <li class="nav-item <?= $actual === 'dashboard.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="./../dashboard.php"><i class="fa fa-house nav-icon"></i><span class="nav-text">Home</span></a>
    </li>
    <li class="nav-item <?= $actual === 'finanzas.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="nav/finanzas.php"><i class="fa fa-hand-holding-usd nav-icon"></i><span class="nav-text">Finanzas</span></a>
    </li>
    <li class="nav-item <?= $actual === 'calendario.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="calendario.php"><i class="fa fa-calendar-check nav-icon"></i><span class="nav-text">Calendario</span></a>
    </li>
    <li class="nav-item <?= $actual === 'deportista.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="deportista.php"><i class="fa fa-person-running nav-icon"></i><span class="nav-text">Deportista</span></a>
    </li>
    <li class="nav-item <?= $actual === 'ajustes.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="ajustes.php"><i class="fa fa-sticky-note nav-icon"></i><span class="nav-text">Documentacion</span></a>
    </li>
  </ul>
</nav>