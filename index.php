<?php
      include_once 'php/main.php';
 ?>
 <html lang="pt">
<!--
    João Víctor Bolsson Marques
    acesse o blog: https://joaobolsson.wordpress.com/
    sua visita é muito importante
    Obrigado!
-->
 <head>
   <!-- estilo dos modais -->
   <style>
   .modal-header, h4, .close {
       background-color: rgba(44, 62, 80, 1);
       color:white !important;
       text-align: center;
       font-size: 30px;
   }
   .modal-footer {
       background-color: #f9f9f9;
   }
   </style>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
     <link href="css/bootstrap.min.css" rel="stylesheet">

<!-- barra principal-->
     <link rel="stylesheet" href="css/style.css">

       <!-- SCRIPTS PARA OS MODAIS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

     <script type="text/javascript">
     var map;
     var myOptions;
     //variaveis para pesquisa
     var input;
     var autocomplete;
     var infowindow;
     var marker;
     var place;
     var address = '';
     var radioButton;

     var array_icone_local = "<?php echo $string_array_icone_local?>".split("|");
     var array_coordenadas = "<?php echo $string_array_coordenadas?>".split("|");
     var array_id_local = "<?php echo $string_array_id_local?>".split("|");
     var array_descricao = "<?php echo $string_array_descricao?>".split("|");

     var array_marker = new Array();
     var array_info_window = new Array();
     var array_posicao = new Array();
     var array_icone = new Array();

     //estilo do mapa
     var main_color = '#18bc9c',
       saturation_value= -20,
       brightness_value= 5;
     //we define here the style of the map
     var style= [
       {
         //set saturation for the labels on the map
         elementType: "labels",
         stylers: [
           {saturation: saturation_value}
         ]
       },
         {	//poi stands for point of interest - don't show these lables on the map
         featureType: "poi",
         elementType: "labels",
         stylers: [
           {visibility: "off"}
         ]
       },
       {
         //don't show highways lables on the map
             featureType: 'road.highway',
             elementType: 'labels',
             stylers: [
                 {visibility: "off"}
             ]
         },
       {
         //don't show local road lables on the map
         featureType: "road.local",
         elementType: "labels.icon",
         stylers: [
           {visibility: "off"}
         ]
       },
       {
         //don't show arterial road lables on the map
         featureType: "road.arterial",
         elementType: "labels.icon",
         stylers: [
           {visibility: "off"}
         ]
       },
       {
         //don't show road lables on the map
         featureType: "road",
         elementType: "geometry.stroke",
         stylers: [
           {visibility: "off"}
         ]
       },
       //style different elements on the map
       {
         featureType: "transit",
         elementType: "geometry.fill",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]
       },
       {
         featureType: "poi",
         elementType: "geometry.fill",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]
       },
       {
         featureType: "poi.government",
         elementType: "geometry.fill",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]
       },
       {
         featureType: "poi.sport_complex",
         elementType: "geometry.fill",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]
       },
       {
         featureType: "poi.attraction",
         elementType: "geometry.fill",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]
       },
       {
         featureType: "poi.business",
         elementType: "geometry.fill",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]
       },
       {
         featureType: "transit",
         elementType: "geometry.fill",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]
       },
       {
         featureType: "transit.station",
         elementType: "geometry.fill",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]
       },
       {
         featureType: "landscape",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]

       },
       {
         featureType: "road",
         elementType: "geometry.fill",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]
       },
       {
         featureType: "road.highway",
         elementType: "geometry.fill",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]
       },
       {
         featureType: "water",
         elementType: "geometry",
         stylers: [
           { hue: main_color },
           { visibility: "on" },
           { lightness: brightness_value },
           { saturation: saturation_value }
         ]
       }
     ];
       function success(position) {
                   var s = document.querySelector('#status');
                   if (s.className == 'success') {
                       return;
                   }
                   s.innerHTML = "";
                   s.className = 'success';
                   var mapcanvas = document.createElement('div');
                       mapcanvas.id = 'mapcanvas';
                       mapcanvas.style.height = '90%';
                       mapcanvas.style.width = '100%';

                   document.querySelector('body').appendChild(mapcanvas);

                   var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                   //para cadastrar um local
                   document.getElementById("localizacao").value = latlng;
                   myOptions = {
                       zoom: 15,
                       center: latlng,
                       mapTypeControl: false,
                       styles: style,
                       mapTypeId: google.maps.MapTypeId.ROADMAP
                   };
                   map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
                   //posição 0 é sempre a posição do usuário
                   var voce = new google.maps.Marker({
                       //latide e longitude (seta no mapa)
                       position: latlng,
                       map: map,
                       icon: 'imagens/voce.png',
                       //título que aparece quando o mouse passa por cima do icone
                       title:"Você está aqui!"
                   });
                   var info_window_voce = new google.maps.InfoWindow({
                      content:"<b>Você está aqui</b><br><br>"
                      });
                    google.maps.event.addListener(voce, 'click', function() {
                      info_window_voce.open(map, voce)
                    });
                   for(i=0;i<array_coordenadas.length;i++){
                     //array_coordenadas precisa ser quebrada em lat e long para poder ser convertida em uma variavel posicao
                     var array_aux = array_coordenadas[i].split(",");
                     //array_aux contém as coordenadas de todos os locais
                     array_posicao[i] = new google.maps.LatLng(array_aux[0], array_aux[1]);
                     array_icone[i] = getIcone(array_icone_local[i]);
                     array_marker[i] = new google.maps.Marker({
                         //latide e longitude (seta no mapa)
                         position: array_posicao[i],
                         map: map,
                         icon: array_icone[i],
                         animation: google.maps.Animation.DROP
                     });
                     criaInfoWindow(i, array_marker[i]);
                   } //for
                   //inicializa função de pesquisa de local
                   pesquisaLocal();
               }
               function pesquisaLocal(){
                 //PESQUISA
                 input = /** @type {!HTMLInputElement} */(
                     document.getElementById('pac-input'));
                 autocomplete = new google.maps.places.Autocomplete(input);
                 autocomplete.bindTo('bounds', map);
                 infowindow = new google.maps.InfoWindow();
                 marker = new google.maps.Marker({
                   map: map,
                   anchorPoint: new google.maps.Point(0, -29)
                 });
                 autocomplete.addListener('place_changed', function() {
                   infowindow.close();
                   marker.setVisible(false);
                   place = autocomplete.getPlace();

                   // If the place has a geometry, then present it on a map.
                   if (place.geometry.viewport) {
                     map.fitBounds(place.geometry.viewport);
                   } else {
                     map.setCenter(place.geometry.location);
                     map.setZoom(15);  // Coloca o zoom no mapa
                   }
                   marker.setIcon(/** @type {google.maps.Icon} */({
                     url: place.icon,
                     size: new google.maps.Size(71, 71),
                     origin: new google.maps.Point(0, 0),
                     anchor: new google.maps.Point(17, 34),
                     scaledSize: new google.maps.Size(35, 35)
                   }));
                   marker.setPosition(place.geometry.location);
                   marker.setVisible(true);
                   if (place.address_components) {
                     address = [
                       (place.address_components[0] && place.address_components[0].short_name || ''),
                       (place.address_components[1] && place.address_components[1].short_name || ''),
                       (place.address_components[2] && place.address_components[2].short_name || '')
                     ].join(' ');
                   }

                   infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                   infowindow.open(map, marker);
                 });
                 // Sets a listener on a radio button to change the filter type on Places
                 // Autocomplete.
                 setupClickListener('changetype-all', []);
                 // TERMINO PESQUISA
               }
               //função usada para pesquisa de local
               function setupClickListener(id, types) {
                 radioButton = document.getElementById(id);
                 radioButton.addEventListener('click', function() {
                   autocomplete.setTypes(types);
                 });
               }
               function criaInfoWindow(i, marker){
                 var info_window = new google.maps.InfoWindow({
                   content:"<h6>"+array_icone_local[i].toUpperCase()+"</h6><h6>"+array_descricao[i]+"</h6>",
                   maxwidth: 400
                    });
                  google.maps.event.addListener(marker, 'click', function() {
                    info_window.open(map, marker)
                  });
               }
               function placeMarker(location) {
                   var marker = new google.maps.Marker({
                     position: location,
                     map: map,
                   });
                   var infowindow = new google.maps.InfoWindow({
                     content: 'Latitude: ' + location.lat() +
                     '<br>Longitude: ' + location.lng()
                   });
                   infowindow.open(map,marker);
                }
               function getIcone(icone_local){
                 var icone = '';
                 if(icone_local == "luz"){
                    icone = 'imagens/lampada.gif';
                 }if(icone_local == "agua"){
                    icone = 'imagens/agua.png';
                 }if(icone_local == "wifi"){
                    icone = 'imagens/semaforo.png';
                 }
                 return icone;
               }
               function error(msg) {
                 var s = document.querySelector('#status');
                     s.innerHTML = typeof msg == 'string' ? msg : "falhou";
                     s.className = 'fail';
               }
               if (navigator.geolocation) {
                 navigator.geolocation.getCurrentPosition(success, error);
               } else {
                 error('Seu navegador não suporta <b style="color:black;background-color:#ffff66">Geolocalização</b>!');
               }
     </script>
     <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=places&sensor=true"></script>

     </script>
     <title>Mapa | JoaoBolsson</title>

 </head>

 <body>
     <main class="cd-main-content">


     </main> <!-- .cd-main-content -->
     <header class="cd-main-header">
       <a class="navbar-brand" href="index.php">JoaoBolsson</a>
      <span id="status">Por favor, aguarde...</span>
   		<div id="search" class="cd-search is-hidden">
   				<input id="pac-input" type="text" placeholder="Pesquisa por Local...">
          <input type="hidden" name="type" id="changetype-all" checked="checked">
   		</div> <!-- cd-search -->

   		<a href="#0" class="cd-nav-trigger">Menu<span></span></a>

   		<nav class="cd-nav">
   			<ul class="cd-top-nav">
          <li>
           <a href="#" id="myBtnLocal"><i class="glyphicon glyphicon-map-marker"></i>Novo Local</a>
          </li>
   			</ul>
   		</nav>
   	</header> <!-- .cd-main-header -->
    <!-- MODA, PARA NOVO LOCAL -->
    <div class="modal fade" id="local" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <form action="php/novolocal.php" method="post">
        <div class="modal-content">
          <div class="modal-header" style="padding:35px 50px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4><span class="glyphicon glyphicon-lock"></span> Novo Local</h4>
          </div>
          <div class="modal-body" style="padding:40px 50px;">
              <div class="form-group">
                <label for="usrname"><span class="glyphicon glyphicon-map-marker"></span> Localização</label>
                <input class="form-control" id="localizacao" type="text" name="localizacao" value="" required>
              </div>
              <div class="form-group">
                <label for="usrname"><span class="glyphicon glyphicon-pencil"></span> Descrição</label>
                <textarea class="form-control" type="text" rows="4" name="descricao" maxlength="250" value="" placeholder="Descrição"></textarea>
              </div>
              <!-- SENHA -->
              <div class="form-group">
                <label for="icone"><span class="glyphicon glyphicon-eye-open"></span> Ícone</label>
                <select class="form-control" name="icone" required>
                  <!-- aqui php para preencher a lista de locais conforme o banco-->
                  <option value="luz" selected>Iluminação</option>
                  <option value="agua">Água</option>
                  <option value="wifi">Wi-Fi Aberto</option>
                </select>
              </div>
          </div>
          <div class="modal-footer">
            <table class="table">
              <tr>
                <td class="col-md-2"><button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button></td>
                <td><button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span>Cadastrar</button></td>
              </tr>
            </table>
          </div>
        </div>
        </form>
      </div>
    </div>


   <script src="js/jquery.menu-aim.js"></script>
   <!--  script para abrir os modais (precisa ficar aqui)-->

   <script>
   $(document).ready(function(){
       $("#myBtnLocal").click(function(){
           $("#local").modal();
       });
   });
   </script>
</body></html>
