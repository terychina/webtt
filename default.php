<?
$host=$_SERVER['HTTP_HOST'];
/*
Directory Listing Script - Version 2
====================================
Script Author: Ash Young <ash@evoluted.net>. www.evoluted.net
Layout: Manny <manny@tenka.co.uk>. www.tenka.co.uk
*/
$startdir = '.';
$showthumbnails = false; 
$showdirs = true;
$forcedownloads = false;
$hide = array(
				'dlf',
				'public_html',				
				'index.php',
				'Thumbs',
				'.htaccess',
				'.htpasswd'
			);
$displayindex = false;
$allowuploads = false;
$overwrite = false;

$indexfiles = array (
				'index.html',
				'index.htm',
				'default.htm',
				'default.html'
			);
			
$filetypes = array (
				'png' => 'jpg.gif',
				'jpeg' => 'jpg.gif',
				'bmp' => 'jpg.gif',
				'jpg' => 'jpg.gif', 
				'gif' => 'gif.gif',
				'zip' => 'archive.png',
				'rar' => 'archive.png',
				'exe' => 'exe.gif',
				'setup' => 'setup.gif',
				'txt' => 'text.png',
				'htm' => 'html.gif',
				'html' => 'html.gif',
				'php' => 'php.gif',				
				'fla' => 'fla.gif',
				'swf' => 'swf.gif',
				'xls' => 'xls.gif',
				'doc' => 'doc.gif',
				'sig' => 'sig.gif',
				'fh10' => 'fh10.gif',
				'pdf' => 'pdf.gif',
				'psd' => 'psd.gif',
				'rm' => 'real.gif',
				'mpg' => 'video.gif',
				'mpeg' => 'video.gif',
				'mov' => 'video2.gif',
				'avi' => 'video.gif',
				'eps' => 'eps.gif',
				'gz' => 'archive.png',
				'asc' => 'sig.gif',
			);
			
error_reporting(0);
if(!function_exists('imagecreatetruecolor')) $showthumbnails = false;
$leadon = $startdir;
if($leadon=='.') $leadon = '';
if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';
$startdir = $leadon;

if($_GET['dir']) {
	//check this is okay.
	
	if(substr($_GET['dir'], -1, 1)!='/') {
		$_GET['dir'] = $_GET['dir'] . '/';
	}
	
	$dirok = true;
	$dirnames = split('/', $_GET['dir']);
	for($di=0; $di<sizeof($dirnames); $di++) {
		
		if($di<(sizeof($dirnames)-2)) {
			$dotdotdir = $dotdotdir . $dirnames[$di] . '/';
		}
		
		if($dirnames[$di] == '..') {
			$dirok = false;
		}
	}
	
	if(substr($_GET['dir'], 0, 1)=='/') {
		$dirok = false;
	}
	
	if($dirok) {
		 $leadon = $leadon . $_GET['dir'];
	}
}



$opendir = $leadon;
if(!$leadon) $opendir = '.';
if(!file_exists($opendir)) {
	$opendir = '.';
	$leadon = $startdir;
}

clearstatcache();
if ($handle = opendir($opendir)) {
	while (false !== ($file = readdir($handle))) { 
		//first see if this file is required in the listing
		if ($file == "." || $file == "..")  continue;
		$discard = false;
		for($hi=0;$hi<sizeof($hide);$hi++) {
			if(strpos($file, $hide[$hi])!==false) {
				$discard = true;
			}
		}
		
		if($discard) continue;
		if (@filetype($leadon.$file) == "dir") {
			if(!$showdirs) continue;
		
			$n++;
			if($_GET['sort']=="date") {
				$key = @filemtime($leadon.$file) . ".$n";
			}
			else {
				$key = $n;
			}
			$dirs[$key] = $file . "/";
		}
		else {
			$n++;
			if($_GET['sort']=="date") {
				$key = @filemtime($leadon.$file) . ".$n";
			}
			elseif($_GET['sort']=="size") {
				$key = @filesize($leadon.$file) . ".$n";
			}
			else {
				$key = $n;
			}
			$files[$key] = $file;
			
			if($displayindex) {
				if(in_array(strtolower($file), $indexfiles)) {
					header("Location: $file");
					die();
				}
			}
		}
	}
	closedir($handle); 
}

