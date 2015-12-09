<?php
	$servidor = "localhost";
	$usuario = "root";
	$senha = "91238176joaovictor";
	$banco = "maps";

	$conexao = mysql_connect($servidor, $usuario, $senha) or die(mysql_error());

	mysql_select_db($banco);
?>
