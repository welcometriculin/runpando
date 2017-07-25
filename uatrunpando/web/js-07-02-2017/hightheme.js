$(function () {
  
	
	// Load the fonts
Highcharts.createElement('link', {
   href: '//fonts.googleapis.com/css?family=Signika:400,700',
   rel: 'stylesheet',
   type: 'text/css'
}, null, document.getElementsByTagName('head')[0]);

// Add the background image to the container
Highcharts.wrap(Highcharts.Chart.prototype, 'getContainer', function (proceed) {
   proceed.call(this);
   this.container.style.background = 'none';
});


Highcharts.DistanceTheme = {
   colors: ["#f9672c", "#8085e9", "#8d4654", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
   chart: {
      backgroundColor: null,
      style: {
         fontFamily: "Open Sans"
      }
   },
   title: {
      style: {
         color: 'black',
         fontSize: '16px',
         fontWeight: 'bold'
      }
   },
   subtitle: {
      style: {
         color: 'black'
      }
   },
   tooltip: {
      borderWidth: 0
   },
   legend: {
      itemStyle: {
         fontWeight: 'bold',
         fontSize: '13px'
      }
   },
   xAxis: {
      labels: {
         style: {
            color: '#ffffff'
         }
      }
   },
   yAxis: {
      labels: {
         style: {
            color: '#ffffff'
         }
      },
      min: 0, 
   },
   plotOptions: {
      series: {
         shadow: true
      },
      candlestick: {
         lineColor: '#404048'
      },
      map: {
         shadow: false
      }
   },

   // Highstock specific
   navigator: {
      xAxis: {
         gridLineColor: '#D0D0D8'
      }
   },
   rangeSelector: {
      buttonTheme: {
         fill: 'white',
         stroke: '#C0C0C8',
         'stroke-width': 0,
         states: {
            select: {
               fill: '#D0D0D8'
            }
         }
      }
   },
   scrollbar: {
      trackBorderColor: '#C0C0C8'
   },

   // General
   background2: null

};

// Apply the theme


// Distance
Highcharts.setOptions(Highcharts.DistanceTheme);
	function renderDistanceChart(data)
	{
		
		 chart = new Highcharts.Chart({
		        chart: {
		            renderTo: 'distance',
		            		        },				
				title: {
					text: ''
				},
//				xAxis: {
//					type: 'datetime',
//				    minTickInterval: 3600*24*30*1000,//time in milliseconds
//				    minRange: 3600*24*30*1000,
//				    ordinal: false //this sets the fixed time formats 
//				},
				   xAxis: {
//			            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
//			                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					   type: 'datetime',
			            dateTimeLabelFormats: {
			                month: '%b'
			            }
			        },
				yAxis: {
					title: {
						text: ''
					}
				},
				dateTimeLabelFormats: {
		            month: '%Y'
		        },
		        legend: {
					enabled: false,
					itemStyle: {
		                color: 'white',
		                fontSize: "12px",
		                fontWeight: "normal",
		                fontFamily: "Open Sans"
		            },
		            symbolHeight: 9,
		            symbolWidth: 9,
		            itemHoverStyle: {
		            	color: '#fff'
		            }
				},
				plotOptions: {
					area: {
						events: {
		                    legendItemClick: function () {
		                       return false;
		                        //return false; // <== returning false will cancel the default action
		                    }
		                },
		            showInLegend: true,
						fillColor: {
							linearGradient: {
								x1: 0,
								y1: 0,
								x2: 0,
								y2: 1
							},
							stops: [
								[0, Highcharts.getOptions().colors[0]],
								[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							]
						},
						marker: {
							radius: 2
						},
						lineWidth: 1,
						states: {
							hover: {
								lineWidth: 1
							}
						},
						threshold: null
					}
				},

				series: [{
					type: 'area',
					name: 'Distance',
					data: [],
						
						
				}]
			});
	}
	
	function renderTotalCampainChart(id)
	{
		totalCampaigns = new Highcharts.Chart({
	        	chart: {
	        		renderTo: 'totalCampaigns',
	            },				
	            title: {
	            	text: ''
	            },
				yAxis: {
					title: {
						text: ''
					}
				},
				 xAxis: {
//			            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
//			                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					 type: 'datetime',
			            dateTimeLabelFormats: {
			                month: '%b'
			            }
			        },
				legend: {
					enabled: false,
					itemStyle: {
		                color: 'white',
		                fontSize: "12px",
		                fontWeight: "normal",
		                fontFamily: "Open Sans"
		            },
		            symbolHeight: 9,
		            symbolWidth: 9,
		            itemHoverStyle: {
		            	color: '#fff'
		            }
				},
				plotOptions: {
					area: {
						events: {
		                    legendItemClick: function () {
		                       return false;
		                        //return false; // <== returning false will cancel the default action
		                    }
		                },
						fillColor: {
							linearGradient: {
								x1: 0,
								y1: 0,
								x2: 0,
								y2: 1
							},
							stops: [
								[0, Highcharts.getOptions().colors[0]],
								[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							]
						},
						marker: {
							radius: 2
						},
						lineWidth: 1,
						states: {
							hover: {
								lineWidth: 1
							}
						},
						threshold: null
					}
				},

				series: [{
					type: 'area',
					name: 'Total Campaigns',
					data: []
				}]
			});
	}
//fgm campaigns chart
	function renderFgmCampainChart(id)
	{
		fgmCampaigns = new Highcharts.Chart({
	        	chart: {
	        		renderTo: 'FgmTotalCampaigns',
	            },				
	            title: {
	            	text: ''
	            },
				yAxis: {
					title: {
						text: ''
					}
				},
				 xAxis: {
//			            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
//			                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					 type: 'datetime',
			            dateTimeLabelFormats: {
			                month: '%b'
			            }
			        },
				legend: {
					enabled: false,
					itemStyle: {
		                color: 'white',
		                fontSize: "12px",
		                fontWeight: "normal",
		                fontFamily: "Open Sans"
		            },
		            symbolHeight: 9,
		            symbolWidth: 9,
		            itemHoverStyle: {
		            	color: '#fff'
		            }
				},
				plotOptions: {
					area: {
						events: {
		                    legendItemClick: function () {
		                       return false;
		                        //return false; // <== returning false will cancel the default action
		                    }
		                },
						fillColor: {
							linearGradient: {
								x1: 0,
								y1: 0,
								x2: 0,
								y2: 1
							},
							stops: [
								[0, Highcharts.getOptions().colors[0]],
								[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							]
						},
						marker: {
							radius: 2
						},
						lineWidth: 1,
						states: {
							hover: {
								lineWidth: 1
							}
						},
						threshold: null
					}
				},

				series: [{
					type: 'area',
					name: 'Group Meetings',
					data: []
				}]
			});
	}
//fhv campaigns chart
	function renderFhvCampainChart(id)
	{
		fhvCampaigns = new Highcharts.Chart({
	        	chart: {
	        		renderTo: 'FhvTotalCampaigns',
	            },				
	            title: {
	            	text: ''
	            },
				yAxis: {
					title: {
						text: ''
					}
				},
				 xAxis: {
//			            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
//			                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					 type: 'datetime',
			            dateTimeLabelFormats: {
			                month: '%b'
			            }
			        },
				legend: {
					enabled: false,
					itemStyle: {
		                color: 'white',
		                fontSize: "12px",
		                fontWeight: "normal",
		                fontFamily: "Open Sans"
		            },
		            symbolHeight: 9,
		            symbolWidth: 9,
		            itemHoverStyle: {
		            	color: '#fff'
		            }
				},
				plotOptions: {
					area: {
						events: {
		                    legendItemClick: function () {
		                       return false;
		                        //return false; // <== returning false will cancel the default action
		                    }
		                },
						fillColor: {
							linearGradient: {
								x1: 0,
								y1: 0,
								x2: 0,
								y2: 1
							},
							stops: [
								[0, Highcharts.getOptions().colors[0]],
								[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							]
						},
						marker: {
							radius: 2
						},
						lineWidth: 1,
						states: {
							hover: {
								lineWidth: 1
							}
						},
						threshold: null
					}
				},

				series: [{
					type: 'area',
					name: 'Farm and Home Visits',
					data: []
				}]
			});
	}
//mc campaigns chart
	function renderMcCampainChart(id)
	{
		mcCampaigns = new Highcharts.Chart({
	        	chart: {
	        		renderTo: 'McTotalCampaigns',
	            },				
	            title: {
	            	text: ''
	            },
				yAxis: {
					title: {
						text: ''
					}
				},
				 xAxis: {
//			            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
//			                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					 type: 'datetime',
			            dateTimeLabelFormats: {
			                month: '%b'
			            }
			        },
				legend: {
					enabled: false,
					itemStyle: {
		                color: 'white',
		                fontSize: "12px",
		                fontWeight: "normal",
		                fontFamily: "Open Sans"
		            },
		            symbolHeight: 9,
		            symbolWidth: 9,
		            itemHoverStyle: {
		            	color: '#fff'
		            }
				},
				plotOptions: {
					area: {
						events: {
		                    legendItemClick: function () {
		                       return false;
		                        //return false; // <== returning false will cancel the default action
		                    }
		                },
						fillColor: {
							linearGradient: {
								x1: 0,
								y1: 0,
								x2: 0,
								y2: 1
							},
							stops: [
								[0, Highcharts.getOptions().colors[0]],
								[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							]
						},
						marker: {
							radius: 2
						},
						lineWidth: 1,
						states: {
							hover: {
								lineWidth: 1
							}
						},
						threshold: null
					}
				},

				series: [{
					type: 'area',
					name: 'Mass Campaigns',
					data: []
				}]
			});
	}
//demo campaigns chart
	function renderDemoCampainChart(id)
	{
		demoCampaigns = new Highcharts.Chart({
	        	chart: {
	        		renderTo: 'DemoTotalCampaigns',
	            },				
	            title: {
	            	text: null
	            },
				yAxis: {
					title: {
						text: ''
					}
				},
				 xAxis: {
//			            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
//			                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					 type: 'datetime',
			            dateTimeLabelFormats: {
			                month: '%b'
			            }
			        },
				legend: {
					enabled: false,
					itemStyle: {
		                color: 'white',
		                fontSize: "12px",
		                fontWeight: "normal",
		                fontFamily: "Open Sans"
		            },
		            symbolHeight: 9,
		            symbolWidth: 9,
		            itemHoverStyle: {
		            	color: '#fff'
		            }
				},
				plotOptions: {
					area: {
						events: {
		                    legendItemClick: function () {
		                       return false;
		                        //return false; // <== returning false will cancel the default action
		                    }
		                },
						fillColor: {
							linearGradient: {
								x1: 0,
								y1: 0,
								x2: 0,
								y2: 1
							},
							stops: [
								[0, Highcharts.getOptions().colors[0]],
								[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							]
						},
						marker: {
							radius: 2
						},
						lineWidth: 1,
						states: {
							hover: {
								lineWidth: 1
							}
						},
						threshold: null
					}
				},

				series: [{
					type: 'area',
					name: 'Demonstrations',
					data: []
				}]
			});
	}
	renderTotalCampainChart('#totalCampaigns');
	renderFgmCampainChart('#FgmTotalCampaigns');
	renderFhvCampainChart('#FhvTotalCampaigns');
	renderMcCampainChart('#McTotalCampaigns');
	renderDemoCampainChart('#DemoTotalCampaigns');
	renderDistanceChart();
	$('svg>text:last-child').remove()
	  //$.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=usdeur.json&callback=?', renderDistanceChart);
});


