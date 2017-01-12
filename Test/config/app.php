<?php
$cnf['default_controller'] = 'Index';
$cnf['default_method'] = 'Index';
$cnf['namespaces']['Controllers'] = 'C:\xampp\htdocs\mvcFrmWrk\Test\controllers';

$cnf['session']['autostart'] = true;

// native o database types
$cnf['session']['type'] = 'native';
$cnf['session']['name'] = '__sess';
$cnf['session']['lifetime'] = 3600;
$cnf['session']['path'] = '/';
$cnf['session']['domain'] = '';
$cnf['session']['secure'] = false;

//in type database only
//$cnf['session']['dbTable'] = 'sessions';

return $cnf;