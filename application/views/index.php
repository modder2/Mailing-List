<!DOCTYPE HTML>
<html lang="<?php $l_pos = strpos(I18n::$lang, '-'); echo $l_pos ? substr(I18n::$lang, 0, $l_pos) : I18n::$lang; ?>">
<head>
    <meta charset="<?php echo Kohana::$charset; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mailing List</title>
    <?php foreach ($styles as $file) { echo HTML::style('media/css/'.$file); } ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="icon" href="<?php echo URL::base(); ?>favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo URL::base(); ?>favicon.ico" type="image/x-icon">
</head>
<body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php echo HTML::anchor('', 'Mailing List', array('class' => 'navbar-brand')); ?>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <p class="navbar-text">is a simple mail distribution</p>
                <?php if (Route::name(Request::initial()->route()) === 'default'): ?>
                <form action="" method="get" class="navbar-form navbar-right">
                    <button type="submit" class="btn btn-success">Refresh</button>
                </form>
                <?php endif; ?>
            </div><!--/.navbar-collapse -->
        </div>
    </nav>

    <div class="container">

        <?php echo $content; ?>

    </div>

    <?php foreach ($scripts as $file) { echo HTML::script('media/js/'.$file); } ?>

</body>
</html>
