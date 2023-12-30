<?php

 
require_once('engine.inc.php');


if(isset($_POST['submit']))
{ $error2=ban_ip($_POST['ban_jail'],$_POST['ban_ip']);
  if($error2!='OK'){ if($error2=='nojailselected') { $error2='<font class="msg_er">'.$nojailselected.'</font>'; } if($error2=='novalidipaddress') { $error2='<font class="msg_er">'.$novalidipaddress.'</font>'; } if($error2=='couldnotbanthisip') { $error2='<font class="msg_er">'.$couldnotbanthisip.'</font>'; }}
  else
  { $error2='<font class="msg_ok">'.$ipsuccessfullybanned.'</font>';
  	unset($_POST); clearstatcache(); sleep(1);
} }

if($_GET['j']!='' && $_GET['c']!='')
{ $error1=unban_ip($_GET['j'],$_GET['c']);
 if($error1!='OK'){ $error1='<font class="msg_er">'.$error1.'</font>'; }
  else
  { $error1='<font class="msg_ok">'.$ipsuccessfullyunbanned.'</font>';
  	unset($_GET); clearstatcache(); sleep(1);
} }


 
$jails=list_jails();
foreach($jails as $j=>$i){ $banned=list_banned($j); $jails[$j]=$banned; }
?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style.css" type="text/css" charset="utf-8">
<title>Fail2Ban Webinterface</title>
</head>
<body>
<h1>Fail2Ban Webinterface</h1></td>
<button name="reload" onclick="location.href='<?=$_SERVER['PHP_SELF']?>';"><img src="images/reload.png" alt="add">&nbsp;<?php echo $Refresh; ?></button>


<?php
$erg2=@exec('sudo /usr/bin/fail2ban-client status');
 if($erg2==''){ echo '<h1><p class="msg_er">'.$serviceerror.'</p> </h1>'; exit; }
 ?> 
 

<h2><?php echo $BannedclientsperJail; ?></h2>
<p><?=$error1?></p>
<p><?=$error2?></p>

<table>
<?php
foreach($jails as $j=>$cli)
{ if($f2b['noempt']===false || is_array($cli))
  { echo '<tr><td class="bold" colspan="2">'.strtoupper($j);
    if($f2b['jainfo']===true)
    { $inf=jail_info($j);
      $inf=implode(', ',$inf);
      echo ' <span class="msg_gr">'.$inf.'</span>';
    }
    echo '</td></tr>';
    if(is_array($cli))
    { foreach($cli as $i=>$c)
      { $ip=strstr($c,'(',true);
      	echo '<tr><td align="center">
        <a href="'.$_SERVER['PHP_SELF'].'?j='.$j.'&c='.$ip.'"><img src="images/del.gif" alt="del" title="'.$UnbanIP.'"></a>
        </td><td>'.$c.'</td></tr>';
      }
    } else { echo '<tr><td colspan="2" class="msg_gr"><?php echo $nobannedclients; ?></td></tr>'; }
} }
?>
</table>
<br>
<h2> <?php echo $ManuallyaddbannedclienttoJail; ?></h2>
<form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
<table>
<tr>
 <td>
  <select name="ban_jail" size="1">
  <option value="">- <?php echo $select; ?> -</option>
  <?php foreach($jails as $j=>$cli){ echo '<option value="'.$j.'"'; if($_POST['ban_jail']==$j){ echo ' selected'; } echo '>'.$j.'</option>'; } ?>
  </select>
 </td>
 <td><input type="text" name="ban_ip" size="18" value="<?=$_POST['ban_ip']?>"></td>
 <td><button type="submit" name="submit"><img src="images/add.gif" alt="add">&nbsp;<?php echo $BanIP; ?></button></td>
</tr>
</table>
</form>
<br>
<?php echo date("r"); ?>
<p class="msg_gr"><?php echo $version; ?>: <?=$f2b['version']?></p>
</body>
</html>
