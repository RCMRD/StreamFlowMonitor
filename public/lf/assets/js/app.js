var map, stationsIndex,featureList,countrySearch = [],countriesSearch = [],stationsSearch = [];

$(window).resize(function() {
  sizeLayerControl();
});

$(document).on("click", ".feature-row", function(e) {
  $(document).off("mouseout", ".feature-row", clearHighlight);
  sidebarClick(parseInt($(this).attr("id"), 10));
});

if ( !("ontouchstart" in window) ) {
  $(document).on("mouseover", ".feature-row", function(e) {
    //highlight.clearLayers().addLayer(L.circleMarker([$(this).attr("lat"), $(this).attr("lng")], highlightStyle));
  });
}

//$(document).on("mouseout", ".feature-row", clearHighlight);

$("#about-btn").click(function() {
  $("#aboutModal").modal("show");
  $(".navbar-collapse.in").collapse("hide");
  return false;
});

$("#full-extent-btn").click(function() {
  map.fitBounds(boroughs.getBounds());
  $(".navbar-collapse.in").collapse("hide");
  return false;
});

$("#legend-btn").click(function() {
  $("#legendModal").modal("show");
  $(".navbar-collapse.in").collapse("hide");
  return false;
});

$("#login-btn").click(function() {
  $("#loginModal").modal("show");
  $(".navbar-collapse.in").collapse("hide");
  return false;
});

$("#list-btn").click(function() {
  animateSidebar();
  return false;
});

$("#nav-btn").click(function() {
  $(".navbar-collapse").collapse("toggle");
  return false;
});

$("#sidebar-toggle-btn").click(function() {
  animateSidebar();
  return false;
});

$("#sidebar-hide-btn").click(function() {
  animateSidebar();
  return false;
});

function animateSidebar() {
  $("#sidebar").animate({
    width: "toggle"
  }, 350, function() {
    map.invalidateSize();
  });
}

function sizeLayerControl() {
  $(".leaflet-control-layers").css("max-height", $("#map").height() - 50);
}

function clearHighlight() {
  highlight.clearLayers();
}

function sidebarClick(id) {
  var layer = markerClusters.getLayer(id);
  map.setView([layer.getLatLng().lat, layer.getLatLng().lng], 10);
  layer.fire("click");
  /* Hide sidebar and go to the map on small screens */
  if (document.body.clientWidth <= 767) {
    $("#sidebar").hide();
    map.invalidateSize();
  }
}

function syncSidebar() {
  /* Empty sidebar features */
  $("#feature-list tbody").empty();
  /* Loop through counties layer and add only features which are in the map bounds */

  
  stations.eachLayer(function (layer) {
    if (map.hasLayer(stationsLayer)) {
      if (map.getBounds().contains(layer.getLatLng())) {
		  
		  let img;
      switch (layer.feature.properties.status) {
        case 'ACTIVE': img = 'lf/assets/img/green_gnss.png'; break;
        case 'UNKOWN':img = 'lf/assets/img/orange_gnss.png'; break;
        case 'DOWN': img = 'lf/assets/img/red_gnss.png'; break;
		default: img = 'lf/assets/img/green_gnss.png';
      }
        $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="'+ img +'"></td><td class="feature-name">' + layer.feature.properties.name + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
      }
    }
  });
  
  /* Update list.js featureList */
  featureList = new List("features", {
    valueNames: ["feature-name"]
  });
  featureList.sort("feature-name", {
    order: "asc"
  });
}

/* Basemap Layers */
var cartoLight = L.tileLayer("https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png", {
  maxZoom: 19,
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="https://cartodb.com/attributions">CartoDB</a>'
});
/*var usgsImagery = L.layerGroup([L.tileLayer("http://basemap.nationalmap.gov/arcgis/rest/services/USGSImageryOnly/MapServer/tile/{z}/{y}/{x}", {
  maxZoom: 15,
}), L.tileLayer.wms("http://raster.nationalmap.gov/arcgis/services/Orthoimagery/USGS_EROS_Ortho_SCALE/ImageServer/WMSServer?", {
  minZoom: 16,
  maxZoom: 19,
  layers: "0",
  format: 'image/jpeg',
  transparent: true,
  attribution: "Aerial Imagery courtesy USGS"
})]);*/


