<?php if(isset($msgs)):?>
    <?php foreach($msgs as $msg):?>
    <div class='message'><?php echo $msg;?></div>
    <?php endforeach;?>
<?php endif;?>
<?php if(isset($errors)):?>
    <?php foreach($errors as $error):?>
    <div class='error'><?php echo $error;?></div>
    <?php endforeach;?>
<?php endif;?>
    <center>
        <a href="?step=5">Next step</a>
    </center>