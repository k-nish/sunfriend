<?php
function convString($string){
	if(get_magic_quotes_gpc()){
		$string = stripslashes($string);
	}
	$string = htmlspecialchars($string,ENT_QUOTES,'utf-8');
	$string = str_replace(",","，",$string);
	$string = str_replace(array("\r\n","\n","\r"),"<br>",$string);
	return $string;
}

function convString_thumbnail($string){
	if(get_magic_quotes_gpc()){
		$string = stripslashes($string);
	}
	$string = htmlspecialchars($string,ENT_QUOTES,'utf-8');
	$string = str_replace(",","，",$string);
	$string = str_replace(array("\r\n","\n","\r"),"",$string);
	$string = substr($string,0,20);
	return $string;
}

function keyCheck($string) {
    if ($string == "3friend") {	
        return true;
    } else {
        return false;
    }
}

function copyright(){
	echo "<span style='font-size:15px; filter:Alpha(opacity=10,)'><div class='text-center'>&copy; 2014 TipsBox</div></span>";
}