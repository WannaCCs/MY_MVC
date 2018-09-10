<?php
    class DB{

        //定义私有静态全局变量
        private static $link;
        private static $res;

        //连接
        public function __construct($config){


            self::$link = mysqli_connect(
                $config['dsn'],
                $config['username'],
                $config['password'],
                $config['database']
            );
            mysqli_query(self::$link,'set names utf8');
        }

        //执行sql
        public function query($sql){

            self::$res = mysqli_query(self::$link,$sql);

            return $this;
        }

        //
        public function fetchAll(){

            return mysqli_fetch_all(self::$res,MYSQLI_ASSOC);

        }

        public function fetchOne(){

            return mysqli_fetch_array(self::$res,MYSQLI_ASSOC);

        }

        //添加
        public function insert($tableName,$array=array()){

            $s= '(';

            foreach ($array as $k => $v){
                if(is_string($v)){
                    $v = "'".$v."'";
                }
                if(empty($v)){
                    $v = 'null';
                }
                $s .= $v.',';
            }
            $s = rtrim($s,',');
            $s.=')';

            $sql = 'insert into '.$tableName.' values '.$s;

            $this->query($sql);
            var_dump($sql) ;

            return mysqli_insert_id(self::$link);

        }

        //修改
        public function update($tableName,$array=array(),$condition=''){

            $s = '';

            foreach ($array as $k => $v){

                is_string($v)?$v="'".$v."'":'';
                $s.=$k.'='.$v.',';
            }

            $s = rtrim($s,',');

            $sql = 'update '.$tableName.' set '.$s.' where '.$condition;

            echo $sql;
            $this->query($sql);
        }

        //删除

        public function delete($tableName,$condition=''){

            $sql = 'delete from '.$tableName.' where '.$condition;

            $this->query($sql);

        }

    }