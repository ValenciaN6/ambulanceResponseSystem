<?php
include('baseservice/json.php');
use \Simple\json;

include('baseservice/baseservice.php');	
include("connecter.php");

function getnotification($id ){
	
	  //`driver`.`Latitude` , `driver`.`Longitude`,
	
     $link = @Conection(new json());
     $sql  = "SELECT DISTINCT `notification`.`ID` as 'NOTID' , `notification`.`FromID` as 'PID',`notification`.`ToID` as 'TOID', `notification`.`Type` as 'NTYPE' , `notification`.`Status` as 'NSTATUS', `notification`.`Date`,
	 ( SELECT `driver`.`Latitude` from `driver` where `notification`.`ToID` = `driver`.`ID` ) as 'Latitude',
	 ( SELECT `driver`.`Longitude` from `driver` where `notification`.`ToID` = `driver`.`ID` ) as 'Longitude',
	 (SELECT `patient`.`Name` FROM `patient` WHERE `patient`.`ID` = `notification`.`FromID`) as 'PName', 
	 (SELECT `patient`.`Name` FROM `patient` WHERE `notification`.`Message` = `patient`.`ID` ) as 'RNAME' ,
	 (SELECT `patient`.`Name` FROM `patient` WHERE `patient`.`ID` = `notification`.`ToID`) as 'TNAME' ,
	 (SELECT `driver`.`Name` FROM `driver` WHERE `driver`.`ID` = `notification`.`ToID`) as 'DNAME' 
	 FROM `notification` , driver WHERE  (`notification`.`FromID` = '$id' OR `notification`.`ToID` = '$id' OR `notification`.`Message` = '$id') and if(`notification`.`Type` = 'Ambulance request',`driver`.`ID` = `notification`.`ToID` , true)" ;

     $dt =  @getElements($sql,new json());

	$dt->datatype = "notification";
   return $dt;
}

getnotification($_GET['id'])->send();
?>