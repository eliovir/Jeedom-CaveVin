<?php
header('Content-type: application/json');
require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";
if (!jeedom::apiAccess(init('apikey'), 'CaveVin')) {
	echo __('Clef API non valide, vous n\'êtes pas autorisé à effectuer cette action (CaveVin)', __FILE__);
	die();
}
$cmd = CaveVinCmd ::byId(init('id'));
if (!is_object($cmd)) {
	throw new Exception(__('Commande ID CaveVin inconnu : ', __FILE__) . init('id'));
}
if ($cmd->getEqType_name() != 'CaveVin') {
	throw new Exception(__('Cette commande n\'est pas de type CaveVin : ', __FILE__) . init('id'));
}
$cmd->setCollectDate('');
$cmd->event(false);
$cmd->setLogicalId('');
$cmd->getEqLogic()->refreshWidget();
$cmd->save();
?>
