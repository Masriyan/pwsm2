<form action="" method="POST">
<h5>Sort by: Date</h5>
<ul>
<li><input type="radio" name="sortby" value="created[az]"<?php echo (($id=='created[az]')?' checked':'');?>><span class="">ABC...-Z sorting</span></li>
<li><input type="radio" name="sortby" value="created[za]"<?php echo (($id=='created[za]')?' checked':'');?>><span class="">ABC...-Z descident sorting</span></li>
</ul>
<input type="submit" name="op" value="Change">&nbsp;<input type="button" onClick="RS.hide_info()" value="close">
</form>