   // In the following example, markers appear when the user clicks on the map.
    // Each marker is labeled with a single alphabetical character.
   
   /***************COnsumer Insights Map1************************************/
var $key = 'AIzaSyAZxHcXXwPR5uppAfMD2xSQAKJ56UUQP8I';
    var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var labelIndex = 0;
    var image1 = 'assets/images/icons/circle1.png';
    var image2 = 'assets/images/icons/circle2.png';
    var image3 = 'assets/images/icons/circle3.png';
    
      
        /* Consume Insight Google Map*/
          if($('#map_div').length){
            google.charts.load('current', {
              'packages': ['map'],
              // Note: you will need to get a mapsApiKey for your project.
              // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
              'mapsApiKey': $key
            });
            google.charts.setOnLoadCallback(drawMaps);



            function drawMaps () {
              var data = new google.visualization.DataTable();
              data.addColumn('string', 'Address');
              data.addColumn('string', 'Location');
              data.addColumn('string', 'Marker')


              var url = 'assets/images/icons/';

              var options = {
                zoomLevel: 6,
                showTooltip: false,
                showInfoWindow: false,
                

                mapType: 'styledMap',
                mapTypeIds: ['styledMap'],
                maps: {
                  // Your custom mapTypeId holding custom map styles.
                  styledMap: {
                    name: '', // This name will be displayed in the map type control.
                    styles: [
                      {featureType: 'poi.attraction',
                       stylers: [{color: '#fce8b2'}]
                      },
                      {featureType: 'road.highway',
                       stylers: [{hue: '#8B0000'}, {saturation: -50}]
                      },
                      {featureType: 'road.highway',
                       elementType: 'labels.icon',
                       stylers: [{hue: '#8B0000'}, {saturation: 100}, {lightness: 50}]
                      },
                      {featureType: 'landscape',
                       stylers: [{hue: '#fff'}, {saturation: 10}, {lightness: -22}]
                      }
                ]}},
                

                useMapTypeControl: false,
                icons: {
                  blue: {
                    normal:   url + 'circle1.png',
                    selected: url + 'circle1.png',
                    
                  },
                  green: {
                    normal:   url + 'circle3.png',
                    selected: url + 'circle3.png',
                   
                  },
                  pink: {
                    normal:   url + 'circle2.png',
                    selected: url + 'circle2.png',
                   
                  }
                  
                }
              };
              var map = new google.visualization.Map(document.getElementById('map_div'));
              map.draw(data, options);

           

              
              var location1 = { lat: 23.8859, lng: 45.0792 };
              var location2 = { lat: 24.5247, lng: 39.5692 };
              var location3 = { lat: 25.0846, lng: 48.0396 };
              var location4 = { lat: 21.3891, lng: 39.8579 };
              var location5 = { lat: 19.3370, lng: 45.9040 };
              var location6 = { lat: 19.7069, lng: 53.9623 };
              var location7 = { lat: 21.8792, lng: 49.7141 };
              var location8 = { lat: 21.9878, lng: 50.9446 };
              var location9 = { lat: 20.1472, lng: 44.8505 };
              var location10 = { lat: 19.1071, lng: 50.1112 };

              var map = new google.maps.Map(document.getElementById('map_div'), {
                zoom: 6,
                center: location1
              });
              addMarker(location2, map,image1,'242');
              addMarker(location3, map,image2,'43');
              addMarker(location4, map,image3,'72');
              addMarker(location5, map,image1,'55');
              addMarker(location6, map,image2,'12');
              addMarker(location7, map,image3,'56');
              addMarker(location8, map,image1,'78');
              addMarker(location9, map,image2,'98');
               addMarker(location10, map,image3,'99');
            // Adds a marker to the map.
            function addMarker(location, map ,image,labelss) {
              // Add the marker at the clicked location, and add the next-available label
              // from the array of alphabetical characters.
              var marker = new google.maps.Marker({
                position: location,
                label: labelss,
                icon: image,
                map: map
              });
            }
            //
            }
          }
               

