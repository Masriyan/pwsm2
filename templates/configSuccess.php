<div class="new_div">
    <a href="?q=create_pattern" class="new_btn">Create Pattern</a>&nbsp;
    <a href="?q=new_json_load" class="new_btn">Load patterns from URL Json</a>
    <a href="?q=export_json" class="new_btn">Export JSON file</a>
</div>
<?php if($templates):?>
	<form action="" method="POST" >
	  <div class="request_tbl_div">
            <table border=1 class="templates_tbl" id="templates_tbl">
            <tr class="request_tbl_header">
                <td>Code</td>
                <td>Description</td>
                <td>Active</td>
            </tr>
	  <?php foreach($templates as $temp):?>
	  <?php $class_tr=((isset($_GET['id'])&&($_GET['act']=='new_template'))&&($_GET['id']==$temp['id']))?"red":"";?>
	  <tr>
              <td><?php echo htmlspecialchars($temp['code']);?></td>
              <td><?php echo $temp['description'];?></td>
              <td><input type="checkbox" name="patterns[<?php echo $temp['id'];?>]"<?php if($temp['status']):?> checked="checked"<?php endif;?>>
              &nbsp;<a href="?q=create_pattern&id=<?php echo $temp['id'];?>">edit</a>
              </td>
       
	   </tr>
	  <?php endforeach;?>
	<tr><td colspan="2">
	  <input type="submit" name="op" value="save"  class="gray_cl btn">
          </td>
        </tr>
	  </table></div></form>
<?php else:?>
    <div class="message">No Security Patters loaded </div>
<?php endif;?>