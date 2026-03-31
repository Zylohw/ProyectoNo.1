<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Listar</title>
</head>
<body>

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
        <li><a class="dropdown-item py-2" href="#">Listar Cuentas</a></li>
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
        <li><a class="dropdown-item py-2" href="../partidascontables/partidascontables.php">Agregar Partidas </a></li>
        <li><a class="dropdown-item py-2" href="../partidascontables/listarpartidas.php">Listar Partidas</a></li>
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

//conectar a db listando la query y lanzando la query 
$link = mysqli_connect('localhost','root','','contabilidad') or die ('hubo un error'.mysqli_error());
$query = "SELECT * FROM cuentascontables order by NumCuenta";
$result = mysqli_query($link,$query) or die('query failed'.mysqli_error($link));

// variables de captura
$codigo="";
$nombre="";
$tipo="";

// tabla esqueleto
echo "<div class='container my-5'>
    <div class='row justify-content-center'>
        <div class='col-md-8'>
            <div class='card shadow-sm'>
                <div class='card-header bg-primary text-white'>
                    <h5 class='mb-0'><i class='fa-solid fa-book me-2'></i>Plan de Cuentas</h5>
                </div>
                <div class='card-body p-0'>
                    <div class='table-responsive'>\n";

echo "<table class='table table-hover table-striped table-bordered mb-0'>\n";
echo "\t\t<thead class='table-dark'>\n";
echo "\t\t<tr>\n";
echo "\t\t\t<th>Número de cuenta</th>\n";
echo "\t\t\t<th>Nombre de la cuenta</th>\n";
echo "\t\t\t<th>Tipo de la cuenta</th>\n";
echo "\t\t\t<th class='text-center'>Acciones</th>\n";  // <-- columna unificada
echo "\t\t</tr>\n";
echo "\t\t</thead>\n";
echo "\t\t<tbody>\n";

while($line = mysqli_fetch_array($result, MYSQLI_ASSOC)){

  $codigo = $line["NumCuenta"];
  $nombre = $line["NombreCuenta"];
  $tipo = $line["Tipo"];
  $n_tipo = "";

  // este if lo que hace es que toma la incial que tiene la DB y la pasa al tipo correspondiente si es toma un A es activo y lo pinta para el usaurio pero internamente solo es como una mascara para nosotros los programadores
  if($tipo == "A"){
    $n_tipo="Activo";
  }else if($tipo=="P"){
    $n_tipo="Pasivo";
  }else if($tipo=="C"){
    $n_tipo="Capital";
  }else if($tipo =="I"){
    $n_tipo="Ingresos";
  }else if($tipo =="G") {
    $n_tipo ="Gastos";
  }

    echo "\t<tr>\n";
    echo "\t\t<td>" . $line["NumCuenta"] . "</td>\n";
    echo "\t\t<td>" . $line["NombreCuenta"] . "</td>\n";
    echo "\t\t<td>" . $n_tipo . "</td>\n";
    // botones de acción para modificar y eliminar una cuenta contable
    echo "\t\t<td class='text-center'>
        <a href='eliminar.php?NumCuenta=$codigo' class='btn btn-sm btn-outline-danger me-1' title='Eliminar'>
            <i class='fa-solid fa-trash'></i>
        </a>
        <a href='modificarForm.php?NumCuenta=$codigo&NombreCuenta=$nombre&Tipo=$tipo' class='btn btn-sm btn-outline-warning' title='Modificar'>
            <i class='fa-solid fa-pen-to-square'></i>
        </a>
    </td>\n";
    echo "\t</tr>\n"; 
}

echo "</table>\n";


mysqli_close($link);
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  
</body>
</html>