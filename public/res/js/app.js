var points_url = "res/data/stations.geojson";
var raster_url = "";
var data_all_url ="stations";
var data_single_vic_url ="stationvic/";
var data_single_fdc_url ="stationfdc/";
var data_single_fdc_res_url ="stationfdcresource/";

var map, featureList, stationSearch = [];

$(window).resize(function () {
    sizeLayerControl();
});

$(document).on("click", ".feature-row", function (e) {
    $(document).off("mouseout", ".feature-row", clearHighlight);
    sidebarClick(parseInt($(this).attr("id"), 10));
});

if (!("ontouchstart" in window)) {
    $(document).on("mouseover", ".feature-row", function (e) {
        highlight.clearLayers().addLayer(L.circleMarker([$(this).attr("lat"), $(this).attr("lng")], highlightStyle));
    });
}

$(document).on("mouseout", ".feature-row", clearHighlight);

$("#about-btn").click(function () {
    $("#aboutModal").modal("show");
    $(".navbar-collapse.in").collapse("hide");
    return false;
});

$("#full-extent-btn").click(function () {
    map.fitBounds(boroughs.getBounds());
    $(".navbar-collapse.in").collapse("hide");
    return false;
});

$("#legend-btn").click(function () {
    $("#legendModal").modal("show");
    $(".navbar-collapse.in").collapse("hide");
    return false;
});

$("#login-btn").click(function () {
    $("#loginModal").modal("show");
    $(".navbar-collapse.in").collapse("hide");
    return false;
});

$("#list-btn").click(function () {
    animateSidebar();
    return false;
});

$("#nav-btn").click(function () {
    $(".navbar-collapse").collapse("toggle");
    return false;
});

$("#sidebar-toggle-btn").click(function () {
    animateSidebar();
    return false;
});

$("#sidebar-hide-btn").click(function () {
    animateSidebar();
    return false;
});

