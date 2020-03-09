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
// $configValues['DB_ENGINE'] = 'mysqli';
// $configValues['DB_HOST'] = 'esmartit-rds-mysql.cfyfyp455hwf.eu-west-1.rds.amazonaws.com';
// $configValues['DB_PORT'] = '3306';
// $configValues['DB_USER'] = 'esmartit';
// $configValues['DB_PASS'] = 'gP3ZnsABNbQnaaudxpOR';
// $configValues['DB_NAME'] = 'esmartitDBTest';
$configValues['DB_ENGINE'] = 'postgres';
$configValues['DB_HOST'] = 'rds-pg-01.smartpoke.es';
$configValues['DB_PORT'] = '5432';
$configValues['DB_USER'] = 'esmartitpg';
$configValues['DB_PASS'] = 'mi3Wa_zU1JTbw7Mj4yS4NQoI';
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

$configValues['DB_PASSWORD_ENCRYPTION'] = 'crypt';
$configValues['LANG'] = 'es';
$configValues['USER_ALLOWEDRANDOMCHARS'] = 'abcdefghjklmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';

?>
