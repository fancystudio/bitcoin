<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Kúpiť bitcoin | BUYSELL</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
<link rel="icon" href="favicon.ico" type="image/x-icon">       
<link rel="apple-touch-icon" href="apple-touch-icon-57x57.png" sizes="57x57">
<link rel="apple-touch-icon" href="apple-touch-icon-72x72.png" sizes="72x72">
<link rel="apple-touch-icon" href="apple-touch-icon-76x76.png" sizes="76x76">
<link rel="apple-touch-icon" href="apple-touch-icon-114x114.png" sizes="114x114">
<link rel="apple-touch-icon" href="apple-touch-icon-120x120.png" sizes="120x120">
<link rel="apple-touch-icon" href="apple-touch-icon-144x144.png" sizes="144x144">
<link rel="apple-touch-icon" href="apple-touch-icon-152x152.png" sizes="152x152">

        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/jquery.min.js"></script>
		<script src="js/vendor/bootstrap.min.js"></script>
		<script src="js/main.js"></script>
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		
		
		
		<div class="container">
			<div class="header">
				<h1 class="pull-left"><a href="/">
					<img src="img/logo.svg" onerror="this.onerror=null; this.src='img/logoimage.png';" width="210" height="59" alt="BUYSELL - kúpiť bitcoin | predať bitcoin" />

				</a></h1>
	
				<ul class="nav nav-pills pull-left cl-effect-5" id="cl-effect-5">
					<li class="active"><a href="#"><span data-hover="BITCOIN">Bitcoin</span></a></li>
					<li><a href="#"><span data-hover="Faq">Faq</span></a></li>
					<li><a href="#"><span data-hover="Kontakt">Kontakt</span></a></li>
				</ul>
				<!--currency chart-->
				<? include('includes/currency-chart.php') ?>
				<!--currency chart-->		
			</div><!--header-->
		</div><!--container-->
		
		<div class="main-content-wrap">
			<div class="container main-content">
					<?// include('includes/main-content.php') ?>
					<? include('includes/kontakt.php') ?>

			
		
      <div class="container footer-containter">
        <p class="pull-left copyright"><strong>&copy; BUYSELL 2014</strong></p>
        <ul class="nav nav-pills footer pull-left">
        	<li><a href="#">čo je bitcoin</a></li>
        	<li>|</li>
        	<li><a href="#">obchodné podmienky</a></li>
        	<li>|</li>
        	<li><a href="#">faq</a></li>
        	<li>|</li>
        	<li><a href="#">kontakt</a></li>
        </ul>
        <p class="fancybrand pull-right">Designed & powered by:
        <a href="http://www.fancystudio.sk" onclick="window.open(this.href, 'OffSite').focus(); return false;"> <img src="img/fancy-logo.png" alt="fancystudio" width="81" height="16" style="margin-left:4px" /></a>
      </div>


<script type="text/javascript">
	$(window).resize(function(){
	function equalHeights (element1, element2) {
		var height;
		if (element1.outerHeight() > element2.outerHeight())
		{
			height = element1.outerHeight();
			element2.css('height', height);
		}
		else {
			height = element2.outerHeight();
			element1.css('height', height);
		}
	}
	equalHeights($('.lavy-predaj'), $('.stred-logo') )
	});
</script>
<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.pack.js" type="text/javascript"></script>

            </body>
</html>
