<?php 
use yii\helpers\Url;
?>
<h2>ACTIVITY</h2>
<div role="tabpanel" class="tabs">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active" id="summary_tab"><a class="all-crop-prdt" href="#all" aria-controls="home"
			role="tab" data-toggle="tab">Summary</a></li>
		<li role="presentation" id ="fgm_window"><a href="#fgm"
			aria-controls="home" role="tab" data-toggle="tab"><span><img src="<?= Url::to('@imageurl/img/dash_farmer_group_meeting_icon.png')?>"></span><span class="act-name">Group Meetings</span></a></li>
		<li role="presentation" id ="fhv_window"><a href="#fhv" aria-controls="profile"
			role="tab" data-toggle="tab"><span><img src="<?= Url::to('@imageurl/img/dash_farm_home_visit.png')?>"></span><span class="act-name">Farm and Home Visits</span></a></li>
		<li role="presentation" id ="mc_window"><a href="#mc" aria-controls="profile"
			role="tab" data-toggle="tab" class = "chart_show"><span><img src="<?= Url::to('@imageurl/img/dash_mass_campaign.png')?>"></span><span class="act-name">Mass Campaigns</span></a></li>
		<li role="presentation" id ="demo_window"><a href="#demo" aria-controls="profile"
			role="tab" data-toggle="tab" class = "chart_show"><span><img src="<?= Url::to('@imageurl/img/dash_demonstration.png')?>"></span><span class="act-name">Demonstrations</span></a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content clearfix text-center">


		<!-- --------------  FARM GROUP MEETING Tab-Panel Start ------------------- -->

		<div role="tabpanel" class="tab-pane" id="fgm">
			<div class="panel-group" id="accordion" role="tablist"
				aria-multiselectable="true">
				<div class="row">
					<div class="col-md-12 mt10 camp_panel_2" id="fgm_activities">
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border-right col mble_btm">
							<div class="panel-heading text-middel">Group Meetings</div>
							<div>
								<div id="fgm_tot">
									<div id="title_distance" class="total-distance tot-activities">
										<div class="title" id="fgm_total"></div>
										<div class="subtitle" id="fgm_avg"></div>
									</div>
								</div>
								<div id="FgmTotalCampaigns_empty"
									class="travelchart text-middel"
									style="display: none; color: white;">No Results Found</div>
								<div id="FgmTotalCampaigns" class="travelchart mt15" style="width:100%; height:240px;"></div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border-right col mble_btm">
							<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crops') ?></div>
							<div class="graph">
								<!-- <div id="farmGroupCrops" class="travelchart"></div> -->
								<div id="fgm_crops_empty" class="travelchart text-middel"
									style="display: none; color: white;">No Results Found</div>
								<div id="fgm_crops" class="travelchart circles"></div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col mble_btm">
							<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Products') ?></div>
							<div class="">
								<div id="farmGroupProducts" class="travelchart" style="width:100%; height:240px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- --------------  FARM GROUP MEETING Tab-Panel End ------------------- -->

		<!-- --------------  FARM HOME VISIT Tab-Panel Start ------------------- -->

		<div role="tabpanel" class="tab-pane" id="fhv">
			<div class="panel-group" id="accordion" role="tablist"
				aria-multiselectable="true">
				<div class="row">
					<div class="col-md-12 mt10 camp_panel_2" id="fhv_activities">
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border-right mble_btm">
							<div class="panel-heading">Farm and Home Visits</div>
							<div class="graph">
								<div id="fhv_tot">
									<div id="title_distance" class="total-distance tot-activities">
										<div class="title" id="fhv_total"></div>
										<div class="subtitle" id="fhv_avg"></div>
									</div>
								</div>
								<div id="FhvTotalCampaigns_empty"
									class="travelchart text-middel"
									style="display: none; color: white;">No Results Found</div>
								<div id="FhvTotalCampaigns" class="travelchart mt15" style="width:100%; height:240px;"></div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border-right mble_btm">
							<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crops') ?></div>
							<div class="graph">
								<div id="fhv_crops_empty" class="travelchart text-middel"
									style="display: none; color: white;">No Results Found</div>
								<div id="fhv_crops" class="travelchart circles">

									<!-- <div id="one">
											<span>50</span>
										</div>
										<div id="two">
											<span>35</span>
										</div>
										<div id="three">
											<span>28</span>
										</div>
										<div id="four">
											<span>60</span>
										</div> -->
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mble_btm">
							<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Products') ?></div>
							<div class="graph">
								<div id="farmHomeProducts" class="travelchart" style="width:100%; height:240px;"></div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<!-- --------------  FARM HOME VISIT Tab-Panel End ------------------- -->

		<!-- --------------  MASS CAMPAIGN Tab-Panel Start ------------------- -->

		<div role="tabpanel" class="tab-pane" id="mc">
			<div class="panel-group" id="accordion" role="tablist"
				aria-multiselectable="true">
				<div class="row">
					<div class="col-sm-12 mt10 camp_panel_2" id="mc_activities">
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border-right mble_btm">
							<div class="panel-heading text-middel">Mass Campaigns</div>
							<div class="graph">
								<div id="mc_tot">
									<div id="title_distance" class="total-distance tot-activities">
										<div class="title" id="mc_total"></div>
										<div class="subtitle" id="mc_avg"></div>
									</div>
								</div>
								<div id="McTotalCampaigns_empty" class="travelchart text-middel"
									style="display: none; color: white;">No Results Found</div>
								<div id="McTotalCampaigns" class="travelchart mt15" style="width:100%; height:240px;"></div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border-right mble_btm">
							<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crops') ?></div>
							<div class="graph">
								<div id="mc_crops_empty" class="travelchart text-middel"
									style="display: none; color: white;">No Results Found</div>
								<div id="mc_crops" class="travelchart circles">

									<!-- <div id="one">
