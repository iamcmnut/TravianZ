<?php

#################################################################################
##              -= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =-                 ##
## --------------------------------------------------------------------------- ##
##  Filename       activate.php                                                ##
##  Developed by:  Dixie                                                       ##
##  License:       TravianX Project                                            ##
##  Copyright:     TravianX (c) 2010-2011. All rights reserved.                ##
##                                                                             ##
#################################################################################

use App\Utils\AccessLogger;

include('GameEngine/Account.php');
AccessLogger::logRequest();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<title><?php echo SERVER_NAME . ' - Account Activation'; ?></title>
	<link rel="shortcut icon" href="favicon.ico"/>
	<meta name="content-language" content="en" />
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<script src="mt-core.js?0faab" type="text/javascript"></script>
	<script src="mt-more.js?0faab" type="text/javascript"></script>
	<script src="unx.js?f4b7h" type="text/javascript"></script>
	<script src="new.js?0faab" type="text/javascript"></script>
	<link href="<?php echo GP_LOCATE; ?>lang/en/compact.css?f4b7i" rel="stylesheet" type="text/css" />
	<link href="<?php echo GP_LOCATE; ?>lang/en/lang.css?f4b7d" rel="stylesheet" type="text/css" />
	<link href="<?php echo GP_LOCATE ?>travian.css?f4b7d" rel="stylesheet" type="text/css" />
	<link href="<?php echo GP_LOCATE ?>lang/en/lang.css" rel="stylesheet" type="text/css" />
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-89TBKCW31P');
	</script>
	</head>

<body class="v35 ie ie7" onload="initCounter()">

<div class="wrapper">
<div id="dynamic_header">
</div>
<div id="header"></div>
<div id="mid">
<?php include("Templates/menu.tpl"); ?>
<div id="content"  class="activate">
<?php

	if(isset($_GET['e']) && (START_DATE < date('d.m.y') || START_DATE == date('d.m.y') && START_TIME <= date('H:i')))
	{
		switch($_GET['e'])
		{
			case 1:
				include("Templates/activate/delete.tpl");
				break;
			case 2:
				include("Templates/activate/activated.tpl");
				break;
			case 3:
				include("Templates/activate/cantfind.tpl");
				break;
		}
	} else if(isset($_GET['id']) && isset($_GET['c'])) {
		$c=$database->getActivateField($_GET['id'],"email",0);
		if($_GET['c'] == $generator->encodeStr($c,5)){
			include("Templates/activate/delete.tpl");
		} else { include("Templates/activate/activate.tpl"); }
	} else {
	include("Templates/activate/activate.tpl");
	}

?>
</div>
<div id="side_info" class="outgame">
</div>

<div class="clear"></div>
			</div>

			<div class="footer-stopper outgame"></div>
			<div class="clear"></div>

<?php include("Templates/footer.tpl"); ?>
<div id="ce"></div>
</body>
</html>