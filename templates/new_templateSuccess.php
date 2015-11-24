<?php $protocols=array('GET','POST','COOKIE');?>
<form action="" method="post" name="pattern_form" style="margin:0px;">
<table class="tbl_form">
   
   <tr>
       <td colspan=2><h5><?php echo $title;?></h5></td>
   </tr>
    <tr>
        <th>Code</th>
        <td><input type="text" name="code" value="<?php echo (isset($temp['code'])?$temp['code']:'');?>"></td>
    </tr>
    <tr>
        <th>Description</th>
        <td><textarea name="description"><?php echo (isset($temp['description'])?$temp['description']:'');?></textarea></td>
    </tr>
    <tr>
        <td colspan=2>
            <input type="submit" value="save" name="op" class="green_cl btn"  onClick="return chk_pattern_form()">&nbsp;
        <?php if(isset($_GET['id'])):?>
            <input type="submit" value="delete" name="op" onClick="if(confirm('Sure delete?'))return true;else return false;"  class="red_cl btn">&nbsp;
        <?php endif;?>
        <input type="submit" value="cancel" name="op"  class="gray_cl btn">
        <?php if(isset($temp['id'])):?>
            <input type="hidden" name="id" value="<?php echo $temp['id'];?>">
        <?php endif;?>
        </td>
    </tr>
    
</table>
</form>