<?php if(isset($_GET['new_agent'])&&(count($objects)==0)):?><div class='message'><b>Object <?php echo urldecode($_GET['new_agent']);?></b> patched, waiting for initialisation, go to site url for startup initialisation,after just refresh the page.</div><?php endif;?>
 <div class="new_div"><a href="?q=new_agent" class="new_btn">Patch New Object</a></div>
 <?php if($objects):?>
 <div class="request_tbl_div"><table border=1 class="request_tbl">
         <tr class="request_tbl_header"><th>Object source</th><th>Options</th><th>Actions</th></tr>

 <?php foreach($objects as $o):?>
 	
    <tr>
     <td><a href="?q=view_file&id=<?php echo $o['id'];?>" target="_blank"><?php echo $o['object_source'];?></a></td>
     <td>
             <label>Enable:</label>
             <small>
             <input type="checkbox" id="POST<?php echo $o['id'];?>" class="cb_al" cb_type="POST" cb_id="<?php echo $o['id'];?>" <?php if($o['POST']):?> checked="checked"<?php endif;?>><label for="POST<?php echo $o['id'];?>">POST</label>&nbsp;
             <input type="checkbox" id="GET<?php echo $o['id'];?>" class="cb_al" cb_type="GET" cb_id="<?php echo $o['id'];?>" <?php if($o['GET']):?> checked="checked"<?php endif;?>><label for="GET<?php echo $o['id'];?>">GET</label>&nbsp;
             <input type="checkbox" id="COOKIE<?php echo $o['id'];?>" class="cb_al" cb_type="COOKIE" cb_id="<?php echo $o['id'];?>" <?php if($o['COOKIE']):?> checked="checked"<?php endif;?>><label for="COOKIE<?php echo $o['id'];?>">COOKIE</label>&nbsp;&nbsp;
             <input type="checkbox" id="stoped_only<?php echo $o['id'];?>" class="cb_al" cb_type="stoped_only" cb_id="<?php echo $o['id'];?>" <?php if($o['stoped_only']):?> checked="checked"<?php endif;?>><label for="stoped_only<?php echo $o['id'];?>">Log Stoped only</label>
             </small>
     </td>
     <td>
     <a href="?q=request_statistics&id=<?php echo $o['id'];?>" class="green_cl btn" >Statistics</a>&nbsp;
         <a href="javascript://" object_id="<?php echo $o['id']?>" object_url='<?php echo $o['object_source'];?>' class="red_cl1 btn uninstall" >Uninstall</a>    
     </td>
    </tr>
   <?php endforeach;?>
 </table></div>
 <?php else:?>
<div class="message">No patched and monitored objects, first - patch new web object and initialise it</div>
<?php endif;?>
<script>AL.init();</script>