<?php

require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
include_file('core', 'mesVin', 'class', 'CaveVin');
class CaveVin extends eqLogic {
	public static function interact($_query, $_parameters = array()) {
		$ok = false;
		$files = array();
		$matchs = explode("\n", str_replace('\n', "\n", config::byKey('interact::sentence', 'CaveVin')));
		if (count($matchs) == 0) {
			return null;
		}
		$query = strtolower(sanitizeAccent($_query));
		foreach ($matchs as $match) {
			if (preg_match_all('/' . $match . '/', $query)) {
				$ok = true;
			}
		}
		if (!$ok) {
			return null;
		}
		//Recherche de la cave
		$data = interactQuery::findInQuery('object', $_query);
		if (is_object($data['object'])){
			$object=$data['object'];
           		$data = interactQuery::findInQuery('cmd', $_query,$object->getEqLogic(true,false,'CaveVin'));
			if (is_object($data['cmd'])){
				//Si un logement est trouvé alors j'ajoute ou enleve une bouteille
				$Logement=$data['cmd'];
				//log::add('CaveVin','debug',json_encode($Logement));	
				// Recheche du vin
				foreach (mesVin::all() as $Vin) {
					if (interactQuery::autoInteractWordFind($data['query'], $Vin->getNom())) {
						$Logement->setLogicalId($Vin->getId());
						$Logement->save();
						return array('reply' => __('Ok j\'ai ', __FILE__) . $query);
					}
				}
			}
		}else{
			//Si aucun logement ,'est trouvé lors je cree un nouvelle bouteille
			return array('ask' => 'Ok, Pour cree une nouvelle fiche de vin j\'ai quelques question a vous poser');
			
		}
		return array('error' => 'Je ne vous ai pas compris');
	}
	public function AddCommande($Name,$_logicalId) {
		$Commande = cmd::byEqLogicIdCmdName($this->getId(),$Name);
		//$Commande = $this->getCmd(null,$_logicalId);
		if (!is_object($Commande))
		{
			$Commande = new CaveVinCmd();
			$Commande->setId(null);
			$Commande->setEqLogic_id($this->getId());
			//$Commande->setLogicalId($_logicalId);
			$Commande->setType("info");
			$Commande->setSubType("binary");
			$Commande->setTemplate('dashboard','Bouteille');
			$Commande->setTemplate('mobile','Bouteille');
			$Commande->setEventOnly(true);
			$Commande->setIsVisible(true);
		}
		$Commande->setName($Name);
		$Commande->save();
		return $Commande;
	}
	public static function ImportVins($File) {
		$dir=dirname(__FILE__) .'/../../images/';
		if (!is_dir($dir)) 
			mkdir($dir);
		$zip = new ZipArchive(); 
		// On ouvre l’archive.
		if($zip->open($File) == TRUE)
		{
			$zip->extractTo($dir);
			$zip->close();
			$ListeVins=json_decode(file_get_contents($dir.'mesVin.sql'),true);
			foreach($ListeVins as $vin){
				$mesVin = new mesVin();
				utils::a2o($mesVin, jeedom::fromHumanReadable($vin));
				$mesVin->save();
			}
			unlink($dir.'mesVin.sql');
			return true;
		}
        	return false;
	}
	public static function ExportVins() {	
		$zipFile='/var/www/html/tmp/mesVin.zip';
		if(file_exists($zipFile))
			unlink($zipFile);
		$zip = new ZipArchive; 
		if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) { 
			log::add('CaveVin','debug','Création du fichier d\'export');	
			$zip->addFromString('mesVin.sql', json_encode(utils::o2a(mesVin::all())));
			$dir=dirname(__FILE__) .'/../../images/';
			$dh = opendir($dir); 
			while($file = readdir($dh)) { 	
				if ($file != '.' && $file != '..') { 
					log::add('CaveVin','debug','Ajout a l\'export:'.$dir.$file);	
					$zip->addFile($dir.$file,'etiquette/'.$file); 
				} 
			} 
			closedir($dh); 
			$zip -> close(); 
        		return $zipFile;
		}
        	return false;
	}
	public static function pull($_option) {
		log::add('CaveVin', 'debug', 'Objet mis à jour => ' . json_encode($_option));
		$Volet = CaveVin::byId($_option['CaveVin_id']);
		if (is_object($CaveVin) && $CaveVin->getIsEnable()) {
			$Commande = cmd::byId($_option['event_id']);
			if(is_object($Commande)){
				$array = utils::o2a($Commande);
				event::add('CaveVin::change', $array);
				//$Commande->setCollectDate('');
				//$Commande->event($_option['value']);
				//$Commande->save();
			}	
		}
	}
    	public function preSave() {
		$listener = listener::byClassAndFunction('CaveVin', 'pull', array('CaveVin_id' => intval($this->getId())));
		if (!is_object($listener))
		    $listener = new listener();
		$listener->setClass('CaveVin');
		$listener->setFunction('pull');
		$listener->setOption(array('CaveVin_id' => intval($this->getId())));
		$listener->emptyEvent();
		foreach($this->getCmd() as $cmd){
			$listener->addEvent(str_replace('#','',$cmd->getConfiguration('SortieBoutielle')));
		}
		$listener->save();	
		for($heightCase=1;$heightCase<=$this->getConfiguration('heightCase');$heightCase++){
			for($widthCase=1;$widthCase<=$this->getConfiguration('widthCase');$widthCase++)
				$this->AddCommande('Rang '.$widthCase." Colonne ".$heightCase,$widthCase."x".$heightCase);
		}
    	}
  	public function toHtml($_version = 'mobile',$Dialog=true) {
		$_version = jeedom::versionAlias($_version);
		$replace = array(
			'#id#' => $this->getId(),
			'#name#' => ($this->getIsEnable()) ? $this->getName() : '<del>' . $this->getName() . '</del>',
			'#eqLink#' => $this->getLinkToConfiguration(),
			'#background#' => $this->getBackgroundColor($_version),				
			'#height#' => $this->getDisplay('height', 'auto'),
			'#width#' => $this->getDisplay('width', '250'),
			'#dialog#' => $Dialog,
		);	
		$HtmlCasier='';
		for($heightCase=1;$heightCase<=$this->getConfiguration('heightCase');$heightCase++){
			$HtmlCasier.= '<tr>';
			for($widthCase=1;$widthCase<=$this->getConfiguration('widthCase');$widthCase++){
					$HtmlCasier.='<td>#Rang '.$widthCase." Colonne ".$heightCase.'#</td>';
				}
			$HtmlCasier.='</tr>';
		}
		if ($this->getIsEnable()) {
			foreach ($this->getCmd(null, null, true) as $cmd) {
				 $vin=mesVin::byId($cmd->getLogicalId());
				 if(is_object($vin)){
					$replaceCasierInfo['#Vigification#'] = $vin->getVinification();
				 	$replaceCasierInfo['#Couleur#'] = $vin->getCouleur();
				 	$replaceCasierInfo['#NbBouteille#'] = $vin->getNbVin();
				 }else{
					$replaceCasierInfo['#Vigification#'] = "Pas de vin dans ce logement";
				 	$replaceCasierInfo['#Couleur#'] = "Rouge";
				 	$replaceCasierInfo['#NbBouteille#'] = "0";
				 }
				 	
				 $replaceCasier['#'.$cmd->getName().'#'] = template_replace($replaceCasierInfo,$cmd->toHtml($_version));
			}
		}   
		$replace['#Casier#']=template_replace($replaceCasier,$HtmlCasier) ;
		return template_replace($replace, getTemplate('core', $_version, 'eqLogic','CaveVin'));
	}
}
class CaveVinCmd extends cmd {
	public function preSave() {
		$url = network::getNetworkAccess('external') . '/plugins/CaveVin/core/api/jeeCaveVin.php?apikey=' . jeedom::getApiKey('CaveVin') . '&id=' . $this->getId();
		$this->setConfiguration('url', $url);
	}
	public function execute($_options = array()) {
	}
}
?>
