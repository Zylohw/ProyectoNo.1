<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Libro Mayor</title>
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
        <li><a class="dropdown-item py-2" href="#">Libro Mayor</a></li>
        <li><a class="dropdown-item py-2" href="balancesaldo.php">Balance de Saldo</a></li>
      </ul>
    </li>

  </ul>
</nav>   

<!-- Card del filtro -->
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-primary text-white rounded-top-4 py-3">
            <h5 class="mb-0">
                <i class="fa-solid fa-filter me-2"></i>Filtrar Libro Mayor
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="libromayor.php">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="fa-solid fa-book me-1 text-primary"></i>Cuenta Contable
                        </label>
                        <select name="filtro_cuenta" class="form-select">
                            <option value="">Todas las Cuentas</option>
                            <?php
                                $link = mysqli_connect("localhost", "root", "", "contabilidad");
                                $queryCuentas = "SELECT NumCuenta, NombreCuenta FROM CuentasContables ORDER BY NumCuenta";
                                $resultCuentas = mysqli_query($link, $queryCuentas);
                                while($c = mysqli_fetch_assoc($resultCuentas)){
                                    $selected = (isset($_GET['filtro_cuenta']) && $_GET['filtro_cuenta'] == $c['NumCuenta']) ? 'selected' : '';
                                    echo "<option value='" . $c['NumCuenta'] . "' $selected>" 
                                         . $c['NumCuenta'] . " - " . $c['NombreCuenta'] 
                                         . "</option>";
                                }
                                mysqli_close($link);
                            ?>
                        </select>
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
                        <a href="libromayor.php" class="btn btn-secondary w-100">
                            <i class="fa-solid fa-broom me-1"></i>Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php
$filtro_cuenta = $_GET["filtro_cuenta"] ?? '';
$filtro_fecha  = $_GET["filtro_fecha"]  ?? '';

$selectFilter = "";
if($filtro_cuenta !== ''){
    $selectFilter .= "AND cc.NumCuenta = '$filtro_cuenta'";
}
if($filtro_fecha !== ''){
    $selectFilter .= " AND pc.Fecha = '$filtro_fecha'";
}

$link = mysqli_connect("localhost", "root", "", "contabilidad") or die("Error: " . mysqli_error($link));

$query = "SELECT cc.NumCuenta, cc.NombreCuenta, pc.NumPartida, pc.Fecha, pc.Descripcion, rc.DebeHaber, rc.Valor
          FROM CuentasContables cc, RegistrosContables rc, PartidasContables pc
          WHERE cc.NumCuenta = rc.NumCuenta AND rc.NumPartida = pc.NumPartida $selectFilter
          ORDER BY cc.NombreCuenta, pc.Fecha ASC";

$result = mysqli_query($link, $query) or die("Error: " . mysqli_error($link));
?>


