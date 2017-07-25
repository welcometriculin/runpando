<div class="tab-panel-section">
	<div class="row">
		<div class="col-sm-12">
			<h2><?= (count($label_names_display) > 0 ? ucwords($label_names_display['village_label']) :'VILLAGE') ?></h2>
		</div>
		<div class="col-sm-12">
			<div role="tabpanel" class="tabs">

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active" ><a href="#activity"
						aria-controls="home" role="tab" data-toggle="tab" id ="village_act" >Activity</a>
					</li>
					<li role="presentation" class=""><a href="#crop"
						aria-controls="home" role="tab" data-toggle="tab"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crop') ?></a>
					</li>
					<li role="presentation"><a href="#product" aria-controls="profile"
						role="tab" data-toggle="tab"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Product') ?></a>
					</li>

				</ul>

				<!-- Tab panes -->
				<div class="tab-content clearfix">

					<!-- --------------  ACTIVITY Tab-Panel ------------------- -->

					<div role="tabpanel" class="tab-pane active" id="activity">
						<div class="panel-group clearfix" id="accordion" role="tablist"
							aria-multiselectable="true">
							<div class="col-sm-12 mt10">
								<div class="panel-heading">Activity</div>
								<div class="graph">
									<div id="villageActivity" class="travelchart"></div>
								</div>
							</div>
						</div>
					</div>
					<!-- -------------- ACTIVITY Tab-Panel END ------------------- -->

					<!-- --------------  CROP Tab-Panel Start ------------------- -->

					<div role="tabpanel" class="tab-pane" id="crop">
						<div class="panel-group clearfix" id="accordion" role="tablist"
							aria-multiselectable="true">
							<div class="col-sm-12 mt10">
								<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucwords($label_names_display['crop_label']) :'Crop') ?></div>
								<div class="graph">
									<div id="village_crops_empty"
										class="travelchart circles text-center"
										style="display: none; color: white;">No Results Found</div>
                                        <div class="table-responsive">
									<table class="table table-bordered" id="village_crops"><!-- --------------  20-06-2016 ------------------- -->
										<!-- villagecropyearlysummary data comes here -->
									</table>
                                    </div>
								</div>
							</div>
						</div>
					</div>

					<!-- --------------  CROP Tab-Panel End ------------------- -->

					<!-- --------------  PRODUCT Tab-Panel Start ------------------- -->

					<div role="tabpanel" class="tab-pane" id="product">
						<div class="panel-group clearfix" id="accordion" role="tablist"
							aria-multiselectable="true">
							<div class="col-sm-12 mt10">
								<div class="panel-heading"><?= (count($label_names_display) > 0 ? ucwords($label_names_display['product_label']) :'Product') ?></div>
								<div class="graph">
									<div id="village_products_empty"
										class="travelchart circles text-center"
										style="display: none; color: white;">No Results Found</div>
                                        <div class="table-responsive"><!-- --------------  20-06-2016 ------------------- -->
									<table class="table table-bordered" id="village_products">
										<!-- villageproductyearlysummary data comes here -->
									</table>
                                    </div>
								</div>
							</div>
						</div>
					</div>

					<!-- --------------  PRODUCT Tab-Panel End ------------------- -->

				</div>

			</div>
		</div>
	</div>
</div>
