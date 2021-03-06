<?php
//Acessing Database to retrieve Lat Lng Values
$servername = "localhost";
$username = "id5480653_humzasqldatabase";
$password = "humzarocks";
$dbname = "id5480653_sqlmaps";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//error_reporting(0);
$sql = "SELECT lat, lng FROM casalatlng";
$result = $conn->query($sql);
$lati = Array();
$lngi = Array();
$length;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $lati[] = $row["lat"];
	    $lngi[] = $row["lng"];
    }
   
} else {
  // Didn't get Var from Database
    echo "0 results";
}
$conn->close();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="casamarker.png" type="image/x-icon" />
    <title>Heatmaps</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      /* NAV BAR - CSS Properties */
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
      #floating-panel {
        background-color: #fff;
        border: 1px solid #999;
        left: 25%;
        padding: 5px;
        position: absolute;
        top: 10px;
        z-index: 5;
      }
      .btn-glass {
      flex-grow: 1;
      text-align: center;
      display: inline-block;
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      padding: 1em 2em;
      font-family: Lato;
      font-weight: 300;
      border: 1px dotted transparent;
      letter-spacing: 0.98pt;
      text-transform: uppercase;
      transition: background-position 2s cubic-bezier(0, 1, 0, 1), border-color 500ms, background-color 500ms;
      position: relative;
      background-attachment: fixed, scroll;
      background-size: 100vw 100vh, cover;
      background-position: center center, 0 0;
      background-image: repeating-linear-gradient(-45deg, rgba(255, 255, 255, 0) 8%, rgba(255, 255, 255, 0.075) 10%, rgba(255, 255, 255, 0.075) 14%, rgba(255, 255, 255, 0.15) 14%, rgba(255, 255, 255, 0.15) 15%, rgba(255, 255, 255, 0.075) 17%, rgba(255, 255, 255, 0) 30%, rgba(255, 255, 255, 0) 36%, rgba(255, 255, 255, 0.075) 40%, rgba(255, 255, 255, 0.15) 42%, rgba(255, 255, 255, 0) 43%, rgba(255, 255, 255, 0) 55%, rgba(255, 255, 255, 0.075) 60%, rgba(255, 255, 255, 0.075) 66%, rgba(255, 255, 255, 0.15) 66%, rgba(255, 255, 255, 0.075) 70%, rgba(255, 255, 255, 0) 75%, rgba(255, 255, 255, 0) 100%), radial-gradient(ellipse farthest-corner, transparent, rgba(0, 0, 0, 0.2) 110%);
    }
    .btn-glass:hover {
      background-position: -100vw 0, 0 0;
    }
    .btn-glass:active {
      background-position: -75vw 0, 0 0;
      border-style: solid;
    }
    .nav-light {
      background-color: white;
    }
    .nav-light .btn-glass {
      color: #585858;
      background-color: rgba(17, 17, 17, 0);
    }
    .nav-light .btn-glass:hover {
      color: rgba(255, 255, 255, 0.7);
      border-color: #000000;
      background-color: #111111;
    }
    .nav-light .btn-glass:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(17, 17, 17, 0.5);
    }
    .nav-light .btn-glass.btn-primary {
      color: #6ab1d1;
      background-color: rgba(42, 143, 189, 0);
    }
    .nav-light .btn-glass.btn-primary:hover {
      color: rgba(255, 255, 255, 0.7);
      border-color: #1c607e;
      background-color: #2A8FBD;
    }
    .nav-light .btn-glass.btn-primary:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(42, 143, 189, 0.5);
    }
    .nav-light .btn-glass.btn-success {
      color: #a5c75f;
      background-color: rgba(127, 175, 27, 0);
    }
    .nav-light .btn-glass.btn-success:hover {
      color: rgba(255, 255, 255, 0.7);
      border-color: #4f6d11;
      background-color: #7FAF1B;
    }
    .nav-light .btn-glass.btn-success:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(127, 175, 27, 0.5);
    }
    .nav-light .btn-glass.btn-warning {
      color: #fccd69;
      background-color: rgba(251, 184, 41, 0);
    }
    .nav-light .btn-glass.btn-warning:hover {
      color: rgba(255, 255, 255, 0.7);
      border-color: #d49104;
      background-color: #FBB829;
    }
    .nav-light .btn-glass.btn-warning:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(251, 184, 41, 0.5);
    }
    .nav-light .btn-glass.btn-danger {
      color: #f56558;
      background-color: rgba(240, 35, 17, 0);
    }
    .nav-light .btn-glass.btn-danger:hover {
      color: rgba(255, 255, 255, 0.7);
      border-color: #aa180b;
      background-color: #F02311;
    }
    .nav-light .btn-glass.btn-danger:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(240, 35, 17, 0.5);
    }
    .nav-light .btn-glass.btn-info {
      color: #98e9f0;
      background-color: rgba(108, 223, 234, 0);
    }
    .nav-light .btn-glass.btn-info:hover {
      color: rgba(255, 255, 255, 0.7);
      border-color: #29d0e0;
      background-color: #6CDFEA;
    }
    .nav-light .btn-glass.btn-info:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(108, 223, 234, 0.5);
    }
    .nav-dark {
      background-color: #444;
    }
    .nav-dark .btn-glass {
      color: rgba(255, 255, 255, 0.7);
      background-color: rgba(17, 17, 17, 0);
    }
    .nav-dark .btn-glass:hover {
      border-color: #000000;
      background-color: #111111;
    }
    .nav-dark .btn-glass:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(17, 17, 17, 0.5);
    }
    .nav-dark .btn-glass.btn-primary {
      color: rgba(255, 255, 255, 0.7);
      background-color: rgba(42, 143, 189, 0);
    }
    .nav-dark .btn-glass.btn-primary:hover {
      border-color: #1c607e;
      background-color: #2A8FBD;
    }
    .nav-dark .btn-glass.btn-primary:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(42, 143, 189, 0.5);
    }
    .nav-dark .btn-glass.btn-success {
      color: rgba(255, 255, 255, 0.7);
      background-color: rgba(127, 175, 27, 0);
    }
    .nav-dark .btn-glass.btn-success:hover {
      border-color: #4f6d11;
      background-color: #7FAF1B;
    }
    .nav-dark .btn-glass.btn-success:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(127, 175, 27, 0.5);
    }
    .nav-dark .btn-glass.btn-warning {
      color: rgba(255, 255, 255, 0.7);
      background-color: rgba(251, 184, 41, 0);
    }
    .nav-dark .btn-glass.btn-warning:hover {
      border-color: #d49104;
      background-color: #FBB829;
    }
    .nav-dark .btn-glass.btn-warning:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(251, 184, 41, 0.5);
    }
    .nav-dark .btn-glass.btn-danger {
      color: rgba(255, 255, 255, 0.7);
      background-color: rgba(240, 35, 17, 0);
    }
    .nav-dark .btn-glass.btn-danger:hover {
      border-color: #aa180b;
      background-color: #F02311;
    }
    .nav-dark .btn-glass.btn-danger:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(240, 35, 17, 0.5);
    }
    .nav-dark .btn-glass.btn-info {
      color: rgba(255, 255, 255, 0.7);
      background-color: rgba(108, 223, 234, 0);
    }
    .nav-dark .btn-glass.btn-info:hover {
      border-color: #29d0e0;
      background-color: #6CDFEA;
    }
    .nav-dark .btn-glass.btn-info:active {
      position: relative;
      z-index: 1;
      box-shadow: 0 0 1em 0.5ex rgba(108, 223, 234, 0.5);
    }
    nav.btn-bar {
      display: flex;
      justify-content: flex-end;
      flex-wrap: wrap;
    }
    :root {
      font-family: 'Open Sans', sans;
      font-size: 11pt;
      line-height: 1.6;
      min-height: 100vh;
      background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/49914/grit-fs8.png), radial-gradient(ellipse farthest-corner, #555, #999);
    }
   
    article {
      padding: 0;
      border: 2px solid transparent;
      border-radius: 2px;
      box-sizing: border-box;
      background-color: white;
      box-shadow: 0 1ex 1em rgba(0, 0, 0, 0.3);
    }
    code {
      font-family: monospace;
      display: inline-block;
      padding: 0.5ex 1ch 0.25ex 1ch;
      background-color: #ccc;
      border-radius: 1ex;
      margin: 0 0.5ch;
    }
    article + article {
      margin-top: 4em;
    }
    article section {
      margin: 2em;
    }
    article > section > h2 {
      font-family: 'Lato';
      font-weight: 800;
      font-size: 1.3em;
      margin-bottom: 0.8em;
    }
    article > section > p {
      margin-bottom: 1em;
      text-indent: 2ch;
    }
    article > section > p:first-child,
    article > section > h2 + p {
      text-indent: 0;
    }
        h1 {
            text-align: center;
            margin-bottom: 2;
            padding-bottom: 2;
        }
    </style>
  </head>

        <!-- Navigation Bar HTML-->
  <body>
    <div id="floating-panel" class= "btn-bar nav-light" >
      <button class="btn btn-glass btn-primary" onclick="toggleHeatmap()">Toggle Heatmap</button>
      <button class="btn btn-glass btn-success"onclick="changeGradient()">Change gradient</button>
      <button class="btn btn-glass btn-warning"onclick="changeRadius()">Change radius</button>
      <button class="btn btn-glass"onclick="changeOpacity()">Change opacity</button>
    </div>
    <div id="map"></div>
    <script>
      // This example requires the Visualization library. Include the libraries=visualization
      // parameter when you first load the API.
      //SETUP HEATMAP
      var map, heatmap;
      
      function initMap() {
        var haightAshbury = { lat: 43.6532, lng: -79.3832 };
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: haightAshbury,
          mapTypeId: 'satellite'
        });
        heatmap = new google.maps.visualization.HeatmapLayer({
          data: getPoints(),
          map: map
        });
      }
      //NAV BAR FUNCTIONS CODE
      function toggleHeatmap() {
        heatmap.setMap(heatmap.getMap() ? null : map);
      }
      function changeGradient() {
        var gradient = [
          'rgba(0, 255, 255, 0)',
          'rgba(0, 255, 255, 1)',
          'rgba(0, 191, 255, 1)',
          'rgba(0, 127, 255, 1)',
          'rgba(0, 63, 255, 1)',
          'rgba(0, 0, 255, 1)',
          'rgba(0, 0, 223, 1)',
          'rgba(0, 0, 191, 1)',
          'rgba(0, 0, 159, 1)',
          'rgba(0, 0, 127, 1)',
          'rgba(63, 0, 91, 1)',
          'rgba(127, 0, 63, 1)',
          'rgba(191, 0, 31, 1)',
          'rgba(255, 0, 0, 1)'
        ]
        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
      }
      function changeRadius() {
        heatmap.set('radius', heatmap.get('radius') ? null : 20);
      }
      function changeOpacity() {
        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
      }
    
    //Assign Database LAT LNG Values to Local VAR
	  var latitude = <?php echo json_encode($lati)?>;
      var longitude = <?php echo json_encode($lngi)?>;
      function getPoints() {
    //ADD POINT TO HEATMAP  
	  var dat = [];
	  
      for (var i=0; i < latitude.length; i++){
		  dat.push(new google.maps.LatLng(latitude[i], longitude[i]));
      console.log(latitude[i] , longitude[i]);
	    }      
        return dat;
      }
      
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoE_s6twEzo_weIsuubSG9fiUfiAfoXpc&libraries=visualization&callback=initMap">
    </script>
  </body>
</html>