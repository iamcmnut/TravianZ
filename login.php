<?php

#################################################################################
##              -= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =-                 ##
## --------------------------------------------------------------------------- ##
##  Filename       login.php                                                   ##
##  Developed by:  Dzoki                                                       ##
##  License:       TravianX Project                                            ##
##  Copyright:     TravianX (c) 2010-2011. All rights reserved.                ##
##                                                                             ##
#################################################################################

use App\Utils\AccessLogger;

if(!file_exists('var/installed') && @opendir('install')) {
    header("Location: install/");
    exit;
}

include("GameEngine/Account.php");
AccessLogger::logRequest();

if(isset($_GET['del_cookie'])) {
	setcookie("COOKUSR","",time()-3600*24,"/");
	header("Location: login.php");
	exit;
}
if(!isset($_COOKIE['COOKUSR'])) {
	$_COOKIE['COOKUSR'] = "";
}

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    if ( !isset( $_SESSION[ 'csrf' ] ) || $_SESSION[ 'csrf' ] !== $_POST[ 'csrf' ] )
        throw new RuntimeException( 'CSRF attack' );
}
$key                = sha1( microtime() );
$_SESSION[ 'csrf' ] = $key;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<title><?php echo SERVER_NAME; ?> - Login</title>
		<link rel="shortcut icon" href="favicon.ico"/>
	<meta name="content-language" content="en" />
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<script src="mt-core.js?0faab" type="text/javascript"></script>
	<script src="mt-more.js?0faab" type="text/javascript"></script>
	<script src="unx.js?f4b7j" type="text/javascript"></script>
	<script src="new.js?0faab" type="text/javascript"></script>
	<link href="<?php echo GP_LOCATE; ?>lang/en/compact.css?f4b7h" rel="stylesheet" type="text/css" />
	<link href="<?php echo GP_LOCATE; ?>lang/en/lang.css?f4b7d" rel="stylesheet" type="text/css" />
	<link href="<?php echo GP_LOCATE ?>travian.css?f4b7d" rel="stylesheet" type="text/css" />
		<link href="<?php echo GP_LOCATE ?>lang/en/lang.css" rel="stylesheet" type="text/css" />
		<script>
			function connectWallet() {
				if (typeof window.ethereum !== 'undefined') {
					const res = ethereum.request({ method: 'eth_requestAccounts' });
					res.then((acc) => {
						document.getElementById('btn_login').style.display = "";
						document.getElementById('login_form').style.display = "";
						document.getElementById('wallet_id').innerText = acc[0];
						document.getElementById('btn_connect').style.display = "none";
					}).catch((err) =>{
						// document.getElementById('btn_login').style.display = "";
						// document.getElementById('login_form').style.display = "";
						// document.getElementById('btn_connect').style.display = "none";
					})
				}
			}
		</script>
	   </head>

<body class="v35 ie ie7" onload="initCounter()">

<div class="wrapper">
<div id="dynamic_header">
</div>
<div id="header"></div>
<div id="mid">
<?php include("Templates/menu.tpl"); ?>

<div id="content"  class="login">

<h1><img class="img_login" src="img/x.gif" alt="log in the game" /></h1>

