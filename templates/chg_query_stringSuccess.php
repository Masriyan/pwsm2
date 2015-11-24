<form action="" method="POST">
<h5>Sort by: QUERY_STRING</h5>
<ul>
<li><input type="radio" name="sortby" value="query_string[az]"<?php echo (($id=='query_string[az]')?' checked':'');?>><span class="">ABC...-Z sorting</span></li>
<li><input type="radio" name="sortby" value="query_string[za]"<?php echo (($id=='query_string[za]')?' checked':'');?>><span class="">ABC...-Z descident sorting</span></li>
</ul>
<input type="submit" name="op" value="Change">&nbsp;<input type="button" onClick="RS.hide_info()" value="close">
</form>