<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Modificar Partida</title>
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
        <li><a class="dropdown-item py-2" href="partidascontables.php">Agregar Partidas </a></li>
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
        <li><a class="dropdown-item py-2" href="../reportescontables/libromayor.php">Libro Mayor</a></li>
        <li><a class="dropdown-item py-2" href="../reportescontables/balancesaldo.php">Balance de Saldo</a></li>
      </ul>
    </li>

  </ul>
</nav>   


<?php 
        // conectandome a la base de datos 
        $link = mysqli_connect('localhost','root','','contabilidad');
        // modificando al tabla partidas contables
        $nueva_descripcion = $_POST["newDescripcion"];
        $nueva_fecha = $_POST["newFecha"];
        $numPartida = $_POST["numero_partida"];


      
        $query1 = "UPDATE  partidascontables SET Fecha = '$nueva_fecha', Descripcion = '$nueva_descripcion' WHERE NumPartida = $numPartida";
        $result = mysqli_query($link,$query1) or die ("fallo de consulta : " .mysqli_error());


        // modificando registros contables
          $debes = $_POST["D"];
          $haberes = $_POST["H"];
          $cuentas = $_POST["tipo_cuenta"];



        $queryDelete = "DELETE FROM RegistrosContables WHERE NumPartida = $numPartida";
        mysqli_query($link, $queryDelete) or die("Error al eliminar: " . mysqli_error($link));

        for($i = 0; $i < count($cuentas); $i++){
            $valDebe  = $debes[$i];
            $valHaber = $haberes[$i];
            $cuenta   = $cuentas[$i];

            if($valDebe > 0){
                $query2 = "INSERT INTO RegistrosContables VALUES($numPartida, $cuenta, 'D', $valDebe)";
            } else {
                $query2 = "INSERT INTO RegistrosContables VALUES($numPartida, $cuenta, 'H', $valHaber)";
            }
            $result2 = mysqli_query($link, $query2) or die("Error en registro: " . mysqli_error($link));
        }
        echo "<div class='container my-4'>
              <div class='row justify-content-center'>
                  <div class='col-md-8'>
                      <div class='alert alert-info alert-dismissible fade show shadow-sm' role='alert'>
                          <i class='fa-solid fa-pen-to-square me-2'></i>
                          <strong>¡Actualizado!</strong> Partidas contables ha sido modificada correctamente.
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