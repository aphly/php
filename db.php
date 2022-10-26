<?php
//include_once 'func.php';
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

//UPDATE product LEFT JOIN product_description ON product.product_id=product_description.product_id SET product.`status`=0 WHERE product_description.name LIKE '%Thermometer%';
$arr = [];
try {
    $dbh = new PDO($dsn, $user, $pass);
    echo "连接成功<br/>";

    $data = [];
    $i = 0;
    $db_select = [];
    $sql = '';
    foreach($arr as $val){
        if(is_array($val['product_ids'])){
            $val['product_ids'] = implode(',',$val['product_ids']);
            foreach ($val['db'] as $v){
                $sql.="update ".$v.".product set status = 0 where product_id in (".$val['product_ids'].");";
            }
        }
    }
    $q = $dbh->query($sql);
    //echo $sql;
    /*
	foreach ($dbh->query('SHOW DATABASES') as $row) {
		if($row['Database'] == 'information_schema' || $row['Database'] == 'mysql' || $row['Database'] == 'performance_schema'){
			continue;
		}
        //update
        //$sql="update ".$row['Database'].".product set price = CEILING(price) where 1;";
		//$sql.="update ".$row['Database'].".product_special set price = CEILING(price) where 1;";
        //
        //select
        if(in_array($row['Database'],$db_select) || 1){
            $sql="select product_id from ".$row['Database'].".product  where status=1 order by product_id desc limit 10;";
            $q = $dbh->query($sql);
            if($q){
                $arr = [];
                while ($r = $q->fetch()){
                    $arr[] = $r['product_id'];
                }
                $data[$row['Database']] = implode(',',$arr);
            }
        }

        $i++;
		echo $i.' --- '.$row['Database'].' successed<br>';
    }
    */

    $dbh = null;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
