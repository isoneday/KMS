
// google map stuff
if (navigator.onLine) {
	document.writeln('<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>');
	// if (typeof google === 'object' && typeof google.maps === 'object') {
		document.writeln('<script type="text/javascript" src="assets/js/googlemap/gmap3.js"></script>');
		document.writeln('<script type="text/javascript" src="assets/js/googlemap/markerwithlabel.js"></script>');
		document.writeln('<script type="text/javascript" src="assets/js/googlemap/custom.js"></script>');
	// };
	document.writeln('<script type="text/javascript" src="https://www.google.com/jsapi"></script>');
	if (typeof google === 'object' && typeof google.load === 'object') {
		google.load('visualization', '1', {'packages': ['geochart']});
	}
}