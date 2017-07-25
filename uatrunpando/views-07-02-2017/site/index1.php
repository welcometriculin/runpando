<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>
<!-- Slider Section -->
<section id="slide">
	<div id="carousel-example-generic" class="carousel slide"
		data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0"
				class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="<?= Yii::getAlias('@weburl'); ?>/img/slide01.jpg"
					alt="img01" class="img-responsive">
				<div class="carousel-caption">
					<!--   <div class="intro-lead-in">Welcome to our Pando!</div> -->
					<div class="intro-heading">Field Force Management, Seamlessly
						Automated</div>
				</div>
			</div>
			<div class="item">
				<img src="<?= Yii::getAlias('@weburl'); ?>/img/slide02.jpg"
					alt="img02" class="img-responsive">
				<div class="carousel-caption">
					<!--   <div class="intro-lead-in">Welcome to our Pando!</div> -->
					<div class="intro-heading">Last Mile Campaign Operations, Enabling
						Real-Time Visibility</div>
				</div>
			</div>
			<div class="item">
				<img src="<?= Yii::getAlias('@weburl'); ?>/img/slide03.jpg"
					alt="img03" class="img-responsive">
				<div class="carousel-caption">
					<!-- <div class="intro-lead-in">Welcome to our Pando!</div> -->
					<div class="intro-heading">Demands and Placements, Liquidation
						Efficiency</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Solutions Section -->
<section id="solutions">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h2 class="section-heading">Solutions</h2>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<a href="#"> <img alt=""
					src="<?= Yii::getAlias('@weburl'); ?>/img/left-img.jpg"
					class="img-responsive">
				</a>
			</div>
			<div class="col-sm-8">
				<div class="row text-center">
					<div class="col-md-4">
						<div class="box">
							<span class="fa-4x pic-box"> <img alt=""
								src="<?= Yii::getAlias('@weburl'); ?>/img/channel-partner11.png"
								class="img-responsive">

							</span>
							<h4 class="service-heading">Travel Module</h4>
							<div class="box-section">
								<div class="box1">
									<p class="text-muted">Daily Travel Log, Plans accomplished and
										Villages traveled</p>
								</div>
								<div class="box1">
									<p class="text-muted">Daily and Average distance covered during
										month</p>
								</div>
								<div class="box1">
									<p class="text-muted">Monitoring Village Level time allocation</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="box box_2">
							<span class="fa-4x pic-box"> <img alt=""
								src="<?= Yii::getAlias('@weburl'); ?>/img/mass-campaign1.png"
								class="img-responsive">
							</span> <span class="fa-4x pic-box"> <img alt=""
								src="<?= Yii::getAlias('@weburl'); ?>/img/demonstration1.png"
								class="img-responsive">

							</span> <span class="fa-4x pic-box"> <img alt=""
								src="<?= Yii::getAlias('@weburl'); ?>/img/farm-group-meeting-icon1.png"
								class="img-responsive">

							</span> <span class="fa-4x pic-box"> <img alt=""
								src="<?= Yii::getAlias('@weburl'); ?>/img/farm-home-visit-icon1.png"
								class="img-responsive">

							</span>
							<h4 class="service-heading">Campaign Module</h4>
							<div class="box-section">
								<div class="box1">
									<p class="text-muted">Monitoring four major campaign tactics
										for product promotions</p>
								</div>
								<div class="box1">
									<p class="text-muted">Crop and product wise campaign planning
										and delivery effectiveness</p>
								</div>
								<div class="box1">
									<p class="text-muted">Monitoring village wise campaign touch
										points</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="box">
							<span class="fa-4x pic-box"> <img alt=""
								src="<?= Yii::getAlias('@weburl'); ?>/img/channel-partner1.png"
								class="img-responsive">
							</span>
							<h4 class="service-heading">Channel Module</h4>
							<div class="box-section">
								<div class="box1">
									<p class="text-muted">Channel touch points and relationship
										management</p>
								</div>
								<div class="box1">
									<p class="text-muted">Channel wise product demands and
										liquidation</p>
								</div>
								<div class="box1">
									<p class="text-muted">Channel wise collection management</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Lorem ipsum</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-laptop fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Lorem ipsum</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Lorem ipsum</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
            </div> -->
	</div>
</section>

