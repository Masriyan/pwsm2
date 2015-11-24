<?php if(isset($msg)):?>
<div class="message"><b><?php echo $msg;?></b></div>
<?php else:?>
<?php if(isset($error)):?>
    <div class="error"><?php echo $error;?></div>
    <?php else:?>
<form action="" method="POST" name="pass_chg" id="pass_chg"><table>
<tr><td>Type Password:</td><td><input type="password" name="password1" id="password1"></td></tr>
<tr><td>ReType Password:</td><td><input type="password" name="password2" id="password2"></td></tr>
<tr><td colspan=2><input type="button" name="op" value="update" class="update_btn btn green"></td></tr>
</table></form><?php endif;?>
<?php endif;?>
<script>RNF.init();</script>