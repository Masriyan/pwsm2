<h5>Show only method:</h5>
<form action="" method="POST">
<ul>
<li><input type="radio" name="method" value="GET"<?php echo (($id=='GET')?' checked':'');?>><span class="">GET Only</span></li>
<li><input type="radio" name="method" value="POST"<?php echo (($id=='allowed')?' checked':'');?>><span class="">POST Only</span></li>
<li><input type="radio" name="method" value="all"<?php echo (($id=='all')?' checked':'')?>><span class="">All(POST & GET)</span></li>
</ul>
<input type="submit" name="op" value="Change">&nbsp;<input type="button" onClick="RS.hide_info()" value="close">
</form>