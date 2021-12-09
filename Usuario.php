<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Interfaz que muestra nuestros datos personales -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuario</title>
  <link rel="stylesheet" type="text/css" href="EstiloPagina1.css" media="screen" />

</head>

<body>

  <?php
  $us = $_GET['RegistroUs'];
  $conn = Conecta();

  $stmt = $conn->query("SELECT * FROM `usuario` Where RegsitroUsuario='$us'");


  while ($row = $stmt->fetch_assoc()) {
    $IdRol = $row["IdRol"];
  }
  ?>
  <nav class="nav">
    <ul class="menu">
      <?php
      if ($IdRol == '1') { ?>
        <li>
          <a href="SolicitudDeArt.php?RegistroUs=<?php echo $us ?>">Solicitud de articulo</a>
        </li><?php }
            if ($IdRol == '2') { ?>
        <li>
          <a href="Roles.php?RegistroUs=<?php echo $us ?>">Solicitud de registro</a>
        </li><?php }
            if ($IdRol > '2' & $IdRol < '7') { ?>
        <li><a href="SolicitudDePedidos.php?RegistroUs=<?php echo $us ?>">Solicitud de pedidos</a></li>
      <?php }
            if ($IdRol == 2) { ?>
        <li><a href="UsuariosDis.php?RegistroUs=<?php echo $us ?>">Historial de registro</a></li>
      <?php } else { ?>
        <li><a href="Pedidos.php?RegistroUs=<?php echo $us ?>">Historial de pedido</a></li>
      <?php } ?> <li><a href=" index.html?RegistroUs=<?php echo $us ?>">Cerrar Sesion</a>
      </li>
      <li><a>Ayuda</a></li>
    </ul>
  </nav><?php
        function Conecta()
        {
          $elServidor = "localhost";
          $elUsuario = "root";
          $elPassword = "";
          $laBD = "telecenter";
          $laconexion = new mysqli($elServidor, $elUsuario, $elPassword, $laBD);

          if ($laconexion->connect_error) {
            die("Error al Conectar con la BD: " . $laconexion->connect_error);
          }
          //echo "Conexion exitosa <br>";

          return $laconexion;
        }
        $conn = Conecta();


        // prepare and bind
        $stmt = $conn->query("SELECT * FROM `usuario` Where RegsitroUsuario='$us'");


        while ($row = $stmt->fetch_assoc()) {
          $val = $row["RegsitroUsuario"];

        ?>

    <div align=center class="Principal">
      <form method="POST" action="UpdateLogin.php" align=center>
        <?php if (isset($_GET["fallo"]) && $_GET["fallo"] == 'true') {
        ?>
          <div style='color:red'>Informacion Modificado con exito </div>
          <br><br>
        <?php
          } ?>

        <h4>Informacion personal</h4>
        <br><br>
        &nbsp;<label for="Registro usuario"><b>Registro usuario:</b></label>
        &nbsp;<input readonly name="Usuario" class="control" id="Us" type="text" value="<?php echo  $row["RegsitroUsuario"]; ?>">

        <br><br>
        <label for="NombreApellidos"><b>NombreApellidos:</b></label>
        &nbsp;<input require class="control" name="NombreApellidos" id="NombreApellidos" type="text" value="<?php echo  $row["NombreApellidos"]; ?>">

        <br><br>
        &nbsp; &nbsp; &nbsp; &nbsp;<label for="Edad"><b>Edad:</b></label>
        &nbsp;<input require class="control" name="Edad" id="Edad" type="int" value="<?php echo  $row["Edad"]; ?>">

        <br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;<label for="Cedula"><b>Cedula:</b></label>
        &nbsp;<input readonly class="control" id="Cedula" type="int" value="<?php echo  $row["cedula"]; ?>">

        <br><br>
        <label for="Correo electronico"><b>Correo electronico:</b></label>
        <input require class="control" name="correo" id="correo" type="text" value="<?php echo  $row["correo"]; ?>">

        <br><br>
        <input class="button" type="submit" value="Guardar cambios" onclick="validarEmail(form.correo.value)">

        <br><br>
      </form>
    </div>
    <script src="ValidarEmail.js"></script>
  <?php } ?>

  </div>
</body>

</html>