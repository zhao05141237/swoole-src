<?php
//$table = new swoole_table(1024);
//$table->column('id', swoole_table::TYPE_INT);
//$table->column('name', swoole_table::TYPE_STRING, 64);
//$table->column('num', swoole_table::TYPE_FLOAT);
//$table->create();
//
//$table['apple'] = array('id' => 145, 'name' => 'iPhone', 'num' => 3.1415);
//$table['google'] = array('id' => 358, 'name' => "AlphaGo", 'num' => 3.1415);
//
//$table['microsoft']['name'] = "Windows";
//$table['microsoft']['num'] = '1997.03';
//
//foreach ($table as $index => $item) {
//    var_dump($index,$item);
//}

//var_dump($table['apple']);
//var_dump($table['microsoft']);
//
//$table['google']['num'] = 500.90;
//var_dump($table['google']);
use Swoole\Table;

$table = new Table(1024);
$table->column('id',Table::TYPE_INT);
$table->column('name', Table::TYPE_STRING,64);
$table->column('num',Table::TYPE_FLOAT);

$table->create();

$table->set('apple',['id' => 145, 'name' => 'iPhone', 'num' => 3.1415]);
$table->set('google',['id' => 358, 'name' => "AlphaGo", 'num' => 3.1415]);
$table->set('microsoft',['name' => 'Windows', 'num' => 1997.03]);
$table->incr('google','id');
$table->decr('apple','id');

var_dump($table->get('apple'));
var_dump($table->get('apple','id'));
var_dump($table->exists('app'));
var_dump($table->exists('apple'));

$table->del('apple');
var_dump($table->count());



