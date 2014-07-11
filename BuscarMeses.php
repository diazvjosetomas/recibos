<?php session_start();
if (!isset($_SESSION['Usuario'])) {
	echo "<script>
			window.location = 'login.php';
		</script>
	";
}else{

$Anho = intval($_GET['a']);
$_SESSION['anho'] = $Anho;
include './conexion/conectMysql.php';
include 'funciones.php';
$Id_Trabajador = $_SESSION['IdTrabajador'];



$SQL = "SELECT mes FROM historicoquincena WHERE anio = '$Anho' and id_trabajador = '$Id_Trabajador'";

$ConsultaMeses = pg_query($SQL);



//Control de muestras de meses, evita que se me repitan los meses, y solo me muestre un solo nombre de mes!
$meses[1] = false;
$meses[2] = false;
$meses[3] = false;
$meses[4] = false;
$meses[5] = false;
$meses[6] = false;
$meses[7] = false;
$meses[8] = false;
$meses[9] = false;
$meses[10] = false;
$meses[11] = false;
$meses[12] = false;


$MesActual = date("m");

if (pg_num_rows($ConsultaMeses) > 0) {

		echo "<select id='idMeses' name='mes' onchange='BuscarQuincenas(this.value)'>";
		echo "<option value='null'>Selecciona un mes</option>";
		while ($row = pg_fetch_array($ConsultaMeses)) {
			if ($row['mes'] == $MesActual and (date("d") < 15 )) {
				//Evita mostrar la nomina a pesar de que ya este cargada antes de la primera quincena
			}else{
			if ($meses[$row['mes']] == false) {
			echo "<option value='".$row['mes']."'>".NombreMes($row['mes'])."</option>";
			$meses[$row['mes']] = true;
			}//Fin de la linea 48
		  }//Fin de la linea 45
		}
		echo "</select>";
	
}else{

	



	echo "<div class='alert alert-error'><b><div class='pull-left'><img class='img-responsive' src='./img/databaseError.png'></div>
	&nbsp;&nbsp;&nbsp;Lo sentimos!, la data buscada aun no se encuentra almacenada.
	  </b></div>";

	echo "<script> 

			$('#idQuincenas').hide();

	 </script>";
}

}
?>
