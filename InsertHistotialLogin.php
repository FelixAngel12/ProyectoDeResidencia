<?php
//insertamos los usuarios que se conectan junto con la fecha

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

$RegistroUs = recoge("Us");
$pass   = recoge("pass");

$conn = Conecta();
$stmt = $conn->query("SELECT * FROM `usuario` where EstadoUs=1");
$Existe = 0;
if ($stmt->num_rows > 0) {
  while ($row = $stmt->fetch_assoc()) {
    $Usu = $row["RegsitroUsuario"];
    $conta = $row["pass"];
    if ($Usu == $RegistroUs) {
      $Existe = 1;
      if ($conta == $pass) {
        echo InsertaDatos($RegistroUs, true);
        header("Status: 301 Moved Permanently");
        header("Location: Usuario.php?RegistroUs=$Usu");
        exit;
      } else {
        echo InsertaDatos($RegistroUs, false);
        header("Status: 301 Moved Permanently");
        header("Location: Login.php?fallo=true");
        exit;
      }
    }
  }
}
if ($Existe == 0) {
  header("Status: 301 Moved Permanently");
  header("Location: Login.php?fallo=false");
  exit;
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

function InsertaDatos($pRegistroUsOk, $val)
{
  $conn = Conecta();
  // prepare and bind
  $stmt = $conn->query("INSERT INTO `HistorialDeLogin` (`RegsitroUsuario`, `EstadoDeLogin`) VALUES ( '$pRegistroUsOk', '$val');");
  $conn->close();
}
