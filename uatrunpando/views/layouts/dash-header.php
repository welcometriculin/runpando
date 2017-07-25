<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\DashAsset;
use yii\helpers\Url;
use app\models\Roles;
use app\models\LabelNames;
DashAsset::register($this);
$kgadmin_role_id = Roles::KGADMIN;
$icadmin_role_id = Roles::ICADMIN;
$menuscountusers = app\models\Users::getMenus(Yii::$app->user->identity->id);
$label_names_display = LabelNames::labelNamesDisplay();

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
?>
				<div class="wrapper">
					<div class="menu">
						<div class="top-nav">
							<img src="<?= Yii::$app->request->hostInfo.Yii::getAlias('@web')?>/img/logo.png">
						</div>
						<div class="main-nav clearfix">
						<div class="main-nav-left pull-left">
								<a id="main-menu-min" class="full toggle-menu pull-left"><i class="fa fa-bars"></i></a>
								<a href="<?= Url::to(['/users/profile']);?>" class="home pull-left home-fs" title = "Home"><i class="fa fa-home icn_padd"></i></a>
								</div>
								 <div class="main-nav-right pull-right">
								 <div class="pull-left welcome">Welcome! <span id = "welcome_text"><?php echo Yii::$app->user->identity->first_name; ?></span></div>
								 <!--  <a href="#" class="brown pull-left"><i class="fa fa-envelope-o"><span class="badge bg-yellow">3</span></i></a> -->
								 <a href="<?php echo Url::to(['site/logout']);?>" class="bg-yellow pull-right" data-method="post" title = "Logout"><i class="fa fa-power-off icn_padd"></i></a>
							<div class="dropdown pull-right">
							<a href="<?= Url::to(['users/changepassword'])?>" class="home pull-right" dropdown-toggle="" type="button" id="menu1" data-toggle="dropdown" title = "Change Password"><i class="fa fa-cog icn_padd"></i></a>
								<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
								  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= Url::to(['users/changepassword'])?>">Change Password</a></li>
								</ul>
							</div>
								</div>
					</div>
					</div>
					<div class="main-body">
						<div id="sidebar-left" class="min-side">
							<div class="sidebar-nav nav-collapse collapse navbar-collapse">
								<ul class="nav main-menu">	
									<?php if (Yii::$app->user->identity->roleid != $kgadmin_role_id) {?>
									<li class="<?= $controller == 'dashboard'?'active':''?>"><a  href="<?= Url::to(['/dashboard/index'])?>"><i class="fa fa-tachometer"></i><span class="text"> Performance</span></a></li>
									<?php }?>
									<li class="<?= $controller == 'users'?'active':''?>"><a  href="<?= Url::to(['/users/profile'])?>"><i class="fa fa-user"></i><span class="text"> Profile</span></a></li>
									<?php if (Yii::$app->user->identity->roleid == $kgadmin_role_id) {?>
									<li class="<?= $controller == 'inputcompanies'?'active':''?>"><a  href="<?= Url::to(['/inputcompanies']);?>"><i class="fa fa-user"></i><span class="text"> Organizations</span></a></li>
									<li class="<?= $controller == 'formbuilder'?'active':''?>"><a  href="<?= Url::to(['/formbuilder/create'])?>"><i class="fa fa-random"></i><span class="text"> Dynamic Form</span></a></li>
									<?php } ?>
									
									<?php if (Yii::$app->user->identity->roleid == $icadmin_role_id) {?>
									<li class="<?= $controller == 'crops'?'active':''?>"><a  href="<?= Url::to(['/crops'])?>"><span class="cust-text"><span class="nav-icon-wd"><img src="<?= Yii::getAlias('@weburl'); ?>/img/crops.png"
					alt="img01" class="img-responsive"></span><span class="text"> <?= (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crops') ?></span></span></a></li>
									<li class="<?= $controller == 'products'?'active':''?>"><a  href="<?= Url::to(['/products'])?>"><span class="cust-text"><span class="nav-icon-wd"><img src="<?= Yii::getAlias('@weburl'); ?>/img/products.png"
					alt="img01" class="img-responsive"></span><span class="text"> <?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Products') ?></span></span></a></li>
									<li class="<?= $controller == 'subactivity'?'active':''?>"><a  href="<?= Url::to(['/subactivity'])?>"><span class="cust-text"><span class="nav-icon-wd"><img src="<?= Yii::getAlias('@weburl'); ?>/img/subactivity.png"
					alt="img01" class="img-responsive"></span><span class="text"> Sub Activity</span></span></a></li>
									<li class="<?= $controller == 'villages'?'active':''?>"><a  href="<?= Url::to(['/villages'])?>"><span class="cust-text"><span class="nav-icon-wd"><img src="<?= Yii::getAlias('@weburl'); ?>/img/village.png"
					alt="img01" class="img-responsive"></span><span class="text"> <?= (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Villages') ?></span></span></a></li>
									<li class="<?= $controller == 'retailer'?'active':''?>"><a  href="<?= Url::to(['/retailer'])?>"><i class="fa fa-random"></i><span class="text"> <?= (count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Partners') ?></span></a></li>
									<?php }?>
								<?php 	if (Yii::$app->user->identity->roleid != $kgadmin_role_id) {?>
									
									<li class="<?php echo ($controller == 'plancard') && ($action == 'index') || ($controller == 'plancard') && ($action == 'create') || ($controller == 'plancard') && ($action == 'update')?'active':''?>" id="planindex"><a href="<?php echo Url::to(['/plancard/index']);?>">
									<span class="cust-text"><span class="nav-icon-wd"><img src="<?= Yii::getAlias('@weburl'); ?>/img/pending_icon.png"
					alt="img01" class="img-responsive"></span> <span class="text">Plans</span></span></a></li>
									<li class="<?php echo ($controller == 'plancard') && ($action == 'history')?'active':''?>" id="planhistory"><a href="<?php echo Url::to(['/plancard/history']);?>">
								<span class="cust-text">	<span class="nav-icon-wd"><img src="<?= Yii::getAlias('@weburl'); ?>/img/completed_cards_icon.png"
					alt="img01" class="img-responsive"></span><span class="text"> History</span></span></a></li>
									<li class="<?= $controller == 'travellog'?'active':''?>"><a  href="<?= Url::to(['/travellog']);?>"><i class="fa fa-motorcycle"></i><span class="text"> Travel</span></a></li>
									<?php } ?>
									<?php if (Yii::$app->user->identity->roleid != $kgadmin_role_id) {?>
									<li class="<?= $controller == 'channelpartners'?'active':''?>"><a  href="<?= Url::to(['/channelpartners/index']);?>">
									<span class="cust-text"><span class="nav-icon-wd"><img src="<?= Yii::getAlias('@weburl'); ?>/img/completed_cards_icon.png"
					alt="img01" class="img-responsive"></span><span class="text"> <?= (count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Partners') ?> Records</span></span></a></li>
									<?php } ?>
									<?php if (Yii::$app->user->identity->roleid == $icadmin_role_id) {?>
									<li class="<?= $controller == 'designation'?'active':''?>"><a  href="<?= Url::to(['/designation/index']);?>">
									<span class="cust-text"><span class="nav-icon-wd"><img src="<?= Yii::getAlias('@weburl'); ?>/img/completed_cards_icon.png"
					alt="img01" class="img-responsive"></span><span class="text">Designations</span></span></a></li>
									
									
									<?php } ?>
									
									
								</ul>
							</div>
						</div>