<div class="container mt-4">

    <!-- Card Libro Mayor -->
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 py-3">
            <h4 class="mb-0">
                <i class="fa-solid fa-book-open me-2"></i>Libro Mayor
            </h4>
            <small>
                <i class="fa-solid fa-building me-1"></i>Empresa Lift &nbsp;|&nbsp;
                <i class="fa-solid fa-calendar-days me-1"></i>Fecha de emisión: <?php echo date('d/m/Y'); ?>
            </small>
        </div>

        <div class="card-body p-3">
       <?php
            $cuenta_actual  = "";
            $total_debe     = 0;
            $total_haber    = 0;

            while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $num_partida   = $line["NumPartida"];
                $fecha         = $line["Fecha"];
                $descripcion   = $line["Descripcion"];
                $nombre_cuenta = $line["NombreCuenta"];
                $num_cuenta    = $line["NumCuenta"];
                $valor         = $line["Valor"];

                if ($nombre_cuenta != $cuenta_actual) {

                    if ($cuenta_actual != "") {
                        $saldo_final = abs($total_debe - $total_haber);

                        echo "<tr class='table-secondary fw-bold'>\n";
                        echo "  <td colspan='3' class='text-end'>Total</td>\n";
                        echo "  <td class='text-end'>Q " . number_format($total_debe, 2) . "</td>\n";
                        echo "  <td class='text-end'>Q " . number_format($total_haber, 2) . "</td>\n";
                        echo "</tr>\n";

                        echo "<tr class='table-dark fw-bold'>\n";
                        echo "  <td colspan='3' class='text-end text-white'>Saldo</td>\n";
                        if ($total_debe >= $total_haber) {
                            echo "  <td class='text-end text-warning'>Q " . number_format($saldo_final, 2) . "</td>\n";
                            echo "  <td class='text-end'>-</td>\n";
                        } else {
                            echo "  <td class='text-end'>-</td>\n";
                            echo "  <td class='text-end text-warning'>Q " . number_format($saldo_final, 2) . "</td>\n";
                        }
                        echo "</tr>\n";
                        echo "</tbody></table></div>\n";
                    }

                    $total_debe    = 0;
                    $total_haber   = 0;
                    $cuenta_actual = $nombre_cuenta;

                    echo "<div class='card border-0 shadow-sm rounded-3 mb-4'>\n";
                    echo "<div class='card-header bg-dark text-white py-2'>\n";
                    echo "  <span class='fw-bold'><i class='fa-solid fa-book me-2'></i>" . $num_cuenta . " - " . $nombre_cuenta . "</span>\n";
                    echo "</div>\n";
                    echo "<table class='table table-bordered table-hover mb-0'>\n";
                    echo "<thead class='table-dark'>\n";
                    echo "<tr>\n";
                    echo "  <th>N° Partida</th>\n";
                    echo "  <th>Fecha</th>\n";
                    echo "  <th>Descripción</th>\n";
                    echo "  <th class='text-end'>Debe (Q)</th>\n";
                    echo "  <th class='text-end'>Haber (Q)</th>\n";
                    echo "</tr>\n";
                    echo "</thead>\n";
                    echo "<tbody>\n";
                }

                $debe_celda  = ($line["DebeHaber"] == "D") ? "Q " . number_format($valor, 2) : "-";
                $haber_celda = ($line["DebeHaber"] == "H") ? "Q " . number_format($valor, 2) : "-";

                if ($line["DebeHaber"] == "D") $total_debe  += $valor;
                if ($line["DebeHaber"] == "H") $total_haber += $valor;

                echo "<tr>\n";
                echo "  <td class='text-center'>#" . $num_partida . "</td>\n";
                echo "  <td class='text-center'>" . $fecha . "</td>\n";
                echo "  <td>" . $descripcion . "</td>\n";
                echo "  <td class='text-end'>" . $debe_celda . "</td>\n";
                echo "  <td class='text-end'>" . $haber_celda . "</td>\n";
                echo "</tr>\n";
            }

            if ($cuenta_actual != "") {
                $saldo_final = abs($total_debe - $total_haber);

                echo "<tr class='table-secondary fw-bold'>\n";
                echo "  <td colspan='3' class='text-end'>Total</td>\n";
                echo "  <td class='text-end'>Q " . number_format($total_debe, 2) . "</td>\n";
                echo "  <td class='text-end'>Q " . number_format($total_haber, 2) . "</td>\n";
                echo "</tr>\n";

                echo "<tr class='table-dark fw-bold'>\n";
                echo "  <td colspan='3' class='text-end text-white'>Saldo</td>\n";
                if ($total_debe >= $total_haber) {
                    echo "  <td class='text-end text-warning'>Q " . number_format($saldo_final, 2) . "</td>\n";
                    echo "  <td class='text-end'>-</td>\n";
                } else {
                    echo "  <td class='text-end'>-</td>\n";
                    echo "  <td class='text-end text-warning'>Q " . number_format($saldo_final, 2) . "</td>\n";
                }
                echo "</tr>\n";
                echo "</tbody></table></div>\n";
            }

            mysqli_close($link);
?>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>