/*var latlong = {};
latlong["SK"] = {
	"latitude": 41.997682,
	"longitude": 21.428838
};
latlong["TE"] = {
	"latitude": 42.0069,
	"longitude": 20.9715
};*/


var mapData = [{}];
/*var mapData = [{
	//"code": "SK",
	"name": "Skopje",
	"latitude": 41.997682,
	"longitude": 21.428838,
	"value": 3,
	"color": "#eea638",
	"description": "Write here the project description.",
},  {
	//"code": "TE",
	"name": "Tetovo",
	"latitude": 42.0069,
	"longitude": 20.9715,
	"value": 2,
	"color": "#d8854f",
	"description": "Write here the project description.",
}];
*/

var map;
var minBulletSize = 10;
var maxBulletSize = 50;
var min = Infinity;
var max = -Infinity;

AmCharts.theme = AmCharts.themes.black;

// get min and max values
for (var i = 0; i < mapData.length; i++) {
	var value = mapData[i].value;
	if (value < min) {
		min = value;
	}
	if (value > max) {
		max = value;
	}
}

// build map
AmCharts.ready(function() {
	map = new AmCharts.AmMap();
	map.projection = "miller";

	map.addTitle("Real Estate", 14);
	map.addTitle("Current Projects", 11);
	map.areasSettings = {
		unlistedAreasColor: "#FFFFFF",
		unlistedAreasAlpha: 0.1
	};
	map.imagesSettings = {
		//balloonText: "<span style='font-size:14px;'><b>[[title]]</b>: [[value]]</span>",
		alpha: 0.6
	}

	var dataProvider = {
		mapVar: AmCharts.maps.macedoniaHigh,
		images: []
	}

	// create circle for each country

	// it's better to use circle square to show difference between values, not a radius
	var maxSquare = maxBulletSize * maxBulletSize * 2 * Math.PI;
	var minSquare = minBulletSize * minBulletSize * 2 * Math.PI;

	// create circle for each country
	for (var i = 0; i < mapData.length; i++) {
		var dataItem = mapData[i];
		var value = dataItem.value;
		// calculate size of a bubble
		var square = (value - min) / (max - min) * (maxSquare - minSquare) + minSquare;
		if (square < minSquare) {
			square = minSquare;
		}
		var size = Math.sqrt(square / (Math.PI * 2));
		//var id = dataItem.code;

		dataProvider.images.push({
			type: "circle",
			width: size,
			height: size,
			color: dataItem.color,
			//longitude: latlong[id].longitude,
			longitude: dataItem.longitude,
			//latitude: latlong[id].latitude,
			latitude: dataItem.latitude,
			title: dataItem.name,
			description: dataItem.description,
			value: value
		});
	}

	map.dataProvider = dataProvider;

	map.write("mapdiv");
});
