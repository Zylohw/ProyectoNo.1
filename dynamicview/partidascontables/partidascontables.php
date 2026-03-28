<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Partidas contables</title>

</head>
<body>
  <!-- NavBar -->
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
        <li><a class="dropdown-item py-2" href="#">Visualizar Partidas</a></li>
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

<!--Empieza form para agregar partidas-->
<div class="container mt-5 pt-5" style="max-width: 700px;">
    <div class="card shadow-sm border-0 rounded-4">

        <!-- Header de la card -->
        <div class="card-header bg-primary text-white rounded-top-4 py-3">
            <h4 class="mb-0">
                <i class="fa-solid fa-file-invoice me-2"></i>
                Agregar Partida Contable
            </h4>
        </div>

        <div class="card-body p-4">
            <form action="partidasVerify.php" method="get">

                <!-- Numero de Partida -->
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fa-solid fa-hashtag me-1 text-primary"></i>
                        Número de Partida
                    </label>
                    <input type="text" class="form-control" placeholder="Ej: 001" name="numero_partida">
                </div>

                <!-- Fecha -->
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fa-solid fa-calendar-days me-1 text-primary"></i>
                        Fecha de Ingreso
                    </label>
                    <input type="date" class="form-control" name="fecha">
                </div>

                <!-- Descripcion -->
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fa-solid fa-pen-to-square me-1 text-primary"></i>
                        Descripción
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fa-solid fa-align-left text-secondary"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Ingrese una breve descripción de la partida" maxlength="100" name="descripcion">
                    </div>
                </div>

                <!-- Tabla de cuentas -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0">
                            <i class="fa-solid fa-table me-1 text-primary"></i>
                            Cuentas Contables
                        </h6>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarfila()">
                            <i class="fa-solid fa-plus me-1"></i> Agregar Item
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-primary text-center" id="tablaPartidas">
                                <tr>
                                    <th><i class="fa-solid fa-book me-1"></i>Cuenta Contable</th>
                                    <th><i class="fa-solid fa-arrow-right me-1"></i>Debe (Q)</th>
                                    <th><i class="fa-solid fa-arrow-left me-1"></i>Haber (Q)</th>
                                    <th><i class="fa-solid fa-gear me-1"></i>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpo">
                            <tr>
                              <?php 
                                $link = mysqli_connect('localhost','root','','contabilidad');
                                $query = "SELECT NumCuenta, NombreCuenta FROM CuentasContables order by NumCuenta";
                                $result = mysqli_query($link,$query) or die("Error en la consulta: " . mysqli_error($link));
                                $debeCounter = 0;                               
                                $haberCounter = 0;                               

                                echo "
                                      <td>
                                          <select name='tipo_cuenta[]' class='form-select'>
                                              <option value='' disabled selected>Seleccione una cuenta</option>";

                                              while($line = mysqli_fetch_assoc($result)){
                                                  echo "<option value='" . $line['NumCuenta'] . "'>" . $line['NumCuenta'] . " - " . $line['NombreCuenta'] . "</option>";
                                              }

                                  echo "   </select>
                                      </td>
                                      <td><input type='number' name='D[]' class='form-control' placeholder='0.00' ></td>
                                      <td><input type='number' class='form-control' name='H[]' placeholder='0.00'></td>
                                      <td>
                                          <button type='button' class='btn btn-danger btn-sm' onclick='this.closest(\"tr\").remove()'>
                                              <i class='fa-solid fa-trash'></i>
                                          </button>
                                      </td>
                                  ";                                
                                mysqli_close($link);

                              ?>

                            </tr> 
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Botón enviar -->
                <input type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm" value="Guardar Partida">

            </form>
        </div>
    </div>

<script src="../../logic/agregarFila.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>