/*********************8consumer insights map2 ends here************************/




/*************************Comsumer insights map2 ******************************/

  


    var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var labelIndex = 0;
    var image4 = 'assets/images/icons/dot1.png';
    var image5 = 'assets/images/icons/dot2.png';
    var image6 = 'assets/images/icons/dot3.png';
    var image7 = 'assets/images/icons/circle.png';
    var image8 = 'assets/images/icons/markerers.png';
    



    
      if($('#map_div_round').length){
            google.charts.load('current', {
              'packages': ['map'],
              // Note: you will need to get a mapsApiKey for your project.
              // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
              'mapsApiKey': $key            });
            google.charts.setOnLoadCallback(drawMaps);



            function drawMaps () {
              var data = new google.visualization.DataTable();
              data.addColumn('string', 'Address');
              data.addColumn('string', 'Location');
              data.addColumn('string', 'Marker')


              var url = 'assets/images/icons/';

              var options = {
                zoomLevel: 6,
                showTooltip: false,
                showInfoWindow: false
                

               /* mapType: 'styledMap',
                mapTypeIds: ['styledMap'],
                maps: {
                  // Your custom mapTypeId holding custom map styles.
                  styledMap: {
                    name: '', // This name will be displayed in the map type control.
                    styles: [
                      {featureType: 'poi.attraction',
                       stylers: [{color: '#fce8b2'}]
                      },
                      {featureType: 'road.highway',
                       stylers: [{hue: '#8B0000'}, {saturation: -50}]
                      },
                      {featureType: 'road.highway',
                       elementType: 'labels.icon',
                       stylers: [{hue: '#8B0000'}, {saturation: 100}, {lightness: 50}]
                      },
                      {featureType: 'landscape',
                       stylers: [{hue: '#fff'}, {saturation: 10}, {lightness: -22}]
                      }
                ]}},
                

                useMapTypeControl: false,
                icons: {
                  blue: {
                    normal:   url + 'circle1.png',
                    selected: url + 'circle1.png',
                    
                  },
                  green: {
                    normal:   url + 'circle3.png',
                    selected: url + 'circle3.png',
                   
                  },
                  pink: {
                    normal:   url + 'circle2.png',
                    selected: url + 'circle2.png',
                   
                  }
                  
                }*/
              };
              var map = new google.visualization.Map(document.getElementById('map_div_round'));
              map.draw(data, options);

           

              
             var locatio1 = { lat: 23.8859, lng: 45.0792 };
              var locatio2 = { lat: 25.8967, lng: 45.3557 };
              var locatio3 = { lat: 25.5637, lng: 47.1606 };
              var locatio4 = { lat: 23.5252, lng: 46.8447 };
              var locatio5 = { lat: 26.3099, lng: 44.8318 };
              var locatio6 = { lat: 24.7136, lng: 46.6753 };
              var locatio7 = { lat: 22.1494, lng: 47.1362 };
              var locatio8 = { lat: 24.1455, lng: 47.3119 };
              var locatio9 = { lat: 25.6668, lng: 46.3697 };
              var locatio10 = { lat: 26.3816, lng: 47.3242 };
              var locatio11 = { lat: 24.5167, lng: 44.4182 };

              var map = new google.maps.Map(document.getElementById('map_div_round'), {
                zoom: 6,
                center: locatio1
              });
              addMarker(locatio1, map,image4,'');
              addMarker(locatio2, map,image4,'');
              addMarker(locatio3, map,image5,'');
              addMarker(locatio4, map,image6,'');
              addMarker(locatio5, map,image6,'');
              addMarker(locatio6, map,image8,'');
              addMarker(locatio7, map,image7,'');
              addMarker(locatio8, map,image4,'');
              addMarker(locatio9, map,image5,'');
               addMarker(locatio10, map,image6,'');
            // Adds a marker to the map.
            function addMarker(location, map ,image,labelss) {
              // Add the marker at the clicked location, and add the next-available label
              // from the array of alphabetical characters.
              var marker = new google.maps.Marker({
                position: location,
                label: labelss,
                icon: image,
                map: map
              });
            }
            //
            }
          }







