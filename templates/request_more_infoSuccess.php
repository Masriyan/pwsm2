<?php $i=$_GET['result_num'];?>
<table border=1 class="request_tbl">
<?php foreach($requests as $req):?>
<tr>
    <td class="status_w">
        <span class="show_info" show_type="request_reason" show_id="<?php echo $req['id'];?>"><?php echo PSS::_draw_request_status($req['status']);?></span>
    </td>
    <td>
        <div class="url_w"><a href="<?php echo $req['url'];?>" target=_blank><?php echo $req['url'];?></a></div>
        <div class="copy_box">&nbsp;<?php echo PSS::copy_link($req['url']);?></div>
    </td>
    <td class="query_string_w"><?php echo $req['query_string']?>&nbsp;</td>
    <td class="method_w"><?php echo $req['method'];?></td>
    <td class="remote_addr_w"><?php echo $req['remote_addr'];?></td>
    <td class="date_w"><?php echo date("H:i d/m/Y",$req['created']);?></td>
</tr> 	
<?php $i++; 
endforeach;?>
<tr class='count'><td colspan=6>>><?php echo $i;?></td></tr>
</table>