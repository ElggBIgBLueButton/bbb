<?php 
/// Config your server here - Configura tu servidor aquí 
// Server example - Servidor de ejemplo: test-install.blindsidenetworks.com/bigbluebutton/ 
// Write without -  Escribir sin : http:// or https:// 
//
$server="test-install.blindsidenetworks.com/bigbluebutton/";

/// Add secret of server - Escriba el codido secreto del servidor
// Example salt - Codigo de ejemplo: 8cd8ef52e8e101574e400365b55e11a6

$salt="8cd8ef52e8e101574e400365b55e11a6";

// Only edit if you need - Solo editar si es necesario
$name = elgg_get_logged_in_user_entity ()->name; // Get name of actual user - Obtiene el nombre del usuario actual
$nameid=elgg_get_logged_in_user_entity ()->guid; // Get id of actual user - Obtiene el id del usuario actual
$name=str_replace(" ", "_",$name); // Replace spaces between letters - Reemplaza espacios entre letras
$groupid=elgg_get_page_owner_guid(); // Get group id - obtiene id del grupo 
$group=get_entity ($groupid); // Get info about group  - Obtiene la informacion del grupo
$dueno=$group->owner_guid; // Get if of group owner - obtiene el id del dueño del grupo
$group=$group->name; // Get name group - Obtiene el nombre del grupo
$group=str_replace(" ", "_",$group); // Replace spaces between letters - Reemplaza espacios entre letras
$pass=md5($dueno); // Generate password for moderator - genera contraseña del moderador
$passgr=md5($group); // Generate password for users - genera contraseña para usuarios

// Check if owner 
if ($nameid==$dueno)
{
// Generate url to check if meeting is running - Genera url para revisar si la sala está creada
$chec= "isMeetingRunning?meetingID=" . $group;
$check= "isMeetingRunningmeetingID=" . $group . $salt;
$checksumcheck= sha1($check);
$urlcheck="http://" . $server . "api/" . $chec .  "&checksum=" .$checksumcheck;
$checkxml= simplexml_load_file($urlcheck);
$istrue= $checkxml->running;
// Generate url to create meeting - Genera url para crear sala
$strr="create?meetingID=" . $group . "&fullName=" . $name . "&attendeePW=" . $passgr . "&moderatorPW=" . $pass;
$str="createmeetingID=" . $group . "&fullName=" . $name . "&attendeePW=" . $passgr . "&moderatorPW=" . $pass . $salt;
$checksum=sha1($str);
$url= "http://" . $server . "api/" . $strr .  "&checksum=" .$checksum;
$xml= simplexml_load_file($url);
// Connect to meeting - Coencta a la sala
$strr2="join?meetingID=" . $group . "&fullName=" . $name . "&password=" . $pass;
$str2="joinmeetingID=" . $group . "&fullName=" . $name . "&password=" . $pass . $salt;
$checksum2=sha1($str2); 
$url2= "http://" . $server . "api/" . $strr2 .  "&checksum=" .$checksum2;
forward($url2);
}
else{ // Check if login 
	if ($name != Null){
		// Generate url to check if meeting is running - Genera url para revisar si la sala está creada
		$chec= "isMeetingRunning?meetingID=" . $group;
		$check= "isMeetingRunningmeetingID=" . $group . $salt;
		$checksumcheck= sha1($check);
		$urlcheck="http://" . $server . "api/" . $chec .  "&checksum=" .$checksumcheck;
		$checkxml= simplexml_load_file($urlcheck);
		$istrue= $checkxml->running;
		// Generate url to create meeting - Genera url para crear sala
		$strr="create?meetingID=" . $group . "&fullName=" . $name . "&attendeePW=" . $passgr . "&moderatorPW=" . $pass;
		$str="createmeetingID=" . $group . "&fullName=" . $name . "&attendeePW=" . $passgr . "&moderatorPW=" . $pass . $salt;
		$checksum=sha1($str);
		$url= "http://" . $server . "api/" . $strr .  "&checksum=" .$checksum;
		$xml= simplexml_load_file($url);
		// Connect to meeting - Coencta a la sala
		$strr2="join?meetingID=" . $group . "&fullName=" . $name . "&password=" . $passgr;
		$str2="joinmeetingID=" . $group . "&fullName=" . $name . "&password=" . $passgr . $salt;
		$checksum2=sha1($str2); 
		$url2= "http://" . $server . "api/" . $strr2 .  "&checksum=" .$checksum2;
		forward($url2);
	}
	else{   // Show info where not loggin - Muestra informacion cuando no esta loggeado
		$params = array(
	        'title' => 'Hola!',
        	'content' => 'Debes Iniciar sesión para continuar ',
        	'filter' => '',
    		);
		$body = elgg_view_layout('content', $params);
		echo elgg_view_page('Hello', $body);
	}
}
?>
