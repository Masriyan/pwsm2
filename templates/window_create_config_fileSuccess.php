<?php if(isset($msg)):?>
<div class='message'><?php echo $msg;?></div>
<?php endif;?>
<?php if(isset($error)):?>
<div class='error'><?php echo $error;?></div>
<?php endif;?>
<?php if(isset($error1)):?>
<p><b><?php echo $error1;?></b></p>
<?php endif;?>
<form action='' method='POST'>
<div class='message'>For installation process of PWSM (PHP Web Security Monitor) need choise database (MYSQL or PostgreSQL), wanted or exists database and database connection details</div>
<table style='margin:20px auto;'>
<tr><td>Type of DB:</td><td><select name='dbtype'>
                   <option value='mysql'<?php echo ((isset($_POST['dbtype'])&&($_POST['dbtype']=='mysql'))?" selected":"");?>>mysql
                   <option value='postgresql'<?php echo ((isset($_POST['dbtype'])&&($_POST['dbtype']=='postgresql'))?" selected":"");?>>postgresql
                   </select></td></tr>
<tr><td>DB host:</td><td><input type='text' name='host' value='<?php echo isset($_POST['host'])?$_POST['host']:'localhost';?>'></td></tr>
<tr><td>DB name:</td><td><input type='text' name='dbname' value='<?php echo (isset($_POST['dbname'])?$_POST['dbname']:'pwsm');?>'></td></tr>
<tr><td>DB user:</td><td><input type='text' name='user' value='<?php echo (isset($_POST['user'])?$_POST['user']:'root');?>'></td></tr>
<tr><td>DB Password:</td><td><input type='password' name='pass'></td></tr>
<tr><td colspan=2><input type='submit' value='create' class='start_btn'></td></tr>
</table>
</form>