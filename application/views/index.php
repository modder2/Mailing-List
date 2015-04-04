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
                <form action="" method="get" class="navbar-form navbar-right">
                    <button type="submit" class="btn btn-success">Refresh</button>
                </form>
            </div><!--/.navbar-collapse -->
        </div>
    </nav>

    <div class="container">

        <div class="breadcrumb">
            <ul class="nav nav-pills nav-justified">
                <li class="text-success" role="presentation">
                    Sent successfully
                    <span class="badge progress-bar-success"><?php echo $counters['success']; ?></span>
                </li>
                <li class="text-danger" role="presentation">
                    Failed
                    <span class="badge progress-bar-danger"><?php echo $counters['error']; ?></span>
                </li>
                <li class="text-info text-right" role="presentation">
                    Last dispatch at
                    <span class="badge progress-bar-info"><?php echo ($counters['last_send'] ? $counters['last_send'] : 'not sent'); ?></span>
                </li>
            </ul>
        </div>

        <hr>

        <?php if ( ! empty($errors)): ?>
            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                You have some errors:
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Email</th>
                    <th class="text-center">Sending time</th>
                    <th class="text-center">Last sending status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ( ! empty($emails)):
                    foreach($emails as $email): ?>
                <tr>
                    <td class="td-email"><?php echo HTML::protect_email($email['email']); ?></td>
                    <td class="text-center td-time"><a href="#" title="Edit sending time"><?php echo $email['sending_time']; ?></a></td>
                    <?php switch($email['last_status'])
                    {
                        case 'wait':
                            echo '<td class="text-center text-warning">';
                            echo '<span class="glyphicon glyphicon-time" aria-hidden="true"></span> ';
                            echo $email['last_status'];
                            echo '</td>';
                            break;
                        case 'sent':
                            echo '<td class="text-center text-success">';
                            echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ';
                            echo $email['last_status'];
                            echo '</td>';
                            break;
                        case 'error':
                            echo '<td class="text-center text-danger">';
                            echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ';
                            echo $email['last_status'];
                            echo '</td>';
                            break;
                        default:
                            echo '<td class="text-center">'.$email['last_status'].'</td>';
                            break;
                    } ?>
                </tr>
                <?php endforeach;
                    else: ?>
                <tr class="warning text-warning">
                    <td colspan="3" class="text-center">Email list is empty</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <form action="" method="post" class="form-inline">
            <div class="form-group">
                <label class="sr-only" for="inputEmail">Email</label>
                <input type="email" name="email" value="<?php

                    echo empty($post_data['email']) ? '' : HTML::chars($post_data['email']);

                ?>" class="form-control" id="inputEmail" placeholder="Enter email" required>
            </div>
            <div class="form-group" style="position: relative">
                <label class="sr-only" for="inputTime">Sending time</label>
                <input type="datetime" name="sending_time" value="<?php

                    echo empty($post_data['sending_time']) ? '' : HTML::chars($post_data['sending_time']);

                ?>" class="form-control" id="inputTime" placeholder="Choose sending time" autocomplete="off" required>
            </div>
            <button type="submit" class="btn btn-primary">Add to list</button>
        </form>

        <hr>

    </div>

    <?php foreach ($scripts as $file) { echo HTML::script('media/js/'.$file); } ?>

</body>
</html>