T
											<span>50</span>
										</div>
										<div id="two">
											<span>35</span>
										</div>
										<div id="three">
											<span>28</span>
										</div>
										<div id="four">
											<span>60</span>
										</div> -->
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mble_btm">
							<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Products') ?></div>
							<div class="graph">
								<div id="mcProducts" class="travelchart" style="width:100%; height:240px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

		<!-- --------------  MASS CAMPAIGN Tab-Panel End ------------------- -->


		<!-- --------------  DEMO Tab-Panel Start ------------------- -->

		<div role="tabpanel" class="tab-pane" id="demo">
			<div class="panel-group" id="accordion" role="tablist"
				aria-multiselectable="true">
				<div class="row">
					<div class="col-sm-12 mt10  camp_panel_2" id="demo_activities">
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border-right mble_btm">
							<div class="panel-heading text-middel">Demonstrations</div>
							<div class="graph">
								<div id="demo_tot">
									<div id="title_distance" class="total-distance tot-activities">
										<div class="title" id="demo_total"></div>
										<div class="subtitle" id="demo_avg"></div>
									</div>
								</div>
								<div id="DemoTotalCampaigns_empty"
									class="travelchart text-middel"
									style="display: none; color: white;">No Results Found</div>
								<div id="DemoTotalCampaigns" class="travelchart mt15" style="width:100%; height:240px;"></div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border-right mble_btm">
							<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crops') ?></div>
							<div class="graph">
								<div id="demo_crops_empty" class="travelchart text-middel"
									style="display: none; color: white;">No Results Found</div>
								<div id="demo_crops" class="travelchart circles">

									<!-- <div id="one">
											<span>50</span>
										</div>
										<div id="two">
											<span>35</span>
										</div>
										<div id="three">
											<span>28</span>
										</div>
										<div id="four">
											<span>60</span>
										</div> -->
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mble_btm">
							<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Products') ?></div>
							<div class="graph">
								<div id="DemoProducts" class="travelchart" style="width:100%; height:240px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- --------------  DEMO Tab-Panel End ------------------- -->

		<!-- --------------  ALL ACTIVITIES Tab-Panel ------------------- -->

		<div role="tabpanel" class="tab-pane active" id="all">
			<div class="panel-group  clearfix" id="accordion" role="tablist"
				aria-multiselectable="true">
				<div class="row">
					<div class="col-sm-12 mt10" id="tc_activities clearfix"><!-- --------------  20-06-2016 ------------------- -->
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border-right col mble_btm">
							<div class="panel-heading text-middel">Activities</div>
							<div class="">
								<div id="tc_tot">
									<div id="title_distance" class="total-distance tot-activities" >
										<div class="title" id="tc_total"></div>
										<div class="subtitle" id="tc_avg"></div>
									</div>
								</div>
								<div id="totalCampaigns_empty" class="travelchart text-middel"
									style="display: none; color: white;">No Results Found</div>
								<div id="totalCampaigns" class="travelchart mt15" style="height: 240px; width: 100%;"></div>
								
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4  border-right col mble_btm">
							<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crops') ?></div>
							<div class="crop-graph">
								<div id="allCrops"  style="height: 240px; width: 100%;"></div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col mble_btm">
							<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Products') ?></div>
							<div class="">
								<div id="allProducts" class="travelchart" style="height: 240px; width: 100%;"></div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- -------------- ALL ACTIVITIES Tab-Panel END ------------------- -->

	</div>

</div>
