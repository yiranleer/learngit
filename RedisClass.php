<?php
/**
 * Created by PhpStorm.
 * User: CPR096
 * Date: 2016/7/21
 * Time: 14:06
 */

namespace learngit;


class RedisClass {

    private $redis;

    /**
     * initial redis
     * @param array $config
     */
    public function __construct($config=array()){

//        if($config['host'] == '')    $config['host'] = '127.0.0.1';
//        if($config['port'] == '')    $config['port'] = '6379';
//        if($config['timeout'] == '') $config['timeout'] = '5000';
        $this->redis = new \Redis();
        $this->redis->connect($config['host'],$config['port'],$config['timeout'] );

        if(!empty($config['pwd'])){
            $this->redis->auth($config['pwd']);
        }

        return $this->redis;
    }

    public function select($id){

        $this->redis->select($id);
    }

    /**
     * set str
     * @param $key
     * @param $value
     * @param int $timeout
     * @return bool
     */
    public function setStr($key,$value,$timeout = 0 ){
        if(is_array($value))  $result =  $this->redis->set($key,json_encode($value));
        if(is_string($value)) $result =  $this->redis->set($key,$value);
        if($timeout>0) $this->redis->setTimeout($key,$timeout);
        return $result;
    }

    /**
     * get str
     * @param $key
     * @return mixed
     *
     */
    public function getStr($key){

        $result = $this->redis->get($key);
        return json_decode($result,true);
    }

    /**
     * delete one str
     * @param $key
     */
    public function deleteStr($key){

        return $this->redis->delete($key);
    }

    /**
     * add unsorted set
     * @param $key
     * @param $value
     * @return int
     */
    public function setSet($key,$value){

        $result = $this->redis->sAdd($key,$value);
        return $result;
    }

    /**
     * get members of a set
     * @param $key
     * @return array
     */
    public function getSetMembers($key){

        return $this->redis->sMembers($key);
    }

    /**
     * get intersection of two sets
     * @param $key_one
     * @param $key_two
     */
    public function getIntersection($key_one,$key_two){

        return $this->redis->sInter($key_one,$key_two);
    }

    /**
     * remove one str from the set
     * @param $key
     * @param $str: which you want to remove
     */
    public function setDelete($key,$str){

        return $this->redis->sRemove($key,$str);
    }

    /**
     * move str from key_one to key_two
     * @param $key_one
     * @param $key_two
     * @param $str
     * @return bool
     */
    public function sMove($key_one,$key_two,$str){

        return $this->redis->sMove($key_one,$key_two,$str);
    }
} 