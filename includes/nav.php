<!-- includes/nav.php -->
<?php $actual = basename($_SERVER['PHP_SELF']); ?>
<nav class="main-menu">
  <h1>Mai App</h1>
  <img class="logo" src="/0mai/maiteam/asset/img/asset1.png" alt="" />
  <ul>
    <li class="nav-item <?= $actual === 'dashboard.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="/0mai/maiteam/dashboard.php"><i class="fa fa-house nav-icon"></i><span class="nav-text">Home</span></a>
    </li>
    <li class="nav-item <?= $actual === 'finanzas.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="/0mai/maiteam/nav/finanzas.php"><i class="fa fa-hand-holding-usd nav-icon"></i><span class="nav-text">Finanzas</span></a>
    </li>
    <li class="nav-item <?= $actual === 'calendario.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="calendario.php"><i class="fa fa-calendar-check nav-icon"></i><span class="nav-text">Calendario</span></a>
    </li>
    <li class="nav-item <?= $actual === 'deportista.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="/0mai/maiteam/nav/deportista.php"><i class="fa fa-person-running nav-icon"></i><span class="nav-text">Deportista</span></a>
    </li>
    <li class="nav-item <?= $actual === 'guardians.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="/0mai/maiteam/public/guardians.php"><i class="fa fa-users nav-icon"></i><span class="nav-text">Apoderados</span></a>
    </li>
    <li class="nav-item <?= $actual === 'coaches.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="/0mai/maiteam/public/coaches.php"><i class="fa fa-user-tie nav-icon"></i><span class="nav-text">Coaches</span></a>
    </li>
     <li class="nav-item <?= $actual === 'guardian_athlete.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="/0mai/maiteam/public/guardian_athlete.php"><i class="fa fa-link nav-icon"></i><span class="nav-text">Relaciones</span></a>
    </li>
    <li class="nav-item <?= $actual === 'club_dues.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="/0mai/maiteam/public/club_dues.php"><i class="fa fa-money-bill nav-icon"></i><span class="nav-text">Cuotas Club</span></a>
    </li>
    <li class="nav-item <?= $actual === 'payments.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="/0mai/maiteam/public/payments.php"><i class="fa fa-money-check-alt nav-icon"></i><span class="nav-text">Pagos Coach</span></a>
    </li>
    <li class="nav-item <?= $actual === 'athlete_coach_sessions.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="/0mai/maiteam/public/athlete_coach_sessions.php"><i class="fa fa-chalkboard-user nav-icon"></i><span class="nav-text">Sesiones</span></a>
    </li>
    <li class="nav-item <?= $actual === 'ajustes.php' ? 'active' : '' ?>">
      <b></b><b></b>
      <a href="/0mai/maiteam/nav/ajustes.php"><i class="fa fa-sticky-note nav-icon"></i><span class="nav-text">Documentacion</span></a>
    </li>
  </ul>
</nav>