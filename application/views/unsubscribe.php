<?php if ( ! empty($errors)): ?>
    <div class="alert alert-warning large text-center" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;
        <?php foreach($errors as $error): ?>
            <?php echo UTF8::ucfirst($error); ?>.
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-success large text-center" role="alert">
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;
        The email <strong><?php echo $email; ?></strong> has been unsubscribed from mailing list successfully.
    </div>
<?php endif; ?>

<p class="text-center"><?php echo HTML::anchor('', 'Go to Homepage', array('class' => 'btn btn-primary')); ?></p>

<hr>
