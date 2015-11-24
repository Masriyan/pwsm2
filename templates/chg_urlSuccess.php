<form action="" method="POST">
<h5>Sort by: URL</h5>
<ul>
<li><input type="radio" name="sortby" value="url[az]"<?php echo (($id=='url[az]')?' checked':'');?>><span class="">ABC...-Z sorting</span></li>
<li><input type="radio" name="sortby" value="url[za]"<?php echo (($id=='url[za]')?' checked':'');?>><span class="">ABC...-Z descident sorting</span></li>
</ul>
<input type="submit" name="op" value="Change">&nbsp;<input type="button" onClick="RS.hide_info()" value="close">
</form>