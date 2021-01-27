<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$autoload['packages'] = array();
$autoload['libraries'] = array('template', 'session', 'form_validation', 'database','auth', 'pagination','dynamic_menu','utility');
$autoload['helper'] = array('url', 'form');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array('master_model','kegiatan_terpilih_model','rka_model','tukd_model','akuntansi_model','m_string','mfungsi');