function animateSidebar() {
    $("#sidebar").animate({
        width: "toggle"
    }, 350, function () {
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
    map.setView([layer.getLatLng().lat, layer.getLatLng().lng], 17);
    layer.fire("click");
    /* Hide sidebar and go to the map on small screens */
    if (document.body.clientWidth <= 767) {
        $("#sidebar").hide();
        map.invalidateSize();
    }
}

function syncSidebar() {
    /* Empty sidebar features */
    $("#feature-list-wami tbody").empty();
	$("#feature-list-rufiji tbody").empty();
	$("#feature-list-ruvu tbody").empty();
    /* Loop through stations layer and add only features which are in the map bounds */
    stations.eachLayer(function (layer) {
        if (map.hasLayer(stationLayer)) {
            if (map.getBounds().contains(layer.getLatLng())) {
				
				if (layer.feature.properties.basin=="Wami"){
                $("#feature-list-wami tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="res/img/station.png"></td><td class="feature-name">' + layer.feature.properties.station_name + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				}else if(layer.feature.properties.basin=="Rufiji"){
				 $("#feature-list-rufiji tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="res/img/station.png"></td><td class="feature-name">' + layer.feature.properties.station_name + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');	
			
				}else if(layer.feature.properties.basin=="Ruvu"){
				 $("#feature-list-ruvu tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="res/img/station.png"></td><td class="feature-name">' + layer.feature.properties.station_name + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');	
				}
			
			
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* Basemap Layers */
var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
});

var cartoLight = L.tileLayer("https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="https://cartodb.com/attributions">CartoDB</a>'
});

var usgsImagery = L.layerGroup([L.tileLayer("http://basemap.nationalmap.gov/arcgis/rest/services/USGSImageryOnly/MapServer/tile/{z}/{y}/{x}", {
    maxZoom: 15,
}), L.tileLayer.wms("http://raster.nationalmap.gov/arcgis/services/Orthoimagery/USGS_EROS_Ortho_SCALE/ImageServer/WMSServer?", {
    minZoom: 16,
    maxZoom: 19,
    layers: "0",
    format: 'image/jpeg',
    transparent: true,
    attribution: "Aerial Imagery courtesy USGS"
})]);

/* Overlay Layers */
var highlight = L.geoJson(null);
var highlightStyle = {
    stroke: false,
    fillColor: "#FFFF00",
    fillOpacity: 0.7,
    radius: 10
};

/* Single marker cluster layer to hold all clusters */
var markerClusters = new L.MarkerClusterGroup({
    spiderfyOnMaxZoom: true,
    showCoverageOnHover: false,
    zoomToBoundsOnClick: true,
    disableClusteringAtZoom: 16
});


/* Empty layer placeholder to add to layer control for listening when to add/remove stations to markerClusters layer */
var stationLayer = L.geoJson(null);
var stations = L.geoJson(null, {
    pointToLayer: function (feature, latlng) {
        return L.marker(latlng, {
            icon: L.icon({
                iconUrl: "res/img/station.png",
                iconSize: [24, 28],
                iconAnchor: [12, 28],
                popupAnchor: [0, -25]
            }),
            title: feature.properties.station_name,
            riseOnHover: true
        });
    },
    onEachFeature: function (feature, layer) {

        if (feature.properties) {

            var data_tbl =
                "<table class='table table-striped table-dark table-bordered'>\
                <tbody>\
                <tr>\
                <th>River Gauge Station</th>" +
                "<td>" + feature.properties.station_name + "</td>" +
                "</tr>\
                <tr>\
                <th>Sub-Catchment Area</th>" +
                "<td>" + feature.properties.area_km2 + "</td>" +
                "</tr>\
                <tr>\
                <th>River</th>" +
                "<td>" + feature.properties.river + "</td>" +
                "</tr>\
                <tr>\
                <th>Basin</th>" +
                "<td>" + feature.properties.basin + "</td>" +
                "</tr>\
                <tr>\
                <th>Country</th>" +
                "<td>" + feature.properties.station_country + "</td>" +
                "</tr>\
                </tbody>\
                </table>";

            layer.bindTooltip(
                data_tbl
            );

            layer.on({
                click: function (e) {

                    get_station_data(
                        data_single_vic_url + feature.properties.station_name,
                        data_single_fdc_url + feature.properties.station_name,
                        data_single_fdc_res_url + feature.properties.station_name, [
                        feature.properties.station_name,
                        feature.properties.station_country,
                        feature.properties.river,
                        feature.properties.basin,
                        feature.properties.area_km2
                    ]
                    );

                    highlight.clearLayers().addLayer(L.circleMarker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], highlightStyle));
                }
            });
			
			if (feature.properties.basin=="Wami"){
                $("#feature-list-wami tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="res/img/station.png"></td><td class="feature-name">' + layer.feature.properties.station_name + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				}else if(feature.properties.basin=="Rufiji"){
				 $("#feature-list-rufiji tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="res/img/station.png"></td><td class="feature-name">' + layer.feature.properties.station_name + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');	
				}else if(feature.properties.basin=="Ruvu"){
				 $("#feature-list-ruvu tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="res/img/station.png"></td><td class="feature-name">' + layer.feature.properties.station_name + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');	
				}

           
            stationSearch.push({
                name: layer.feature.properties.station_name,
                river: layer.feature.properties.river,
                source: "Stations",
                id: L.stamp(layer),
                lat: layer.feature.geometry.coordinates[1],
                lng: layer.feature.geometry.coordinates[0]
            });
        }
    }
});
$.getJSON(points_url, function (data) {
    stations.addData(data);
    map.addLayer(stationLayer);
});

//////////////////////////////////////////////////////////////////////

var rufijiLayer = L.geoJson(null);
var wamiruvuLayer = L.geoJson(null);
var greatruahaLayer = L.geoJson(null);
var kilomberoLayer = L.geoJson(null);
var lweguLayer = L.geoJson(null);
var riverLayer = L.geoJson(null);
var rwmriverLayer = L.geoJson(null);
var roi_tzLayer = L.geoJson(null);

var roi_tz = L.tileLayer.wms("https://data.rcmrd.org/geoserver/smft/wms", {
    layers: 'smft:tanzania_country',
    format: 'image/png',
    transparent: true,
    version: '1.1.1',
    attribution: "Tanzania Administrative Unit",
    styles: 'countries',
});

var riverWays = L.tileLayer.wms("https://data.rcmrd.org/geoserver/smft/wms", {
    layers: 'smft:Rivers_Tanzania',
    format: 'image/png',
    transparent: true,
    version: '1.1.1',
    attribution: "Tanzania Rivers",
    styles: 'rivers',
});

var rwmriverWays = L.tileLayer.wms("https://data.rcmrd.org/geoserver/smft/wms", {
    layers: 'smft:Rufiji_Wami_Ruvu_River',
    format: 'image/png',
    transparent: true,
    version: '1.1.1',
    attribution: "Rufiji_Wami_Ruvu River",
    styles: 'rivers',
});

var rufijiBasin = L.tileLayer.wms("https://data.rcmrd.org/geoserver/smft/wms", {
    layers: 'smft:Rufiji_River_Basin_Tanzania',
    format: 'image/png',
    transparent: true,
    version: '1.1.1',
    attribution: "Rufiji Basin",
    styles: 'basins',
});

var wamiruvuBasin = L.tileLayer.wms("https://data.rcmrd.org/geoserver/smft/wms", {
    layers: 'smft:Wami_Ruvu_River_Basin_Tanzania',
    format: 'image/png',
    transparent: true,
    version: '1.1.1',
    attribution: "Wami-Ruvu Basin",
    styles: 'basins',
});

var greatruahaBasin = L.tileLayer.wms("https://data.rcmrd.org/geoserver/smft/wms", {
    layers: 'smft:Great_Ruaha_Catchment',
    format: 'image/png',
    transparent: true,
    version: '1.1.1',
    attribution: "Great Ruaha Catchment",
    styles: 'basins',
});

var kilomberoBasin = L.tileLayer.wms("https://data.rcmrd.org/geoserver/smft/wms", {
    layers: 'smft:Kilombero_Watershed',
    format: 'image/png',
    transparent: true,
    version: '1.1.1',
    attribution: "Kilombero Watershed",
    styles: 'basins',
});

var lweguBasin = L.tileLayer.wms("https://data.rcmrd.org/geoserver/smft/wms", {
    layers: 'smft:Lwegu_Watershed',
    format: 'image/png',
    transparent: true,
    version: '1.1.1',
    attribution: "Lwegu Watershed",
    styles: 'basins',
});



//////////////////////////////////////////////////////////////////////

map = L.map("map", {
    zoom: 6.6,
    center: [0, 39.2627871],
    layers: [cartoLight, roi_tzLayer, markerClusters, highlight], //[osm, cartoLight, usgsImagery, markerClusters, highlight]
    zoomControl: false,
    attributionControl: false
});

map.addLayer(roi_tzLayer);
map.addLayer(roi_tz);
map.addLayer(rwmriverLayer);
map.addLayer(rwmriverWays);

function addThematicLayers(e) {

    if (e.layer === rufijiLayer) {
        map.addLayer(rufijiBasin);
    }

    if (e.layer === wamiruvuLayer) {
        map.addLayer(wamiruvuBasin);
    }

    if (e.layer === riverLayer) {
        map.addLayer(riverWays);
    }

    if (e.layer === rwmriverLayer) {
        map.addLayer(rwmriverWays);
    }

    if (e.layer === greatruahaLayer) {
        map.addLayer(greatruahaBasin);
    }

    if (e.layer === kilomberoLayer) {
        map.addLayer(kilomberoBasin);
    }

    if (e.layer === lweguLayer) {
        map.addLayer(lweguBasin);
    }

}

function removeThematicLayers(e) {

    if (e.layer === rufijiLayer) {
        map.removeLayer(rufijiBasin);
    }

    if (e.layer === wamiruvuLayer) {
        map.removeLayer(wamiruvuBasin);
    }

    if (e.layer === riverLayer) {
        map.removeLayer(riverWays);
    }

    if (e.layer === rwmriverLayer) {
        map.removeLayer(rwmriverWays);
    }

    if (e.layer === greatruahaLayer) {
        map.removeLayer(greatruahaBasin);
    }

    if (e.layer === kilomberoLayer) {
        map.removeLayer(kilomberoBasin);
    }

    if (e.layer === lweguLayer) {
        map.removeLayer(lweguBasin);
    }

    clearHighlight();

}

/* Layer control listeners that allow for a single markerClusters layer */
map.on("overlayadd", function (e) {
    if (e.layer === stationLayer) {
        markerClusters.addLayer(stations);
        //syncSidebar();
    }

    var isThematic =
        (e.layer === rufijiLayer) ? true :
            (e.layer === wamiruvuLayer) ? true :
                (e.layer === greatruahaLayer) ? true :
                    (e.layer === kilomberoLayer) ? true :
                        (e.layer === lweguLayer) ? true :
                            (e.layer === rwmriverLayer) ? true :
                                (e.layer === riverLayer) ? true :
                                    false;

    if (
        e.layer === rufijiLayer ||
        e.layer === wamiruvuLayer ||
        e.layer === riverLayer ||
        e.layer === rwmriverLayer ||
        e.layer === greatruahaLayer ||
        e.layer === lweguLayer ||
        e.layer === kilomberoLayer
    ) {
        addThematicLayers(e);

    } else if (
        e.layer !== rufijiLayer &&
        e.layer !== wamiruvuLayer &&
        e.layer !== riverLayer &&
        e.layer !== rwmriverLayer &&
        e.layer !== kilomberoLayer &&
        e.layer !== lweguLayer &&
        e.layer !== greatruahaLayer
    ) {
        removeThematicLayers(e);

    }
});

map.on("overlayremove", function (e) {
    if (e.layer === stationLayer) {
        markerClusters.removeLayer(stations);
        //syncSidebar();
    }
    removeThematicLayers(e);
});

/* Filter sidebar feature list to only show features in current map bounds */
map.on("moveend", function (e) {
    //syncSidebar();
});

/* Clear feature highlight when map is clicked */
map.on("click", function (e) {
    highlight.clearLayers();
});

/* Attribution control */
function updateAttribution(e) {
    $.each(map._layers, function (index, layer) {
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

    div.innerHTML = "<span class='hidden-xs'>Developed by <a href='https://servirglobal.net/Regions/ESAfrica'>SERVIR E&SA</a>  and <a href='https://rcmrd.org'>RCMRD</a>| </span><a href='#' onclick='$(\"#attributionModal\").modal(\"show\"); return false;'>Attribution</a>";

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
    //"OSM - Street Map": osm,
    "CartoDB - Street Map": cartoLight,
    //"Satellite Imagery": usgsImagery
};

var groupedOverlays = {
    "Stations": {
        "<img src='res/img/station.png' width='24' height='28'>&nbsp;River Gauge Stations": stationLayer,
        "<img src='res/img/river.png' width='24' height='28'>&nbsp;Rivers": rwmriverLayer
    },
    "Basins": {
        "Rufiji Basin": rufijiLayer,
        "Wami-Ruvu Basin": wamiruvuLayer,
        "Great Ruaha Catchment": greatruahaLayer,
        "Lwegu Watershed": lweguLayer,
        "Kilombero Watershed": kilomberoLayer
    },
    "Country": {
        "Tanzania": roi_tzLayer
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
    /* Fit map to stations bounds */
    map.fitBounds(stations.getBounds());
    featureList = new List("features", { valueNames: ["feature-name"] });
    featureList.sort("feature-name", { order: "asc" });

    var stationsBH = new Bloodhound({
        name: "Stations",
        datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d.name);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: stationSearch,
        limit: 10
    });

    var geonamesBH = new Bloodhound({
        name: "GeoNames",
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
    },
        /* {
           name: "Boroughs",
           displayKey: "name",
           source: boroughsBH.ttAdapter(),
           templates: {
             header: "<h4 class='typeahead-header'>Boroughs</h4>"
           }
         }, */
        {
            name: "Stations",
            displayKey: "name",
            source: stationsBH.ttAdapter(),
            templates: {
                header: "<h4 class='typeahead-header'><img src='res/img/station.png' width='24' height='28'>&nbsp;Stations</h4>",
                suggestion: Handlebars.compile(["{{name}}<br>&nbsp;<small>{{address}}</small>"].join(""))
            }
        }, {
        name: "GeoNames",
        displayKey: "name",
        source: geonamesBH.ttAdapter(),
        templates: {
            header: "<h4 class='typeahead-header'><img src='res/img/globe.png' width='25' height='25'>&nbsp;GeoNames</h4>"
        }
    }).on("typeahead:selected", function (obj, datum) {
        /* if (datum.source === "Boroughs") {
          map.fitBounds(datum.bounds);
        } */
        if (datum.source === "Stations") {
            if (!map.hasLayer(stationLayer)) {
                map.addLayer(stationLayer);
            }
            map.setView([datum.lat, datum.lng], 17);
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

// Leaflet patch to make layer control scrollable on touch browsers
var container = $(".leaflet-control-layers")[0];
if (!L.Browser.touch) {
    L.DomEvent
        .disableClickPropagation(container)
        .disableScrollPropagation(container);
} else {
    L.DomEvent.disableClickPropagation(container);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Raster Loading
/*L.WMS.overlay('http://geoportal.rcmrd.org/geoserver/wms', {
    'request': 'GetMap',
    'service': 'WMS',
    'layers': 'servir:rwanda_sebeya_4_0m_flood_depth',
    //'styles': 'wijkenbuurten_thema_buurten_gemeentewijkbuurt_gemiddeld_aantal_autos_per_huishouden',
    'srs': 'EPSG:4326',
    'transparent': 'false',
    'format': 'image/png'
}).addTo(map);*/

//Data Loading
function get_station_data(urlvic, urlfdc, urlfdcres, info) {

    setModalSTATION(info);
    console.log(info);
	
	
	
 var datafdc = $.ajax({
            url: urlfdc,
            dataType: "json",
            //success: console.log("County data successfully loaded."),
            error: function(xhr) {
                alert(xhr.statusText);
            }
        })
		$.when(datafdc).done(function() {
			
			//console.log(datafdc.responseJSON);
          setModalFDC(datafdc.responseJSON);
		  
		  var datavic = $.ajax({
            url: urlvic,
            dataType: "json",
            //success: console.log("County data successfully loaded."),
            error: function(xhr) {
                alert(xhr.statusText)
            }
        })
		$.when(datavic).done(function() {
          
		   setModalVIC(datavic.responseJSON, info);
		   $('#myModal').modal('show');
         		
   
		});
         		
   
   
		});
	

  


}

//gets max val in array
Array.prototype.max = function () {
    return Math.max.apply(null, this);
};

//gets min val in array
Array.prototype.min = function () {
    return Math.min.apply(null, this);
};

//plots graphs, show info
function setModalSTATION(info_) {

    var info = info_;

    var stn_info =
        "<table id='infoTbl' class='table table-striped table-dark table-bordered' style='table-layout: fixed;width: 100%;'>\
            <tbody>\
            <tr>\
            <th>River Gauge Station</th>" +
        "<td>" + info[0] + "</td>" +
        "</tr>\
            <tr>\
                <th>Sub-Catchment Area (Km2)</th>" +
        "<td>" + info[5] + "</td>" +
        "</tr>\
                <tr>\
                <th>River</th>" +
        "<td>" + info[2] + "</td>" +
        "</tr>\
                <tr>\
                <th>Basin</th>" +
        "<td>" + info[3] + "</td>" +
        "</tr>\
        <tr>\
                <th>Country</th>" +
        "<td>" + info[1] + "</td>" +
        "</tr>\
            </tbody>\
            </table>";

    $('#myModal').on('shown.bs.modal', function (e) {

        //add station data
        const div = document.getElementById("myDiv1");

        //clear div
        while (div.hasChildNodes()) {
            div.removeChild(div.firstChild);
        }

        div.innerHTML = stn_info;
    });

    //station
    $('#tab1').on('shown.bs.tab', function () {

        const div = document.getElementById("myDiv1");

        //clear div
        while (div.hasChildNodes()) {
            div.removeChild(div.firstChild);
        }

        div.innerHTML = stn_info;

    });

}


function setModalVIC(data_vic, info_) {

    //vic///////////////////////////////////////////////////////////////////////////////////////////
    var trace1_vic = {

        name: 'Simulated Values (VIC)',
        type: "scatter",
        mode: "lines",
        line: { color: '#17BECF' },

        x: [],
        y: []
    };

    var trace2_vic = {

        name: 'Observed Values',
        type: "scatter",
        mode: "lines",
        line: { color: '#7F7F7F' },
        x: [],
        y: []
    };

    data_vic.forEach(function (val) {
        trace1_vic.x.push(val["_data_date"]);
        trace1_vic.y.push(val["_data_value_sim"]);
        trace2_vic.x.push(val["_data_date"]);
        trace2_vic.y.push(val["_data_value_obs"]);
    });

    var datavic = [trace1_vic, trace2_vic];

    var layout = {

        title: 'Streamflow Monitoring & Forecasting Tool - Time Series',
        xaxis: {
            autorange: true,
            rangeselector: {
                buttons: [{
                    count: 1,
                    label: '1m',
                    step: 'month',
                    stepmode: 'backward'
                },
                {
                    count: 6,
                    label: '6m',
                    step: 'month',
                    stepmode: 'backward'
                },
                {
                    count: 1,
                    label: '1y',
                    step: 'year',
                    stepmode: 'backward'
                },
                { step: 'all' }
                ]
            },
            rangeslider: { autorange: true },
            type: 'date'
        },
        yaxis: {
            autorange: true,
            type: 'linear',
            title: {
                text: 'Discharge m3/s',
                font: {
                    family: 'Courier New, monospace',
                    size: 18,
                    color: '#7f7f7f'
                }
            }

        },

        autosize: true

    };
    ////////////////////////////////////////////////////////////////////////////////////////////////



    $('#myModal').on('shown.bs.modal', function (e) {

        const div = document.getElementById("myDiv2");

        //clear div
        while (div.hasChildNodes()) {
            div.removeChild(div.firstChild);
        }

        //vic
        Plotly.newPlot('myDiv2', datavic, layout);

        // Make plots responsives
        window.addEventListener('resize', function () {

            Plotly.Plots.resize(
                Plotly.d3.select("div[id='myDiv2']").node()
            );
        });

    });

    //vic
    $('#tab2').on('shown.bs.tab', function () {

        Plotly.Plots.resize(
            Plotly.d3.select("div[id='myDiv2']").node()
        );
    });

    //downloading data
    $("#btnDwn").click(function () {

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        var csv_name = info_[0] + '_' + mm + '_' + dd + '_' + yyyy + '.csv';

        let csvContent = "data:text/csv;charset=utf-8,";

        data_vic.forEach(function (rowObj) {

            let rowlist = [
                rowObj["_station_name"],
                rowObj["_data_date"],
                rowObj["_data_value_sim"],
                rowObj["_station_country"]
            ];

            let row = rowlist.join(",");
            csvContent += row + "\r\n";
        });

        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", csv_name);
        document.body.appendChild(link);
        link.click();

    });

}


function setModalFDCRES(data_fdc_res) {

    var info = data_fdc_res[0];

    var stn_info_fdcres =
        "<div style='position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);width: 100%;'>\
        <table id='infoTbl' class='table table-striped table-dark table-bordered' style='table-layout: fixed;width: 100%;'>\
            <tbody>\
            <tr class='table-dark'> <th colspan='3'> Study Sub-Catchment Discharge</th> </tr>\
        <tr>\
            <th>Units</th>\
            <th>m<sup>3</sup>/sec</th>\
            <th>Million m<sup>3</sup>/day</th>\
        </tr>\
        <tr>\
            <th>Reserve / Environmental Flow</th>" +
        "<td>" + info["reserve_sub_cat"] + "</td>" +
        "<td>" + info["reserve_sub_cat_2"] + "</td>" +
        "</tr>\
        <tr>\
            <th>Normal Flow</th>" +
        "<td>" + info["normal_flow_sub_cat"] + "</td>" +
        "<td>" + info["normal_flow_sub_cat_2"] + "</td>" +
        "</tr>\
        <tr>\
            <th>Flood Flow</th>" +
        "<td>" + info["flood_flow_sub_cat"] + "</td>" +
        "<td>" + info["flood_flow_sub_cat_2"] + "</td>" +
        "</tr>\
        <tr>\
            <th>Flood Discharge (Allocation)</th>" +
        "<td>" + info["flood_dis_sub_cat"] + "</td>" +
        "<td>" + info["flood_dis_sub_cat_2"] + "</td>" +
        "</tr>\
        </tbody>\
        </table>" +

        "<br>\
        <table id='infoTbl' class='table table-striped table-dark table-bordered' style='table-layout: fixed;width: 100%;'>\
            <tbody>\
            <tr class='table-info'> <th colspan='3'> Study Sub-Catchment - Spring Flow Conditions</th> </tr>\
        <tr>\
            <th>Units</th>\
            <th>m<sup>3</sup>/sec</th>\
            <th>Million m<sup>3</sup>/day</th>\
        </tr>\
        <tr>\
            <th>Reserve / Environmental Flow</th>" +
        "<td>" + info["reserve_spring"] + "</td>" +
        "<td>" + info["reserve_spring"] + "</td>" +
        "</tr>\
        <tr>\
            <th>Normal Flow (Domestic Use)</th>" +
        "<td>" + info["normal_dom_spring"] + "</td>" +
        "<td>" + info["normal_dom_spring"] + "</td>" +
        "</tr>\
        <tr>\
            <th>Flood Discharge (Commercial Allocation)</th>" +
        "<td>" + info["flow_comm_spring"] + "</td>" +
        "<td>" + info["flow_comm_spring"] + "</td>" +
        "</tr>\
            </tbody>\
            </table>\
            </div>";

    $('#myModal').on('shown.bs.modal', function (e) {

        //add station data
        const div = document.getElementById("myDiv4");

        //clear div
        while (div.hasChildNodes()) {
            div.removeChild(div.firstChild);
        }

        div.innerHTML = stn_info_fdcres;
    });

    //station fdcres
    $('#tab4').on('shown.bs.tab', function () {

        const div = document.getElementById("myDiv4");

        //clear div
        while (div.hasChildNodes()) {
            div.removeChild(div.firstChild);
        }

        div.innerHTML = stn_info_fdcres;

    });

}


function setModalFDC(data_fdc) {


    //fdc///////////////////////////////////////////////////////////////////////////////////////////
    var trace1_fdc = {

        name: 'Simulated Values (VIC)',
        type: "scatter",
        mode: "lines",
        line: { color: '#17BECF' },

        x: [],
        y: []
    };

    var trace2_fdc = {

        name: 'Observed Values',
        type: "scatter",
        mode: "lines",
        line: { color: '#7F7F7F' },

        x: [],
        y: []
    };

    data_fdc.forEach(function (val) {
        trace1_fdc.x.push(val["_prob_exc"]);
        trace1_fdc.y.push(val["_data_value_sim"]);
        trace2_fdc.x.push(val["_prob_exc"]);
        trace2_fdc.y.push(val["_data_value_obs"]);
    });

    var datafdc = [trace1_fdc, trace2_fdc];

    var layout = {

        title: 'Flow Duration Curve - Time Series',
        xaxis: {
            autorange: true,
            showline: true,
            title: {
                text: 'Probability of Exceedance',
                font: {
                    family: 'Courier New, monospace',
                    size: 18,
                    color: '#7f7f7f'
                }
            }
        },
        yaxis: {
            autorange: true,
            showline: true,
            title: {
                text: 'Flow (m3/s)',
                font: {
                    family: 'Courier New, monospace',
                    size: 18,
                    color: '#7f7f7f'
                }
            }

        },
        autosize: true

    };
    ////////////////////////////////////////////////////////////////////////////////////////////////

    $('#myModal').on('shown.bs.modal', function (e) {

        const div = document.getElementById("myDiv3");

        //clear div
        while (div.hasChildNodes()) {
            div.removeChild(div.firstChild);
        }

        //fdc
        Plotly.newPlot('myDiv3', datafdc, layout);

        // Make plots responsives
        window.addEventListener('resize', function () {

            Plotly.Plots.resize(
                Plotly.d3.select("div[id='myDiv3']").node()
            );
        });

    });

    $('#tab3').on('shown.bs.tab', function () {
        Plotly.Plots.resize(
            Plotly.d3.select("div[id='myDiv3']").node()
        );
    });

}




/* var hospitals = L.geoJSON(data, {
    pointToLayer: function(feature, latlng) {
        return L.marker(latlng, {
            icon: L.icon({
                iconUrl: 'images/hospital.png',
                iconSize: [24, 24],
                iconAnchor: [12, 12],
                opacity: 0.5
            })
        }).bindTooltip(
            feature.properties.hospital_name +
            '<br>' + feature.properties.city +
            '<br>' + feature.properties.zip_code
        )
    }
}).addTo(map) */
