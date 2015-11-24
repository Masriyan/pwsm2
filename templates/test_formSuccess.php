<form action='' name='test_form' id="test_form">
 <table class='forma'>
 <tr ><td class='red_cl btn'> 	Target object URL:</td><td><input type='text' name='url' id="url" value='<?php echo (isset($object['object_url'])?$object['object_url']:(isset($_GET['url'])?urldecode($_GET['url']):''));?>' size=50></td></tr>
 <tr><td>Request method:</td><td><select name='method' id="method"><option>GET</option><option>POST</option></select></td></tr>
 <tr><td colspan=2>
 <ul id="variables">
 <li>Custom variable:<input class="name" type='text'>&nbsp;=&nbsp;Value:<input type='text' class="value" value=''></li>
 </ul>
 <input type='button' class='green_cl btn' value='more variables' id="more_variables4test" ></td></tr>
 <tr><td colspan=2><input type='button' id="send_test_btn" class='red_cl btn' value='send'></td></tr>
  </table>
</form>
<script>TF.init();</script>