/*********************8comsumer insights map 2 ends here  *******************/



/******************************Listing page map 1 *****************************/



 if($('#map_div_mylocations').length){
            google.charts.load('current', {
              'packages': ['map'],
              'mapsApiKey': $key
            });
            google.charts.setOnLoadCallback(drawMaping);

            function drawMaping () {
              var data = new google.visualization.DataTable();
              data.addColumn('string', 'Address');
              data.addColumn('string', 'Location');
              data.addColumn('string', 'Marker');
              data.addRows([
                ['Medina Saudi Arabia', 'Medina',   'blue' ],
                ['khurais, Saudi Arabia',      "<div class='map_tooltip'><img src='assets/images/tooltip_img.jpg' class='img-fluid'><h5>Pizza Hut</h5><p>Text Here</p><p>4 <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-secondary'></i> (666)</p><div class='w-100 my-1 font-14'><span class='w-75'>Total Number of reviews</span> <span class='w-25'>25</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Number of tickets</span> <span class='w-25  text-danger'>5</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Overdue reviews</span> <span class='w-25  text-danger'>10</span></div><div class=;'w-100 my-1 font-14'><span class='w-75'>Countdown to post expiry</span> <span class='w-25 text-primary'>25/06/2019</span></div></div>",   'green'],
                ['Mecca Saudi Arabia, Saudi Arabia',      'Mecca',   'green'],          
                ['Oroug Bani Maradh Wildlife Sanctuary, Saudi Arabia',"<div class='map_tooltip'><img src='assets/images/tooltip_img.jpg' class='img-fluid'><h5>Pizza Hut</h5><p>Text Here</p><p>4 <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-secondary'></i> (666)</p><div class='w-100 my-1 font-14'><span class='w-75'>Total Number of reviews</span> <span class='w-25'>25</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Number of tickets</span> <span class='w-25  text-danger'>5</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Overdue reviews</span> <span class='w-25  text-danger'>10</span></div><div class=;'w-100 my-1 font-14'><span class='w-75'>Countdown to post expiry</span> <span class='w-25 text-primary'>25/06/2019</span></div></div>",'green'],
                ['Al Aflaj Saudi Arabia, Saudi Arabia',      "<div class='map_tooltip'><img src='assets/images/tooltip_img.jpg' class='img-fluid'><h5>Pizza Hut</h5><p>Text Here</p><p>4 <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-secondary'></i> (666)</p><div class='w-100 my-1 font-14'><span class='w-75'>Total Number of reviews</span> <span class='w-25'>25</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Number of tickets</span> <span class='w-25  text-danger'>5</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Overdue reviews</span> <span class='w-25  text-danger'>10</span></div><div class=;'w-100 my-1 font-14'><span class='w-75'>Countdown to post expiry</span> <span class='w-25 text-primary'>25/06/2019</span></div></div>",   'green'],
                ['Ash Shalfa Saudi Arabia, Saudi Arabia',      "<div class='map_tooltip'><img src='assets/images/tooltip_img.jpg' class='img-fluid'><h5>Pizza Hut</h5><p>Text Here</p><p>4 <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-secondary'></i> (666)</p><div class='w-100 my-1 font-14'><span class='w-75'>Total Number of reviews</span> <span class='w-25'>25</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Number of tickets</span> <span class='w-25  text-danger'>5</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Overdue reviews</span> <span class='w-25  text-danger'>10</span></div><div class=;'w-100 my-1 font-14'><span class='w-75'>Countdown to post expiry</span> <span class='w-25 text-primary'>25/06/2019</span></div></div>",   'green'],
                ['Al-Obailah Saudi Arabia, Saudi Arabia',      "<div class='map_tooltip'><img src='assets/images/tooltip_img.jpg' class='img-fluid'><h5>Pizza Hut</h5><p>Text Here</p><p>4 <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-secondary'></i> (666)</p><div class='w-100 my-1 font-14'><span class='w-75'>Total Number of reviews</span> <span class='w-25'>25</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Number of tickets</span> <span class='w-25  text-danger'>5</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Overdue reviews</span> <span class='w-25  text-danger'>10</span></div><div class=;'w-100 my-1 font-14'><span class='w-75'>Countdown to post expiry</span> <span class='w-25 text-primary'>25/06/2019</span></div></div>",   'green']            
              ]);
              var url = 'assets/images/icons/';

              var options = {
                zoomLevel: 6,
                showTooltip: false,
                showInfoWindow: true,
                

                mapType: 'styledMap',
                mapTypeIds: ['styledMap'],
                maps: {
                  // Your custom mapTypeId holding custom map styles.
                  styledMap: {
                    name: '', // This name will be displayed in the map type control.
                    styles: [
                      {featureType: 'poi.attraction',
                       stylers: [{color: '#fce8b2'}]
                      },
                      {featureType: 'road.highway',
                       stylers: [{hue: '#0277bd'}, {saturation: -50}]
                      },
                      {featureType: 'road.highway',
                       elementType: 'labels.icon',
                       stylers: [{hue: '#000'}, {saturation: 100}, {lightness: 50}]
                      },
                      {featureType: 'landscape',
                       stylers: [{hue: '#259b24'}, {saturation: 10}, {lightness: -22}]
                      }
                ]}},
                

                useMapTypeControl: false,
                icons: {
                  blue: {
                    normal:   url + 'map_location_small.png',
                    selected: url + 'map_location_small.png'
                  },
                  green: {
                    normal:   url + 'map_location_small.png',
                    selected: url + 'map_location_small.png'
                  },
                  pink: {
                    normal:   url + 'map_location_small.png',
                    selected: url + 'map_location_small.png'
                  }
                }
              };
              var map4 = new google.visualization.Map(document.getElementById('map_div_mylocations'));
              map4.draw(data, options);
            }
         }




