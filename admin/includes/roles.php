<?php
	// ARCHIVO
	$pagweb = basename($_SERVER['PHP_SELF']);
	$paginaext = explode(".", $pagweb);
	$pagina_actual = $paginaext[0];

	// COMPROBAR POR PÁGINAS SI PUEDE VERLA EL ROL
	switch ($pagina_actual) {
		case 'operadores':
		case 'actualizar-operador':
		case 'crear-operador':
		case 'usuarios':
		case 'crear-usuario':
		case 'actualizar-usuario':
		case 'roles':
		case 'actualizar-rol':
		case 'administrar-puertas':
		case 'puertas':
			// NO PUEDE USUARIOS
			/* if($_SESSION['rol_user'] == 2 || $_SESSION['rol_user'] == "" || is_null($_SESSION['rol_user'])){
				header("location:../index.php");
				exit();
			} */
			break;



		case 'lockers':
		case 'crear-locker':
		case 'actualizar-locker':
		case 'controladores':
		case 'crear-controlador':
		case 'actualizar-controlador':
		case 'crear-puerta':
		case 'actualizar-puerta':
			// NO PUEDE ADMIN (no keypoint) / USUARIOS
			/* if($_SESSION['id_operador'] != 0 || $_SESSION['rol_user'] == "" || is_null($_SESSION['rol_user'])){
				header("location:../index.php");
				exit();
			} */
			break;
	}
?>