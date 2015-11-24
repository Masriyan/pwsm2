<?php if(isset($msg)):?>
<div class='message'><?php echo $msg;?></div>
<?php endif;?>
<?php if(isset($error)):?>
<div class='error'><?php echo $error;?></div>
<?php endif;?>
<form action="" method="POST" id="first_user_form"><table style="margin:0 auto;">
<caption><b> Register first administrator user</b></caption>
<tr><td>Email</td><td><input type='email' name='email' value='<?php echo ((isset($_POST['start_btn'])&&($_POST['start_btn']=='save')&&isset($_POST['email']))?$_POST['email']:'');?>'></td></tr>
<tr><td>Password</td><td><input type='password' name='password' id="password1" value=''></td></tr>
<tr><td>Retype Password</td><td><input type='password' name='password1'  id="password2" value=''></td></tr>
<tr><td colspan=2><input type='button' value='save' name='start_btn' id="start_btn" class='start_btn'></td></tr>
</table>
</form>
<script>
var RNF={};
RNF.init=function (){
    RNF.init_update_btn();
};
RNF.init_update_btn=function (){
    $('#password1').val('');
    $('#password2').val('');
    $('#start_btn').click(function (){
        if($('#password1').val().length<6)
        {   
            $('#password1').val('');
            $('#password2').val('');
            alert('Password to short')
            return false;
        }
        if($('#password1').val()!=$('#password2').val())
        {   
            $('#password1').val('');
            $('#password2').val('');
            alert('Passwords not Equal')
            return false;
        }
       
        $('#first_user_form').submit();
        
    });
}
RNF.init();
</script>