<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");

	$datas = array('result'=>false, 'message'=>null);

	if($_POST['revwTitle']!=null){
		$today_date = Date("y-m-d");

		$sql = "update revw_tbl set revwTitle='".$_POST['revwTitle']."', revwSatisfaction='".$_POST['revwSatisfaction']."', revwContent='".$_POST['revwContent']."', revwModifyDate='".$today_date."', lecNum='".$_POST['lecNum']."' where revwNum='".$_POST['revwNum']."';";

		$result_updt = mysql_query($sql);

		if(!$result_updt){
			$datas['result']=false;
			$datas['message'] = mysql_error($result_updt);
		}
		else{

			$sql_delfile = "delete from revw_file_tbl where revwNum='".$_POST['revwNum']."';";
			$result_delfile = mysql_query($sql_delfile);

			if(!$result_delfile){
				$datas['result']=false;
				$datas['message'] = mysql_error($result_delfile);
			}
			else{
				if($_POST['fileInfo'] !=null){
					foreach($_POST['fileInfo'] as $value){

						$file_value = explode("...", $value);

						$sql_revwfile = "insert into revw_file_tbl set revwNum='".$_POST['revwNum']."', fileName='".basename($file_value[0])."', realName='".$file_value[1]."', fileAttacher='".$file_value[2]."';";
						$result_revwfile = mysql_query($sql_revwfile);

						$datas['result']=true;
						$datas['message']=null;

						if(!$result_revwfile){
							$datas['result']=false;
							$datas['message'] = mysql_error($result_revwfile);
						}
					}
				}
				else{
					$datas['result']=true;
					$datas['message']=null;
				}
				
			}

		}
	}

	echo json_encode($datas);

	mysql_close($connect);
	exit;

?>