<?php
try {
	require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
    	include_file('core', 'authentification', 'php');
	include_file('core', 'mesVin', 'class', 'CaveVin');

    	if (!isConnect()) {
		throw new Exception(__('401 - Accès non autorisé', __FILE__));
	}
	if (init('action') == 'ImportVins') {
		if (isset($_FILES['Vins']))
			ajax::success(CaveVin::ImportVins($_FILES['Vins']['tmp_name']));
	}
	if (init('action') == 'ExportVins') {	
		ajax::success(CaveVin::ExportVins());
	}
	if (init('action') == 'getFiltreVins') {	
		switch(init('Filtre')){
			case "met":
				$return = utils::o2a(mesVin::byMet(init('search')));
			break;
			default:
				$return = utils::o2a(mesVin::all());
			break;
		}
		for($loop=0;$loop<count($return);$loop++){
			$QtsTypeVin=0;
			$Caves=eqLogic::byType('CaveVin');
			if (is_array($Caves)){
				foreach ($Caves as $Cave){
					if (is_object($Cave)){
						$Qts=count($Cave->getCmd(null, $return[$loop]['id'],null,true));
						log::add('CaveVin','debug',$Qts.' bouteille(s) de'.$return[$loop]['Nom'].' ont été trouvé');
						$QtsTypeVin=$QtsTypeVin+$Qts;
					}
				}
			}
			$return[$loop]['QtsTypeVin']=$QtsTypeVin;
		}
        	ajax::success(jeedom::toHumanReadable($return));
	}
	if (init('action') == 'getVinInformation') {	
		ajax::success(jeedom::toHumanReadable(utils::o2a(mesVin::byId(init('id')))));
	}
	if (init('action') == 'gestionBouteille') {
		$Commande = cmd::byId(init('logement'));
		if (is_object($Commande))
		{
			log::add('CaveVin','debug','Mise a jours de la bouteille: '.init('logement').' '.init('status'));
			$Commande->setCollectDate('');
			$Commande->event(init('status'));
			$Commande->setConfiguration('vin',init('type'));
			$Commande->getEqLogic()->refreshWidget();
			$Commande->save();
			ajax::success(true);
		}
		else
			ajax::success(false);
	}
	if (init('action') == 'updateVin') {
	        $mesmesVinave = json_decode(init('event'), true);
	        $mesVin = null;
	        if (isset($mesmesVinave['id'])) {
	            $mesVin = mesVin::byId($mesmesVinave['id']);
	        }
	        if (!is_object($mesVin)) {
	            $mesVin = new mesVin();
	        }
	        utils::a2o($mesVin, jeedom::fromHumanReadable($mesmesVinave));
	        $mesVin->save();
	        ajax::success(jeedom::toHumanReadable(utils::o2a($mesVin)));
    	}
	if (init('action') == 'removeVin') {
	        $mesVin = mesVin::byId(init('id'));
	        if (is_object($mesVin))
			$mesVin->remove();
	        ajax::success();
	}	
  	if (init('action') == 'getWidget') {
		$CaveWidget=eqLogic::byId(init('id'));
		if (is_object($CaveWidget))
		{
			ajax::success($CaveWidget->toHtml('dashboard',false));
		}
		ajax::success(false);
    	}
    	if (init('action') == 'uploadEttiquette') {
		$uploaddir = dirname(__FILE__) . '/../../images';
		if (!file_exists($uploaddir)) {
			mkdir($uploaddir);
		}
		if (!file_exists($uploaddir)) {
			throw new Exception(__('Répertoire d\'upload non trouvé : ', __FILE__) . $uploaddir);
		}
		if (!isset($_FILES['file'])) {
			throw new Exception(__('Aucun fichier trouvé. Vérifié parametre PHP (post size limit)', __FILE__));
		}
		/*$extension = strtolower(strrchr($_FILES['file']['name'], '.'));
		if (!in_array($extension, array('.zip'))) {
			throw new Exception('Extension du fichier non valide (autorisé .zip) : ' . $extension);
		}*/
		if (filesize($_FILES['file']['tmp_name']) > 100000000) {
			throw new Exception(__('Le fichier est trop gros (maximum 100mo)', __FILE__));
		}
		$filename = str_replace(array(' ', '(', ')'), '', $_FILES['file']['name']);
		if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . '/' . $filename)) {
			throw new Exception(__('Impossible de déplacer le fichier temporaire', __FILE__));
		}
		if (!file_exists($uploaddir . '/' . $filename)) {
			throw new Exception(__('Impossible d\'uploader le fichier (limite du serveur web ?)', __FILE__));
		}
		ajax::success('./plugins/CaveVin/images/' . $filename);
    }
	throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}
?>
