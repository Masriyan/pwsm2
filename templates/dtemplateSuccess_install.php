<html>
    <title>PHP Web Security Monitor - Installation Wisard</title>

    <head>
    <META NAME=robots CONTENT="noindex,follow">
    <link rel="stylesheet" type="text/css" href="../staff/style.css" />
    <script type="text/javascript" src="../staff/jquery-1.11.3.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    </head>
    <body>
    
    <div class="content">
    <div class="header">
	<div class="logo">
	<a href="http://romanshneer.info/pwsm/" title="PHP Web Security Monitor">
    <img src="../staff/logo1.png" title="PHP Web Security Monitor" alt="PHP Web Security Monitor">
    </a></div>
	<div class="headername">
    <h1>PHP Web Security Monitor - Installation Wisard</h1>
	</div>
	</div>    
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
    ?></div>
    <div class="footer"><?php echo $headers['footer'];?></div>
    </body></html>