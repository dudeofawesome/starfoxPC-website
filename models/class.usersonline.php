<?php	

class usersOnline {
	
	function __construct() {
		global $loggedInUser,$userOnlineTime;
		
		//Used for display only
		if(!isUserLoggedIn()) { $session = "0"; $userOnlineName =  "Anonymous";
		} else { 
		$session = "1"; $userOnlineName = $loggedInUser->display_username;
		}
		
		$this->userOnlineTime 		= $userOnlineTime;									// Timeout
		$this->userOnlineDate 		= $userOnlineDate = time(); 						// Momento que entra en línea
		$this->userOnlineLimit 		= $this->userOnlineDate-$this->userOnlineTime*60;	// Tiempo Limite de espera
		$this->userOnlineIP 		= $_SERVER['REMOTE_ADDR'];							// Recuperamos su IP
		$this->userOnlineSession	= $session;											// Ver si es usuario o no
		$this->userOnlineName		= $userOnlineName;									// Si hay nombre se muestra
	}
	
	function usersOnlineDelete() {
		global $db,$db_table_prefix;	
		
		// si se supera el tiempo limite (5 minutos) lo borramos
		$sql = "DELETE FROM ".$db_table_prefix."Users_Online 
					WHERE Date_Time < ".$db->sql_escape($this->userOnlineLimit)."
					";
					return $db->sql_query($sql);

	}
	
	function usersOnlinePrcess() {
		global $db,$db_table_prefix;
		
		// tomamos todos los usuarios en linea
		$sql = "SELECT * 
				FROM ".$db_table_prefix."Users_Online 
				WHERE User_IP = '".$db->sql_escape($this->userOnlineIP)."'
				";
		
		// Si son los mismo actualizamos la tabla gente_online
		if(returns_result($sql) != 0) {
		$sql = "UPDATE ".$db_table_prefix."Users_Online 
				SET Date_Time = '".$db->sql_escape($this->userOnlineDate)."', 
				User_Session = '".$db->sql_escape($this->userOnlineSession)."', 
				Username = '".$db->sql_escape($this->userOnlineName)."' 
				WHERE User_IP = '".$db->sql_escape($this->userOnlineIP)."'
				";
				return $db->sql_query($sql);
					
		} else {
		// Si son diferentes insertamos en la tabla gente_online
		$sql = "INSERT INTO ".$db_table_prefix."Users_Online (
				Date_Time,
				User_IP,
				User_Session,
				Username
				) 
				VALUES (
				'".$db->sql_escape($this->userOnlineDate)."',
				'".$db->sql_escape($this->userOnlineIP)."',
				'".$db->sql_escape($this->userOnlineSession)."',
				'".$db->sql_escape($this->userOnlineName)."'
				)
				";
				return $db->sql_query($sql);
		}
	}
}		
		
class usersOnlineView extends usersOnline {		
	
	public function ViewTotal() {	
		global $db,$db_table_prefix;
		usersOnline::usersOnlineDelete();
		usersOnline::usersOnlinePrcess();
		
		// Seleccionamos toda la tabla
		$sql = "SELECT * 
				FROM ".$db_table_prefix."Users_Online";
				$usuarios = returns_result($sql);	
				return $usuarios;
	}
	
	public function ViewNoRegistred() {
		global $db,$db_table_prefix;
		usersOnline::usersOnlineDelete();
		usersOnline::usersOnlinePrcess();
		
		//Usuarios no registrados
		$sql = "SELECT * 
				FROM ".$db_table_prefix."Users_Online 
				WHERE User_Session = '0'
				";
				$noregistrados = returns_result($sql);		
				return $noregistrados;
	}
	
	public function ViewRegistred() {
		global $db,$db_table_prefix;
		usersOnline::usersOnlineDelete();
		usersOnline::usersOnlinePrcess();
		
		//Usuarios registrados
		$sql = "SELECT * 
				FROM ".$db_table_prefix."Users_Online 
				WHERE User_Session = '1'
				";
				$registrados = returns_result($sql);
				return $registrados;
	}
}	
?>