<?php
$time = time();
if( COMMENCE > $time )
{
echo '<p><font color="red" size="6">'.NOT_OPENED_YET.'</font></p>' ;
}
else
{
?>
<h5><img class="img_u04" src="img/x.gif" alt="login" /></h5>
<p><?php echo COOKIES; ?></p>
<?php
$stime = strtotime(START_DATE) - strtotime(date('d.m.y')) + strtotime(START_TIME);
if($stime > time()){
?>
<br/><div style="text-align: center"><big>Server will start in: </big></div>
<script language="JavaScript">
TargetDate = "<?php echo START_DATE; ?> <?php echo START_TIME; ?>";
CountActive = true;
CountStepper = -1;
LeadingZero = true;
DisplayFormat = "%%H%%:%%M%%:%%S%%";
FinishMessage = "START NOW";

function calcage(secs, num1, num2) {
  s = ((Math.floor(secs/num1))%num2).toString();
  if (LeadingZero && s.length < 2)
	s = "0" + s;
  return "" + s + "";
}

function CountBack(secs) {
  if (secs < 0) {
	document.getElementById("cntdwn").innerHTML = FinishMessage;
	return;
  }
  DisplayStr = DisplayFormat.replace(/%%D%%/g, calcage(secs,86400,100000));
  DisplayStr = DisplayStr.replace(/%%H%%/g, calcage(secs,3600,100000));
  DisplayStr = DisplayStr.replace(/%%M%%/g, calcage(secs,60,60));
  DisplayStr = DisplayStr.replace(/%%S%%/g, calcage(secs,1,60));

  document.getElementById("cntdwn").innerHTML = DisplayStr;
  if (CountActive)
	setTimeout("CountBack(" + (secs+CountStepper) + ")", SetTimeOutPeriod);
}

function putspan(backcolor, forecolor) {
  document.write("<div class='activation_time' id='cntdwn'></div>");
}

if (typeof(BackColor)=="undefined")
  BackColor = "white";
if (typeof(ForeColor)=="undefined")
  ForeColor= "black";
if (typeof(TargetDate)=="undefined")
  TargetDate = "12/31/2020 5:00 AM";
if (typeof(DisplayFormat)=="undefined")
  DisplayFormat = "%%H%%:%%M%%:%%S%%";
if (typeof(CountActive)=="undefined")
  CountActive = true;
if (typeof(FinishMessage)=="undefined")
  FinishMessage = "";
if (typeof(CountStepper)!="number")
  CountStepper = -1;
if (typeof(LeadingZero)=="undefined")
  LeadingZero = true;


CountStepper = Math.ceil(CountStepper);
if (CountStepper == 0)
  CountActive = false;
var SetTimeOutPeriod = (Math.abs(CountStepper)-1)*1000 + 990;
putspan(BackColor, ForeColor);
var dthen = new Date(TargetDate);
var dnow = new Date();
if(CountStepper>0)
  ddiff = new Date(dnow-dthen);
else
  ddiff = new Date(dthen-dnow);
gsecs = Math.floor(ddiff.valueOf()/1000);
CountBack(gsecs);

</script>
<?php
}else{ ?>
<form method="post" name="snd" action="login.php">
<input type="hidden" name="ft" value="a4" />
<script type="text/javascript">
Element.implement({
	 //imgid: if an arrow belongs to the link this can be "opened"
	 showOrHide: function(imgid) {
		 //insert
		 if (this.getStyle('display') == 'none')
		 {
			 if (imgid != '')
			 {
				 $(imgid).className = 'open';
			 }
		 }
		 //hide
		 else
		 {
			 if (imgid != '')
			 {
				 $(imgid).className = 'close';
			 }
		 }
		 this.toggleClass('hide');
	}
});
</script>
<table cellpadding="1" cellspacing="1" id="login_form">
	<tbody>
		<tr class="top">
			<th>Wallet ID</th>
			<td><span id="wallet_id"></span></td>
		</tr>
		<tr class="top">
			<th><?php echo NAME; ?></th>
			<td><input class="text" type="text" name="user" value="<?php echo stripslashes(stripslashes(stripslashes($form->getDiff("user",$_COOKIE['COOKUSR'])))); ?>" maxlength="30" autocomplete='off' /> <span class="error"> <?php echo $form->getError("user"); ?></span></td>
		</tr>
		<tr class="btm">
			<th><?php echo PASSWORD; ?></th>
			<td><input class="text" type="password" name="pw" value="<?php echo $form->getValue("pw");?>" maxlength="100" autocomplete='off' /> <span class="error"><?php echo $form->getError("pw"); ?></span></td>
		</tr>
	</tbody>
</table>

<p class="btn">
	<!--<input type="hidden" name="e1d9d0c" value="" />-->
		<button value="login" name="s1"	onclick="xy();" id="btn_login" class="trav_buttons" alt="login button"/> Login </button>
</p>
<p class="btn">
	<!--<input type="hidden" name="e1d9d0c" value="" />-->
		<!-- <input type="button" class="trav_buttons" onclick="connectWallet()" value="Connect Wallet" id="btn_connect"> -->
		
</p>

</form>
<?php }
}
if ($form->getError("pw") == LOGIN_PW_ERROR) {
echo "<p class=\"error_box\">
	<span class=\"error\">".PW_FORGOTTEN."</span><br>
	".PW_REQUEST."<br>
	<a href=\"password.php?npw=".$database->getUserField($form->getValue('user'), 'id', 1)."\">".PW_GENERATE."</a>
</p>";
}
if($form->getError("activate") != "") {
	echo "<p class=\"error_box\">
	<span class=\"error\">".EMAIL_NOT_VERIFIED."</span><br>
	".EMAIL_FOLLOW."<br>
	<a href=\"activate.php?usr=".$form->getError("activate")."\">".VERIFY_EMAIL."</a>
	</p>";
}
if($form->getError("vacation") != "") {
echo "<p class=\"error_box\">
<span class=\"error\">".$form->getError("vacation")."</span></p>";
}
?>
</div>
<div id="side_info" class="outgame">
<?php
if(NEWSBOX1) { include("Templates/News/newsbox1.tpl"); }
if(NEWSBOX2) { include("Templates/News/newsbox2.tpl"); }
if(NEWSBOX3) { include("Templates/News/newsbox3.tpl"); }
?>
			</div>

<div class="clear"></div>
			</div>

			<div class="footer-stopper outgame"></div>
			<div class="clear"></div>

<?php include("Templates/footer.tpl"); ?>
<div id="ce"></div>
</body>
</html>
