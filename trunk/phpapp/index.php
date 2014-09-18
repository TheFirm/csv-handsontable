<?php
/**
 * Created by PhpStorm.
 * User: boom
 * Date: 15.09.14
 * Time: 12:31
 */
//require_once 'auth.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>CSV-HANDSONTABLE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="public/stylesheets/styles.css"/>
    <link type="text/css" rel="stylesheet" href="public/stylesheets/custom_styles.css"/>
    <link type="text/css" rel="stylesheet" href="public/stylesheets/selectric.css"/>
    <link type="text/css" rel="stylesheet" href="public/stylesheets/responsive_styles.css"/>
    <link type="text/css" rel="stylesheet" href="public/stylesheets/font-awesome.min.css"/>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
</head>
<body ng-app="App">
<div class="main_wrapper">
    <div class="fixed_left_navigation">
        <ul>
            <li><a href="#"><i class="fa fa-home"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-share-alt"></i>Company</a></li>
            <li><a href="#"><i class="fa fa-calendar"></i>Calendar</a></li>
            <li><a href="#"><i class="fa fa-clock-o"></i>Time Clock</a></li>
            <li><a href="#"><i class="fa fa-plane"></i>Leave</a></li>
            <li><a href="#"><i class="fa fa-plus-square-o"></i>App Store</a></li>
            <li><a href="#"><i class="fa fa-question-circle"></i>Support</a></li>
        </ul>
    </div>
    <header>
        <div class="container-fluid" data-ng-controller="errorCtrl">
            <div class="top_navbar">
                <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav left_navbar">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle dropdown_base dropdown_main"
                                       data-toggle="dropdown">
                                        <i class="fa fa-share-alt"></i>
                                        Company
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">One more separated link</a></li>
                                    </ul>
                                </li>
                                <li class="thin_border_wrapper">
                                    <div class="thin_border"></div>
                                </li>
                                <li><p class="navbar-text">Company Staff & Owerview</p></li>
                                <li class="notificaton_wrapper" ng-show="error">
                                    <div class="base_notification notificaton_error">
                                        <span>Error in Column<a href=""><i class="fa fa-times"></i></a></span>
                                    </div>
                                </li>
                                <li class="notificaton_wrapper" ng-hide="error">
                                    <div class="base_notification notificaton_success">
                                        <span>5 rows succesfully imported<a href=""><i
                                                    class="fa fa-times"></i></a></span>
                                    </div>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right right_navbar">
                                <li class="header_btn_wrapper">
                                    <button class="main_btn btn_blue">Done editing</button>
                                </li>
                                <li class="header_btn_wrapper">
                                    <button class="main_btn btn_blue">Import Data</button>
                                </li>
                                <li class="thin_border_wrapper">
                                    <div class="thin_border"></div>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle dropdown_base" data-toggle="dropdown">
                                        <i class="fa fa-life-ring"></i>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle dropdown_base user_icon_wrapper"
                                       data-toggle="dropdown">
                                        <img src="public/img/user.jpg" alt="">
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle dropdown_base" data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    </div>
                    <!-- /.container-fluid -->
                </nav>
            </div>
        </div>
    </header>
    <div class="main_content">
        <div ng-view class="container-fluid">

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script src="public/javascripts/lib/angular/angular.min.js"></script>
<script src="public/javascripts/lib/angular/angular-route.min.js"></script>

<script src="public/javascripts/app/main.js"></script>
<script src="public/javascripts/app/route.js"></script>

<!--filters-->
<script src="public/javascripts/app/filters/truncate.js"></script>
<!--filters-->

<!--controllers-->
<script src="public/javascripts/app/controllers/fileUploadCtrl.js"></script>
<script src="public/javascripts/app/controllers/tableCtrl.js"></script>
<script src="public/javascripts/app/controllers/errorCtrl.js"></script>
<!--controllers-->

<!--for debug-->
<script src="public/javascripts/app/localLoaderService.js"></script>
<!--for debug-->

<script src="public/javascripts/lib/bootstrap/dropdown.js"></script>
<script src="public/javascripts/lib/bootstrap/transition.js"></script>
<script src="public/javascripts/lib/bootstrap/collapse.js"></script>
<script src="public/javascripts/lib/bootstrap/scrollspy.js"></script>
<script src="public/javascripts/lib/jquery.selectric.min.js"></script>
<script src="public/javascripts/lib/dropzone.js"></script>

</body>
</html>