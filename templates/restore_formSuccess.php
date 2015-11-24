<?php if(isset($msg)):?>
<div class="message"><b><?php echo $msg;?></b></div>
<?php else:?>
    <?php if(isset($error)):?>
    <div class="error"><?php echo $error;?></div>
    <?php endif;?>
<div class="box" style="width:400px;margin:0 auto;"><form action="" method="POST">
<table border=0 width="400">
        <caption><b>Restore user password by email</b></caption>
        <tr><td><input type="text" name="email" placeholder="User Email"></td></tr>
        <tr><td><input type="submit" value="remember password" class="green_cl btn"></td><td><a href="login/">Back to Login page</a></td></tr>
        </table></form></div>
<?php endif;?>