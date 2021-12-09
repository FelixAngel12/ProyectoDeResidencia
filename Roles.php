<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Asignamos el rol al usuario que deseamos insertar -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
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
    </nav>
    <form method="POST" action="SolicitudDeRegi.php">
        <input name="RegistroUs" id="Nombre" type="hidden" value="<?php echo  $us; ?>">

        <div class="Principal">
            <?php if (isset($_GET["fallo"]) && $_GET["fallo"] == 'true') {
            ?>
                <div style='color:red'>Informacion insertada con exito </div>
                <br><br>
            <?php
            } ?>
            <div id="Borde" hspace="15">Tipo De Empleado
                <h4></h4>

                <input align="left" type="radio" value="Comprador" name="Tip" checked>Comprador
                <br><br>
                <input align="left" type="radio" value="Aprobador En Jefe" name="Tip">Aprobador En Jefe
                <br><br>
                <input align="left" type="radio" value="Aprobador En Financiero" name="Tip">Aprobador En Financiero
                <br><br>
                <input align="left" type="radio" value="Adminitrador De Sistemas" name="Tip">Adminitrador De Sistemas
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br><br>
            <br><br>
            <input class="button" type="submit" value="Registar ">
            <br><br>
            <br><br>

        </div>
    </form>
</body>

</html>