/*******************************Listing Page Map 1 *******************************/

/*****************************Home page Map**************************************/


 if($('#map_div_home_page').length){
            google.charts.load('current', {
              'packages': ['map'],
              'mapsApiKey': $key
            });
            google.charts.setOnLoadCallback(drawMaping);

            function drawMaping () {
              var data = new google.visualization.DataTable();
              data.addColumn('string', 'Address');
              data.addColumn('string', 'Location');
              data.addColumn('string', 'Marker');
              data.addRows([
                ['Medina Saudi Arabia', 'Medina',   'blue' ],
                ['khurais, Saudi Arabia',      "<div class='map_tooltip'><img src='assets/images/tooltip_img.jpg' class='img-fluid'><h5>Pizza Hut</h5><p>Text Here</p><p>4 <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-secondary'></i> (666)</p><div class='w-100 my-1 font-14'><span class='w-75'>Total Number of reviews</span> <span class='w-25'>25</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Number of tickets</span> <span class='w-25  text-danger'>5</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Overdue reviews</span> <span class='w-25  text-danger'>10</span></div><div class=;'w-100 my-1 font-14'><span class='w-75'>Countdown to post expiry</span> <span class='w-25 text-primary'>25/06/2019</span></div></div>",   'green'],
                ['Mecca Saudi Arabia, Saudi Arabia',      'Mecca',   'green'],          
                ['Oroug Bani Maradh Wildlife Sanctuary, Saudi Arabia',"<div class='map_tooltip'><img src='assets/images/tooltip_img.jpg' class='img-fluid'><h5>Pizza Hut</h5><p>Text Here</p><p>4 <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-secondary'></i> (666)</p><div class='w-100 my-1 font-14'><span class='w-75'>Total Number of reviews</span> <span class='w-25'>25</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Number of tickets</span> <span class='w-25  text-danger'>5</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Overdue reviews</span> <span class='w-25  text-danger'>10</span></div><div class=;'w-100 my-1 font-14'><span class='w-75'>Countdown to post expiry</span> <span class='w-25 text-primary'>25/06/2019</span></div></div>",'green'],
                ['Al Aflaj Saudi Arabia, Saudi Arabia',      "<div class='map_tooltip'><img src='assets/images/tooltip_img.jpg' class='img-fluid'><h5>Pizza Hut</h5><p>Text Here</p><p>4 <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-secondary'></i> (666)</p><div class='w-100 my-1 font-14'><span class='w-75'>Total Number of reviews</span> <span class='w-25'>25</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Number of tickets</span> <span class='w-25  text-danger'>5</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Overdue reviews</span> <span class='w-25  text-danger'>10</span></div><div class=;'w-100 my-1 font-14'><span class='w-75'>Countdown to post expiry</span> <span class='w-25 text-primary'>25/06/2019</span></div></div>",   'green'],
                ['Ash Shalfa Saudi Arabia, Saudi Arabia',      "<div class='map_tooltip'><img src='assets/images/tooltip_img.jpg' class='img-fluid'><h5>Pizza Hut</h5><p>Text Here</p><p>4 <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-secondary'></i> (666)</p><div class='w-100 my-1 font-14'><span class='w-75'>Total Number of reviews</span> <span class='w-25'>25</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Number of tickets</span> <span class='w-25  text-danger'>5</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Overdue reviews</span> <span class='w-25  text-danger'>10</span></div><div class=;'w-100 my-1 font-14'><span class='w-75'>Countdown to post expiry</span> <span class='w-25 text-primary'>25/06/2019</span></div></div>",   'green'],
                ['Al-Obailah Saudi Arabia, Saudi Arabia',      "<div class='map_tooltip'><img src='assets/images/tooltip_img.jpg' class='img-fluid'><h5>Pizza Hut</h5><p>Text Here</p><p>4 <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-warning'></i> <i class='fa fa-star font-14 text-secondary'></i> (666)</p><div class='w-100 my-1 font-14'><span class='w-75'>Total Number of reviews</span> <span class='w-25'>25</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Number of tickets</span> <span class='w-25  text-danger'>5</span></div><div class='w-100 my-1 font-14'><span class='w-75'>Overdue reviews</span> <span class='w-25  text-danger'>10</span></div><div class=;'w-100 my-1 font-14'><span class='w-75'>Countdown to post expiry</span> <span class='w-25 text-primary'>25/06/2019</span></div></div>",   'green']            
              ]);
              var url = 'assets/images/icons/';

              var options = {
                zoomLevel: 6,
                showTooltip: false,
                showInfoWindow: true,
                

                mapType: 'styledMap',
                mapTypeIds: ['styledMap'],
                maps: {
                  // Your custom mapTypeId holding custom map styles.
                  styledMap: {
                    name: '', // This name will be displayed in the map type control.
                    styles: [
                      {featureType: 'poi.attraction',
                       stylers: [{color: '#fce8b2'}]
                      },
                      {featureType: 'road.highway',
                       stylers: [{hue: '#0277bd'}, {saturation: -50}]
                      },
                      {featureType: 'road.highway',
                       elementType: 'labels.icon',
                       stylers: [{hue: '#000'}, {saturation: 100}, {lightness: 50}]
                      },
                      {featureType: 'landscape',
                       stylers: [{hue: '#259b24'}, {saturation: 10}, {lightness: -22}]
                      }
                ]}},
                

                useMapTypeControl: false,
                icons: {
                  blue: {
                    normal:   url + 'map_location_small.png',
                    selected: url + 'map_location_small.png'
                  },
                  green: {
                    normal:   url + 'map_location_small.png',
                    selected: url + 'map_location_small.png'
                  },
                  pink: {
                    normal:   url + 'map_location_small.png',
                    selected: url + 'map_location_small.png'
                  }
                }
              };
              var map4 = new google.visualization.Map(document.getElementById('map_div_home_page'));
              map4.draw(data, options);
            }
         }






/*********************************************************************************/