var esriImagery= L.tileLayer("https://ibasemaps-api.arcgis.com/arcgis/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}?token=AAPKfe2fd8f24d8647ca8f80d92b8ebe1aedYGc9HMwIXzH-rPFNNQUjdtQ532XMXm-aIYma55FQ9uAxnazoAC2vArLCWuDNHByF", {
  maxZoom: 19,
  attribution: '&copy; <a href="">World Imagery</a> contributors, &copy; <a href="">Esri</a>'
});




/* Overlay Layers */
var highlight = L.geoJson(null);
var highlightStyle = {
  fillColor: "#f0d1b1",
  fillOpacity: 1,
  color: '#fff',
  opacity: 1,
  weight: 1
};



/* Single marker cluster layer to hold all clusters */
var markerClusters = new L.MarkerClusterGroup({
  spiderfyOnMaxZoom: true,
  showCoverageOnHover: false,
  zoomToBoundsOnClick: true,
  disableClusteringAtZoom: 8
});

// Set style function that sets fill color property
function style(feature) {
    return {
       // fillColor: 'green', 
        fillOpacity: 0,  
        weight: 1,
        opacity: 0.5,
        color: '#000',
        //dashArray: '3'
    };
}
var highlight2 = {
		'fillColor': 'yellow',
		'weight': 2,
		'opacity': 1
	};

function stylepoint(feature) {
    return {
       // fillColor: 'green', 
        radius: 4,
    fillColor: "#ff7800",
    color: "#000",
    weight: 1,
    opacity: 1,
    fillOpacity: 0.8
        //dashArray: '3'
    };
}

var highlightpoint = {
		radius: 8,
    fillColor: "#00ff7b",
    color: "#000",
    weight: 1,
    opacity: 1,
    fillOpacity: 0.8
	};	
	
var geojsonMarkerOptions = {
    radius: 4,
    fillColor: "#ff5500",
    color: "#000",
    weight: 1,
    opacity: 1,
    fillOpacity: 0.8
};

let stationIcon = L.Icon.extend({
    options: {
      iconSize:     [14, 18], // size of the icon
      iconAnchor:   [7, 18],   // point of the icon which will correspond to marker's location
      popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    }
});

let greenIcon = new stationIcon({iconUrl: 'lf/assets/img/green_gnss.png'});

let redIcon = new stationIcon({iconUrl: 'lf/assets/img/red_gnss.png'});

let orangeIcon = new stationIcon({iconUrl: 'lf/assets/img/orange_gnss.png'});



/*var greenIcon = L.icon({
    iconUrl: 'lf/assets/img/green_gnss.png',
    //shadowUrl: 'lf/assets/img/green_gnss.png',

    iconSize:     [10, 12], // size of the icon
    //shadowSize:   [50, 64], // size of the shadow
    iconAnchor:   [5, 12], // point of the icon which will correspond to marker's location
    //shadowAnchor: [4, 62],  // the same for the shadow
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

function createMarker(feature, latlng) {
  return L.marker(latlng, {icon: greenIcon});
}*/





/* Empty layer placeholder to add to layer control for listening when to add/remove counties to markerClusters layer */
var stationsLayer = L.geoJson(null);
var countriesLayer = L.geoJson(null);

