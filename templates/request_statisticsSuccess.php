<?php $object_folder=substr($object['object_source'],0,strrpos($object['object_source'],"/"));?>
 <div class="box"><table>
 <tr><td>Object Source:</td><td><a href="?q=view_file&id=<?php echo $object['id'];?>" target=_blank><?php echo $object['object_source'];?></a></td></tr>
 <tr><td>Object Directory Browse:</td><td><a href="?q=new_agent&dir=<?php echo urlencode($object_folder);?>"><?php echo $object_folder;?></a></td></tr>
 <tr><td>Register date:</td><td><?php echo date("H:i d/m/Y",$object['created']);?></td></tr>
 </table></div>
 

<div class="buttons_row">
    <div id="search_form_btn" class="btn green_cl">Search</div>
    <div id="remove_stat_btn">
     <form action="" method="POST">
     <input type="hidden" name="id" value="<?php echo $id;?>">
     <input class="remove_btn btn red_cl" type="submit" value="Remove Statistics" name="op" onClick="return confirm('Sure want delete all request statistics for object?')">
     </form>
    </div>
</div>
<div id="search_form">
    <form action="" method="GET">
        <input type="hidden" name="q" value="request_statistics">    
        <input type="hidden" name="id" value="<?php echo $id?>">    
    <table><tr>
    <td>IP:<input type="text" name="ip" value="<?php echo (isset($_GET['ip'])?$_GET['ip']:'');?>" class="inp"></td>
    <td>Query fragment:<input type="text" name="query" value="<?php echo (isset($_GET['query'])?$_GET['query']:'');?>" class="inp"></td>
    <td>Date:<input type="date" name="from" id="from" value="<?php echo (isset($_GET['from'])?$_GET['from']:'');?>" class="inp"> - <input type="date" name="to" id="to" value="<?php echo (isset($_GET['to'])?$_GET['to']:'');?>" class="inp"></td>
    <td>Status:<select name="status" class="inp">
            <?php
            $opts=Array('all'=>'All','1'=>'Blocked','0'=>'Allowed');
            foreach($opts as $k=>$v):
            ?>
            <option value="<?php echo $k?>" <?php if(isset($_GET['status'])&&($_GET['status']==$k)):?> selected<?php endif;?>><?php echo $v;?></option>
            <?php endforeach;?>
        </select>
    </td>
    <td>Method:
        <select name="method" class="inp">
            <?php
            $opts=Array('all'=>'All','GET'=>'GET','POST'=>'POST','COOKIE'=>'COOKIE');
            foreach($opts as $k=>$v):
            ?>
            <option value="<?php echo $k?>" <?php if(isset($_GET['method'])&&($_GET['method']==$k)):?> selected<?php endif;?>><?php echo $v;?></option>
            <?php endforeach;?>
        </select>
    </td>
   <td><input type="submit" name="op" value="find" class="green_cl btn">
       <input type="button" id="search_form_close" value="x" class="red_cl btn">
    </td>
    </tr></table>
    </form>   
</div>
    <div>Total:<b><?php echo $pss->results_count?></b> requests </div>
 <div id="request_tbl_box">
 <div class="request_tbl_div">
 <table border=1 class="request_tbl">
 <tr class="request_tbl_header">
 <td class="status_w" ><label id="chg_status">Status</label></td>
 <td class="url_w"><label  id="chg_url">URL</label></td>
 <td class="query_string_w"><label id="chg_query_string">QUERY_STRING</label></td>
 <td class="method_w"><label id="chg_method">Method</label></td>
 <td class="remote_addr_w"><label id="chg_remote_ip">REMOTE_ADDR</td>
 <td class="date_w"><label id="chg_date">Date</label></td>
 </tr>
 <?php
 $i=0;
 $color_tr="#fff";
 if($requests)
 foreach($requests as $req):
     #print_r(unserialize($req['vars']));
     ?>
 	
 	
<tr style="background:<?php echo $color_tr;?>">
<td class="status_w"><span class="show_info" show_type="request_reason" show_id="<?php echo $req['id'];?>" title=""><?php echo PSS::_draw_request_status($req['status']);?></span></td>
<td><div class="url_w"><a href="<?php echo $req['url'];?>" target=_blank><?php echo $req['url'];?></a></div><div class="copy_box">&nbsp;<?php echo $pss->copy_link($req['url'],$req['vars'],$req['method']);?></div></td>
 <td><div class="query_string_w"><a href="<?php echo $req['query_string'];?>" target="Blank"><?php echo $req['query_string'];?></a></div><div class="copy_box">&nbsp;<?php echo $pss->copy_link($req['query_string'],$req['vars'],$req['method']);?></div></td>
 <td class="method_w"><?php echo $req['method'];?></td>
 <td class="remote_addr_w"><?php echo $req['remote_addr'];?></td>

 <td class="date_w"><?php echo date("H:i d/m/Y",$req['created']);?></td>
 </tr>
<?php
 	$i++;
 	if($color_tr=='#fff')$color_tr='#FFFFAA';
 	else $color_tr='#fff';
endforeach;?>

 <tr class="count"><td colspan=6>>><?php echo $i;?></td></tr>
 </table></div></div>
<?php if($i<$pss->results_count):?>
 <div>
 <script>
     RS.result_num=<?php echo $i;?>;
     RS.results_count=<?php echo $pss->results_count;?>;
 </script>
 <a href="javascript://" rel="<?php echo $id;?>" id="more_btn">More...</a></div>
 <?php endif;?>
<script>
RS.chg_status='<?php echo isset($_GET['status'])?$_GET['status']:'all';?>';
RS.chg_method='<?php echo isset($_GET['method'])?$_GET['method']:'all';?>';
RS.results_step=<?php echo PSS::$results_step;?>;
RS.ip='<?php echo (isset($_GET['ip'])&&(!empty($_GET['ip'])))?$_GET['ip']:'';?>';
RS.query='<?php echo (isset($_GET['query'])&&(!empty($_GET['query'])))?$_GET['query']:'';?>';
RS.from='<?php echo (isset($_GET['from'])&&(!empty($_GET['from'])))?$_GET['from']:'';?>';
RS.to='<?php echo (isset($_GET['to'])&&(!empty($_GET['to'])))?$_GET['to']:'';?>';
RS.status='<?php echo (isset($_GET['status'])&&($_GET['status']!='all'))?$_GET['status']:'';?>';
RS.method='<?php echo (isset($_GET['method'])&&($_GET['method']!='all'))?$_GET['method']:'';?>';
RS.init();
</script>