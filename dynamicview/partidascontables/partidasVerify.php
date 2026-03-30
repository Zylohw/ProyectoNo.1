<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        <li><a class="dropdown-item py-2" href="listar.php">Listar Cuentas</a></li>
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
        <li><a class="dropdown-item py-2" href="#">Libro Diario</a></li>
        <li><a class="dropdown-item py-2" href="#">Libro Mayor</a></li>
        <li><a class="dropdown-item py-2" href="#">Balance de Saldo</a></li>
      </ul>
    </li>

  </ul>
</nav> 

  <?php 
  // parte para enviar a la tabla 'PartidasContables' 
  // Enviar datos a la base de datos  
  
  $link = mysqli_connect('localhost','root','','contabilidad') or die('Hubo un erro al conectar la db'. mysqli_error());
  
    
  /**
   * capturando los campos necesarios para la tabla partidas contables
   * Num partida
   * Fecha
   * descripción
   * 
   */
    $NumPartida = $_GET["numero_partida"];
    $fecha = $_GET["fecha"];
    $descripcion = $_GET["descripcion"];
    $query = "INSERT INTO partidascontables VALUES($NumPartida,'$fecha','$descripcion')";
    $result = mysqli_query($link,$query) or die("error al insertar datos".mysqli_error());
    echo "<div class='container my-4'>
    <div class='row justify-content-center'>
        <div class='col-md-8'>
            <div class='alert alert-success alert-dismissible fade show shadow-sm' role='alert'>
                <i class='fa-solid fa-database me-2'></i>
                <strong>¡Éxito!</strong> La partida contable ha sido registrada en la base de datos correctamente.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        </div>
    </div>
</div>\n"; 

/* agregando los registroscontables */
/**
 *  datos necesarios
 * DebeHaber
 * Valor 
 */

  // las variables como el NumPartida y NumCuenta ya las usamos mediante la llave foranea

  $debes = $_GET["D"];
  $haberes = $_GET["H"];
  $cuentas = $_GET["tipo_cuenta"];



  for($i = 0; $i < count($cuentas); $i++){
    $valDebe  = $debes[$i];
    $valHaber = $haberes[$i];
    $cuenta   = $cuentas[$i];

    if($valDebe > 0){
        $query2 = "INSERT INTO registroscontables VALUES($NumPartida,$cuenta,'D',$valDebe)";
    } else {
        $query2 = "INSERT INTO registroscontables VALUES($NumPartida,$cuenta,'H',$valHaber)";
    }
    $result2 = mysqli_query($link, $query2) or die("Error en registro: " . mysqli_error($link));
  }

  echo "<div class='container my-4'>
    <div class='row justify-content-center'>
        <div class='col-md-8'>
            <div class='alert alert-success alert-dismissible fade show shadow-sm' role='alert'>
                <i class='fa-solid fa-database me-2'></i>
                <strong>¡Éxito!</strong> Los datos de la partida contable ha sido registrada en la base de datos correctamente.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        </div>
    </div>
</div>\n"; 





    mysqli_close($link);


  
  
  ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>