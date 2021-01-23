<?php
require_once('../controleur/Action.interface.php');
class CompteAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "default";	
		else return "compte";
	}
}
?>