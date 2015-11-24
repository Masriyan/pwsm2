<?php
 $object_folder=substr($object['object_source'],0,strrpos($object['object_source'],"/"));?>
 <div class="box"><table>
 <tr><td>Object Source:</td><td><a href="?q=view_file&id=<?php echo $object['id'];?>" target=_blank><?php echo $object['object_source'];?></a></td></tr>
 <tr><td>Object Directory Browse:</td><td><a href="?q=new_agent&dir=<?php echo urlencode($object_folder);?>"><?php echo $object_folder;?></a></td></tr>
 <tr><td>Register date:</td><td><?php echo date("H:i d/m/Y",$object['created']);?></td></tr>
 <tr><td colspan=2><a href="?q=agents_list&id=<?php echo $object['id'];?>" class="green_cl btn" >Statistics</a></td></tr>
 </table></div> 
<?php
 $new_content=htmlspecialchars(substr($content,0,strpos($content,$agent_content)));
 if(strstr($content,$agent_content))
  {
  $code_exists=true;
  }else{
  $code_exists=false;
  $html.="<div class='error message'>Something wrong! Code of Agent not finded in file, try again patch file and run agent initialisation again</div>";
  }
  $new_content='';
  $new_content.=($code_exists?"<span style='color:red;font-weight:bold;'>":"").htmlspecialchars(substr($content,strpos($content,$agent_content),strlen($agent_content))).($code_exists?"</span>":"");
  $new_content.=htmlspecialchars(substr($content,(strpos($content,$agent_content)+strlen($agent_content)),strlen($content)-(strpos($content,$agent_content)+strlen($agent_content))));
  ?>
<div class="file_code"><pre><code><?php echo $new_content;?></code></pre></div>
 