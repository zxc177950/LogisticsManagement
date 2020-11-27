<?php
/**
 * Created by PhpStorm.
 * User: 13673
 * Date: 2019-09-27
 * Time: 19:09
 */
header('Content-type:text/html;charset=utf-8');
header('Content-type: application/json');

class Main
{
    //配置数据库连接
    public function conn()
    {
        //主机，账号，密码，数据库，端口号
        $conn = new mysqli('localhost', 'root', '15356269982', "logistic_login", '3306');
        $conn->set_charset("utf-8");
        mysqli_query($conn, "SET NAMES 'UTF8'");
        //检测连接
        if ($conn->connect_error) {
            die("数据库连接失败：" . $conn->connect_error);
        }
        //echo "数据库已连接";
        return $conn;
    }

    //登录
    public function login()
    {
        //获取post过来的data
        $userid = $_POST['userid'];
        $password = $_POST['password'];
        //定义数据库连接
        $conn = $this->conn();
        //建立数据库查询
        $search = "SELECT ac.userid,ac.usertype,al.is_freeze isfreeze FROM account ac,alluser al
        WHERE ac.userid = '{$userid}' AND ac.password = '{$password}' AND ac.userid=al.userid";
        //执行查询语句
        $result = $conn->query($search);
        //遍历结果为数组
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '无数据'));
        } else {
            $row = $result->fetch_assoc();
            // echo $row;
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            return json_encode($return);
        }
    }
    public function register()
    {
        //获取post过来的data
        $userid = $_POST['userid'];
        $password = $_POST['password'];
        $usertype=$_POST['usertype'];
        //定义数据库连接
        $conn = $this->conn();
        //建立数据库查询
        $search = "SELECT ac.password FROM account ac
        WHERE ac.userid = '{$userid}'";
        //执行查询语句
        $result = $conn->query($search);
        $row=$result->fetch_assoc();
        //遍历结果为数组
        if (!$row) {
            $sql="insert into account values('{$userid}','{$password}','{$usertype}')";
            $sql1="insert into alluser(userid,usertype)  values('{$userid}','{$usertype}')";
            $res = $conn->query($sql);
            $res1 = $conn->query($sql1);
            if(!$res)
            {
                return json_encode(array('error' => 444, 'msg' => '数据插入失败'));
            }
            else{
                $row['isSuccess']="1";
                $return['status'] = is_null($row) ? false : true;
                $return['msg'] = is_null($row) ? 'error' : 'ok';
                $return['data'] = $row;
                //输出查询结果
                echo json_encode($return);
            }
        } else {
            $row['isSuccess']="0";
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            return json_encode($return);
        }
    }

}
