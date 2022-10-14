<?php

$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='root';          //对应的密码
if($dbName){
    $dsn="$dbms:host=$host;dbname=$dbName";
}else{
    $dsn="$dbms:host=$host;";
}

//默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true) 变成这样：
//$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));

try {
    $dbh = new PDO($dsn, $user, $pass);
    echo "连接成功<br/>";

    $data = [];
    $i = 0;
    $db_select = ['karenty_com','buridal_com','bridany_com','naclari_com','tareken_com','helenue_com','paricen_com','sariaen_com','yobouet_com','karsony_com'];
	foreach ($dbh->query('SHOW DATABASES') as $row) {
		if($row['Database'] == 'information_schema' || $row['Database'] == 'mysql' || $row['Database'] == 'performance_schema'){
			continue;
		}
        //update
        //$sql="update ".$row['Database'].".product set price = CEILING(price) where 1;";
		//$sql.="update ".$row['Database'].".product_special set price = CEILING(price) where 1;";
        //
        //select
        if(in_array($row['Database'],$db_select)){
            $sql="select product_id from ".$row['Database'].".product  where status=1 order by product_id desc limit 10;";
            $q = $dbh->query($sql);
            if($q){
                $arr = [];
                while ($r = $q->fetch(PDO::FETCH_ASSOC)){
                    $arr[] = $r['product_id'];
                }
                $data[$row['Database']] = implode(',',$arr);
            }
        }

        $i++;
		echo $i.' --- '.$row['Database'].' successed<br>';
    }
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    $dbh = null;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
