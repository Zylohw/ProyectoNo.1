<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Link para tener bootstrap-->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <title>agregar</title>
</head>
<body>
  
  <!--Navbar-->
  <nav class="navbar navbar-expand-lg bg-body-tertiary px-4 py-3">
  <a class="navbar-brand fw-semibold fs-4" href="../../index.html">Menu</a>

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

<!--Manejo con php-->
<?php 
// conectando a la base de datos del servidoro
try {
  $link = mysqli_connect('localhost','root','','contabilidad') or die
  ('No se pudo conectar  a la base ded datos error:  '.mysqli_error());
  // capturando los datos necesarios
  $codigo  = $_GET["codigo"];
  $nombre = $_GET["cuenta"];
  $tipo = $_GET["tipo_cuenta"];

  // generando query
  $query = "INSERT INTO cuentascontables VALUES($codigo,'$nombre','$tipo')";


  $resul = mysqli_query($link,$query) or die("Ocurrio un error: ".mysqli_error());
  echo '<div class="alert alert-success text-center">
      ✅ ¡La cuenta fue registrada exitosamente!
  </div>';
  mysqli_close($link);
}catch (Exception $e){
    echo '<div class="alert alert-danger text-center">
            ⚠️favor acceder a la navbar y volver a agregar una cuenta si es lo que desea si no vuelva a menu
        </div>';
}

?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>