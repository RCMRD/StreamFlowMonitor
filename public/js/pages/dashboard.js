//[Dashboard Javascript]

//Project:	BonitoPro Admin - Responsive Admin Template
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

  'use strict';
	
  // jvectormap data
  var visitorsData = {
    US: 398, // USA
    SA: 400, // Saudi Arabia
    CA: 1000, // Canada
    DE: 500, // Germany
    FR: 760, // France
    CN: 300, // China
    AU: 700, // Australia
    BR: 600, // Brazil
    IN: 800, // India
    GB: 320, // Great Britain
    RU: 2000 // Russia
  };
  

  // Sparkline charts
  var myvalues = [1300, 500, 1920, 927, 831, 1127, 719, 1930, 1221];
  $('#sparkline-1').sparkline(myvalues, {
    type     : 'line',
    lineColor: '#ef483e',
    fillColor: '#ef483e',
    height   : '50',
    width    : '70'
  });
  myvalues = [715, 319, 620, 342, 662, 990, 730, 467, 559, 340, 881];
  $('#sparkline-2').sparkline(myvalues, {
    type     : 'line',
    lineColor: '#ef483e',
    fillColor: '#ef483e',
    height   : '50',
    width    : '70'
  });
  myvalues = [88, 49, 22,35, 45, 72, 11, 55, 25, 19, 27];
  $('#sparkline-3').sparkline(myvalues, {
    type     : 'line',
    lineColor: '#ef483e',
    fillColor: '#ef483e',
    height   : '50',
    width    : '70'
  });
	
  // -----------------
  // - SPARKLINE BAR -
  // -----------------
  $('.sparkbar').each(function () {
    var $this = $(this);
    $this.sparkline('html', {
      type    : 'bar',
      height  : $this.data('height') ? $this.data('height') : '30',
      barColor: $this.data('color')
    });
  });

  /* jQueryKnob */
  $('.knob').knob();	

  /*
     * BAR CHART
     * ---------
     */

    var bar_data = {
	data : [['2013', 18], ['2014', 8], ['2015', 15], ['2016', 20], ['2017', 11], ['2018', 3], ['2019', 18], ['2020', 8]],
      color: '#ba69aa', borderWidth:'0.1'
    }
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
        bars: {
          show    : true,
          barWidth: 0.8,
		  lineWidth: 0,
		  fillColor:'#ba69aa',
          align   : 'center',
        }
      },
      xaxis : {
        mode      : 'categories',
        tickLength: 0
      }
    })
    /* END BAR CHART */


}); // End of use strict