var stations = L.geoJson(null, {

  onEachFeature: function (feature, layer) {
    if (feature.properties) {
		let content;
		switch (feature.properties.availability) {
        case 'Yes': content = "<table class='table table-striped table-bordered table-condensed'>" + "<tr><th>Name</th><td>" + feature.properties.name + "</td></tr>" + "<tr><th>Height (M)</th><td>" + feature.properties.height + "</td></tr>" + "<tr><th>Agency</th><td> <a href="+ feature.properties.website +" target='_blank'>"+ feature.properties.agency + "</a></td></tr>"+ "<tr><th>Country</th><td>" + feature.properties.country + "</td></tr>" + "<tr><th>Status</th><td>" + feature.properties.status + "</td></tr>" + "<tr><th>Data Link</th><td><a href="+ feature.properties.data_link +" target='_blank'>Link</a></td></tr>"+"<tr><th>Receiver Satellite</th><td>" + feature.properties.receiver_satellite + "</td></tr><table>"; break;
        case 'No':content = "<table class='table table-striped table-bordered table-condensed'>" + "<tr><th>Name</th><td>" + feature.properties.name + "</td></tr>" + "<tr><th>Height (M)</th><td>" + feature.properties.height + "</td></tr>" + "<tr><th>Agency</th><td> <a href="+ feature.properties.website +" target='_blank'>"+ feature.properties.agency + "</a></td></tr>"+ "<tr><th>Country</th><td>" + feature.properties.country + "</td></tr>" + "<tr><th>Status</th><td>" + feature.properties.status + "</td></tr>" + "<tr><th>Receiver Satellite</th><td>" + feature.properties.receiver_satellite + "</td></tr><table>"; break;
       
		default: content = "<table class='table table-striped table-bordered table-condensed'>" + "<tr><th>Name</th><td>" + feature.properties.name + "</td></tr>" + "<tr><th>Height (M)</th><td>" + feature.properties.height + "</td></tr>" + "<tr><th>Agency</th><td> <a href="+ feature.properties.website +" target='_blank'>"+ feature.properties.agency + "</a></td></tr>"+ "<tr><th>Country</th><td>" + feature.properties.country + "</td></tr>" + "<tr><th>Status</th><td>" + feature.properties.status + "</td></tr>" + "<tr><th>Receiver Satellite</th><td>" + feature.properties.receiver_satellite + "</td></tr><table>"; break;
      }
      
     
	  layer.on({
        click: function (e) {
          $("#feature-title").html(feature.properties.name);
          $("#feature-info").html(content);
          $("#featureModal").modal("show");
		  
		  //stations.setStyle(stylepoint); //resets layer colors
          //layer.setStyle(highlightpoint); 
		  
          //highlight.clearLayers().addLayer(L.circleMarker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], highlightStyle));
        }
      });
	  let img;
      switch (layer.feature.properties.status) {
        case 'ACTIVE': img = 'lf/assets/img/green_gnss.png'; break;
        case 'UNKOWN':img = 'lf/assets/img/orange_gnss.png'; break;
        case 'DOWN': img = 'lf/assets/img/red_gnss.png'; break;
		default: img = 'lf/assets/img/green_gnss.png';
      }
	  
	   
	  
      $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="' + img + '"></td><td class="feature-name">' + layer.feature.properties.name + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
      stationsSearch.push({
        name: layer.feature.properties.name,
        source: "Stations",
        id: L.stamp(layer),
        lat: layer.getLatLng().lat,
        lng: layer.getLatLng().lng
      });
	  
    }
  },
  /*pointToLayer: function (feature, latlng) {
        return L.circleMarker(latlng, geojsonMarkerOptions);
    }*/
	
	pointToLayer:function(feature, LatLng) {
      let icon;
      switch (feature.properties.status) {
        case 'ACTIVE': icon = greenIcon; break;
        case 'UNKOWN': icon = orangeIcon; break;
        case 'DOWN': icon = redIcon; break;
		default: icon = greenIcon;
      }
      return L.marker(LatLng, {icon: icon});
    }
}

);
var countries = L.geoJson(null, {
	
	onEachFeature: function (feature, layer) {
    if (feature.properties) {
      
     
      countriesSearch.push({
        name: layer.feature.properties.name,
        
      });
	  
    }
  },

  style: style
});
$.getJSON("lf/data/rcmrd.json", function (data) {
  countries.addData(data);
  map.addLayer(countriesLayer);
});



/*$.getJSON("lf/data/cors.geojson", function (data) {
  stations.addData(data);
  map.addLayer(stationsLayer);
});*/


map = L.map("map", {
  zoom: 3,
  center: [-6.49, 34.80],
  layers: [cartoLight, countries,stations, markerClusters, highlight],
  zoomControl: false,
  cursor: true,
  attributionControl: false
});

/* Layer control listeners that allow for a single markerClusters layer */
map.on("overlayadd", function(e) {
  
  if (e.layer === stationsLayer) {
    markerClusters.addLayer(stations);
    syncSidebar();
  }
});

map.on("overlayremove", function(e) {
  
  if (e.layer === stationsLayer) {
    markerClusters.removeLayer(stations);
    syncSidebar();
  }
});

/* Filter sidebar feature list to only show features in current map bounds */
map.on("moveend", function (e) {
  syncSidebar();
});

/* Clear feature highlight when map is clicked */
map.on("click", function(e) {
  highlight.clearLayers();
  
});

