
<?php
//Insertamos los articulos de los usuarios 
function recoge($var, $m = "")
{
  if (!isset($_REQUEST[$var])) {
    $tmp = (is_array($m)) ? [] : "";
  } elseif (!is_array($_REQUEST[$var])) {
    $tmp = trim(htmlspecialchars($_REQUEST[$var], ENT_QUOTES, "UTF-8"));
  } else {
    $tmp = $_REQUEST[$var];
    array_walk_recursive($tmp, function (&$valor) {
      $valor = trim(htmlspecialchars($valor, ENT_QUOTES, "UTF-8"));
    });
  }
  return $tmp;
}

$Nom = recoge("Nombre");
$Pre   = recoge("Precio");
$Des = recoge("Descripcion");
$us = recoge("Us");

$conn = Conecta();
$stmt = $conn->query("SELECT * FROM `usuario` Where RegsitroUsuario='$us'");
while ($row = $stmt->fetch_assoc()) {
  $val = $row["carnet"];
}
$stmt1 = $conn->query("INSERT INTO `solicitudart` (`nombreArt`, `descripcion`,`precio`,`carnetUs`) VALUES ( '$Nom', '$Des','$Pre','$val');");
if ($stmt1) {
  $stmt = $conn->query("SELECT * FROM `solicitudart` Where 	carnetUs='$val'");
  while ($row = $stmt->fetch_assoc()) {
    $IdSart = $row["idSArt"];
  }
  print($IdSart);
  print($val);
  $stmt2 = $conn->query("INSERT INTO `historial` (`CarnetUsuar`, `IdSart`) VALUES ( '$val', '$IdSart');");
  if ($stmt2) {
    $stmt = $conn->query("SELECT * FROM `historial` Where CarnetUsuar='$val'");
    while ($row = $stmt->fetch_assoc()) {
      $idHistorial  = $row["idHistorial"];
    }
    print $idHistorial;
    $stmt3 = $conn->query("INSERT INTO `estado` (`idHistorial`, `Visto`) VALUES ( '$idHistorial', '1');");
    if ($stmt3) {
      header("Status: 301 Moved Permanently");
      header("Location: SolicitudDeArt.php?RegistroUs=$us&fallo=true");
      exit;
    }
  }
} else {
  $response = "No se almaceno la cita satisfactoriamente";
}
$conn->close();
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
