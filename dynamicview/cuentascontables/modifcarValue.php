<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Modificar Cuenta Contable</title>
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
        <li><a class="dropdown-item py-2" href="#"">Agregar Partidas </a></li>
        <li><a class="dropdown-item py-2" href="#">Listar Partidas</a></li>
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
  // conectandome a la base de datos 
  $link = mysqli_connect('localhost','root','','contabilidad') or die ('Error de conexión '.mysqli_error());
  // inicializando variables inciales 
  $codigo = $_POST["codigo"];
  $name = $_POST["cuenta_M"];
  $tipo = $_POST["tipo_cuenta_M"];

  $query = "UPDATE cuentascontables SET NombreCuenta = '$name', Tipo = '$tipo' WHERE NumCuenta = $codigo";

  $result = mysqli_query($link,$query) or die('Query failed: ' . mysqli_error($link));


  echo "<div class='container my-4'>
    <div class='row justify-content-center'>
        <div class='col-md-8'>
            <div class='alert alert-info alert-dismissible fade show shadow-sm' role='alert'>
                <i class='fa-solid fa-pen-to-square me-2'></i>
                <strong>¡Actualizado!</strong> La cuenta contable ha sido modificada correctamente.
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