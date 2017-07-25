 // COLOR SET
var _colorConstants = {PURPLE: "#42296d"}
$(function () {
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
                "#eb6060",
				"#5cd2a7",
                ]);
				
});
 
 
 $(function (global) {
	 // DISTANCE travelled Graph
	 var distanceTravelled = new CanvasJS.Chart("distance", {
		theme : "theme1",
		title : {
			text : "Total Distance Travelled(kms)",
			fontColor : _colorConstants.PURPLE
		},
		animationEnabled : true,
		axisX : {
			valueFormatString : "MMM",
			interval : 1,
			intervalType : "month"

		},
		axisY : {
			includeZero : false,
			gridThickness : 0
		},

		data : [ {
			type : "line",
			// lineThickness: 3,
			dataPoints : [ ]
		}

		]
	});
	distanceTravelled.render();
	global.distanceTravelled = distanceTravelled; 
	
	// Build and Completed
	var bulidCompleted = new CanvasJS.Chart("buildCompleted",
		    {
				theme: "theme1",
				colorSet: "plan",
				animationEnabled: true,
				legend:{
		        verticalAlign: "bottom",
		        horizontalAlign: "center"
		      },
			  
			  title:{
		        text: "Build and Completed",
				fontFamily: "Open Sans",
				fontColor: _colorConstants.PURPLE,
				fontSize: 20
		      },
		      data: [
		      {
		       type: "doughnut",
		       dataPoints: [
		       {  y: 40.0, indexLabel: "Adhoc" },
		       {  y: 60.0, indexLabel: "Planned" }
		        ]
		     }
		     ]
	});
	bulidCompleted.render();
	global.bulidCompleted = bulidCompleted; 
    //console.log(chart)
  
// PLAN SUMMARY
	// Build and Completed
	renderBuildCompleted();
	
	// Build and not Completed
	renderBuildNotCompleted();
	
	// Assigned and completed
	renderAssignedCompleted();
	
	// Assigned and not completed
	renderAssignedNotCompleted();
	
	
	
	
// ALL TOTAL CAMPAIGNS
  renderAllTotalCampaigns();
   
// ALL CROPS
renderAllCropsGraph();
	
// ALL Products
renderAllProductsGraph();

// FARM GROUP MEETING CROPS
renderFGMCropsGraph();

	
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

}

// PLAN SUMMARY GRAPH

	//Build and Completed
	function renderBuildCompleted()
	{
	 

	}

	//Build and Not Completed
	function renderBuildNotCompleted()
	{
	 var chart = new CanvasJS.Chart("buildNotCompleted",
    {
      theme: "theme1",
		colorSet: "plan",
		animationEnabled: true,
	  
	  title:{
        text: "Build and Not Completed",
		fontFamily: "Open Sans",
		fontColor: _colorConstants.PURPLE,
		fontSize: 20
      },
      data: [
      {
       type: "doughnut",
       dataPoints: [
       {  y: 80.0, indexLabel: "Adhoc" },
       {  y: 20.0, indexLabel: "Planned" }
       ]
     }
     ]
   });

    chart.render();
	}
	//Assigned and Completed
	function renderAssignedCompleted()
	{
	 var chart = new CanvasJS.Chart("assignedCompleted",
    {
      theme: "theme1",
		colorSet: "plan",
		animationEnabled: true,
	  
	  title:{
        text: "Assigned and Completed",
		fontFamily: "Open Sans",
		fontColor: _colorConstants.PURPLE,
		fontSize: 20
      },
      data: [
      {
       type: "doughnut",
       dataPoints: [
       {  y: 60.0, indexLabel: "Adhoc" },
       {  y: 40.0, indexLabel: "Planned" }
       ]
     }
     ]
   });

    chart.render();
	}
	
	//Assigned and Not Completed
	function renderAssignedNotCompleted()
	{
	 var chart = new CanvasJS.Chart("assignedNotCompleted",
    {
      	  theme: "theme1",
		colorSet: "plan",
		animationEnabled: true,
		
	  title:{
        text: "Assigned and Not Completed",
		fontFamily: "Open Sans",
		fontColor: _colorConstants.PURPLE,
		fontSize: 20
      },
      data: [
      {
       type: "doughnut",
       dataPoints: [
       {  y: 23.0, indexLabel: "Adhoc" },
       {  y: 77.0, indexLabel: "Planned" }
       ]
     }
     ]
   });

    chart.render();
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
		fontColor: _colorConstants.PURPLE,
		fontSize: 20
      },
      animationEnabled: true,
      axisX: {
        valueFormatString: "MMM",
        interval:1,
        intervalType: "month"
        
      },
      axisY:{
        includeZero: false,
			gridThickness: 0
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

// ALL CROPS GRAPH
function renderAllCropsGraph()
{
// var chart = new CanvasJS.Chart("allCrops",
    // {
		// theme: "theme1",
		// height : 300,
		// colorSet: "pando",
		// animationEnabled: true,
		// axisY:{
          // gridThickness: 0
       // },
	 // title:{
      // text: "Crops",
	  // fontFamily: "Open Sans",
		// fontColor: _colorConstants.PURPLE,
		// fontSize: 20
      // },
	// dataPointMaxWidth: 40,
      // data: [
      // {
        // type: "stackedColumn",
        // dataPoints: [
        // {  y: 111338 , label: "Cotton"},
        // {  y: 49088, label: "Paddy" },
        // {  y: 62200, label: "Turmeric" },
        // {  y: 90085, label: "Lemon" },
        // {  y: 38600, label: "Others"}
        
        // ]
      // },  {
        // type: "stackedColumn",
         // dataPoints: [
        // {  y: 135305 , label: "Cotton"},
        // {  y: 107922, label: "Paddy" },
        // {  y: 52300, label: "Turmeric" },
        // {  y: 3360, label: "Lemon" },
        // {  y: 39900, label: "Others"}
        // ]
      // },
	  // {
        // type: "stackedColumn",
        // dataPoints: [
        // {  y: 111338 , label: "Cotton"},
        // {  y: 49088, label: "Paddy" },
        // {  y: 62200, label: "Turmeric" },
        // {  y: 90085, label: "Lemon" },
        // {  y: 38600, label: "Others"}

        // ]
      // },  {
        // type: "stackedColumn",
         // dataPoints: [
        // {  y: 135305 , label: "Cotton"},
        // {  y: 107922, label: "Paddy" },
        // {  y: 52300, label: "Turmeric" },
        // {  y: 3360, label: "Lemon" },
        // {  y: 39900, label: "Others"}

        // ]
      // }
     
	 // ]
    // });

    // chart.render();
	
	var chart = new CanvasJS.Chart("allCrops",
    {
      title:{
        text: "Crops",
		fontFamily: "Open Sans",
		fontColor: _colorConstants.PURPLE,
		fontSize: 20		
      },
	  height : 300,
		colorSet: "pando",
		animationEnabled: true,
		axisY:{
          gridThickness: 0
       },
      // axisY2: {
        // title:"Production (bbl/day)"
      // },
      
      legend: {
        verticalAlign: "bottom",
		fontSize : 10,
		fontFamily: "Open Sans"
      },
      data: [

      {        
        type: "column",  
        showInLegend: true, 
        legendText: "FGM",
        dataPoints: [      
        { x: 10, y: 10,  label: "Cotton" },
        { x: 20, y: 20,  label: "Paddy"},
        { x: 30, y: 30,  label: "Turmeric"},
        { x: 40, y: 20,  label: "Lemon"},
        { x: 50, y: 10,  label: "Others"},
        
        ]
      },
      {        
        type: "column",  
        showInLegend: true,
        legendText: "FHV",
        dataPoints: [      
        { x: 10, y:10, label: "Cotton" },
        { x: 20, y:5, label: "Paddy"},
        { x: 30, y:80 , label: "Turmeric"},
        { x: 40, y:60 , label: "Lemon"},
        { x: 50, y:40 , label: "Others"},
        
        ]
      }
	  ,
      {        
        type: "column",  
        showInLegend: true,
        legendText: "MC",
        dataPoints: [      
        { x: 10, y:60, label: "Cotton" },
        { x: 20, y:80, label: "Paddy"},
        { x: 30, y:15 , label: "Turmeric"},
        { x: 40, y:10 , label: "Lemon"},
        { x: 50, y:20 , label: "Others"},
        
        ]
      }
	  ,
      {        
        type: "column",  
        showInLegend: true,
        legendText: "DEMO",
        dataPoints: [      
        { x: 10, y:30, label: "Cotton" },
        { x: 20, y:25, label: "Paddy"},
        { x: 30, y:80 , label: "Turmeric"},
        { x: 40, y:65 , label: "Lemon"},
        { x: 50, y:35 , label: "Others"},
        
        ]
      }

      ]
    });

chart.render();
	
}

// ALL PRODUCTS GRAPH
function renderAllProductsGraph()
{
var chart = new CanvasJS.Chart("allProducts",
    {
	height : 300,
	colorSet: "pando",
	animationEnabled: true,
	axisY:{
          gridThickness: 0
       },
      title:{
      text: "Products",
	  fontFamily: "Open Sans",
		fontColor: _colorConstants.PURPLE,
		fontSize: 20
      },
	  
dataPointMaxWidth: 40,
      data: [
      {
        type: "column",
		showInLegend: true, 
        legendText: "FGM",
        dataPoints: [
        {  y: 40 , label: "Product1"},
        {  y: 55, label: "Product2" },
        {  y: 105, label: "Product3" },
        {  y: 90, label: "Product4" },
        {  y: 20, label: "Others"}
       

        ]
      },  {
        type: "column",
		showInLegend: true, 
        legendText: "FHV",
         dataPoints: [
        {  y: 45 , label: "Product1"},
        {  y: 90, label: "Product2" },
        {  y: 65, label: "Product3" },
        {  y: 35, label: "Product4" },
        {  y: 80, label: "Others"}
        
        ]
      },
	  {
        type: "column",
		showInLegend: true, 
        legendText: "MC",
        dataPoints: [
        {  y: 50 , label: "Product1"},
        {  y: 30, label: "Product2" },
        {  y: 80, label: "Product3" },
        {  y: 20, label: "Product4" },
        {  y: 100, label: "Others"}
        
        ]
      },  {
	  type: "column",
	  showInLegend: true, 
        legendText: "DEMO",
         dataPoints: [
        {  y: 80 , label: "Product1"},
        {  y: 60, label: "Product2" },
        {  y: 150, label: "Product3" },
        {  y: 40, label: "Product4" },
        {  y: 25, label: "Others"}
        
        ]
        
      }
     
	 ]
    });

    chart.render();
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
		fontColor: _colorConstants.PURPLE,
		fontSize: 20
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
axisY:{
          gridThickness: 0
       },
	title:{
       text: "Crops",
	   fontFamily: "Open Sans",
		fontColor: _colorConstants.PURPLE,
		fontSize: 20
      },
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

var chart = new CanvasJS.Chart("farmGroupProducts",
	{
		theme: "theme1",
		height : 300,
		title:{
			text: "Products",
			fontFamily: "Open Sans",
		fontColor: _colorConstants.PURPLE,
		fontSize: 20
		},
		legend: {
			maxWidth: 350,
			itemWidth: 120,
			horizontalAlign: "right", 
			verticalAlign: "center",
			fontSize: 12,
			fontFamily: "tahoma"	
		},
		animationEnabled: true,
		data: [
		{
			type: "doughnut",
			showInLegend: true,
			legendMarkerType: "square",
			legendText: "{indexLabel}",
			dataPoints: [
				{ y: 4181563, indexLabel: "Product1 " },
				{ y: 2175498, indexLabel: "Product2" },
				{ y: 3125844, indexLabel: "Product3" },
				{ y: 1176121, indexLabel: "Others"},
				
			]
		}
		]
	});
	chart.render();
	
}

// VILLAGE ACTIVITY GRAPH

function renderFGMTotalCampaigns(){

var chart = new CanvasJS.Chart("villageActivity",
    {
      title:{
        text: "Crops",
		fontFamily: "Open Sans",
		fontColor: _colorConstants.PURPLE,
		fontSize: 20		
      },
	  height : 300,
		colorSet: "pando",
		animationEnabled: true,
		axisY:{
          gridThickness: 0
       },
	   
      // axisY2: {
        // title:"Production (bbl/day)"
      // },
      
      legend: {
        verticalAlign: "bottom",
		fontSize : 10,
		fontFamily: "Open Sans"
      },
      data: [

      {        
        type: "column",  
        showInLegend: true, 
        legendText: "FGM",
        dataPoints: [      
         {y:30, label: "Nalgonda" },
        {  y:25, label: "Guntur"},
        {  y:80 , label: "Vijayawada"},
        { y:65 , label: "Hyderabad"},
        {  y:35 , label: "Rajhmundry"},
		{ y: 10,  label: "Karimnagar" },
		        { y:65 , label: "Khammam"},
        {  y:35 , label: "Nandyala"},
		{ y: 10,  label: "Chennai" }
		]
      },
      {        
        type: "column",  
        showInLegend: true,
        legendText: "FHV",
        dataPoints: [      
         {  y:90, label: "Nalgonda" },
        { y:30, label: "Guntur"},
        { y:50 , label: "Vijayawada"},
        {  y:70 , label: "Hyderabad"},
        {  y:65 , label: "Rajhmundry"},
		{ y: 45,  label: "Karimnagar" },
		{ y:95 , label: "Khammam"},
        {  y:75 , label: "Nandyala"},
		{ y: 10,  label: "Chennai" }
        ]
      }
	  ,
      {        
        type: "column",  
        showInLegend: true,
        legendText: "MC",
        dataPoints: [      
         { y:75, label: "Nalgonda" },
        { y:35, label: "Guntur"},
        { y:95 , label: "Vijayawada"},
        { y:25 , label: "Hyderabad"},
        { y:15 , label: "Rajhmundry"},
		{  y: 15,  label: "Karimnagar" },
		{ y:55 , label: "Khammam"},
        {  y:85 , label: "Nandyala"},
		{ y: 50,  label: "Chennai" },
        
        
        ]
      }
	  ,
      {        
        type: "column",  
        showInLegend: true,
        legendText: "DEMO",
        dataPoints: [      
        {  y:35, label: "Nalgonda" },
        {  y:90, label: "Guntur"},
        {  y:25 , label: "Vijayawada"},
        {  y:95 , label: "Hyderabad"},
        { y:80 , label: "Rajhmundry"},
		{  y: 50,  label: "Karimnagar" },
		        { y:35 , label: "Khammam"},
        {  y:25 , label: "Nandyala"},
		{ y: 85,  label: "Chennai" },
        
        
        ]
      }

      ]
    });

    chart.render();
}
	
