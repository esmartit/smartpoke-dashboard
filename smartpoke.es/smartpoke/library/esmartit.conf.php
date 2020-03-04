<?php
/*
 *********************************************************************************************************
 * eSmartIT - Web Platform
 * Copyright (C) 2019 - Adolfo Zignago All Rights Reserved.
 * This is a modified version of daloRADIUS - RADIUS Web Platform
 * Copyright (C) 2007 - Liran Tal <liran@enginx.com> All Rights Reserved.
 *
 *********************************************************************************************************
 * Description:
 *              eSmartIT Configuration File
 *
 * Modification Date:
 *              Thu Feb 21 21:46:17 CET 2019
 *********************************************************************************************************
 */


$configValues['DALORADIUS_VERSION'] = '0.9-9';
$configValues['FREERADIUS_VERSION'] = '2';
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

$configValues['TBL_RADNAS'] = 'nas';
$configValues['TBL_RADACCT'] = 'radacct';
$configValues['TBL_RADCHECK'] = 'radcheck';
$configValues['TBL_RADGROUPCHECK'] = 'radgroupcheck';
$configValues['TBL_RADGROUPREPLY'] = 'radgroupreply';
$configValues['TBL_RADPOSTAUTH'] = 'radpostauth';
$configValues['TBL_RADREPLY'] = 'radreply';
$configValues['TBL_RADUSERGROUP'] = 'radusergroup';
$configValues['TBL_RSHOTSPOTS'] = 'rs_hotspots';
$configValues['TBL_RSSPOTOPERATORS'] = 'rs_spot_operators';
$configValues['TBL_RSUSERDEVICE'] = 'rs_userdevice';
$configValues['TBL_RSUSERINFO'] = 'rs_userinfo';
$configValues['TBL_RWDEVICES'] = 'rw_devices';
$configValues['TBL_RWMESSAGES'] = 'rw_messages';
$configValues['TBL_RWMESSAGESDETAIL'] = 'rw_messages_detail';
$configValues['TBL_RWSENSOR'] = 'rw_sensor';
$configValues['TBL_RWSENSORACCT'] = 'rw_sensoracct';
$configValues['TBL_RWSENSORTOTAL'] = 'rw_sensortotal';
$configValues['TBL_RWSETTINGS'] = 'rw_settings';
$configValues['TBL_RWSMARTPOKETOTAL'] = 'rw_smartpoketotal';
$configValues['TBL_RWSPOT'] = 'rw_spot';

$configValues['DB_PASSWORD_ENCRYPTION'] = 'cleartext';
$configValues['IFACE_PASSWORD_HIDDEN'] = 'yes';
$configValues['LANG'] = 'es';
$configValues['USER_ALLOWEDRANDOMCHARS'] = 'abcdefghjklmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';

?>
