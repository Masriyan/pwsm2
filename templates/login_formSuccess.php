<?php if(isset($error)):?>
<div class="message error"><?php echo $error;?></div>
<?php endif;?>
<div class="box" style="margin:0 auto;width:300px;"><form action="" method="POST">
<table>
    <tr><td colspan=2><b>Email&nbsp;&nbsp;&nbsp;&nbsp;</b><input type="email" name="email"  placeholder="Email"  id="user_email"></td></tr>
<tr><td colspan=2><b>Password&nbsp;</b><input type="password" name="password" placeholder="Password"  id="user_password"></td></tr>
<tr><td><input type="submit" value="SignIn" class="green_cl btn"></td><td><a href="login/?act=restore" class="gray_cl btn">Restore password</a></td></tr>
</table></form></div>