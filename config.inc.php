<?php


#####################
# FAIL2BAN SETTINGS #
#####################

$f2b['socket']='/var/run/fail2ban/fail2ban.sock'; # path to the Fail2Ban socket file (Must CMDOD to 777)
$f2b['usedns']=true; # show hostnames per banned IP [true|false]
$f2b['noempt']=true; # do not show jails without banned clients [true|false]
$f2b['jainfo']=true; # show jail information in table headers [true|false]

######################
# DO NOT EDIT PLEASE #
######################
$f2b['version']='0.1a (2017-07)';

?>
