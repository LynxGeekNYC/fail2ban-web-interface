<?php
require_once('config.inc.php');
include ("language/$language.php");


function list_jails()
{ global $f2b; $jails=array();
  $erg=@exec('sudo /usr/bin/fail2ban-client status | grep "Jail list:" | awk -F ":" \'{print $2}\' | awk \'{$1=$1;print}\'');
  $erg=explode(",",$erg); foreach($erg as $i=>$j){ $jails[trim($j)]=false; }
  ksort($jails); return $jails;
}

function jail_info($jail)
{ global $f2b; $info=array();
  $erg=@exec('sudo /usr/bin/fail2ban-client get '.escapeshellarg($jail).' findtime ');
  if(is_numeric($erg)){ $info['findtime']='findtime: '.$erg; }
  $erg=@exec('sudo /usr/bin/fail2ban-client get '.escapeshellarg($jail).' bantime ');
  if(is_numeric($erg)){ $info['bantime']='bantime: '.$erg; }
  $erg=@exec('sudo /usr/bin/fail2ban-client get '.escapeshellarg($jail).' maxretry ');
  if(is_numeric($erg)){ $info['maxretry']='maxretry: '.$erg; }
  return $info;
}

function list_banned($jail)
{ global $f2b; $banned=array();
  $erg=@exec('sudo /usr/bin/fail2ban-client status '.$jail.' | grep "IP list:" | awk -F "list:" \'{print$2}\' | awk \'{$1=$1;print}\'');
  if($erg!='')
  { $banned=explode(" ",$erg);
    if($f2b['usedns']===true)
    { foreach($banned as $i=>$cli)
      { $dns=gethostbyaddr($cli);
        if($dns==$cli){ $dns=' (unknown)'; } else { $dns=' ('.$dns.')'; }
        $banned[$i].=$dns;
      }
    } return $banned;
  }
  return false;
}

function ban_ip($jail,$ip)
{ if($jail==''){ return 'nojailselected';  }
  elseif(!filter_var($ip,FILTER_VALIDATE_IP)) { return 'novalidipaddress'; }
  $erg=@exec('sudo /usr/bin/fail2ban-client  set '.escapeshellarg($jail).' banip '.escapeshellarg($ip));
  if($erg!=$ip){ return 'couldnotbanthisip'; }
  return 'OK';
}

function unban_ip($jail,$ip)
{ if($jail==''){ return 'no jail selected'; }
  elseif(!filter_var($ip,FILTER_VALIDATE_IP)) { return 'no valid ip address'; }
  $erg=@exec('sudo /usr/bin/fail2ban-client  set '.escapeshellarg($jail).' unbanip '.escapeshellarg($ip));
  if($erg!=$ip){ return 'could not unban this ip'; }
  return 'OK';
}

?>
