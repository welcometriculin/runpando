<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
$loginsession = Yii::$app->session;
AppAsset::register($this);
Yii::setAlias('@foo', '/var/www/kisangates/web/');
?>

<div class="top-nav-header">
<nav class="navbar navbar-default navbar-fixed-top" id="navhead">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <a class="navbar-brand page-scroll" href="#page-top"><img src="<?= Yii::getAlias('@web'); ?>/img/pando-logo.png"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
					<!-- <li>
                        <a class="page-scroll" href="#page-top"><i class="fa fa-home"></i></a>
                    </li> -->
                    <li>
                        <a class="page-scroll" href="#solutions">Solution</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#features">Features</a>
                    </li>
                   <!--  <li>
                        <a class="page-scroll" href="#pricing">Pricing</a>
                    </li> -->
                    <li>
                        <a class="page-scroll" href="#contact">Contact Us</a>
                    </li>
                    <li>
                        <a class="page-scroll login-btn" href="<?= Url::home(); ?>/site/login" id="login">Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</div>