<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Mostramos los pedidos de los usuarios -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio Examen</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/fotograma.css">
    <link rel="stylesheet" type="text/css" href="EstiloPagina1.css" media="screen" />
    <style>
        .table {
            border-color: blueviolet;
        }

        #Tercero {
            width: 950px;
            /*Ancho del area de elemento*/
        }
    </style>
</head>

<body>
    <?php
    $us = $_GET['RegistroUs'];
    $conn = Conecta();
    $stmt = $conn->query("SELECT * FROM `usuario` WHERE RegsitroUsuario='$us'");
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
            <?php }?>
            <li><a href=" Usuario.php?RegistroUs=<?php echo $us ?>">Perfil de usuario</a></li>

            <li><a href=" index.html?RegistroUs=<?php echo $us ?>">Cerrar Sesion</a>
            </li>
            <li><a>Ayuda</a></li>
        </ul>
    </nav>
    <div class="main">
        <?php
        //Pagina que muestra los datos de base de datos
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
        echo "<div align=center class='Principal' id=Tercero>";
        echo "<h3>Pedidos ingresados </h3>";
        echo "<br>";


        echo "<table class='table' border='5'  >";
        echo "<tr>";
        echo " <th> Art  </th>";
        echo " <th> nombreArt </th>";
        echo " <th> descripcion  </th>";
        echo " <th> precio </th>";
        echo " <th> fechaSolicitud </th>";
        echo " <th> Us  </th>";
        echo " <th> fechaAprobadoORechazado	 </th>";
        echo " <th> EstadoJefe </th>";
        echo " <th> IdFinanciero </th>";
        echo " <th> EstadoFinan </th>";
        echo "</tr>";
        $conn = Conecta();
        $stmt = $conn->query("SELECT * FROM `usuario` WHERE RegsitroUsuario='$us'");
        while ($row = $stmt->fetch_assoc()) {
            $rol = $row["IdRol"];
            $Pedidos = $row["carnet"];
        }
        if ($rol == 1) {
            $stmt = $conn->query("SELECT * FROM `pedidos` WHERE carnetUs=$Pedidos ");
            while ($row = $stmt->fetch_assoc()) {
                imprimirTabla($row);
            }
        }
        if ($rol > 2 & $rol < 7) { // Administrador Financiero
            $stmt = $conn->query("SELECT * FROM `roles` WHERE TipoDeRol='$rol'");
            while ($row = $stmt->fetch_assoc()) {
                $min = $row["min"];
                $min = $min - 1;
                $max = $row["Máximo"];
                $max = $max + 1;
            }
            $stmt = $conn->query("SELECT * FROM `pedidos` WHERE AprobadorJefe='1'");
            while ($row = $stmt->fetch_assoc()) {
                $precio = $row["precio"];
                if ($precio > $min & $precio < $max) {
                    imprimirTabla($row);
                }
            }
        }
        if ($rol == 3) {
            $stmt = $conn->query("SELECT * FROM `usuario` WHERE RegsitroUsuario='$us'");
            while ($row = $stmt->fetch_assoc()) {
                $carnet = $row["carnet"];
            }
            $stmt = $conn->query("SELECT * FROM `usuario` WHERE IdJefe='$carnet'");
            while ($row = $stmt->fetch_assoc()) {
                $Pedidos = $row["carnet"];
                $stmt1 = $conn->query("SELECT * FROM `pedidos` WHERE carnetUs=$Pedidos ");
                while ($rows = $stmt1->fetch_assoc()) {

                    imprimirTabla($rows);
                }
            }
        }
        function imprimirTabla($row)
        {
            $Val= $row["AprobadorJefe"];
            if($Val==1){
                $Jefe="Aprobado";
            }else{
                $Jefe="Rechazado";
            }
            $Val= $row["AprobadorFinan"];
            if($Val==1){
                $Fina="Aprobado";
            }else{
                $Fina="Rechazado";
            }
            echo "<tr>";
            echo "<td>" . $row["idSArt"] .      "</td> ";
            echo "<td>" . $row["nombreArt"] .      "</td> ";
            echo "<td>" . $row["descripcion"] .      "</td> ";
            echo "<td>" . $row["precio"] .      "</td> ";
            echo "<td>" . $row["fechaSolicitud"] .      "</td> ";
            echo "<td>" . $row["carnetUs"] .      "</td> ";
            echo "<td>" . $row["fechaAprobadoORechazado"] .      "</td> ";
            echo "<td>" . $Jefe.      "</td> ";
            echo "<td>" . $row["IdFinanciero"] .      "</td> ";
            echo "<td>" . $Fina.      "</td> ";
            echo "</tr>";
        }
        //End imprimeTabla  -----------------------------------------------------------
        echo "</table>";
        echo "</div>";
        ?>
    </div>
    </div>

</body>

</html>