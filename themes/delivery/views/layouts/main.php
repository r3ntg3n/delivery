<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $this->pageTitle; ?></title>
	<link media="all" rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/form.css" type="text/css" />
	<link media="all" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" type="text/css" />
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="top">
                <div class="container">
				<h1><?php echo Yii::app()->name; ?></h1>
                </div>
            </div>
            <div class="menu">
                <div class="container no-padding">
					<?php $this->widget('MenuWidget', array(
						'menuId' => 1,
					)); ?>
                </div>
            </div>
        </header>
		<div class="container">
			<div class="column6 offset3">
				Login form
			</div>
		</div>
        <div class="container content">
            <div class="column3">
                <div class="well dark">
                    <h1>Dark Well</h1>
                    <div class="container">
                        Enter a ZIP o postal code to find a location near you
                    </div>
                </div>
                <div class="well light">
                    <h1>Would You like to...?</h1>
                </div>
            </div>
            <div class="column6">
				<?php echo $content; ?>
            </div>
            <div class="column3">
                <a href="#" class="btn btn-large padded-bottom big-sign">
					Calculator
                    <span>for you everyday mailing needs</span>
                </a>
                <a href="#" class="btn btn-warning btn-large big-sign">
                    Small & medium businesses
                    <span>from 1 to 250 staff</span>
                </a>
            </div>
        </div>
    </div>
    <footer>
	<div class="container"><?php echo date('Y') . ' &copy; ' . Yii::app()->name; ?></div>
    </footer>
</body>
</html>
