<html>
    <title>PHP Web Security Monitor 2.0 - <?php echo $headers['title'];?></title>
    <head>
    <META NAME=description CONTENT="<?php echo $headers['description'];?>">
    <META NAME=keywords CONTENT="<?php echo $headers['keywords'];?>">
    <META NAME=robots CONTENT="noindex,follow">
    <?php if(file_exists("../conf/config.php")):?>
    
    <link rel="stylesheet" type="text/css" href="../staff/style.css" />
     <script type="text/javascript" src="../staff/jquery-1.11.3.min.js"></script>
     <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
     <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script language="JavaScript" src="../staff/lib.js"></script>
    <base href="../">
    <?php else:?>
    <link rel="stylesheet" type="text/css" href="staff/style.css" />
     <script type="text/javascript" src="staff/jquery-1.11.3.min.js"></script>
     <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
     <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script language="JavaScript" src="staff/lib.js"></script>
    
    <?php endif;?>


        </head>
    <body>
	<div class="content">
    <div class="header">
	<div class="logo"><a href="http://romanshneer.info/pwsm/" title="PHP Web Security Monitor"><img src="staff/logo1.png" alt="PHP Web Security Monitor"></a></div>
	<div class="headername"><h1>PHP Web Security Monitor 2 - <?php echo $headers['title'];?></h1>
    <table border=0  class="menu">
 	<tr>
  	<td><a href="?q=agents_list">Objects list</a></td>
  	<td><a href="?q=config">Security Patterns</a></td>
  	<td><a href="?q=test_form">Test form</a></td>
  	<td><a href="?q=users">Users</a></td><td><a href="?q=about">About</a></td>
  	<td><a href="?q=exit">Exit</a></td>
 	</tr>
    </table>
  
    </div></div>
            <div class="center"> 
<?php ?>                
<?php if(isset($_SESSION['msg'])):?>                    
<div class='message'><?php echo $_SESSION['msg']; unset($_SESSION['msg']);?></div>                
<?php endif;?>                
<?php if(isset($_SESSION['error'])):?>                    
<div class='message'><?php echo $_SESSION['error']; unset($_SESSION['error']);?></div>                
<?php endif;?>
<?php if(isset($data['msgs'])):?>
    <?php foreach($data['msgs'] as $msg):?>
    <div class='message'><?php echo $msg;?></div>
    <?php endforeach;?>
<?php endif;?>
<?php if(isset($data['errors'])):?>
    <?php foreach($data['errors'] as $error):?>
    <div class='error'><?php echo $error;?></div>
    <?php endforeach;?>
<?php endif;?>     

   <?php         
   extract($data);
   
    include_once 'templates/'.$template.'Success.php';
    ?>
            </div>
    </div>
    <div class="footer"><?php echo $headers['footer'];?></div>
    </body></html>