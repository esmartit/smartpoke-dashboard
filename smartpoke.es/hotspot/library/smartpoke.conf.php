<?php

$configValues['DB_ENGINE'] = 'postgres';
$configValues['DB_HOST'] = $_ENV["DB_HOST"];
$configValues['DB_PORT'] = $_ENV["DB_PORT"];
$configValues['DB_USER'] = $_ENV["DB_USER"];
$configValues['DB_PASS'] = $_ENV["DB_PASS"];
$configValues['DB_NAME'] = 'postgres';

// Public Schema
$configValues['TBL_RSDICTIONARY'] = 'esmartit.rs_dictionary';
$configValues['TBL_RSMENUOPTIONS'] = 'esmartit.rs_menu_options';
$configValues['TBL_RSMENUOPTIONSPROFILES'] = 'esmartit.rs_menu_options_profiles';
$configValues['TBL_RSOPERATORS'] = 'esmartit.rs_operators';
$configValues['TBL_RSPROFILES'] = 'esmartit.rs_profiles';
$configValues['TBL_RWBRANDS'] = 'esmartit.rw_brands';
$configValues['TBL_RWBUSINESS'] = 'esmartit.rw_business';
$configValues['TBL_RWCITY'] = 'esmartit.rw_city';
$configValues['TBL_RWCLIENT'] = 'esmartit.rw_client';
$configValues['TBL_RWCOUNTRY'] = 'esmartit.rw_country';
$configValues['TBL_RWLOCATION'] = 'esmartit.rw_location';
$configValues['TBL_RWPROVIDERS'] = 'esmartit.rw_providers';
$configValues['TBL_RWSTATE'] = 'esmartit.rw_state';
$configValues['TBL_RWZIPCODE'] = 'esmartit.rw_zipcode';

$esquema = 'smartpoke.';

$configValues['TBL_RADNAS'] = $esquema.'nas';
$configValues['TBL_RADACCT'] = $esquema.'radacct';
$configValues['TBL_RADCHECK'] = $esquema.'radcheck';
$configValues['TBL_RADGROUPCHECK'] = $esquema.'radgroupcheck';
$configValues['TBL_RADGROUPREPLY'] = $esquema.'radgroupreply';
$configValues['TBL_RADPOSTAUTH'] = $esquema.'radpostauth';
$configValues['TBL_RADREPLY'] = $esquema.'radreply';
$configValues['TBL_RADUSERGROUP'] = $esquema.'radusergroup';
$configValues['TBL_RSHOTSPOTS'] = $esquema.'rs_hotspots';
$configValues['TBL_RSSPOTOPERATORS'] = $esquema.'rs_spot_operators';
$configValues['TBL_RSUSERDEVICE'] = $esquema.'rs_userdevice';
$configValues['TBL_RSUSERINFO'] = $esquema.'rs_userinfo';
$configValues['TBL_RWDEVICES'] = $esquema.'rw_devices';
$configValues['TBL_RWMESSAGES'] = $esquema.'rw_messages';
$configValues['TBL_RWMESSAGESDETAIL'] = $esquema.'rw_messages_detail';
$configValues['TBL_RWSENSOR'] = $esquema.'rw_sensor';
$configValues['TBL_RWSENSORACCT'] = $esquema.'rw_sensoracct';
$configValues['TBL_RWSENSORTOTAL'] = $esquema.'rw_sensortotal';
$configValues['TBL_RWSETTINGS'] = $esquema.'rw_settings';
$configValues['TBL_RWSMARTPOKETOTAL'] = $esquema.'rw_smartpoketotal';
$configValues['TBL_RWSPOT'] = $esquema.'rw_spot';

$configValues['DB_PASSWORD_ENCRYPTION'] = 'cleartext';
$configValues['IFACE_PASSWORD_HIDDEN'] = 'yes';
$configValues['LANG'] = 'es';

$configValues['CONFIG_GROUP_NAME'] = "D01";       /* the group name to add the user to */
$configValues['CONFIG_GROUP_SMNAME'] = "D01";       /* the group name to add the facebook user to */

$configValues['CONFIG_GROUP_PRIORITY'] = 0;             /* an integer only! */
$configValues['CONFIG_USERNAME_PREFIX'] = "SP_";	/* username prefix to append to the automatically generated username */
$configValues['CONFIG_USERNAME_LENGTH'] = "6";		/* the length of the random username to generate */
$configValues['CONFIG_PASSWORD_LENGTH'] = "4";		/* the length of the random password to generate */
$configValues['CONFIG_USER_ALLOWEDRANDOMCHARS'] = "0123456789";


?>
