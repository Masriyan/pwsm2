<form action="" method="POST">
<h5>Sort by: REMOTE ADDR IP</h5>
<ul>
<li><input type="radio" name="sortby" value="remote_addr[az]"<?php echo (($id=='remote_addr[az]')?' checked':'');?>><span class="">ABC...-Z sorting</span></li>
<li><input type="radio" name="sortby" value="remote_addr[za]"<?php echo (($id=='remote_addr[za]')?' checked':'');?>><span class="">ABC...-Z descident sorting</span></li>
</ul>
<input type="submit" name="op" value="Change">&nbsp;<input type="button" onClick="RS.hide_info()" value="close">
</form>