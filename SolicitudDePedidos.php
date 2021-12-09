<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Muestra los pedidos de los usuarios a los aprobadores 
    para asi determinar se lo aceptan o no -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio Examen</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/fotograma.css">
    <link rel="stylesheet" type="text/css" href="EstiloPagina1.css" media="screen" />
    <style>
        .table {
            margin-left: 118px;
            border-color: blueviolet;
        }
    </style>
</head>

<body>
    <?php
    $us = $_GET['RegistroUs']; ?>
    <nav class="nav">
        <ul class="menu">
            <li><a href="Pedidos.php?RegistroUs=<?php echo $us ?>">Historial de pedido</a></li>
            <li><a href=" Usuario.php?RegistroUs=<?php echo $us ?>">Perfil de usuario</a></li>
            <li><a href="index.html?RegistroUs=<?php echo $us ?>">Cerrar Sesion</a></li>
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

        echo "<div align=center class='Principal' id=Segundo>";
        if (isset($_GET["fallo"]) && $_GET["fallo"] == 'true') {
        ?>
            <div style='color:red'>Operacion realizada con exito </div>
            <br><br>
        <?php
        }
        echo "<h3>Pedidos ingresados </h3>";
        echo "<br>";


        echo "<table class='table' border='5' width=80% >";
        echo "<tr>";
        echo " <th> idSArt  </th>";

        echo " <th> nombreArt </th>";
        echo " <th> descripcion  </th>";
        echo " <th> precio </th>";
        echo " <th> fechaSolicitud </th>";
        echo " <th> carnetUs  </th>";
        echo "</tr>";
        $conn = Conecta();
        $stmt = $conn->query("SELECT * FROM `usuario` WHERE RegsitroUsuario='$us'");
        while ($row = $stmt->fetch_assoc()) {

            $rol = $row["IdRol"];
            $carnet = $row["carnet"];
        }

        if ($rol > 2 & $rol < 7) { // Administrador Financiero
            $stmt = $conn->query("SELECT * FROM `roles` WHERE TipoDeRol='$rol'");
            while ($row = $stmt->fetch_assoc()) {
                $min = $row["min"];
                $min = $min - 1;
                $max = $row["Máximo"];
                $max = $max + 1;
            }
            $stmt = $conn->query("SELECT * FROM `pedidos` WHERE AprobadorJefe='1' and AprobadorFinan IS NULL ");
            while ($row = $stmt->fetch_assoc()) {
                $precio = $row["precio"];
                if ($precio > $min & $precio < $max) {
                    imprimirTabla($row, $us, $rol, $carnet);
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
                $stmt1 = $conn->query("SELECT * FROM `pedidos` WHERE carnetUs=$Pedidos and Visto=1");
                while ($rows = $stmt1->fetch_assoc()) {

                    imprimirTabla($rows, $us, $rol, $carnet);
                }
            }
        }
        function imprimirTabla($row, $us, $rol, $carnet)
        {
            $Idart = $row["idSArt"];
            echo "<tr>";
            echo "<td>" . $row["idSArt"] .      "</td> ";
            echo "<td>" . $row["nombreArt"] .      "</td> ";
            echo "<td>" . $row["descripcion"] .      "</td> ";
            echo "<td>" . $row["precio"] .      "</td> ";
            echo "<td>" . $row["fechaSolicitud"] .      "</td> ";
            echo "<td>" . $row["carnetUs"] .      "</td> ";
            echo "<td>" . "<a href='AcepORech.php?AproORech=1&Us=$us&Rol=$rol&carnet=$carnet&Idart=$Idart" .
                "'>Aceptar</a>" .   "</td>";
            echo "<td>" . "<a href='AcepORech.php?AproORech=0&Us=$us&Rol=$rol&carnet=$carnet&Idart=$Idart" .
                "'>Rechazar</a>" .   "</td>";
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