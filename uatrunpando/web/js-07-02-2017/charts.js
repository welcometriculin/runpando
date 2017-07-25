 // COLOR SET
var _colorConstants = {WHITE: "#fff"}
$(function () {

				
});
 
 
 $(function (global) {
     CanvasJS.addColorSet("pando",
             [//colorSet Array
             "#279dcf",
             "#93c64f",
             "#ff9414",
             "#ac70e1",
             "#fc6d34"                
             ]);
		CanvasJS.addColorSet("plan",
             [//colorSet Array
				// Adhoc
             "#ff9414",
				// Planned
				"#93C64F",
             ]);
	 var VillageActivity = new CanvasJS.Chart("villageActivity",
			    {
			       title:{
			         text: "",
			         fontWeight: 'normal',
					 fontFamily: "Open Sans",
					 fontColor: _colorConstants.WHITE,
					 fontSize: 14		
			       },
				  	height :0 ,
				  //	dataPointWidth : 30,
					colorSet: "pando",
					animationEnabled: false,				   
			       axisX: {
			        labelFontColor: "white",
			       // labelFontSize: 10,
			        interval:1,
			        labelFontFamily: "'Open Sans', sans-serif",
					 labelFontWeight: "normal"
			        },
			      axisY:{
				    gridThickness: 0,
			        labelFontColor: "white",
			       // labelFontSize: 10,
			        interval: 100
			      },
			      
			      legend: {
			        verticalAlign: "bottom",
					fontSize : 10,
					fontFamily: "Open Sans",
					fontColor: "white"
			      },
			      responsive: true,
			      maintainAspectRatio: false,
			      data: []
			    });
			VillageActivity.render();
			global.VillageActivity = VillageActivity; 
			//build  completed
			var BuildCompleted = new CanvasJS.Chart("buildCompleted",
				    {
						theme: "theme1",
						colorSet: "plan",
						animationEnabled: true,
						legend:{
				        verticalAlign: "bottom",
				        horizontalAlign: "center",
						fontColor: "white"
				      },
					   width:0,
					   legend: {
					        horizontalAlign: "right",
					        verticalAlign: "center"
					      },
					  // height:150,
					   title:{
				         text: "",
						 fontFamily: "Open Sans",
						 fontColor: _colorConstants.WHITE,
						 fontSize: 13
				       },
				      data: [
				      {
					  indexLabelFontColor: "white",
				       type: "pie",
				       showInLegend: false,
				       dataPoints: [
				    
				        ]
				     }
				     ]
				   });

					 BuildCompleted.render();
					 global.BuildCompleted = BuildCompleted; 
			 //build not completed
						var BuildNotCompleted = new CanvasJS.Chart("buildNotCompleted",
							    {
									theme: "theme1",
									colorSet: "plan",
									animationEnabled: true,
									legend:{
							        verticalAlign: "bottom",
							        horizontalAlign: "center",
									fontColor: "white"
							      },
								   width:0,
								  // height:150,
								   title:{
							         text: "",
									 fontFamily: "Open Sans",
									 fontColor: _colorConstants.WHITE,
									 fontSize: 13
							       },
							      data: [
							      {
								  indexLabelFontColor: "white",
							       type: "pie",
							       dataPoints: [
							    
							        ]
							     }
							     ]
							   });

				 BuildNotCompleted.render();
				 global.BuildNotCompleted = BuildNotCompleted; 
				 // assigned completes
				 var AssignedCompleted = new CanvasJS.Chart("assignedCompleted",
						    {
						      theme: "theme1",
								colorSet: "plan",
								animationEnabled: true,
							   width:0,
							  // height:150,
							   title:{
						         text: "",
								 fontFamily: "Open Sans",
								 fontColor: _colorConstants.WHITE,
								 fontSize: 13
						       },
						      data: [
						      {
							  indexLabelFontColor: "white",
						       type: "pie",
						       dataPoints: []
						     }
						     ]
						   });

				AssignedCompleted.render();
				global.AssignedCompleted = AssignedCompleted;
				
			// assigned notcompleted
				var AssignedNotCompleted = new CanvasJS.Chart("assignedNotCompleted",
					    {
							theme: "theme1",
							colorSet: "plan",
							animationEnabled: true,
							legend:{
					        verticalAlign: "bottom",
					        horizontalAlign: "center",
							fontColor: "white"
					      },
						   width:0,
						  // height:150,
						   title:{
					         text: "",
							 fontFamily: "Open Sans",
							 fontColor: _colorConstants.WHITE,
							 fontSize: 13
					       },
					      data: [
					      {
						  indexLabelFontColor: "white",
					       type: "pie",
					       dataPoints: [
					    
					        ]
					     }
					     ]
					   });
					AssignedNotCompleted.render();	
					global.AssignedNotCompleted = AssignedNotCompleted; 
			//all crops graph
			var AllCrops = new CanvasJS.Chart("allCrops",
				    {
					   title:{
				         text: "",
				         fontWeight: 'normal',
						 fontFamily: "Open Sans",
						 fontColor: _colorConstants.WHITE,
						 fontSize: 14		
				       },
				       
						dataPointWidth : 35,
						colorSet: "pando",
						animationEnabled: true,
						
						axisX: {
				        labelFontColor: "white",
				         //labelFontSize: 10,
				        interval:1,
				        labelFontFamily: "'Open Sans', sans-serif",
						 labelFontWeight: "normal"
				        },
				      axisY:{
						gridThickness: 0,
				        labelFontColor: "white",
				        //labelFontSize: 10,
				        interval: 100
				      },
					  
				      legend: {
				        verticalAlign: "bottom",
						fontFamily: "Open Sans",
						fontColor: "white",
						fontSize: 10
						 
				      },
				       data: []
				    });
			AllCrops.render();
			global.AllCrops = AllCrops; 
			
			//all products
			var AllProducts = new CanvasJS.Chart("allProducts",
				    {
					colorSet: "pando",
					// width:310,
					//height :240 ,
					dataPointWidth : 35,
					animationEnabled: true,
					   title:{
				         text: "",
				         fontWeight: 'normal',
						 fontFamily: "Open Sans",
						 fontColor: _colorConstants.WHITE,
						fontSize: 14		
				       },
					   axisX: {
				        labelFontColor: "white",
					   // labelFontSize: 10,
						 interval:1,
						 labelFontFamily: "'Open Sans', sans-serif",
						 labelFontWeight: "normal"
				        },
				      axisY:{
					   gridThickness: 0,
				        labelFontColor: "white",
				       // labelFontSize: 10,
				        interval: 100,
				        fontFamily: "Open Sans",
						fontWeight: "normal"
				      },
					  legend:{
					  fontColor: "white",
					  fontSize: 10,
					  fontFamily: "Open Sans"
					  },
					  
				dataPointMaxWidth: 40,
				      data: []
				    });
			AllProducts.render();
			global.AllProducts = AllProducts;
			
//farmGroupProducts graphs
			var farmGroupProducts = new CanvasJS.Chart("farmGroupProducts",
				{
					theme: "theme1",
					// width:333,
					//height : 300,
					colorSet: "pando",
					 title:{
						 text: "",
						 fontFamily: "Open Sans",
						 fontWeight: "normal",
					 fontColor: _colorConstants.WHITE,
					 fontSize: 14
					 },
					 legend: {
			        verticalAlign: "bottom",
					fontSize : 12,
					fontFamily: "Open Sans",
					fontColor: "white"
			      },
					
					animationEnabled: true,
					data: [
					{
					indexLabelFontColor: "white",
						type: "doughnut",
						showInLegend: true,
						legendMarkerType: "square",
						//legendText: "{indexLabel}",
						dataPoints: []
					}
					]
				});
			farmGroupProducts.render();
			global.farmGroupProducts = farmGroupProducts; 
//farmHomeProducts graphs
			var farmHomeProducts = new CanvasJS.Chart("farmHomeProducts",
				{
					theme: "theme1",
					//width:333,
					//height : 300,
					colorSet: "pando",
					 title:{
						 text: "",
						 fontFamily: "Open Sans",
						 fontWeight: "normal",
					 fontColor: _colorConstants.WHITE,
					 fontSize: 14
					 },
					 legend: {
			        verticalAlign: "bottom",
					fontSize : 12,
					fontFamily: "Open Sans",
					fontColor: "white"
			      },
					
					animationEnabled: true,
					data: [
					{
					indexLabelFontColor: "white",
						type: "doughnut",
						showInLegend: true,
						legendMarkerType: "square",
						//legendText: "{indexLabel}",
						dataPoints: []
					}
					]
				});
			farmHomeProducts.render();
			global.farmHomeProducts = farmHomeProducts;
//mcProducts graphs
			var mcProducts = new CanvasJS.Chart("mcProducts",
				{
					theme: "theme1",
				//	width:333,
					//height : 300,
					colorSet: "pando",
					 title:{
						 text: "",
						 fontFamily: "Open Sans",
						 fontWeight: "normal",
					 fontColor: _colorConstants.WHITE,
					 fontSize: 14
					 },
					 legend: {
			        verticalAlign: "bottom",
					fontSize : 12,
					fontFamily: "Open Sans",
					fontColor: "white"
			      },
					
					animationEnabled: true,
					data: [
					{
					indexLabelFontColor: "white",
						type: "doughnut",
						showInLegend: true,
						legendMarkerType: "square",
						//legendText: "{indexLabel}",
						dataPoints: []
					}
					]
				});
			mcProducts.render();
			global.mcProducts = mcProducts;
//demoProducts graphs
			var DemoProducts = new CanvasJS.Chart("DemoProducts",
				{
					theme: "theme1",
					//width:333,
					//height : 300,
					colorSet: "pando",
					 title:{
						 text: "",
						 fontFamily: "Open Sans",
						 fontWeight: "normal",
					 fontColor: _colorConstants.WHITE,
					 fontSize: 14
					 },
					 legend: {
			        verticalAlign: "bottom",
					fontSize : 12,
					fontFamily: "Open Sans",
					fontColor: "white"
			      },
					
					animationEnabled: true,
					data: [
					{
					indexLabelFontColor: "white",
						type: "doughnut",
						showInLegend: true,
						legendMarkerType: "square",
						//legendText: "{indexLabel}",
						dataPoints: []
					}
					]
				});
			DemoProducts.render();
			global.DemoProducts = DemoProducts;
	 // DISTANCE
  // renderDistanceGraph();
  
// PLAN SUMMARY
	//Build and Completed
	renderBuildCompleted();
	
	//Build and not Completed
	renderBuildNotCompleted();
	
	//Assigned and completed
	renderAssignedCompleted();
	
	//Assigned and not completed
	renderAssignedNotCompleted();
	
	
	
	
// ALL TOTAL CAMPAIGNS
 // renderAllTotalCampaigns();
   
// ALL CROPS
renderAllCropsGraph();
	
// ALL Products
renderAllProductsGraph();

// FARM GROUP MEETING CROPS
// renderFGMCropsGraph();

	
	// FARM GROUP MEETING PRODUCTS
renderFGMProductsGraph();

	// FGM TOTAL CAMPAIGNS
  renderFGMTotalCampaigns();
  
  // VILLAGE ACTIVITY
renderFGMTotalCampaigns();

   
}(this));



 // DISTANCE GRAPH
