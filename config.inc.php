<?php
# Fail2Ban Webinterface (f2bwi)
# Monitoring fail2ban and manually ban / release IP's
# (c) 2017 CC-BY-SA 3.0 Steffen Ille <steffen@php-works.net>

#####################
# FAIL2BAN SETTINGS #
#####################

$f2b['socket']='/var/run/fail2ban/fail2ban.sock'; # path to the Fail2Ban socket file
$f2b['usedns']=true; # show hostnames per banned IP [true|false]
$f2b['noempt']=true; # do not show jails without banned clients [true|false]
$f2b['jainfo']=true; # show jail information in table headers [true|false]

######################
# DO NOT EDIT PLEASE #
######################
$f2b['version']='0.1a (2017-07)';

?>