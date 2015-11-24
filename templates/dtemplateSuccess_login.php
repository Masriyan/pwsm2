<html>
    <title>PHP Web Security Monitor - <?php echo $headers['title'];?></title>
    <head>
    <META NAME=description CONTENT="<?php echo $headers['description'];?>">
    <META NAME=keywords CONTENT="<?php echo $headers['keywords'];?>">
    <META NAME=robots CONTENT="noindex,follow">
    <?php //if(file_exists("../conf/config.php")):?>
    
    <link rel="stylesheet" type="text/css" href="../staff/style.css" />
  <script type="text/javascript" src="../staff/jquery-1.11.3.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
  <script language="JavaScript" src="../staff/lib.js"></script>
    <base href="../">
   </head>
    <body>
	<div class="content">
    <div class="header">
	<div class="logo"><a href="http://romanshneer.info/pwsm/" title="PHP Web Security Monitor"><img src="staff/logo1.png" alt="PHP Web Security Monitor"></a></div>
	<div class="headername"><h1>PHP Web Security Monitor - <?php echo $headers['title'];?></h1>
    
  
    </div></div>
            <div class="center">    
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
    include_once '../templates/'.$template.'Success.php';
    ?>
            </div>
    </div>
    <div class="footer"><?php echo $headers['footer'];?></div>
    </body></html>