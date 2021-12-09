<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Interfaz de usuario para solicitar un articulo -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=p, initial-scale=1.0">
  <title>Solicitud De Articulo</title>
  <link rel="stylesheet" type="text/css" href="EstiloPagina1.css" media="screen" />

</head>

<body>
  <?php
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
  $us = $_GET['RegistroUs'];
  $conn = Conecta();

  $stmt = $conn->query("SELECT * FROM `usuario` Where RegsitroUsuario='$us'");


  while ($row = $stmt->fetch_assoc()) {
    $Carnet = $row["IdRol"];
  }
  ?>
  <nav class="nav">
    <ul class="menu">
      <li><a>Historial de pedido</a></li>
      <li><a href=" Usuario.php?RegistroUs=<?php echo $us ?>">Perfil de usuario</a></li>
      <li><a href="index.html?RegistroUs=<?php echo $us ?>">Cerrar Sesion</a></li>
      <li><a>Ayuda</a></li>
    </ul>
  </nav><?php
        ?>
  <div align=center class="Principal">
    <form method="post" action="InsertArt.php" align=center>
      <h4>Solicitud De Articulo</h4>
      <br>
      <?php
      if (isset($_GET["fallo"]) && $_GET["fallo"] == 'true') {
      ?>
        <div style='color:red'>solicitud de pedido exitoso </div>

      <?php
      }
      ?>
      <br><br>
      <input name="Us" id="Nombre" type="hidden" value="<?php echo  $us; ?>">

      <label for="Nombre De articulo"><b>Nombre De Articulo:</b></label>
      <input name="Nombre" class="control" id="Nombre" type="text" placeholder="Televisor">

      <br><br>
      <label for="Precio"><b>Precio De Articulo:</b></label>
      <input name="Precio" class="control" id="Precio" type="int" placeholder="100 000">

      <br><br>
      <label for="Descripcion"><b>Descripcion De Articulo:</b></label>
      <textarea name="Descripcion" rows="2" cols="20" id="Descripcion" style="height:64px;width:440px;" required></textarea>
      <br><br>
      <input class="button" type="reset" value="Cancelar">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input class="button" type="submit" value="Solicitar pedido">

      <br><br>
    </form>
  </div>

  <br><br><br>
</body>

</html>