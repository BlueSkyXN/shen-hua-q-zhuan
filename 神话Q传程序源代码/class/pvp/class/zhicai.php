<?php
   
if (!defined('wapxyz')) {
	exit('Not Found WAPWORK,程序异常操作！');
}
//zhicai破甲
$shuliang="0";
foreach($list as $ks=>$zd){


//只攻击这个对象
if($zd['duixiang']==$gongji_duixiang){

	$zhandou0= explode("|", $zd['name']); 
		if($zhandou0['0']=="user"){
			//人物对象
			$guaiwu = mysqli_query($db,"SELECT * FROM users WHERE id='".$zhandou0['1']."'");
$guaiwu = mysqli_fetch_array($guaiwu);
}elseif($zhandou0['0']=="pet"){
	//宠物对象
	$guaiwu = mysqli_query($db,"SELECT * FROM pet WHERE id='".$zhandou0['1']."'");
$guaiwu = mysqli_fetch_array($guaiwu);
}elseif($zhandou0['0']=="guaiwu"){
	//怪物对象
	$guaiwu = mysqli_query($db,"SELECT * FROM guaiwu WHERE id='".$zhandou0['1']."'");
$guaiwu = mysqli_fetch_array($guaiwu);
}

if($guaiwu[qixue]>"0"){
	$shuliang+="1";
	if($shuliang>$jineng_u['2']){
		break;//跳出循环
	}

//开始攻击
if($jineng_u[3]=="wu"){
$zhandou_gongji=$pkuser[gongji];
}else{
$zhandou_gongji=$pkuser[gongji_fa];
}//获取技能是法术还是物理

if($guaiwu[qixue]>"0"){

$zhanshou_shanghai=$jineng_u['10']*$guaiwu[dengji];
$zhanshou_shanghai+=$pkuser[pojia];//破甲
$mianshang=100-$guaiwu[mianshang];
$mianshang/=100;
$zhanshou_shanghai*=$mianshang;
if($zhanshou_shanghai<"1"){
	$zhanshou_shanghai="1";
}
}
	$guaiwu[qixue]-=$zhanshou_shanghai;
//吸血
$xixue1=floor($xixue1);
$pkuser[qixue]+=$xixue1;
//技能效果对大boss无效
if($guaiwu[boss]=="yes"){
	$s0="insert into pvp_tip(text,cid,time) values('".$pkuser[username]."使用了".$jineng_u[5].",".$guaiwu[username]."免疫该技能！','".$pk[id]."','".time()."')";
$ok0=mysqli_query($db,$s0);
}else{
	$s0="insert into pvp_tip(text,cid,time) values('".$pkuser[username]."对".$guaiwu[username]."使用了".$jineng_u[5].",".$guaiwu[username]."受到制裁效果减少".$zhanshou_shanghai."点气血','".$pk[id]."','".time()."')";
$ok0=mysqli_query($db,$s0);


//判断是否死了
if($guaiwu[qixue]<"1"){
		$s0="insert into pvp_tip(text,cid,time) values('".$guaiwu[username]."被打死了','".$pk[id]."','".time()."')";
$ok0=mysqli_query($db,$s0);
}
		if($zhandou0['0']=="user"){
			//人物对象
$sql1="update users set qixue='".$guaiwu[qixue]."' where id='".$zhandou0['1']."'";
$ok=mysqli_query($db,$sql1);

}elseif($zhandou0['0']=="pet"){
	//宠物对象	
$sql1="update pet set qixue='".$guaiwu[qixue]."' where id='".$zhandou0['1']."'";
$ok=mysqli_query($db,$sql1);

}elseif($zhandou0['0']=="guaiwu"){
	//宠物对象	
$sql1="update guaiwu set qixue='".$guaiwu[qixue]."' where id='".$zhandou0['1']."'";
$ok=mysqli_query($db,$sql1);

}
}
//获取敌方对象结束
}




}}