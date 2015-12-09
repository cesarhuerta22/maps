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



        }


        //
        //inicializa função de pesquisa de local
        pesquisaLocal();

        //irá criar uma InfoWindow para cada marcador adicionado ao mapa
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

        //cria uma InfoWindow para o usuário
        var info_window_voce = new google.maps.InfoWindow({
           content:"<b>Você está aqui</b><br><br>"
           });
         google.maps.event.addListener(voce, 'click', function() {
           info_window_voce.open(map, voce)
         });

         //cria um marcador personalizado para o usuário
         var voce = new google.maps.Marker({
             //latide e longitude (seta no mapa)
             position: latlng,
             map: map,
             icon: 'imagens/voce.png',
             //título que aparece quando o mouse passa por cima do icone
             title:"Você está aqui!"
         });
