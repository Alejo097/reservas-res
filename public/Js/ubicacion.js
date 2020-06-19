var zoom = 6;
var infoWindow;
var info;
var ico = 'https://image.flaticon.com/icons/png/128/181/181549.png';
var contenido = '<div>'+
'<h3>My position !</h3>'+
'<img src="'+ico+'" width="30px" height="30px"/>'+
'</div>';


function initMap() { 
    var benidorm = new google.maps.LatLng(39.9688757, -4.4304944);
    var map = new google.maps.Map(document.getElementById('map1'),{
        center: benidorm,
        zoom: zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    kmlLayer = new google.maps.KmlLayer( src, {
        suppressInfoWindows: true,
        preserveViewport: false,
        map: map
    });
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showMap, errorMap);
    }else{

        //geolocalizacion no disponible 
        errorMap(map.getCenter());    
    }
    function showMap(position){
        var pos = {
            lat: position.coords.latitude,
            lng:position.coords.longitude
        };
        var marker = new google.maps.Marker({
            position: {lat:pos.lat, lng:pos.lng},
            map: map,
            animation: google.maps.Animation.DROP,
            draggable: false 
        
        });
        info = new google.maps.InfoWindow();
        infoWindow = new google.maps.InfoWindow({
        content: contenido
        });
        kmlLayer.addListener('click', function(kmlEvent) { //kmlEvent, informacion sobre el Objeto kml
            var nombre = kmlEvent.featureData.name;
            var latLng = kmlEvent.latLng;
            var contenido = '<div style="text-aling:center"><strong><p>'+nombre+'</p></strong>'+latLng+'</div>'; 
            info.setOptions({
                content: contenido,
                //pixelOffset:kmlEvent.pixelOffset
                position: kmlEvent.latLng    
            })
            info.open(map); 
        });
        window.onload = function(){
            infoWindow.open(map, marker);
        }
        marker.addListener("click", function(){
            infoWindow.open(map, marker);
        });

        /*infoWindow.setPosition(pos);
        infoWindow.setContent(contenido);
        infoWindow.open(map);
        map.setCenter(pos);*/
    }
    function errorMap(pos){
        infoWindow.setPosicion(pos);
        infoWindow.setContent("Error");
        infoWindow.open(map);
    }
}