<!-- Features Grid Section -->
<section id="features" class="bg-light-gray">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h2 class="section-heading">Features</h2>
			</div>
		</div>
		<div class="row">
			<div id="carousel-feature-generic" class="carousel slide"
				data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#carousel-feature-generic" data-slide-to="0"
						class="active"></li>
					<li data-target="#carousel-feature-generic" data-slide-to="1"></li>
					<li data-target="#carousel-feature-generic" data-slide-to="2"></li>
					<li data-target="#carousel-feature-generic" data-slide-to="3"></li>
				</ol>
				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<div class="col-sm-5">
							<img src="<?= Yii::getAlias('@weburl'); ?>/img/feature-img01.png"
								alt="img001" class="img-responsive">
						</div>
						<div class="col-sm-7">
							<h3>Campaign Module</h3>
							<p>Planning and delivery of quality sales campaigns.</p>
						</div>
					</div>
					<div class="item">
						<div class="col-sm-5">
							<img src="<?= Yii::getAlias('@weburl'); ?>/img/feature-img02.png"
								alt="img001" class="img-responsive">
						</div>
						<div class="col-sm-7">
							<h3>Travel Module</h3>
							<p>Managing Field Force daily travel log and operations</p>
						</div>
					</div>
					<div class="item">
						<div class="col-sm-5">
							<img src="<?= Yii::getAlias('@weburl'); ?>/img/feature-img03.png"
								alt="img001" class="img-responsive">
						</div>
						<div class="col-sm-7">
							<h3>Employee Performance</h3>
						</div>
					</div>
					<div class="item">
						<div class="col-sm-5">
							<img src="<?= Yii::getAlias('@weburl'); ?>/img/feature-img04.png"
								alt="img001" class="img-responsive">
						</div>
						<div class="col-sm-7">
							<h3>Channel Module</h3>
							<p>Efficiency in Demand Assessment and Liquidation.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Pricing Section -->
<section id="pricing">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h2 class="section-heading">Pricing</h2>
			</div>
		</div>
		<div class="row">
			<div class="links">
				<section class="all-features">
					<a href="#">
						<h2 class="title">PANDO</h2>

						<div class="feature fitText">
							<h5>APPRAISAL MODULE</h5>
							<h5>CAMPAIGN/CHANNEL MODULE</h5>
						</div>
						<div class="price">
							<div class="price-tag">
								<span itemprop="price"> INR 300 </span> <span><small>Per Month</small>
								</span>
							</div>
						</div>
					</a>
				</section>

				<section class="simple-pricing">
					<a href="#">
						<h2 class="title">PANDO 3x</h2>
						<div class="feature fitText">
							<h5>APPRAISAL MODULE</h5>
							<h5>CAMPAIGN/CHANNEL MODULE</h5>
							<h5>ATTENDANCE MODULE</h5>
							<h5>TRAVEL EXPENSE MODULE</h5>
						</div>
						<div class="price">
							<div class="price-tag">
								<span itemprop="price"> INR 375 </span> <span><small>Per Month</small>
								</span>
							</div>
						</div>
					</a>
				</section>
				<section class="web-mobile">
					<a href="#">
						<h2 class="title">PANDO 5x</h2>
						<div class="feature fitText">
							<h5>APPRAISAL MODULE</h5>
							<h5>CAMPAIGN/CHANNEL MODULE</h5>
							<h5>ATTENDANCE MODULE</h5>
							<h5>TRAVEL EXPENSE MODULE</h5>
							<h5>SALES MODULE</h5>
							<h5>APPRAISAL MODULE</h5>
						</div>
						<div class="price">
							<div class="price-tag">
								<span itemprop="price"> INR 475 </span> <span><small>Per Month</small>
								</span>
							</div>
						</div>
					</a>
				</section>
			</div>
		</div>
	</div>
</section>
<!-- Contact Section -->
<section id="contact" class="new-contact">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h2 class="section-heading">Contact Us</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				
					<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
					<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<?= $form->field($model, 'name')->textInput(['placeholder' => 'Your Name *', 'class' => 'form-control'])->label('') ?>
						</div>
						<div class="form-group">
							<?= $form->field($model, 'email_address')->textInput(['placeholder' => 'Your Email *', 'class' => 'form-control'])->label('') ?>
						</div>
						<div class="form-group">
							<?= $form->field($model, 'phone_number')->textInput(['placeholder' => 'Your Phone number *', 'class' => 'form-control'])->label('') ?>
						</div>
						<div class="form-group">
							<?= $form->field($model, 'company_name')->textInput(['placeholder' => 'Your Company Name *', 'class' => 'form-control'])->label('') ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<?= $form->field($model, 'message')->textArea(['rows' => 2, 'placeholder' => 'Your Message * Message Contains only 400 Characters.', 'class' => 'form-control'])->label('') ?>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-lg-12 text-center mt20">
						<div id="success"></div>
						<?= Html::submitButton('Send Message', ['class' => 'btn btn-xl']) ?>
						<div class ="contactsuccess" >
						<?php echo Yii::$app->session->getFlash('contactus-success');?>
						</div>
					</div>
					</div>
					<div class="contact-content">
							<div class="row">
								<div class="col-md-4">
									<span>Phone: +91-9505034734</span>
								</div>
								<div class="col-md-4 text-center">
								Sales: pradeepraj.y@kisangates.com
								</div>
								<div class="col-md-4">
								   <span class="pull-right">Support: manoj.r@kisangates.com</span>
								</div>
							</div>
						</div>
					<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</section>
     <?php 
$script = <<< JS
$(document).ready(function(){	
	$('.contactsuccess').delay(10000).fadeOut('slow');
		
});
JS;
$this->registerJs($script);
?>