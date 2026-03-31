<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <title>Partidas Enviada</title>
</head>
<body>
  <!-- NavBar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary px-4 py-3">
  <a class="navbar-brand fw-semibold fs-4" href="../../index.html"><i class="fa-solid fa-leaf"></i></a>

  <ul class="nav nav-pills gap-2 ms-3">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle fs-6 px-3 py-2"
         data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
        Cuentas Contables
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item py-2" href="../../staticview/cuentascontables/agregar.html">Agregar Cuenta</a></li>
        <li><a class="dropdown-item py-2" href="../cuentascontables/listar.php">Listar Cuentas</a></li>
      </ul>
    </li>

  <ul class="nav nav-pills gap-2 ms-3">
    <li class="nav-item dropdown">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle fs-6 px-3 py-2"
         data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
        Partidas Contables
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item py-2" href="partidascontables.php"">Agregar Partidas </a></li>
        <li><a class="dropdown-item py-2" href="listarpartidas.php">Listar Partidas</a></li>
      </ul>
    </li>

    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle fs-6 px-3 py-2"
         data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
        Reportes
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item py-2" href="../reportescontables/librodiario.php">Libro Diario</a></li>
        <li><a class="dropdown-item py-2" href="../reportescontables/libormayor.php">Libro Mayor</a></li>
        <li><a class="dropdown-item py-2" href="../reportescontables/balancesaldo.php">Balance de Saldo</a></li>
      </ul>
    </li>

  </ul>
</nav> 

  <?php 
 
      
      $link = mysqli_connect('localhost','root','','contabilidad') or die('Hubo un error al conectar la db'. mysqli_error());

      $NumPartida  = $_GET["numero_partida"];
      $fecha       = $_GET["fecha"];
      $descripcion = $_GET["descripcion"];
      $debes       = $_GET["D"];
      $haberes     = $_GET["H"];
      $cuentas     = $_GET["tipo_cuenta"];

      // Verificar que la partida cuadre
      $sumaD = 0;
      $sumaH = 0;

      for($i = 0; $i < count($cuentas); $i++){
          if($debes[$i] > 0)   $sumaD += $debes[$i];
          if($haberes[$i] > 0) $sumaH += $haberes[$i];
      }

      if($sumaD != $sumaH){
      echo "<div class='container my-4'>
          <div class='row justify-content-center'>
              <div class='col-md-8'>
                  <div class='alert alert-danger shadow-sm' role='alert'>
                      <i class='fa-solid fa-triangle-exclamation me-2'></i>
                      <strong>¡Error!</strong> La partida no cuadra.
                      El total del Debe (Q " . number_format($sumaD, 2) . ") 
                      no es igual al total del Haber (Q " . number_format($sumaH, 2) . ").
                  </div>
              </div>
          </div>
      </div>";
      mysqli_close($link);
      exit();
    }

      // Inserta la partida contable
      $query = "INSERT INTO partidascontables VALUES($NumPartida,'$fecha','$descripcion')";
      $result = mysqli_query($link, $query) or die("Error al insertar partida: " . mysqli_error($link));

      echo "<div class='container my-4'>
          <div class='row justify-content-center'>
              <div class='col-md-8'>
                  <div class='alert alert-success alert-dismissible fade show shadow-sm' role='alert'>
                      <i class='fa-solid fa-database me-2'></i>
                      <strong>¡Éxito!</strong> La partida contable ha sido registrada correctamente.
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>
              </div>
          </div>
      </div>";

      // Inserta los registros contables
      for($i = 0; $i < count($cuentas); $i++){
          $valDebe  = $debes[$i];
          $valHaber = $haberes[$i];
          $cuenta   = $cuentas[$i];

          if($valDebe > 0){
              $query2 = "INSERT INTO registroscontables VALUES($NumPartida, $cuenta, 'D', $valDebe)";
          } else {
              $query2 = "INSERT INTO registroscontables VALUES($NumPartida, $cuenta, 'H', $valHaber)";
          }
          $result2 = mysqli_query($link, $query2) or die("Error en registro: " . mysqli_error($link));
      }

      echo "<div class='container my-4'>
          <div class='row justify-content-center'>
              <div class='col-md-8'>
                  <div class='alert alert-success alert-dismissible fade show shadow-sm' role='alert'>
                      <i class='fa-solid fa-database me-2'></i>
                      <strong>¡Éxito!</strong> Los registros contables han sido guardados correctamente.
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>
              </div>
          </div>
      </div>";

      mysqli_close($link);
?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>