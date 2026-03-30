<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link rel="stylesheet" href="../../style/librodiario.css">
  <title>Libro Diario</title>
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
        <li><a class="dropdown-item py-2" href="#">Libro Diario</a></li>
        <li><a class="dropdown-item py-2" href="libromayor.php">Libro Mayor</a></li>
        <li><a class="dropdown-item py-2" href="balancesaldo.php">Balance de Saldo</a></li>
      </ul>
    </li>

  </ul>
</nav>   

<!-- Filtro -->
<!-- Card del filtro -->
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-primary text-white rounded-top-4 py-3">
            <h5 class="mb-0">
                <i class="fa-solid fa-filter me-2"></i>Filtrar Libro Diario
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="librodiario.php">
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
                        <a href="libroDiario.php" class="btn btn-secondary w-100">
                            <i class="fa-solid fa-broom me-1"></i>Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

$filtro_partida = $_GET["filtro_partida"] ?? '';
$filtro_fecha   = $_GET["filtro_fecha"]   ?? '';

$selectFilter = "";
if($filtro_partida !== ''){
    $selectFilter .= "AND rc.NumPartida = '$filtro_partida'";
} elseif($filtro_fecha !== ''){
    $selectFilter .= "AND pc.Fecha = '$filtro_fecha'";
}

$link = mysqli_connect("localhost", "root", "", "contabilidad") or die("Error: " . mysqli_error($link));

$query = "SELECT rc.NumPartida, rc.NumCuenta, rc.DebeHaber, rc.Valor, 
                 pc.Fecha, pc.Descripcion, cc.NombreCuenta
          FROM RegistrosContables rc, PartidasContables pc, CuentasContables cc
          WHERE rc.NumPartida = pc.NumPartida AND rc.NumCuenta = cc.NumCuenta $selectFilter
          ORDER BY pc.Fecha, rc.NumPartida";

$result = mysqli_query($link, $query) or die("Error: " . mysqli_error($link));
?>


<!-- Libro diario -->
<div class="container mt-4">
    <div class="card shadow border-0 rounded-4">

        <!-- Header -->
        <div class="card-header bg-primary text-white rounded-top-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fa-solid fa-book me-2"></i>Libro Diario
                </h4>
            </div>
        </div>

        <div class="card-body p-0">

<?php 
// conectandome a la base de datos 
$link = mysqli_connect('localhost','root','','contabilidad') or die("hubo un error al conectase a la db".mysqli_error());

// query para seleccionar datos 
$query = "SELECT rc.NumPartida, rc.NumCuenta, rc.DebeHaber, rc.Valor, 
                 pc.Fecha, pc.Descripcion, cc.NombreCuenta
          FROM RegistrosContables rc, PartidasContables pc, CuentasContables cc
          WHERE rc.NumPartida = pc.NumPartida AND rc.NumCuenta = cc.NumCuenta
          ORDER BY pc.Fecha, rc.NumPartida";

$result = mysqli_query($link, $query) or die("Error: " . mysqli_error($link));

echo "<table class='table table-bordered mb-0'>\n";
echo "<thead class='table-dark'>\n";
echo "<tr>\n";
echo "  <th>N° Cuenta</th>\n";
echo "  <th>Nombre de Cuenta</th>\n";
echo "  <th class='text-end'>Debe (Q)</th>\n";
echo "  <th class='text-end'>Haber (Q)</th>\n";
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";

// variables auxiliares 
$partida_actual = "";
$subtotal_debe  = 0;
$subtotal_haber = 0;
$total_debe     = 0;
$total_haber    = 0;

while($line = mysqli_fetch_assoc($result)){

    if($line["NumPartida"] != $partida_actual){

        // Imprime subtotales de la partida anterior
        if($partida_actual != ""){
            echo "<tr class='table-secondary fw-bold'>\n";
            echo "  <td colspan='2' class='text-end'>Subtotal Partida #$partida_actual</td>\n";
            echo "  <td class='text-end'>Q " . number_format($subtotal_debe, 2) . "</td>\n";
            echo "  <td class='text-end'>Q " . number_format($subtotal_haber, 2) . "</td>\n";
            echo "</tr>\n";

            // Acumula totales generales
            $total_debe  += $subtotal_debe;
            $total_haber += $subtotal_haber;

            // Reinicia subtotales
            $subtotal_debe  = 0;
            $subtotal_haber = 0;
        }

        $partida_actual = $line["NumPartida"];

        echo "<tr class='table-dark'>\n";
        echo "  <td colspan='4' class='lh-sm py-2'>
                    <span class='fw-bold text-white'>Partida #" . $line["NumPartida"] . "</span><br>
                    <small class='text-warning'>📅 " . $line["Fecha"] . "</small><br>
                    <small class='text-info'>📝 " . $line["Descripcion"] . "</small>
                </td>\n";
        echo "</tr>\n";
    }

    if($line["DebeHaber"] == "D"){
        $subtotal_debe += $line["Valor"];
        echo "<tr>\n";
        echo "  <td>" . $line["NumCuenta"] . "</td>\n";
        echo "  <td>" . $line["NombreCuenta"] . "</td>\n";
        echo "  <td class='text-end'>Q " . number_format($line["Valor"], 2) . "</td>\n";
        echo "  <td class='text-end'>-</td>\n";
        echo "</tr>\n";
    } else {
        $subtotal_haber += $line["Valor"];
        echo "<tr>\n";
        echo "  <td>" . $line["NumCuenta"] . "</td>\n";
        echo "  <td>" . $line["NombreCuenta"] . "</td>\n";
        echo "  <td class='text-end'>-</td>\n";
        echo "  <td class='text-end'>Q " . number_format($line["Valor"], 2) . "</td>\n";
        echo "</tr>\n";
    }
}

if($partida_actual != ""){
    echo "<tr class='table-secondary fw-bold'>\n";
    echo "  <td colspan='2' class='text-end'>Total Partida #$partida_actual</td>\n";
    echo "  <td class='text-end'>Q " . number_format($subtotal_debe, 2) . "</td>\n";
    echo "  <td class='text-end'>Q " . number_format($subtotal_haber, 2) . "</td>\n";
    echo "</tr>\n";

    $total_debe  += $subtotal_debe;
    $total_haber += $subtotal_haber;
}



echo "</tbody>\n";
echo "</table>\n";

mysqli_close($link);



?>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>