var sts = $.ajax({
            url: '/stations',
            dataType: "json",
            //success: console.log("County data successfully loaded."),
            error: function(xhr) {
                alert(xhr.statusText)
            }
        })
		$.when(sts).done(function() {
           
           
			
			stations.addData(sts.responseJSON);
			
            map.addLayer(stationsLayer);
			stationsIndex = leafletKnn(stations);
			
			
			
			map.on('mousemove', function (ev) {
            
			var nearestResult =  stationsIndex.nearest(ev.latlng, 1)[0]
	        //nearestResult.layer.bindPopup("I'm nearest to where you clicked yes!").openPopup();
			
			$("#nearest-list tbody").empty();
			
			 $("#nearest-list tbody").append('<tr class="feature-row"><td class="feature-name"><b>Cursor Lat, Lon:</b> ('+ev.latlng.lat.toFixed(4) +','+ev.latlng.lng.toFixed(4) +')</td></tr>');
			
		    $("#nearest-list tbody").append('<tr class="feature-row" id="' + L.stamp(nearestResult) + '" lat="' + nearestResult.lat + '" lng="' + nearestResult.lng + '"><td class="feature-name">' + nearestResult.layer.feature.properties.name + '</td></tr>');
	        //nearestResult.layer.bindPopup("I'm nearest to where you clicked!"+nearestResult.layer.feature.properties.name).openPopup();
  
            //console.log(nearestResult);
			
			
			
			
			});
			/* countries.on('mouseover', function(e) { 
	  
			var nearestResult =  stationsIndex.nearest(e.latlng, 1)[0]
			
			 $("#nearest-list tbody").empty();
			
			 $("#nearest-list tbody").append('<tr class="feature-row" id="' + L.stamp(nearestResult) + '" lat="' + nearestResult.lat + '" lng="' + nearestResult.lng + '"><td class="feature-name">' + nearestResult.layer.feature.properties.name + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
	        nearestResult.layer.bindPopup("I'm nearest to where you clicked!"+nearestResult.layer.feature.properties.name).openPopup();
			
			_length = L.GeometryUtil.length([e.latlng, nearestResult.layer._latlng]);
			
			const coordinates_array = stations.getLayers().map(l => l.feature.geometry.coordinates)
            let closest_latlng = L.GeometryUtil.closest(map, coordinates_array, e.latlng)
			
			let closest_latlng = L.GeometryUtil.closest(map, coords, e.latlng,true);
			
			stations.bindPopup(closest_latlng.lat+","+closest_latlng.lng).openPopup()
			
			console.log(nearestResult);
			
			console.log(closest_latlng);

	
        });*/
   
   
		});

/* Attribution control */
function updateAttribution(e) {
  $.each(map._layers, function(index, layer) {
    if (layer.getAttribution) {
      $("#attribution").html((layer.getAttribution()));
    }
  });
}
map.on("layeradd", updateAttribution);
map.on("layerremove", updateAttribution);

var attributionControl = L.control({
  position: "bottomright"
});
attributionControl.onAdd = function (map) {
  var div = L.DomUtil.create("div", "leaflet-control-attribution");
  div.innerHTML = "<span class='hidden-xs'>Developed by <a href='https://www.rcmrd.org'>RCMRD</a> | </span><a href='#' onclick='$(\"#attributionModal\").modal(\"show\"); return false;'>Attribution</a>";
  return div;
};
map.addControl(attributionControl);

var zoomControl = L.control.zoom({
  position: "bottomright"
}).addTo(map);

/* GPS enabled geolocation control set to follow the user's location */
var locateControl = L.control.locate({
  position: "bottomright",
  drawCircle: true,
  follow: true,
  setView: true,
  keepCurrentZoomLevel: true,
  markerStyle: {
    weight: 1,
    opacity: 0.8,
    fillOpacity: 0.8
  },
  circleStyle: {
    weight: 1,
    clickable: false
  },
  icon: "fa fa-location-arrow",
  metric: false,
  strings: {
    title: "My location",
    popup: "You are within {distance} {unit} from this point",
    outsideMapBoundsMsg: "You seem located outside the boundaries of the map"
  },
  locateOptions: {
    maxZoom: 18,
    watch: true,
    enableHighAccuracy: true,
    maximumAge: 10000,
    timeout: 10000
  }
}).addTo(map);

/* Larger screens get expanded layer control and visible sidebar */
if (document.body.clientWidth <= 767) {
  var isCollapsed = true;
} else {
  var isCollapsed = false;
}

var baseLayers = {
  "Street Map": cartoLight,
  "Aerial Imagery": esriImagery
 
};

var groupedOverlays = {
	"Boundaries": {
    "<img src='lf/assets/img/boundary.png' width='20' height='24'>&nbsp;Member States": countriesLayer,
    
  },
  "Stations": {
    "<img src='lf/assets/img/green_gnss.png' width='20' height='24'>&nbsp;Stations": stationsLayer,
    
  }
};

var layerControl = L.control.groupedLayers(baseLayers, groupedOverlays, {
  collapsed: isCollapsed
}).addTo(map);

