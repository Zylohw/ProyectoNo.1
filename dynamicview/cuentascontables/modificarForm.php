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

<form action="" method = "post">
  <div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5">
      <div class="card shadow-sm p-4"> 
          <?php
          $codigo = $_GET["NumCuenta"];
          $nombre = $_GET["NombreCuenta"];
          $tipo = $_GET["Tipo"];

          echo'<div class="mb-3">
            <label for="exampleInputEmail1" class="form-label mb-4 d-block text-center">Agregar Cuenta</label>
            <!--Input para agregar el nombre de la cuenta-->

            <!--Insertar codigo-->
            <input  name="codigo" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value='$codigo' readonly>
            <br>

            <!--Insertar nombre-->
            <input  name="cuenta"type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Inserte el nombre de la cuenta">

            <div class="mb-3">
            <label for="Select" class="form-label">Seleccione el tipo de cuenta:</label>
            <select name="tipo_cuenta" id="Select" class="form-select">
              <option value="A">Activo</option>
              <option value="P">Pasivo</option>
              <option value="G">Gastos</option>
              <option value="C">Capital</option>
              <option value="I">Ingresos</option>
            </select>
          </div>

          <button name="submit" type="submit" class="btn btn-primary w-100">Agregar Cuenta</button>
          </div>';
          ?>
      </div>
    </div>
   </div>
  </div>


</form>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>