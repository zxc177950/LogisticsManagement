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
    public function getCarType()
    {
        $conn = $this->conn();
        //建立数据库查询
        $search = "SELECT vehicleid,name carname,pledge 
        from vehicle
                ";
        //插入不成功
        $result = $conn->query($search);
        //遍历结果为数组
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '无数据'));
        } else {
            $array = array(); //自定义一个数组，存放数据
            $i = 0; //初始数据为 0
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                //从返回到$row中所有的数据中取出需要的字段，并把它储存在数组$array中
//                $array[$i]["ID"] = $row["ID"];

                $array[$i]["vehicleid"] = $row["vehicleid"];
                $array[$i]["carname"] = $row["carname"];
                $array[$i]["pledge"] = $row["pledge"];
                $i++;
            }

            $json = json_encode(
            //array()是组织要显示的数据结构
                array(
                    "resultCode" => 200,
                    "message" => "success",
                    "length" => $i,
                    "data" => $array
                )
            ); //转换为JSON

            echo json_encode($json);
        }
    }
    public function delCar()
    {
        $conn = $this->conn();
        $vehicleid=$_POST['vehicleid'];
        $carname=$_POST['carname'];
        $pledge=$_POST['pledge'];
        //建立数据库查询
        $sql="delete from vehicle where vehicleid='{$vehicleid}'";
        $sql1="delete from tax where vehicleid='{$vehicleid}'";
        $result = $conn->query($sql);
        $result1 = $conn->query($sql1);
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败','isSuccess'=>'0'));
        } else {
            $row['isSuccess']="1";
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }
    public function addCar()
    {
        $conn = $this->conn();
        $vehicleid=$_POST['vehicleid'];
        $carname=$_POST['carname'];
        $pledge=$_POST['pledge'];
        //建立数据库查询
        $sql="insert into vehicle values('{$vehicleid}','{$carname}',0,{$pledge})";
        $sql1="insert into tax values('{$vehicleid}',0.05,'{$vehicleid}')";
        $result = $conn->query($sql);
        $conn->query($sql1);
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败','isSuccess'=>'0'));
        } else {
            $row['isSuccess']="1";
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }
    public function getGoodType()
    {
        $conn = $this->conn();
        //建立数据库查询
        $search = "SELECT goodid,name goodname
        from good
                ";
        $result = $conn->query($search);
        //遍历结果为数组
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '无数据'));
        } else {
            $array = array(); //自定义一个数组，存放数据
            $i = 0; //初始数据为 0
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                //从返回到$row中所有的数据中取出需要的字段，并把它储存在数组$array中
//                $array[$i]["ID"] = $row["ID"];

                $array[$i]["goodid"] = $row["goodid"];
                $array[$i]["goodname"] = $row["goodname"];
                $i++;
            }

            $json = json_encode(
            //array()是组织要显示的数据结构
                array(
                    "resultCode" => 200,
                    "message" => "success",
                    "length" => $i,
                    "data" => $array
                )
            ); //转换为JSON

            echo json_encode($json);
        }
    }
    public function delGood()
    {
        $conn = $this->conn();
        $goodid=$_POST['goodid'];
        $goodname=$_POST['goodname'];
        //建立数据库查询
        $sql="delete from good where goodid='{$goodid}'";
        $sql2="delete from price where goodid='{$goodid}'";
        $result = $conn->query($sql);
        $result2 = $conn->query($sql2);
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败','isSuccess'=>'0'));
        } else {
            $row['isSuccess']="1";
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }
    public function addGood()
    {
        $conn = $this->conn();
        $goodid=$_POST['goodid'];
        $goodname=$_POST['goodname'];
        //建立数据库查询
        $sql="insert into good values('{$goodid}','{$goodname}')";
        $sql1="insert into price values('{$goodid}',10,'{$goodid}')";
        $result = $conn->query($sql);
        $conn->query($sql1);
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败','isSuccess'=>'0'));
        } else {
            $row['isSuccess']="1";
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }
    public function getPrice()
    {
        $conn = $this->conn();
        //建立数据库查询
        $search = "SELECT g.name name,p.money money
        from price p,good g where p.priceid=g.goodid
                ";
        //插入不成功
        $result = $conn->query($search);
        //遍历结果为数组
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '无数据'));
        } else {
            $array = array(); //自定义一个数组，存放数据
            $i = 0; //初始数据为 0
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                //从返回到$row中所有的数据中取出需要的字段，并把它储存在数组$array中
//                $array[$i]["ID"] = $row["ID"];

                $array[$i]["name"] = $row["name"];
                $array[$i]["money"] = $row["money"];
                $i++;
            }

            $json = json_encode(
            //array()是组织要显示的数据结构
                array(
                    "resultCode" => 200,
                    "message" => "success",
                    "length" => $i,
                    "data" => $array
                )
            ); //转换为JSON

            echo json_encode($json);
        }
    }
    public function savePrice()
    {
        //定义数据库连接
        $conn = $this->conn();
        $goodname=$_POST['goodname'];
        $price=$_POST['price'];
        //建立数据库查询
        $sql="update price p
        set p.money={$price}
        where p.goodid=(
        select g.goodid
        from good g
        where g.name='{$goodname}'
        )";
        $result = $conn->query($sql);
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败'));
        } else {
            $row['isSuccess']="1";
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }
    public function getTax()
    {
        $conn = $this->conn();
        //建立数据库查询
        $search = "SELECT v.name name,t.rate rate 
        from vehicle v,tax t where t.vehicleid=v.vehicleid
                ";
        //插入不成功
        $result = $conn->query($search);
        //遍历结果为数组
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '无数据'));
        } else {
            $array = array(); //自定义一个数组，存放数据
            $i = 0; //初始数据为 0
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                //从返回到$row中所有的数据中取出需要的字段，并把它储存在数组$array中
//                $array[$i]["ID"] = $row["ID"];

                $array[$i]["name"] = $row["name"];
                $array[$i]["rate"] = $row["rate"];
                $i++;
            }

            $json = json_encode(
            //array()是组织要显示的数据结构
                array(
                    "resultCode" => 200,
                    "message" => "success",
                    "length" => $i,
                    "data" => $array
                )
            ); //转换为JSON

            echo json_encode($json);
        }
    }
    public function saveTax()
    {
        //定义数据库连接
        $conn = $this->conn();
        $carname=$_POST['carname'];
        $tax=$_POST['tax'];
        //建立数据库查询
        $sql="update tax t
        set t.rate={$tax}
        where t.vehicleid=(
        select v.vehicleid
        from vehicle v
        where v.name='{$carname}'
        )";
        $result = $conn->query($sql);
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败'));
        } else {
            $row['isSuccess']="1";
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }
    public function getUser()
    {
        $conn = $this->conn();
        //建立数据库查询
        $search = "select ac.userid userid,ac.usertype usertype,al.star_level level,al.is_freeze isfreeze
        from account ac,alluser al where ac.userid=al.userid
                ";
        //插入不成功
        $result = $conn->query($search);
        //遍历结果为数组
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '无数据'));
        } else {
            $array = array(); //自定义一个数组，存放数据
            $i = 0; //初始数据为 0
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                //从返回到$row中所有的数据中取出需要的字段，并把它储存在数组$array中
//                $array[$i]["ID"] = $row["ID"];

                $array[$i]["userid"] = $row["userid"];
                $array[$i]["usertype"] = $row["usertype"];
                $array[$i]["level"] = $row["level"];
//                $array[$i]["isfreeze"] = $row["isfreeze"];
                if($row["isfreeze"]=="0"){
                    $array[$i]["isfreeze"] ="正常";
                }else{
                    $array[$i]["isfreeze"] ="已冻结";
                }
                $i++;
            }

            $json = json_encode(
            //array()是组织要显示的数据结构
                array(
                    "resultCode" => 200,
                    "message" => "success",
                    "length" => $i,
                    "data" => $array
                )
            ); //转换为JSON

            echo json_encode($json);
        }
    }
    public function freezeUser()
    {
        $conn = $this->conn();
        $userid=$_POST['userid'];
        //建立数据库查询
        $search = "update alluser set is_freeze=1 where userid='{$userid}'
                ";
        //插入不成功
        $result = $conn->query($search);
        //遍历结果为数组
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败'));
        } else {
        $row['isSuccess'] = "1";
        $return['status'] = is_null($row) ? false : true;
        $return['msg'] = is_null($row) ? 'error' : 'ok';
        $return['data'] = $row;
        //输出查询结果
        echo json_encode($return);
         }
    }
    public function unfreezeUser()
    {
        $conn = $this->conn();
        $userid=$_POST['userid'];
        //建立数据库查询
        $search = "update alluser set is_freeze=0 where userid='{$userid}'
                ";
        //插入不成功
        $result = $conn->query($search);
        //遍历结果为数组
        if (!$result) {
            return json_encode(array('error' => 444, 'msg' => '更新失败'));
        } else {
            $row['isSuccess'] = "1";
            $return['status'] = is_null($row) ? false : true;
            $return['msg'] = is_null($row) ? 'error' : 'ok';
            $return['data'] = $row;
            //输出查询结果
            echo json_encode($return);
        }
    }
}
