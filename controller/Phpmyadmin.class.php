<?php

class Phpmyadmin {
    //登录页面
    public function login(){

        //查
      //  $aa = $GLOBALS['db']->query('show tables;')->fetchAll();

        //增
         // $aa = $GLOBALS['db']->insert('user',array('id'=>null,'name'=>'大傻逼','age'=>3));

        //删
        //$GLOBALS['db']->delete('user','id=5');

        //改
       // $GLOBALS['db']->update('user',array('name'=>'CC'),"name='小傻逼'");

//        var_dump($aa);
        include "view/phpmyadmin.html";
    }

    //执行登录
    public function loginCheck(){

        //var_dump($_POST);
        //获取用户信息
        $user = $_POST['pma_username'];
        $psw = $_POST['pma_password'];

        //调数据库信息
        $sql = 'select User,Password from mysql.user where User = "'.$user.'" limit 1';
        $res = $GLOBALS['db']->query($sql)->fetchOne();

        //判断用户是否存在
        if(empty($res)) die('此用户不存在');


        //验证用户密码
        $is_psw = $GLOBALS['db']->query("select '".$res['Password']."'=password('".$psw."') as res;")->fetchOne();

        //数据库
        $databases = $GLOBALS['db']->query('show databases;')->fetchAll();

        //判断密码
        if($is_psw){
            include "view/select.html";
        }else{
            die('密码错误');
        }
    }


    //处理ajax获得表数据
    public function getTable(){

        //获得数据库名字
        $database = $_GET['database'];

        //定位的数据库
        $GLOBALS['db']->query("use $database;");

        //获取数据库的表
        $result = $GLOBALS['db']->query("show tables;")->fetchAll();

        //转为json串
        $json_str = json_encode($result);

        $jsonString = str_replace("Tables_in_$database",'name',$json_str);
        $result = json_decode($jsonString,true);    //如果没有true则默认转为object对象
        include "view/tables.html";


    }

    //获得字段索引
    function getFieldIndex(){
        $database=$_GET['database'];
        $table=$_GET['table'];
        include "view/fieldindex.html";
        die;
    }

    //
    function getFieldIndexlist(){
        $database=$_GET['database'];
        $table=$_GET['table'];
        $res=$GLOBALS['db']->query("desc $database.$table")->fetchAll();
        include "view/getFieldIndexlist.html";
    }

    function joinDb(){
        //获得数据库名字
        $database = $_GET['database'];

        //定位的数据库
        $GLOBALS['db']->query("use $database;");

        //获取数据库的表
        $result = $GLOBALS['db']->query("show tables;")->fetchAll();

        //转为json串
        $json_str = json_encode($result);

        $jsonString = str_replace("Tables_in_$database",'name',$json_str);
        $result = json_decode($jsonString,true);    //如果没有true则默认转为object对象
        include "view/joindb.html";
    }


    function joinTable(){
        $database=$_GET['database'];
        $table=$_GET['table'];

        $GLOBALS['db']->query("use $database");
        $bb=$GLOBALS['db']->query("select * from $table")->fetchall();
        $res=$GLOBALS['db']->query("desc $database.$table")->fetchall();
        include "view/join_table.html";
    }

    function getsyIndexlist(){
        $database=$_GET['database'];
        $table=$_GET['table'];
        include "view/getsyindexlist.html";
    }

    //新建表
    function newTable(){

        $database = $_GET['database'];

        include "view/newtable.html";
    }

    //sql语句及建表
    function getData(){

        $assign = $_POST;
        //sql语句头
        $SQL = "CREATE TABLE `".$assign['db']."`.`".$assign['table']."`(";

        //sql语句尾
        $Sql = ") ENGINE = ".$assign['tbl_storage_engine']." CHARSET=utf8 COLLATE ".$assign['tbl_collation']." COMMENT = '".$assign['comment']."';";

//        $SQL = " CREATE TABLE `1712asp`.`qq` (
//                          `a` INT(10) AS () VIRTUAL COMMENT '注释' ,
//                           PRIMARY KEY (`a`)
//                          ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = '表注释';";
        $sql = "";
        foreach ($assign as $k => $v){
            if(!empty($v['field_name'])){
                $sql = $sql."`".$v['field_name']."` ".$v['field_type']."(".$v['field_length'].") ".$v['field_virtuality']." COMMENT '".$v['field_comments']."' ,";
                if(strpos($v['field_key'],'primary')!=false){
                    $pri = substr($v['field_key'],0,strrpos($v['field_key'],'_'));
                }
            }
        }

        $SQL = $SQL.$sql;
        var_dump($assign);
    }


}