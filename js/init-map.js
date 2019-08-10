/**
 * Инициализация карт
 */
var map;
document.addEventListener("DOMContentLoaded", function(event) {	
	var minLat = in_vc_listing_map.points[0].lat,
		maxLat = in_vc_listing_map.points[0].lat,
		minLong = in_vc_listing_map.points[0].long,
		maxLong = in_vc_listing_map.points[0].long;
		
	for (var i=0; i< in_vc_listing_map.points.length; i++ ){
		if ( in_vc_listing_map.points[i].lat < minLat) minLat = in_vc_listing_map.points[0].lat;
		if ( in_vc_listing_map.points[i].lat > maxLat) maxLat = in_vc_listing_map.points[0].lat;
		if ( in_vc_listing_map.points[i].lat < minLong) minLong = in_vc_listing_map.points[0].long;
		if ( in_vc_listing_map.points[i].lat > maxLong ) maxLong = in_vc_listing_map.points[0].long;
	}
	
	var center = new google.maps.LatLng(
		minLat + (maxLat - minLat) / 2,
		minLong + (maxLong - minLong) / 2
	);

	var map = new google.maps.Map(document.getElementById( 'in-vc-listing-map' ), {
		zoom: 10,
		center: center,
		mapTypeId: 'terrain'
	});
	
	// Map markers
	for (var i=0; i< in_vc_listing_map.points.length; i++ ){
		var latLng = new google.maps.LatLng(in_vc_listing_map.points[i].lat,in_vc_listing_map.points[i].long);
		console.log(latLng);
		var marker = new google.maps.Marker({
			position: latLng,
			title: in_vc_listing_map.points[i].title,
			map: map
		});
	}
});

