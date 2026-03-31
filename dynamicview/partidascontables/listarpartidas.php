<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=|, initial-scale=1.0">
  <title>Listar Partidas Contables</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        <li><a class="dropdown-item py-2" href="#">Listar Partidas</a></li>
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

<div class="container mt-4">

    <!-- Card del filtro -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-primary text-white rounded-top-4 py-3">
            <h5 class="mb-0">
                <i class="fa-solid fa-filter me-2"></i>Filtrar Partidas
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="listarpartidas.php">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="fa-solid fa-hashtag me-1 text-primary"></i>Número de Partida
                        </label>
                        <input type="number" name="filtro_partida" class="form-control" 
                               placeholder="Ej: 60"
                               value="<?php echo isset($_GET['filtro_partida']) ? $_GET['filtro_partida'] : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="fa-solid fa-calendar-days me-1 text-primary"></i>Fecha
                        </label>
                        <input type="date" name="filtro_fecha" class="form-control"
                               value="<?php echo isset($_GET['filtro_fecha']) ? $_GET['filtro_fecha'] : '' ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-magnifying-glass me-1"></i>Filtrar
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="listarpartidas.php" class="btn btn-secondary w-100">
                            <i class="fa-solid fa-broom me-1"></i>Limpiar
                          </a>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Card de la tabla -->
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 py-3">
            <h5 class="mb-0">
                <i class="fa-solid fa-book me-2"></i>Lista de Partidas
            </h5>
        </div>
        <div class="card-body p-0">

<?php

$filtro_partida = $_GET["filtro_partida"] ?? '';
$filtro_fecha   = $_GET["filtro_fecha"]   ?? '';

$selectFilter = "";
if ($filtro_partida !== '') {
    $selectFilter .= "AND rc.NumPartida = '$filtro_partida'";
} elseif ($filtro_fecha !== '') {
    $selectFilter .= "AND pc.Fecha = '$filtro_fecha'";
}

$link = mysqli_connect("localhost", "root", "", "contabilidad") or die("Error al conectar: " . mysqli_error($link));

$query = "SELECT rc.NumPartida, rc.NumCuenta, rc.DebeHaber, rc.Valor, pc.Fecha, pc.Descripcion, cc.NombreCuenta
          FROM RegistrosContables rc, PartidasContables pc, CuentasContables cc
          WHERE rc.NumPartida = pc.NumPartida AND rc.NumCuenta = cc.NumCuenta $selectFilter
          ORDER BY rc.NumPartida";

$result = mysqli_query($link, $query) or die("Error en la consulta: " . mysqli_error($link));

$numero_partida = "";
$nombre_cuenta  = "";
$num_cuenta     = "";
$valor          = "";
$fecha          = "";
$descripcion    = "";

echo "<table class='table table-hover table-striped table-bordered mb-0'>\n";
echo "\t<thead class='table-dark'>\n";
echo "\t<tr>\n";
echo "\t\t<th>Numero de Partida</th>\n";
echo "\t\t<th>Numero de Cuenta</th>\n";
echo "\t\t<th>Nombre de Cuenta</th>\n";
echo "\t\t<th>DebeHaber</th>\n";
echo "\t\t<th>Valor</th>\n";
echo "\t\t<th>Acciones</th>\n";
echo "\t</tr>\n";
echo "\t</thead>\n";
echo "\t<tbody>\n";

$partida_actual = "";

while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $numero_partida = $line["NumPartida"];
    $num_cuenta     = $line["NumCuenta"];
    $nombre_cuenta  = $line["NombreCuenta"];
    $valor          = $line["Valor"];
    $fecha          = $line["Fecha"];
    $descripcion    = $line["Descripcion"];
    $db = "";
    if ($line["DebeHaber"] == "D"){
        $db = "Debe";
    } else if ($line["DebeHaber"] == "H"){
        $db = "Haber";
    }

    if ($line["NumPartida"] != $partida_actual){
        $partida_actual = $line["NumPartida"];

        echo "\t<tr class='table-dark'>\n";
        echo "\t\t<td colspan='5' class='lh-sm py-2'>
                    <span class='fw-bold text-white'>Partida #" . $line["NumPartida"] . "</span><br>
                    <small class='text-warning'>📅 " . $line["Fecha"] . "</small><br>
                    <small class='text-info'>📝 " . $line["Descripcion"] . "</small>
                  </td>\n";

        echo "\t\t<td class='text-center align-middle'>
                    <a href='eliminarpartida.php?NumPartida=$numero_partida' class='btn btn-outline-danger btn-sm me-1'>
                        <i class='fa-solid fa-trash'></i>
                    </a>
                    <a href='modificarpartida.php?NumPartida=$numero_partida' class='btn btn-outline-warning btn-sm'>
                        <i class='fa-solid fa-pen-to-square'></i>
                    </a>
                </td>\n";
        echo "\t</tr>\n";
    }

    echo "\t<tr>\n";
    echo "\t\t<td>" . $line["NumPartida"] . "</td>\n";
    echo "\t\t<td>" . $line["NumCuenta"] . "</td>\n";
    echo "\t\t<td>" . $line["NombreCuenta"] . "</td>\n";
    echo "\t\t<td>" . $db . "</td>\n";
    echo "\t\t<td>" . number_format($line["Valor"],2) . "</td>\n";

    echo "\t</tr>\n";
}

echo "\t</tbody>\n";
echo "</table>\n";

mysqli_close($link);
?>

        </div>
    </div>
</div>

 

<script src="../../logic/filter.js"></script>
<script src="../../logic/agregarFila.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>