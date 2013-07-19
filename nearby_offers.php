<?php include 'header.php'?>
<!DOCTYPE html>
<html>
<head>
<title>nearby offers</title>

<script type="text/javascript" src="http://j.maxmind.com/app/geoip.js"></script>
<style>

.heading_distance{
  overflow: hidden;
}
.heading_distance h3{
  float: left;
}
.heading_distance h5{
  float: right;
}
h6,h3,.heading_distance h5{
  padding-left: 10px;
}

</style>
</head>
<body>
<div id="mapContainer"></div> 

<script type="text/javascript">

        var lat = geoip_latitude();
        var lng = geoip_longitude();
        function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
          var R = 6371; // Radius of the earth in km
          var dLat = deg2rad(lat2-lat1);  // deg2rad below
          var dLon = deg2rad(lon2-lon1); 
          var a = 
          Math.sin(dLat/2) * Math.sin(dLat/2) +
          Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
          Math.sin(dLon/2) * Math.sin(dLon/2)
          ; 
          var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
          var d = R * c; // Distance in km
          return d;
        }

        function deg2rad(deg) {
          return deg * (Math.PI/180)
        }
        function get_offers(category){
            params = "lat="+lat+"&long="+lng;
            params+="&category="+category;
            $.ajax({
                  url: "nearby_places.php",
                  data: params,
                  dataType: "JSON",
                  success: function(data){
		    table = "";
                    for(i in data){
                      lat2 = data[i].places[0].geo_location[1];
                      lng2 = data[i].places[0].geo_location[0];
                      distance=getDistanceFromLatLonInKm(lat,lng,lat2,lng2)
                      distance = distance.toFixed(3); 
                      table += '<div class=""accordion" id="accordion2"" style="width: 100%;">  '
                      table += '<div class="accordion-group"><div class = "accordion-heading">'
                      table += '<div class = "heading_distance"><h3>'+data[i].merchant.name+"</h3><h5>" +distance + "</h5></div><h6>"+data[i].description+"</h6></div>"
                      table += '<div id="collapseOne" class="accordion-body collapse">  <div class="accordion-inner">'
                      table += '</div></div></div>'
                      $('.container-fluid').html(table);
                    }
                  }
                });

        }
        $(document).ready(function(){
            get_offers(false);
            $("#category").change(function(){
              get_offers($(this).val());
            });
        });
</script> 
  
</head>  
<body>  
    <select id="category" name="category">
        <option value="All places">All places</option>
        <option value="Eat & Drink">Eat & Drink</option>
        <option value="Fun & Arts">Fun & Arts</option>
        <option value="Shopping">Shopping</option>
        <option value="Services">Services</option>
  </select> 
   <div class="container-fluid"></div>
</body>  
</html> 

<?php include 'footer.php'?>