function renderDistanceGraph()
{
var chart = new CanvasJS.Chart("distance",
    {
      theme: "theme1",
      title:{
        text: "Total Distance Travelled(kms)   1840",
		horizontalAlign: "right",
		fontColor: "#ffb685",
		fontWeight: 300,
		fontSize: 20
      },
	  subtitles:[
		{
			text: "Monthly Distance(kms)     237",
			horizontalAlign: "right",
			fontColor: "#ffb685",
		fontWeight: 300,
		fontSize: 20
		}
		],
	  animationEnabled: true,
      axisX: {
        valueFormatString: "MMM",
        interval:1,
        intervalType: "month",
		labelFontColor: "white",
		lineThickness: 0
		
      },
      axisY:{
        includeZero: false,
		  gridThickness: 0.5,
		  labelFontColor: "white",
		  lineThickness: 0
       },
	  
      data: [
	  {        
        type: "area",
		color: "rgba(251,101,48,0.6)",
		//lineThickness: 3,        
        dataPoints: [
        { x: new Date(2012, 00, 1), y: 450 },
        { x: new Date(2012, 01, 1), y: 414 },
        { x: new Date(2012, 02, 1), y: 520 },
        { x: new Date(2012, 03, 1), y: 460 },
        { x: new Date(2012, 04, 1), y: 450 },
        { x: new Date(2012, 05, 1), y: 500 },
        { x: new Date(2012, 06, 1), y: 480 },
        { x: new Date(2012, 07, 1), y: 480 },
        { x: new Date(2012, 08, 1), y: 410 },
        { x: new Date(2012, 09, 1), y: 500 },
        { x: new Date(2012, 10, 1), y: 480 },
        { x: new Date(2012, 11, 1), y: 510 }
        
        ]
      }

      ]
    });
chart.render();
}