/* Highlight search box text on click */
$("#searchbox").click(function () {
  $(this).select();
});

/* Prevent hitting enter from refreshing the page */
$("#searchbox").keypress(function (e) {
  if (e.which == 13) {
    e.preventDefault();
  }
});

$("#featureModal").on("hidden.bs.modal", function (e) {
  $(document).on("mouseout", ".feature-row", clearHighlight);
});

/* Typeahead search functionality */
$(document).one("ajaxStop", function () {
  $("#loading").hide();
  sizeLayerControl();
  /* Fit map to boroughs bounds */
  map.fitBounds(stations.getBounds());
  featureList = new List("features", {valueNames: ["feature-name"]});
  featureList.sort("feature-name", {order:"asc"});

 

  
  
  
  var stationsBH = new Bloodhound({
    name: "Stations",
    datumTokenizer: function (d) {
      return Bloodhound.tokenizers.whitespace(d.name);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    local: stationsSearch,
    limit: 10
  });

  var geonamesBH = new Bloodhound({
    name: "Geo4Names",
    datumTokenizer: function (d) {
      return Bloodhound.tokenizers.whitespace(d.name);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: "http://api.geonames.org/searchJSON?username=bootleaf&featureClass=P&maxRows=5&countryCode=US&name_startsWith=%QUERY",
      filter: function (data) {
        return $.map(data.geonames, function (result) {
          return {
            name: result.name + ", " + result.adminCode1,
            lat: result.lat,
            lng: result.lng,
            source: "GeoNames"
          };
        });
      },
      ajax: {
        beforeSend: function (jqXhr, settings) {
          settings.url += "&east=" + map.getBounds().getEast() + "&west=" + map.getBounds().getWest() + "&north=" + map.getBounds().getNorth() + "&south=" + map.getBounds().getSouth();
          $("#searchicon").removeClass("fa-search").addClass("fa-refresh fa-spin");
        },
        complete: function (jqXHR, status) {
          $('#searchicon').removeClass("fa-refresh fa-spin").addClass("fa-search");
        }
      }
    },
    limit: 10
  });
  stationsBH.initialize();
  geonamesBH.initialize();

  /* instantiate the typeahead UI */
  $("#searchbox").typeahead({
    minLength: 3,
    highlight: true,
    hint: false
  }, {
    name: "Stations",
    displayKey: "name",
    source: stationsBH.ttAdapter(),
    templates: {
      header: "<h4 class='typeahead-header'>Stations</h4>"
    }
  } , {
    name: "GeoNames",
    displayKey: "name",
    source: geonamesBH.ttAdapter(),
    templates: {
      header: "<h4 class='typeahead-header'><img src='lf/assets/img/globe.png' width='25' height='25'>&nbsp;GeoNames</h4>"
    }
  }).on("typeahead:selected", function (obj, datum) {
    
    if (datum.source === "Stations") {
      if (!map.hasLayer(stationsLayer)) {
        map.addLayer(stationsLayer);
      }
      map.setView([datum.lat, datum.lng], 10);
      if (map._layers[datum.id]) {
        map._layers[datum.id].fire("click");
      }
    }
    
    if (datum.source === "GeoNames") {
      map.setView([datum.lat, datum.lng], 14);
    }
    if ($(".navbar-collapse").height() > 50) {
      $(".navbar-collapse").collapse("hide");
    }
  }).on("typeahead:opened", function () {
    $(".navbar-collapse.in").css("max-height", $(document).height() - $(".navbar-header").height());
    $(".navbar-collapse.in").css("height", $(document).height() - $(".navbar-header").height());
  }).on("typeahead:closed", function () {
    $(".navbar-collapse.in").css("max-height", "");
    $(".navbar-collapse.in").css("height", "");
  });
  $(".twitter-typeahead").css("position", "static");
  $(".twitter-typeahead").css("display", "block");
});

/*map.on("click", function(ev) {  
  var nearestResult = stationsIndex.nearest(ev.latlng, 1)[0];
  
  nearestResult.layer.bindPopup("I'm nearest to where you clicked!").openPopup();
  
  console.log(nearestResult);
});*/

// Leaflet patch to make layer control scrollable on touch browsers
var container = $(".leaflet-control-layers")[0];
if (!L.Browser.touch) {
  L.DomEvent
  .disableClickPropagation(container)
  .disableScrollPropagation(container);
} else {
  L.DomEvent.disableClickPropagation(container);
}
