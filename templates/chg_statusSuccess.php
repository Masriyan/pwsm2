<form action="" method="POST">
<h5>Show only with status:</h5>
<ul>
<li><input type="radio" name="status" value="1"<?php echo (($id=='1')?' checked':'');?>><span class="status_inline red">Blocked Only</span></li>
<li><input type="radio" name="status" value="0"<?php echo (($id=='0')?' checked':'');?>><span class="status_inline green">Allowed Only</span></li>
<li><input type="radio" name="status" value="all"<?php echo (($id=='all')?' checked':'');?>><span class="status_inline mixed">All (Blocked & Allowed)</span></li>
</ul>
<input type="submit" name="op" value="Change">&nbsp;<input type="button" onClick="RS.hide_info()" value="close">
</form>