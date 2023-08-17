<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#008080">
    <meta name="description" content="SERVIR E&SA - Streamflow Monitoring & Forecasting Tool">
    <meta name="author" content="Joseph Chemutt">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/MarkerCluster.Default.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/MarkerCluster.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-locatecontrol/0.73.0/L.Control.Locate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-groupedlayercontrol/0.6.1/leaflet.groupedlayercontrol.css">
    <link rel="stylesheet" href="{{URL::asset('res/css/app.css')}}">
    <link rel="stylesheet" href="{{URL::asset('res/css/modal.css')}}">

    <!-- https://favicon.io/favicon-converter/ -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{URL::asset('res/img/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{URL::asset('res/img/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('res/img/favicon-16x16.png')}}">
    <link rel="manifest" href="{{URL::asset('res/img/site.webmanifest')}}">
	
	<style>
	
	.panel-heading .accordion-toggle:after {
    /* symbol for "opening" panels */
    font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
    content: "\e114";    /* adjust as needed, taken from bootstrap.css */
    float: right;        /* adjust as needed */
    color: grey;         /* adjust as needed */
}
.panel-heading .accordion-toggle.collapsed:after {
    /* symbol for "collapsed" panels */
    content: "\e080";    /* adjust as needed, taken from bootstrap.css */
}

	
	
	</style>

    <title>Streamflow Monitoring & Forecasting Tool</title>

</head>

<body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="navbar-icon-container">
                    <a href="#" class="navbar-icon pull-right visible-xs" id="nav-btn"><i class="fa fa-bars fa-lg white"></i></a>
                    <a href="#" class="navbar-icon pull-right visible-xs" id="sidebar-toggle-btn"><i class="fa fa-search fa-lg white"></i></a>
                </div>


                <a class="navbar-brand" href="#">
                    <span>
                        <img src="{{URL::asset('res/img/android-chrome-192x192.png')}}" width="30" height="30">
                    </span>
                    <span style="color:#FFFFFF">Streamflow Monitoring & Forecasting Tool</span>
                </a>

            </div>
            <div class="navbar-collapse collapse">
                <form class="navbar-form navbar-right" role="search">
                    <div class="form-group has-feedback">
                        <input id="searchbox" type="text" placeholder="Search" class="form-control">
                        <span id="searchicon" class="fa fa-search form-control-feedback"></span>
                    </div>
                </form>
                <ul class="nav navbar-nav">
                    <li><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="about-btn"><i class="fa fa-question-circle white"></i>&nbsp;&nbsp;About</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" id="downloadDrop" href="#" role="button" data-toggle="dropdown"><i class="fa fa-cloud-download white"></i>&nbsp;&nbsp;Download <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{URL::asset('res/data/stations.geojson')}}" download="stations.geojson" target="_blank" data-toggle="collapse" data-target=".navbar-collapse.in"><i class="fa fa-download"></i>&nbsp;&nbsp;River Gauge Stations Data</a></li>
                        </ul>
                    </li>
                    <li class="hidden-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="list-btn"><i class="fa fa-list white"></i>&nbsp;&nbsp;POI List</a></li>
                </ul>
            </div>
            <!--/.navbar-collapse -->
        </div>
    </div>


    <div id="container">
        <div id="sidebar">
            <div class="sidebar-wrapper">
                <div class="panel panel-default" id="features">
                    <div class="panel-heading">
                        <h3 class="panel-title">River Gauge Stations
                            <button type="button" class="btn btn-xs btn-default pull-right" id="sidebar-hide-btn"><i class="fa fa-chevron-left"></i></button></h3>
                    </div>
                   
                    <div class="sidebar-table">
					
			
					  <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Wami Basin
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        <table class="table table-hover" id="feature-list-wami">
                            <thead class="hidden">
                                <tr>
                                    <th>Icon</th>
                                    <tr>
                                        <tr>
                                            <th>Name</th>
                                            <tr>
                                                <tr>
                                                    <th>Chevron</th>
                                                    <tr>
                            </thead>
                            <tbody class="list"></tbody>
                        </table>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          Rufuji Basin
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
       <table class="table table-hover" id="feature-list-rufiji">
                            <thead class="hidden">
                                <tr>
                                    <th>Icon</th>
                                    <tr>
                                        <tr>
                                            <th>Name</th>
                                            <tr>
                                                <tr>
                                                    <th>Chevron</th>
                                                    <tr>
                            </thead>
                            <tbody class="list"></tbody>
                        </table>
      </div>
    </div>
  </div>
  
  
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          Ruvu Basin
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
       <table class="table table-hover" id="feature-list-ruvu">
                            <thead class="hidden">
                                <tr>
                                    <th>Icon</th>
                                    <tr>
                                        <tr>
                                            <th>Name</th>
                                            <tr>
                                                <tr>
                                                    <th>Chevron</th>
                                                    <tr>
                            </thead>
                            <tbody class="list"></tbody>
                        </table>
      </div>
    </div>
  </div>