// PLAN SUMMARY GRAPH

	//Build and Completed
	function renderBuildCompleted()
	{
	 
	}

	//Build and Not Completed
	function renderBuildNotCompleted()
	{
	
	}
	//Assigned and Completed
	function renderAssignedCompleted()
	{
	
	}
	
	//Assigned and Not Completed
	function renderAssignedNotCompleted()
	{
	
	}
	
	
	// ALL TOTAL CAMPAIGNS GRAPH
function renderAllTotalCampaigns()
{
	 var chart = new CanvasJS.Chart("totalCampaigns",
    {
      theme: "theme1",
	  height : 300,
	   
      title:{
        text: "Total Campaigns",
		fontFamily: "Open Sans",
		fontColor: _colorConstants.WHITE,
		fontSize: 18
      },
      animationEnabled: true,
      axisX: {
        valueFormatString: "MMM",
        interval:1,
        intervalType: "month",
		labelFontColor: "white",
		lineThickness: 0
        
      },
      axisY:{
        includeZero: false,
			gridThickness: 0.5,
			labelFontColor: "white",
			lineThickness: 0
      },
      data: [
      {        
        type: "area",
		color: "rgba(251,101,48,0.6)",
        //lineThickness: 3,        
        dataPoints: [
        { x: new Date(2012, 00, 1), y: 450 },
        { x: new Date(2012, 01, 1), y: 414},
        { x: new Date(2012, 02, 1), y: 520},
        { x: new Date(2012, 03, 1), y: 460 },
        { x: new Date(2012, 04, 1), y: 450 },
        { x: new Date(2012, 05, 1), y: 500 },
        { x: new Date(2012, 06, 1), y: 480 },
        { x: new Date(2012, 07, 1), y: 480 },
        { x: new Date(2012, 08, 1), y: 410 },
        { x: new Date(2012, 09, 1), y: 500 },
        { x: new Date(2012, 10, 1), y: 480 },
        { x: new Date(2012, 11, 1), y: 510 }
        
        ]
      }
      ]
    });

chart.render();
}

