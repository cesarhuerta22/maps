<?php
    include_once 'php/conexao.php';
    $query_coordenadas = mysql_query("select id_local, coordenadas_local, icone_local, descricao_local from locais", $conexao);
    mysql_close();
    $cont = 0;
    //array_coordenadas conterá as coordenadas sem os parenteses
    while ($lista_coordenadas = mysql_fetch_array($query_coordenadas)) {
        $array_coordenadas[$cont] = $lista_coordenadas["coordenadas_local"];
        $array_icone_local[$cont] = $lista_coordenadas["icone_local"];
        $array_id_local[$cont] = $lista_coordenadas["id_local"];
        $array_descricao[$cont] = $lista_coordenadas["descricao_local"];
        $cont++;
    }
    //arrays transformados em strings para serem quebrados denovo pelo javascript
    $string_array_id_local = implode("|", $array_id_local);
    $string_array_coordenadas = implode("|", $array_coordenadas);
    $string_array_icone_local = implode("|", $array_icone_local);
    $string_array_descricao = implode("|", $array_descricao);
 ?>
