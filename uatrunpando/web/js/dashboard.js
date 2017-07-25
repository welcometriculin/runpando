$(document).ready(function() {
	// for footer to reponsive design
	function mapSecHeight() {
		var winWidth = $(window).width();
		var winHeight = $(window).innerHeight();
		var hederHeight = $('.menu').innerHeight();
		var footerHeight = $('footer').innerHeight();
		var newHeight = footerHeight + hederHeight
		var mapHeight = winHeight - newHeight
		if (winWidth > 768) {
			$('.min-cont').css("min-height", mapHeight);
		} else {
			$('.min-cont').css("min-height", mapHeight + 60);
		}
	}//text wrapping
	function textWrapping() {
		if (($(window).width()) < 768) {
			var str = $("#welcome_text").text();
			var dots = '...';
			if (str.length > 1)
				str = str.substring(0, 4);
			var text = str.concat(dots)
			$("#welcome_text").text(text);
		}
	}
	mapSecHeight();
	textWrapping();
	$(window).resize(function() {
		mapSecHeight();
		textWrapping();
	});

	$('#summary_tab').on("shown.bs.tab", function() {
		AllCrops.render();
		AllProducts.render();
		$('#summary_tab').off(); // to remove the binded event after the
									// initial rendering
	});

	$('#fgm_window').on("shown.bs.tab", function() {
		farmGroupProducts.render();
		$('#fgm_window').off(); // to remove the binded event after the initial
								// rendering
	});
	$('#fhv_window').on("shown.bs.tab", function() {
		farmHomeProducts.render();
		$('#fhv_window').off(); // to remove the binded event after the initial
								// rendering
	});
	$('#mc_window').on("shown.bs.tab", function() {
		mcProducts.render();
		$('#mc_window').off(); // to remove the binded event after the initial
								// rendering
	});
	$('#demo_window').on("shown.bs.tab", function() {
		DemoProducts.render();
		$('#demo_window').off(); // to remove the binded event after the
									// initial rendering
	});
	$('#village_act').on("click", function() {
		setTimeout(function(){
			VillageActivity.render();
		},0000);
//		$('#village_act').off(); // to remove the binded event after the
									// initial rendering
	});
	
	$('#main-menu-min').click(function() {
		$('#distance').highcharts().reflow();
		$('#FgmTotalCampaigns').highcharts().reflow();
		$('#DemoTotalCampaigns').highcharts().reflow();
		$('#FhvTotalCampaigns').highcharts().reflow();
		$('#McTotalCampaigns').highcharts().reflow();
		$('#totalCampaigns').highcharts().reflow();
		farmGroupProducts.render();
		farmHomeProducts.render();
		DemoProducts.render();
		mcProducts.render();
		AllCrops.render();
		AllProducts.render();
		VillageActivity.render();
	})

	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		$('#FgmTotalCampaigns').highcharts().reflow();
		$('#DemoTotalCampaigns').highcharts().reflow();
		$('#FhvTotalCampaigns').highcharts().reflow();
		$('#McTotalCampaigns').highcharts().reflow();
		$('#totalCampaigns').highcharts().reflow();
	});
	
});