</div>
                      
						
						
						
						
                    </div>
                </div>
            </div>
        </div>
        <div id="map"></div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.7/handlebars.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/leaflet.markercluster.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-locatecontrol/0.73.0/L.Control.Locate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-groupedlayercontrol/0.6.1/leaflet.groupedlayercontrol.js"></script>
        <script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js'></script>


    </div>

    <div id="loading">
        <div class="loading-indicator">
            <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-info progress-bar-full"></div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="aboutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Welcome to the VIC Data Viewer</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs nav-justified" id="aboutTabs">
                        <li class="active"><a href="#about" data-toggle="tab"><i class="fa fa-question-circle"></i>&nbsp;About the tool</a></li>
                        <li><a href="#contact" data-toggle="tab"><i class="fa fa-envelope"></i>&nbsp;Contact us</a></li>
                        <li><a href="#disclaimer" data-toggle="tab"><i class="fa fa-exclamation-circle"></i>&nbsp;Disclaimer</a></li>
                    </ul>
                    <div class="tab-content" id="aboutTabsContent">
                        <div class="tab-pane fade active in" id="about">
                            <p>The <a href="https://vic.readthedocs.io/en/master/Overview/ModelOverview/" target="_blank">Variable Infiltration Capacity</a> (VIC) model (<a href="http://dx.doi.org/10.1029/94JD00483">Liang et al., 1994</a>) is a large-scale,
                                semi-distributed hydrologic model. As such, it shares several basic features with the other land surface models (LSMs) that are commonly coupled to global circulation models (GCMs). The model is run in Tanzania Wami/Ruvu
                                basin within various gauge stations. </p>
                            <div class="panel panel-primary">
                                <div class="panel-heading">Features</div>
                                <ul class="list-group">
                                    <li class="list-group-item">The land surface is modeled as a grid of large (>>1km), flat, uniform cells</li>
                                    <li class="list-group-item">Inputs are time series of sub-daily meteorological drivers (e.g. precipitation, air temperature, wind speed, radiation, etc.)</li>
                                    <li class="list-group-item">Land-atmosphere fluxes, and the water and energy balances at the land surface, are simulated at a daily or sub-daily time step</li>
                                    <li class="list-group-item">Water can only enter a grid cell via the atmosphere</li>
                                </ul>
                            </div>
                        </div>
                        <div id="disclaimer" class="tab-pane fade text-danger">
                            <p>The data provided on this site is for informational and planning purposes only.</p>
                            <p>Absolutely no accuracy or completeness guarantee is implied or intended. All information on this map is subject to such variations and corrections as might result from a complete title search and/or accurate field survey.</p>
                        </div>
                        <div class="tab-pane fade" id="contact">
                            <p> For more information kindly reach out to the Water Services Lead at <a href="https://rcmrd.org" target="_blank"> RCMRD </a>, Calvince Wara (cwara@rcmrd.org)</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="attributionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
                        Developed by <a href='https://servirglobal.net/Regions/ESAfrica'>SERVIR E&SA</a> and <a href='https://rcmrd.org'>RCMRD</a>
                    </h4>
                </div>
                <div class="modal-body">
                    <div id="attribution"></div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">River Gauge Station Details</h4>
                </div>

                <div class="modal-body">

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#1" data-toggle="tab" id='tab1'>Station Information</a>
                        </li>
                        <li>
                            <a href="#2" data-toggle="tab" id='tab2'>Simulated Streamflow</a>
                        </li>
                        <li>
                            <a href="#3" data-toggle="tab" id='tab3'>Flow Curve Duration</a>
                        </li>
                        <li>
                            <a href="#4" data-toggle="tab" id='tab4'>Resource Availability</a>
                        </li>
                        <li>
                            <a href="#5" data-toggle="tab" id='tab5'>Forecast Streamflow</a>
                        </li>
                    </ul>

                    <div class="tab-content ">
                        <div role="tabpanel" class="tab-pane active" id="1">
                            <div id="myDiv1" class="tab_div"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="2">
                            <div id="myDiv2" class="tab_div"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="3">
                            <div id="myDiv3" class="tab_div"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="4">
                            <div id="myDiv4" class="tab_div"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="5">
                            <div id="myDiv5" class="tab_div"></div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnDwn">Download Data</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>

        </div>
    </div>

    <script src="{{URL::asset('res/js/app.js')}}"></script>


</body>

</html>