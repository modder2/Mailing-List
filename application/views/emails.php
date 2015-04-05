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
