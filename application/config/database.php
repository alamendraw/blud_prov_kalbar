<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$active_group				= 'default';
$active_record				= TRUE;
$query_builder 				= TRUE;


$db['default']['hostname'] = 'driver=SQL Server;server=localhost;uid=sa;pwd=murfa;database=simblud_prov_2020';
// $db['default']['hostname'] = 'driver=SQL Server;server=DESKTOP-34E0524\SQLEXPRESS;uid=sa;pwd=sqlserver123;database=simblud_prov_2020';
$db['default']['username'] = '';
$db['default']['password'] = '';
$db['default']['database'] = 'simblud_prov_2020';
$db['default']['dbdriver'] = 'odbc';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = FALSE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

/*
$db['alternatif']['hostname']	= 'dpkkd.pidie.net';
$db['alternatif']['username']	= 'root';
$db['alternatif']['password']	= 'safe';
$db['alternatif']['database']	= 'simakda_siadinda_2016';
$db['alternatif']['dbdriver']	= 'mysql';
$db['alternatif']['dbprefix']	= '';
$db['alternatif']['pconnect']	= FALSE;
$db['alternatif']['db_debug']	= FALSE;
$db['alternatif']['cache_on']	= FALSE;
$db['alternatif']['cachedir']	= '';
$db['alternatif']['char_set']	= 'utf8';
$db['alternatif']['dbcollat']	= 'utf8_general_ci';
$db['alternatif']['swap_pre']	= '';
$db['alternatif']['autoinit']	= TRUE;
$db['alternatif']['stricton']	= FALSE;
*/

//$db['default']['pconnect'] = FALSE;