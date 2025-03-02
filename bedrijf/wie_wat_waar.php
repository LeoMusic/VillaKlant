<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../includes/header.php';

// Haal de bedrijfsgegevens op
$sql = "SELECT id, bedrijfsnaam, straat, huisnummer, postcode, woonplaats, land FROM bedrijven WHERE id != 1";
$result = $conn->query($sql);

$bedrijven = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $bedrijven[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Wie Wat Waar</title>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxySiOV-nRnFVhYnV0lpurdCRq3DsNxgw&callback=initMap"></script>
    <script>
        function initMap() {
            var mapOptions = {
                zoom: 7,
                center: {lat: 52.1326, lng: 5.2913} // Centraal punt in Nederland
            };
            var map = new google.maps.Map(document.getElementById('map'), mapOptions);

            var bedrijven = <?php echo json_encode($bedrijven); ?>;
            bedrijven.forEach(function(bedrijf) {
                var geocoder = new google.maps.Geocoder();
                var address = bedrijf.straat + ' ' + bedrijf.huisnummer + ', ' + bedrijf.postcode + ' ' + bedrijf.woonplaats + ', ' + bedrijf.land;
                geocoder.geocode({'address': address}, function(results, status) {
                    if (status === 'OK') {
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            title: bedrijf.bedrijfsnaam
                        });

                        var infoWindow = new google.maps.InfoWindow({
                            content: '<a href="read_bedrijf.php?id=' + bedrijf.id + '">' + bedrijf.bedrijfsnaam + '</a>'
                        });

                        marker.addListener('click', function() {
                            infoWindow.open(map, marker);
                        });
                    } else {
                        console.error('Geocode was not successful for the following reason: ' + status);
                    }
                });
            });
        }

        function handleMapError() {
            console.error('Google Maps failed to load. Please check your API key and referer settings.');
        }
    </script>
</head>
<body>
    <h1>Wie Wat Waar</h1>
    <div id="map" style="height: 500px; width: 100%;"></div>
</body>
</html>

<?php include '../includes/footer.php'; ?>