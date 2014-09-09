<?php
$cnf['default_controller']='Index';
$cnf['default_action']='index2';
$cnf['namespaces']['Controllers']= $_SERVER['DOCUMENT_ROOT']	.	DIRECTORY_SEPARATOR	.	'abphpftest'	.	DIRECTORY_SEPARATOR	.	'controllers'	.	DIRECTORY_SEPARATOR;
//$cnf['namespaces']['Controllers']='/store2/work/www/gftest/controllers/';

$cnf['session']['autostart'] = true;
$cnf['session']['type'] = 'database';
$cnf['session']['name'] = '_default';
$cnf['session']['lifetime'] = 3600;
$cnf['session']['path'] = '/';
$cnf['session']['domain'] = '';
$cnf['session']['secure'] = false;
$cnf['session']['dbConnection'] = 'default';
$cnf['session']['dbTable'] = 'sessions';

$cnf['viewsDirectory'] = NULL;

return $cnf;
