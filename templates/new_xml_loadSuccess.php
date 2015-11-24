<form action='' method='POST' name='theform' style='margin:0px;'>
    <table class='tbl_form'>
  <tr><td colspan=2><h5>Loading Security patterns via url of JSON file</h5></td></tr>
    <tr><th>Input valid JSON URL:</th><td><input type='text' width='256' name='url' id="url" value='http://romanshneer.info/pwsm/patterns.json'>
	<input type='hidden' id='data' name='data' value=''></td></tr>
	<tr><td colspan=2>
	<input type='button' name='op' value='load' onClick='submit()' class='green_cl btn'>
	<input type='button' name='op' value='cancel' onClick='document.location="?q=config";' class='gray_cl btn'>
	</td></tr>
	</table>
</form>