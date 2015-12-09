<?php

    $localizacao = $_POST["localizacao"];
    $descricao = $_POST["descricao"];
    $icone = $_POST["icone"];
    include_once 'conexao.php';

    $tamanho_array= strlen($localizacao) - 1;
    $array_localizacao = $localizacao.split('|');
    $localizacao = "";
    //retira os parenteses das coordenadas para poder serem colocadas no mapa
    for($i = 0; $i <= $tamanho_array; $i++){
        if($array_localizacao[$i] == "(" || $array_localizacao[$i] == ")"){
          $array_localizacao[$i] = " ";
        }
        $localizacao = $localizacao . "" . $array_localizacao[$i];
    }
    $localizacao = utf8_decode($localizacao);
    mysql_query("INSERT INTO locais VALUES(NULL, '$localizacao', '$descricao', '$icone')", $conexao);
    mysql_close();
    header("Location: ../index.php");
 ?>
