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

//$arr['chicire_com'] = ['db'=>['christiy','sudarin']];
//$arr['corekoe_com'] = ['db'=>['daphare','chrinea_com','harinch_com','patelsi_com','miccain_com','boriden_com','raquely_com','helenue_com']];
//$arr['findunds_com'] = ['db'=>['kimiber','aunites_com','hisomiy_com','niarsha_com','cynilon_com','bridany_com','yobouet_com']];
//$arr['ithrzn_com'] = ['db'=>['lindaey','dareney_com','himenit_com','lutoya_com','vishate_com','yaledia_com','naclari_com','karsony_com']];
//$arr['knittes_com'] = ['db'=>['lizeben']];
//$arr['pintzxcr_com'] = ['db'=>['magenri','canites_com','milisar_com','shanany_com','tamarse_com','karenty_com','paricen_com']];
//$arr['siniand_com'] = ['db'=>['pameniy','burkera_com','grovicn_com','resaniy_com','buridal_com','sariaen_com']];
//$arr['toskaha_com'] = ['db'=>['ravaley','lourder_com','mathria_com','wilsion_com','caspern_com','arsilin_com','tareken_com','casperneu_com']];
//$arr['visiive_com'] = ['db'=>['ricadom']];

$arr['corekoe_com'] = ['db'=>['patelsi_com','boriden_com','raquely_com','helenue_com']];
$arr['findunds_com'] = ['db'=>['niarsha_com','cynilon_com','bridany_com','yobouet_com','mathria_com','wilsion_com','arsilin_com','tareken_com']];
$arr['ithrzn_com'] = ['db'=>['lutoya_com','vishate_com','yaledia_com','naclari_com','karsony_com']];
$arr['pintzxcr_com'] = ['db'=>['milisar_com','shanany_com','tamarse_com','karenty_com','paricen_com']];
$arr['siniand_com'] = ['db'=>['resaniy_com','buridal_com','sariaen_com']];

$arr['findunds_com']['product_ids'] = [3198,3172,3188,3200,3184,3190,3178,3187,3196,3189,3007,3034,3003,3004,3026,3019,3065,3001,3068,3054,3207];
//$arr['toskaha_com']['product_ids'] = [214,62];
$arr['corekoe_com']['product_ids'] = [49];
$arr['pintzxcr_com']['product_ids'] = [7391,7385];


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
