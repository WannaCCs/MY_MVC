<?php

class A {
    function B(){

        //查
      //  $aa = $GLOBALS['db']->query('show tables;')->fetchAll();

        //增
         // $aa = $GLOBALS['db']->insert('user',array('id'=>null,'name'=>'大傻逼','age'=>3));

        //删
        //$GLOBALS['db']->delete('user','id=5');

        //改
       // $GLOBALS['db']->update('user',array('name'=>'CC'),"name='小傻逼'");

//        var_dump($aa);
        include "view/index.php";



    }
}