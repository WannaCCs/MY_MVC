<?php

    header('content-type:text/html;charset=utf8');
    //判断$_SERVER['PATH_INFO']是否存在
    if(!isset($_SERVER['PATH_INFO']) or empty($_SERVER['PATH_INFO'])){
        $_SERVER['PATH_INFO'] = 'welcom';
        //如果不存在跳到框架首页
        include 'view/welcom.php';

    }
    //如果存在 把$_SERVER['PATH_INFO']赋值给$pathInfo
    $pathInfo = $_SERVER['PATH_INFO'];



    /*
     * 数据库初始化
     */

    //把获得的paseInfo值中的/去掉
    $a = ltrim($pathInfo,'/');
    $b = explode('/',$a);
    $b[0] = ucfirst($b[0]);

    //引入数据库处理文件
    include 'common/db.config.php';
    include 'vendor/db.class.php';

    //定义全局
    $GLOBALS['db'] = new DB($config['db']);

    /*
     * 结束数据库初始化
     */

    //图片地址处理
    $project = $_SERVER['SCRIPT_NAME'];
    $project = ltrim($project,'/');
    $project = explode('/',$project);
    $host = $_SERVER['HTTP_HOST'];
    $host = rtrim($host,'/');

  //  var_dump($project);die;
    define("__PUBLIC__",'http://'.$host.'/'.$project[0].'/public/');

    session_start();
    //拼接控制器文件名
    include 'controller/'.$b[0].'.class.php';

    //回调
    @call_user_func_array($b,array(''));




//var_dump($b);