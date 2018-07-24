<?php
require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';

function CaveVin_install() {
	$values = array('id' => 'mesVin');			
	$sql = "SHOW TABLES LIKE :id";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = file_get_contents(dirname(__FILE__) . '/install_mesVin.sql');
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Met'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Met` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Ettiquette'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Ettiquette` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Apogee'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Apogee` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Garde'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Garde` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
}

function CaveVin_update() {
	$values = array('id' => 'mesVin');			
	$sql = "SHOW TABLES LIKE :id";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = file_get_contents(dirname(__FILE__) . '/install_mesVin.sql');
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Met'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Met` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Ettiquette'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Ettiquette` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Apogee'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Apogee` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Garde'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Garde` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	foreach(eqLogic::byType('CaveVin') as $Cave){
		for($heightCase=1;$heightCase<=$Cave->getConfiguration('heightCase');$heightCase++){
			for($widthCase=1;$widthCase<=$Cave->getConfiguration('widthCase');$widthCase++){
				$Name=$Cave->getName().'_'.$widthCase."x".$heightCase;
				$Commande = cmd::byEqLogicIdCmdName($Cave->getId(),$Name);
				$Commande->setConfiguration('vin',$Commande->getLogicalId());
				$Commande->setLogicalId($widthCase."x".$heightCase);
				$Commande->setName('Rang '.$widthCase." Colonne ".$heightCase);
				$Commande->save();
			}
		}
	}
}
function CaveVin_remove() {
	$values = array('id' => 'mesVin');
	$sql = "SDROP TABLE mesVin";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
}
?>
