<?php

//use url of the form "localhost/movsim.php?name=inception"
//movie name should be in the format "the-social-network"
if(!empty($_GET[name])){
$name=$_GET['name'];

$cmd1 =<<< EOT
curl --proxy http://
EOT;

//setting up proxy
$username='';//username here
$password='';//password here
$server='';//'servername:port' here


//website from where we are going to get the suggestions
$cmd2=<<< EOT
http://www.tastekid.com/movies/like/
EOT;
$movie=$name;
$cmd3=<<< EOT
 | grep "tk-Resource-title" |awk '{gsub("<span class=\"tk-Resource-title\">", "");print}' | awk '{gsub("</span>","");print}' 
EOT;
//some shell scripting blal blah
$h =shell_exec($cmd1.$username.':'.$password.'@'.$server.' '.$cmd2.$movie);
//shell_exec('string='.$h);
//checks whether movie is valid or not
//some more shell scripting blah blah

preg_match_all("/(Sorry,)/", $h, $found);


if(!($found[1][0] === 'Sorry,')){
	$h =shell_exec($cmd1.$username.':'.$password.'@'.$server.' '.$cmd2.$movie.$cmd3);
	//echo $found;
	//if the movie is found on the website then $similar stores the movie names
	$similar=explode ("\n",$h);
	unset($similar[0]);
	unset($similar[11]);
	$similar=array_values($similar);
}
//otherwise
else {
	$similar=NULL;
	//echo "not found";
}

$arr_for_json  = array('movie' => $movie, 'similar' => $similar );
echo json_encode($arr_for_json);

}
else {

//when input is not valid;
	$arr_for_json  = array('movie' => $movie, 'similar' => NULL );
echo json_encode($arr_for_json);
}



?>