//sort our files
if($_GET['sort']=="date") {
	@ksort($dirs, SORT_NUMERIC);
	@ksort($files, SORT_NUMERIC);
}
elseif($_GET['sort']=="size") {
	@natcasesort($dirs); 
	@ksort($files, SORT_NUMERIC);
}
else {
	@natcasesort($dirs); 
	@natcasesort($files);
}

//order correctly
if($_GET['order']=="desc" && $_GET['sort']!="size") {$dirs = @array_reverse($dirs);}
if($_GET['order']=="desc") {$files = @array_reverse($files);}
$dirs = @array_values($dirs); $files = @array_values($files);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width">
<title>Welcome to <? print $host; ?></title>
<link rel="stylesheet" type="text/css" href="http://www.000webhost.com/images/index/styles.css" />
</head>
<body>
	<style>
		 body{background-color:#fff;font: normal 100% Helvetica, Arial, sans-serif; margin:0;padding:0;}
		 a{text-decoration:none;}
		 ul{list-style-type:none;}
		 img{border:0} 
		.clear{clear:both;}
		 div{display:block;}
		.header-damo{width: auto;height: 110px;margin:0;padding:0;border-bottom:1px solid #e1e1e1;}
		.header-damo ul{width: 100%;height: 100%;margin:0;padding:0;}
		.header-damo ul li{float:left;margin:0 0.83%;line-height:100%;width:15%;height:100%;}
		.header-damo ul li a{font-size:0.75em;color:#000;width:100%;height:auto;margin:0 auto;cursor:pointer;}
		.header-damo ul li.active-damo{background-color:#F20303;}
		.header-damo ul li.active-damo a{color:#fff;}
		.header-damo ul li.active-damo a span.en-menu{color:#fff;}
	    .header-damo ul li.on-damo{background-color:#F20303;}
		.header-damo ul li.on-damo a{color:#fff;}
		.header-damo ul li.on-damo a span.en-menu{color:#fff;}
		.header-damo ul li span{line-height:16px;height:16px;display:block;text-align:center;}
		.header-damo ul li a span.cn-menu{margin:40px 0 10px 0;padding:0;}
		.header-damo ul li a span.en-menu{font-size:0.75em;color:#6c6c6c;}		
		.header-damo img{width: 100%; max-width: 100%;height: 69px;float: left;}
		.logo-damo{width: 20%;height:112px;line-height:112px;vertical-align:middle; }
		.logo-damo div.logo-img{margin-top:16.5px;width:auto;height:auto;overflow:hidden; padding-top:0;}
		.logo-damo a{width:auto;height:auto;}
		.menu-damo{width:1024px;height:100%;margin:0 auto;border-bottom:1px solid #e1e1e1;}
		.menu-damo div.logo-damo{float:left;margin:0 auto;}
		.menu-list-damo{width: 60%;height: 100%;text-align:right;float:right;}
		@media screen and (max-device-width: 768px) {
		.menu-damo{width: 768px;}	
		}

	</style>
	<script src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
	<script>
		$(function(){
			$(".nav-damo li").hover(function(){
				$(this).addClass("on-damo");
			},function(){
				$(this).removeClass("on-damo");
			});
		})
	</script>
	<div class="header-damo">
		<div class="menu-damo">
			<div class="logo-damo"><div class="logo-img"><a href="#"><img src="http://nanjing.zhuangxiubao.com/data/images/2016/08/1471498724_9567.jpg" alt=""></a></div></div>
			 <div class="menu-list-damo">
				<ul class="nav-damo">
					<li class="active-damo"><a href="#"><span class="cn-menu">首页</span><span class="en-menu">Home</span></a></li>  
					<li><a href="#"><span class="cn-menu">案例展示</span><span class="en-menu">Case</span></a></li>
					<li><a href="#"><span class="cn-menu">设计团队</span><span class="en-menu">Team</span></a></li>
					<li><a href="#"><span class="cn-menu">关于我们</span><span class="en-menu">About us</span></a></li>
					<li><a href="#"><span class="cn-menu">新闻动态</span><span class="en-menu">News</span></a></li>
					<li><a href="#"><span class="cn-menu">联系我们</span><span class="en-menu">Contact us</span></a></li>	
				</ul>	
			</div>
		</div>
	</div>
	<p class="clear"></p>
<div id="container"> <!-- 
  <h1>Your  website is up and running!</h1> <div id="breadcrumbs">
    <p>Website <strong><? print $host; ?></strong> has been successfully installed on
      server.<br />
      Please delete file &quot;<strong>default.php</strong>&quot; from <strong>public_html</strong> folder and upload your website by using FTP or web based File Manager.<br />
      <br />
      - Your account information can be found on <a href="http://members.000webhost.com/"><u>http://members.000webhost.com/</u></a><br />
      - If you need help, please check our <a href="http://www.000webhost.com/forum/" target="_blank"><u>forums</u></a> and and <a href="http://www.000webhost.com/faq.php"><u>FAQ List</u></a> or submit a ticket.<br />    
      - Please review our <a href="http://www.000webhost.com/includes/tos.php" target="_blank"><u>Terms Of Service</u></a> to see what is not allowed to upload.<br />
    </p>
    <p><span class="style3">If you  are going to violate our <a href="http://www.000webhost.com/includes/tos.php" target="_blank"><u>TOS</u></a>, please read this text until it's not too late!<br /> 
      Do not waste your time with 000webhost.com, if you are going to upload any illegal website here! All websites are manually reviewed by humans, so if we will notice anything illegal, your account will be terminated. So don't waste your time in promoting your scams, hacking websites, or anything else malicious - your account will be terminated in 5 minutes after we will receive first abuse report or anything abusive will be detected by our staff. We also report <strong>all</strong> illegal activities to  local and international authorities.</span>
	</p>      
  	<p>Below you can see your current files in <strong>public_html</strong> folder.</p>
  </div>
  <div id="listingcontainer">
    <div id="listingheader"> 
	<div id="headerfile">File</div>
	<div id="headersize">Size</div>
	<div id="headermodified">Last Modified</div>
	</div>	-->

    <div id="listing">
	<?
	$class = 'b';
	if($dirok) {
	?>
	<div><a href="<?=$dotdotdir;?>" class="<?=$class;?>"><img src="http://www.000webhost.com/images/index/dirup.png" alt="Folder" /><strong>..</strong> <em>-</em> <?=date ("M d Y h:i:s A", filemtime($dotdotdir));?></a></div>
	<?
		if($class=='b') $class='w';
		else $class = 'b';
	}
	$arsize = sizeof($dirs);
	for($i=0;$i<$arsize;$i++) {
	?>
	<div><a href="<?=$leadon.$dirs[$i];?>" class="<?=$class;?>"><img src="http://www.000webhost.com/images/index/folder.png" alt="<?=$dirs[$i];?>" /><strong><?=$dirs[$i];?></strong> <em>-</em> <?=date ("M d Y h:i:s A", filemtime($leadon.$dirs[$i]));?></a></div>
	<?
		if($class=='b') $class='w';
		else $class = 'b';	
	}
	
	$arsize = sizeof($files);
	for($i=0;$i<$arsize;$i++) {
		$icon = 'unknown.png';
		$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
		$supportedimages = array('gif', 'png', 'jpeg', 'jpg');
		$thumb = '';
				
		if($filetypes[$ext]) {
			$icon = $filetypes[$ext];
		}
		
		$filename = $files[$i];
		if(strlen($filename)>43) {
			$filename = substr($files[$i], 0, 40) . '...';
		}
		
		$fileurl = $leadon . $files[$i];
	?>
	<!--<div><a href="<?=$fileurl;?>" class="<?=$class;?>"<?=$thumb2;?>><img src="http://www.000webhost.com/images/index/<?=$icon;?>" alt="<?=$files[$i];?>" /><strong><?=$filename;?></strong> <em><?=round(filesize($leadon.$files[$i])/1024);?>KB</em> <?=date ("M d Y h:i:s A", filemtime($leadon.$files[$i]));?><?=$thumb;?></a></div>-->
	<?
		if($class=='b') $class='w';
		else $class = 'b';	
	}	
	?></div>
  </div>
</div>
<!--<div id="copy">Free <a href="http://www.hosting24.com/">Web Hosting</a> by <a href="http://www.000webhost.com/">www.000webhost.com</a></div>-->
</body>
</html>
