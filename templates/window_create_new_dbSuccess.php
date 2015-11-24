<?php if(isset($msg)):?>
<div class="message"><?php echo $msg;?></div>
<?php endif;?>
<center>
Are you want delete old Database <?php echo $dbname;?> or Repair old?<br>
<form action='' method='post'>
<input type='submit' name='op' value='delete'>
<input type='submit' name='op' value='use old'>
</form>
</center>