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

    $i = 0;
	foreach ($dbh->query('SHOW DATABASES') as $row) {
		if($row['Database'] == 'information_schema' || $row['Database'] == 'mysql' || $row['Database'] == 'performance_schema'){
			continue;
		}
        $sql="update ".$row['Database'].".product set price = CEILING(price) where 1;";
		$sql.="update ".$row['Database'].".product_special set price = CEILING(price) where 1;";
		$dbh->query($sql);
        $i++;
		echo $i.' --- '.$row['Database'].' successed<br>';
    }

    $dbh = null;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
