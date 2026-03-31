<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Balance de Saldo</title>
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
        <li><a class="dropdown-item py-2" href="librodiario.php">Libro Diario</a></li>
        <li><a class="dropdown-item py-2" href="libromayor.php">Libro Mayor</a></li>
        <li><a class="dropdown-item py-2" href="#">Balance de Saldo</a></li>
      </ul>
    </li>

  </ul>
</nav>   


<div class="container mt-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 py-3">
            <h4 class="mb-0">
                <i class="fa-solid fa-scale-balanced me-2"></i>Balance de Saldo
            </h4>
            <small>
                <i class="fa-solid fa-building me-1"></i>Empresa Lift &nbsp;|&nbsp;
                <i class="fa-solid fa-calendar-days me-1"></i>Fecha de emisión: <?php echo date('d/m/Y'); ?>
            </small>
        </div>
        <div class="card-body p-0">

<?php
$link = mysqli_connect("localhost", "root", "", "contabilidad") or die("Error: " . mysqli_error($link));

$query = "SELECT cc.NumCuenta, cc.NombreCuenta, cc.Tipo,
                 SUM(IF(rc.DebeHaber='D', rc.Valor, 0)) AS TotalDebe,
                 SUM(IF(rc.DebeHaber='H', rc.Valor, 0)) AS TotalHaber
          FROM CuentasContables cc, RegistrosContables rc
          WHERE cc.NumCuenta = rc.NumCuenta
          GROUP BY cc.NumCuenta, cc.NombreCuenta, cc.Tipo
          ORDER BY cc.Tipo, cc.NumCuenta";

$result = mysqli_query($link, $query) or die("Error: " . mysqli_error($link));

echo "<table class='table table-bordered table-hover mb-0'>\n";
echo "<thead class='table-dark'>\n";
echo "<tr>\n";
echo "  <th>N° Cuenta</th>\n";
echo "  <th>Nombre de Cuenta</th>\n";
echo "  <th class='text-end'>Debe (Q)</th>\n";
echo "  <th class='text-end'>Haber (Q)</th>\n";
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";

$tipo_actual      = "";
$gran_total_debe  = 0;
$gran_total_haber = 0;

while($line = mysqli_fetch_assoc($result)){
    $total_debe  = $line["TotalDebe"];
    $total_haber = $line["TotalHaber"];
    $tipo        = $line["Tipo"];

    // Nombre del tipo con if
    $nombre_tipo = "";
    if($tipo == "A")      $nombre_tipo = "ACTIVO";
    else if($tipo == "P") $nombre_tipo = "PASIVO";
    else if($tipo == "G") $nombre_tipo = "GASTOS";
    else if($tipo == "C") $nombre_tipo = "CAPITAL";
    else if($tipo == "I") $nombre_tipo = "INGRESOS";

    // Encabezado de tipo cuando cambia
    if($tipo != $tipo_actual){
        $tipo_actual = $tipo;
        echo "<tr class='table-dark'>\n";
        echo "  <td colspan='4' class='fw-bold text-warning'>\n";
        echo "      <i class='fa-solid fa-tag me-2'></i>" . $nombre_tipo . "\n";
        echo "  </td>\n";
        echo "</tr>\n";
    }

    $gran_total_debe  += $total_debe;
    $gran_total_haber += $total_haber;

    echo "<tr>\n";
    echo "  <td class='ps-4'>" . $line["NumCuenta"] . "</td>\n";
    echo "  <td class='ps-4'>" . $line["NombreCuenta"] . "</td>\n";
    echo "  <td class='text-end'>Q " . number_format($total_debe, 2) . "</td>\n";
    echo "  <td class='text-end'>Q " . number_format($total_haber, 2) . "</td>\n";
    echo "</tr>\n";
}

// Total general
echo "<tr class='table-dark fw-bold'>\n";
echo "  <td colspan='2' class='text-end text-white'>TOTAL GENERAL</td>\n";
echo "  <td class='text-end text-warning'>Q " . number_format($gran_total_debe, 2) . "</td>\n";
echo "  <td class='text-end text-warning'>Q " . number_format($gran_total_haber, 2) . "</td>\n";
echo "</tr>\n";

echo "</tbody>\n";
echo "</table>\n";

mysqli_close($link);
?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>