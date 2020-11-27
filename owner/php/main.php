<?php
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
        return $conn;
    }
    public
    function getUserInfor()
    {
        //定义数据库连接
        $conn = $this->conn();
        $userid=$_POST['userid'];
        //建立数据库查询
        $search = "SELECT username,sex,age,phone,common_goods goods,address,star_level level
        FROM alluser WHERE userid='{$userid}'";
        $result = $conn->query($search);
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '无数据'));
        } else {
            $row = $result->fetch_assoc();
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }
    public
    function saveUserInfor()
    {
        //定义数据库连接
        $conn = $this->conn();
        $userid=$_POST['userid'];
        $age=$_POST['age'];
        $phone=$_POST['phone'];
        $goods=$_POST['goods'];
        $address=$_POST['address'];
        //建立数据库查询
        $sql="update alluser
        set age='{$age}',phone='{$phone}',common_goods='{$goods}',address='{$address}'
        where userid='{$userid}'";
        $result = $conn->query($sql);
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败'));
        } else {
            $row['isSuccess']=1;
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }
    public
    function updatePass()
    {
        $conn = $this->conn();
        $userid=$_POST['userid'];
        $oldpass=$_POST['oldpass'];
        $newpass=$_POST['newpass'];
        //建立数据库查询
        $sql="update account
        set password='{$newpass}'
        where userid='{$userid}' and password='{$oldpass}'";
        $result = $conn->query($sql);
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败','isSuccess'=>'0'));
        } else {
            $row['isSuccess']=1;
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }
    public function outOrder()
    {
        $conn = $this->conn();
        $orderid=$_POST['orderid'];
        $ownerid=$_POST['userid'];
        $goodtype=$_POST['goodtype'];
        $goodheavy=$_POST['goodheavy'];
        $cartype=$_POST['cartype'];
        $receiverName=$_POST['receiverName'];
        $receiverAddress=$_POST['receiverAddress'];
        $receiverPhone=$_POST['receiverPhone'];
        $senderName=$_POST['senderName'];
        $senderAddress=$_POST['senderAddress'];
        $senderPhone=$_POST['senderPhone'];
        $sendDate=$_POST['sendDate'];
        $distance=$_POST['distance'];
        //建立数据库查询
        $sql="
        insert
        into order(orderid,ownerid,start_place,end_place,distance,
        logistics_status,order_status,total_price,start_date,goodid,goodweight,
        sendername,senderphone,receivername,receiverphone,wish_vehicle_id)
        values('{$orderid}','{$ownerid}','{$senderAddress}','{$receiverAddress}',
        '{$distance}','1','1',
        (select p.money*'{$goodheavy}'*'{$distance}'
        from good g,price p
        where g.name='{$goodtype}' and g.goodid=p.goodid
        ),
        '{$sendDate}',
        (select g.goodid
        from good g
        where g.name='{$goodtype}'
        ),
        '{$goodheavy}','{$senderName}',
        '{$senderPhone}','{$receiverName}','{$receiverPhone}',
        (select v.vehicleid
        from vehicle v
        where v.name='{$cartype}'
        )
        )
        ";
        $result = $conn->query($sql);
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败','isSuccess'=>'0'));
        } else {
            $row['isSuccess']=1;
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }
    public function gainFate()
    {
        //定义数据库连接
        $conn = $this->conn();
        $goodtype=$_POST['goodtype'];
        $goodheavy=$_POST['goodheavy'];
        $distance=$_POST['distance'];
        //建立数据库查询
        $sql="select p.money*'{$goodheavy}'*'{$distance}' totalprice
        from good g,price p
        where g.name='{$goodtype}' and g.goodid=p.goodid";
        $result = $conn->query($sql);
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败'));
        } else {
            $row=$result->fetch_assoc();
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }

}
