<?php if($success):?>
<div class='message'>
    Congratulations! Succefully installed config file.
    Now Please <a href="?step=7">Next Step</a>
</div>
<?php else:?>
<div class='message'>
    Some problem happen! Confuration file not created, please check directory permissions.
   <a href="?step=1">Start Again</a>
   <a href="?step=500">Rollback DB changes</a>
</div>
<?php endif; ?>
