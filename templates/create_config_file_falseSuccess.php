<?php if(isset($error)):?>
<div class='error'><?php echo $error;?></div>
<?php endif;?>
<?php if(isset($msg)):?>
<div class='message'><?php echo $msg;?></div>
<?php endif;?>
<center>
<?php if($data['success']):?>
    <a href="?step=4">Next Step</a>    
<?php else:?>    
    <a href="?step=3">Step Before</a>    
<?php endif;?>
</center>