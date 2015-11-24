<p class="green_cl btn usr"><a href="index.php?q=users&id=0">New User</a></p>
 <ul class="users_list">
  <?php foreach($users as $u):?>
  <li><?php echo $u['email'];?> <a href="?q=users&id=<?php echo $u['id'];?>" class="green_cl btn">edit</a></li>
  <?php endforeach;?>
 </ul>
 