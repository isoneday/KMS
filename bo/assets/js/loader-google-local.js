
// google map stuff
if (navigator.onLine) {
	//document.writeln('<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>');
	document.writeln('<script type="text/javascript" src="assets/js/googlemap/sensor-gmap.js"></script>');
	document.writeln('<script type="text/javascript" src="assets/js/googlemap/main.js"></script>');
		// if (typeof google === 'object' && typeof google.maps === 'object') {
		document.writeln('<script type="text/javascript" src="assets/js/googlemap/gmap3.js"></script>');
		document.writeln('<script type="text/javascript" src="assets/js/googlemap/markerwithlabel.js"></script>');
		document.writeln('<script type="text/javascript" src="assets/js/googlemap/custom.js"></script>');
	// };
	//document.writeln('<script type="text/javascript" src="https://www.google.com/jsapi"></script>');
	document.writeln('<script type="text/javascript" src="assets/js/googlemap/jsapi.js"></script>');
	document.writeln('<script type="text/javascript" src="assets/js/googlemap/geochart.js"></script>');
	document.writeln('<script type="text/javascript" src="assets/js/googlemap/geochart-visualization.js"></script>');
	/*if (typeof google === 'object' && typeof google.load === 'object') {
		google.load('visualization', '1', {'packages': ['geochart']});
	}*/
}