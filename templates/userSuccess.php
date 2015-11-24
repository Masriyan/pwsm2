<form action="" method="POST" name="user_edit" id="user_edit_form"><table id="user_edit" class="box">
 <tr><th>Email</th><td><input type="email" name="email" id="email" value="<?php echo $user['email'];?>"></td></tr>
 <tr><th>New Password</th><td><input type="password" name="password1" id="password1"></td></tr>
 <tr><th>Retype New Password</th><td><input type="password" name="password2" id="password2"></td></tr>
 <tr><td><input id="user_edit_btn" type="button" class="green_cl btn" value="save"></td>
     <?php if(($user['id'])&&($user['id']!=$_SESSION['user']['id'])):?>
    <td><input type="submit"  id="user_del_btn" value="delete" class="red_cl btn"></td></tr>
    <?php endif;?>
</table><input type="hidden" name="id" id="id" value="<?php echo $user['id'];?>">
        <input type="hidden" name="op" id="op" value="save">
</form>
<script>
UEF.init();
</script>