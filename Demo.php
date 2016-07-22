<?php
/**
 * Created by PhpStorm.
 * User: CPR096
 * Date: 2016/7/21
 * Time: 11:33
 */

require_once('./RedisClass.php');

$config = array(
    'host' => '127.0.0.1',
    'port' => '6379',
    'timeout' => '5000'
);

$redis = new \learngit\RedisClass($config);

$key = 'mySet';
$value = 'the first redis test!';
$redis->select(1);
var_dump($redis->getSetMembers($key));

$key_one = 'set1';
$key_two = 'set2';
$redis->setSet($key_two,json_encode(array('John','Tom','Tonny')));

$redis->setSet($key_one,json_encode(array('John','Tonny')));

var_dump($redis->getIntersection($key_one,$key_two));

$redis->setDelete($key_one,json_encode(array('John','Tonny')));