// ALL CROPS GRAPH
function renderAllCropsGraph()
{
	
	AllCrops.render();
	
}

// ALL PRODUCTS GRAPH
function renderAllProductsGraph()
{

}

// FGM TOTAL CAMPAIGNS GRAPH

function renderFGMTotalCampaigns(){

var chart = new CanvasJS.Chart("FgmTotalCampaigns",
    {
      theme: "theme1",
	  height : 300,
      title:{
        text: "Total Campaigns",
		fontFamily: "Open Sans",
		fontColor: _colorConstants.WHITE,
		fontSize: 18
      },
      animationEnabled: true,
      axisX: {
        valueFormatString: "MMM",
        interval:1,
        intervalType: "month"
        
      },
      axisY:{
        includeZero: false
        
      },
      data: [
      {        
        type: "line",
        //lineThickness: 3,        
        dataPoints: [
        { x: new Date(2012, 00, 1), y: 450 },
        { x: new Date(2012, 01, 1), y: 414},
        { x: new Date(2012, 02, 1), y: 520, indexLabel: "highest",markerColor: "red", markerType: "triangle"},
        { x: new Date(2012, 03, 1), y: 460 },
        { x: new Date(2012, 04, 1), y: 450 },
        { x: new Date(2012, 05, 1), y: 500 },
        { x: new Date(2012, 06, 1), y: 480 },
        { x: new Date(2012, 07, 1), y: 480 },
        { x: new Date(2012, 08, 1), y: 410 , indexLabel: "lowest",markerColor: "red", markerType: "cross"},
        { x: new Date(2012, 09, 1), y: 500 },
        { x: new Date(2012, 10, 1), y: 480 },
        { x: new Date(2012, 11, 1), y: 510 }
        
        ]
      }
      
      
      ]
    });

chart.render();
}

// FGM CROPS GRAPH

function renderFGMCropsGraph()
{
var chart = new CanvasJS.Chart("farmGroupCrops",
    {
height : 300,
colorSet: "pando",
axisY:{
          gridThickness: 0
       },
	// title:{
       // text: "Crops",
	   // fontFamily: "Open Sans",
		// fontColor: _colorConstants.WHITE,
		// fontSize: 18
      // },
	  
	  data: [
      {
	  type: "bubble",
     dataPoints: [
     { x: 78.1, y: 2.00, z:306.77, name: "Cotton" },
     { x: 68.5, y: 2.15, z: 237.414, name: "Paddy"},
     { x: 72.5, y: 3.00, z: 400.24, name: "Turmeric"},
     { x: 80.5, y: 4.86, z: 193.24, name: "Lemon"},
     ]
   }
   ]
 });

    chart.render();
}

// FGM PRODUCTS GRAPH

function renderFGMProductsGraph()
{
var isCanvasSupported = !!document.createElement("canvas").getContext;

	
}

// VILLAGE ACTIVITY GRAPH

	
