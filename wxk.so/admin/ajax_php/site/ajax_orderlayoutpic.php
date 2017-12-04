<?php 

/*

ajax_orderlayoutpic.php   图片 改变顺序

         目前每个AJAX页面会产生6个 个人权限  用于判断用户当前权限
	     $ajaxispermit[DP]='1'; //DISPLAY             0  1
		 $ajaxispermit[AD]='1'; //ADD                 0  1
		 $ajaxispermit[ED]='1'; //EDIT                0  1
		 $ajaxispermit[DE]='1'; //DEL                 0  1
		 $ajaxispermit[GL]='1'; //GROUP LIST          0  1
		 $ajaxispermit[GE]='1'; //GROUP EDIT          0  1
		 $ajaxispermit[GD]='1'; //GROUP DEL           0  1
		 
		 



*/

require "../../inc/ajax_config.php";
$c_url='/siteset/layout.html';//当前AJAX文件的 父级文件 对应出当前AJAX文件的权限  注意：菜单的URL文件名更换 一旦生成之后 保持固定 不要随意更换 更换后 相应修改此处
require "../../inc/ajax_permit.php";



if( isset($_SESSION[username]) && $ajaxispermit[ED]){// 只有登陆用户才可以 并且拥有编辑权 


 //查找同组图片
	 $strSQL="SELECT * FROM layoutpic WHERE  id_layout=(select id_layout from layoutpic where id_layoutpic='".$_POST[picid]."') order by ordernum asc";
     $objDB->Execute($strSQL);
     $orderlayoutpic=$objDB->GetRows();
	 $intnum=sizeof($orderlayoutpic);



   // 更新状态	
   
   if($_POST["arrow"]=='up'){//向上移动
    
	 
	 for($i=0;$i<$intnum;$i++){
		 
		 if(($_POST[picid]==$orderlayoutpic[$i][id_layoutpic]) && $i!=0){//判断一级目录是否位置在最前，如果不到顶部就可以向上移动
			 
	             //             $orderlayoutpic[$i][id_newsdir] 当前ID      $orderlayoutpic[$i][ordernum]  当前顺序
				 //             $orderlayoutpic[$i-1][id_newsdir] 交换ID      $orderlayoutpic[$i-1][ordernum]  交换顺序
				 
//file_put_contents('aa.txt',$orderlayoutpic[$i][ordernum]); 
				 
				 $strSQL="UPDATE layoutpic SET ordernum=". $orderlayoutpic[$i-1][ordernum]." WHERE id_layoutpic=".$orderlayoutpic[$i][id_layoutpic]."";
				 $objDB->Execute($strSQL);
				 $strSQL="UPDATE layoutpic SET ordernum=".$orderlayoutpic[$i][ordernum]." WHERE id_layoutpic=".$orderlayoutpic[$i-1][id_layoutpic]."";	
				 $objDB->Execute($strSQL);
				 
			 
		 }

		 
	 }
	 
	
	
	
   }//end if  up
   
   
   
   
  if($_POST["arrow"]=='down'){//向下移动
    
	
	 for($i=0;$i<$intnum;$i++){
		 
		if(($_POST[picid]==$orderlayoutpic[$i][id_layoutpic]) && $i!=$intnum-1){//判断一级目录是否位置在最后，如果不在最后就可以向下移动
			 
	             //             $orderlayoutpic[$i][id_newsdir] 当前ID      $orderlayoutpic[$i][ordernum]  当前顺序
				 //             $orderlayoutpic[$i+1][id_newsdir] 交换ID      $orderlayoutpic[$i+1][ordernum]  交换顺序
				 
				 $strSQL="UPDATE layoutpic SET ordernum=". $orderlayoutpic[$i+1][ordernum]." WHERE id_layoutpic=".$orderlayoutpic[$i][id_layoutpic]."";
				 $objDB->Execute($strSQL);
				 $strSQL="UPDATE layoutpic SET ordernum=".$orderlayoutpic[$i][ordernum]." WHERE id_layoutpic=".$orderlayoutpic[$i+1][id_layoutpic]."";	
				 $objDB->Execute($strSQL);
				 
			 
		 }

		 
	 }
	
	
	
  }//end if end
   
   








}







?>

