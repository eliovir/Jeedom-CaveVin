<?php
class mesVin {
	private $id;
	private $Nom;
	private $Cepage;
	private $Couleur;
	private $Millesime;
	private $Terroir;
	private $DegreAlcoolique;
	private $Vinification;
	private $TempIdeal;
	private $Decanter;
	private $Volume;
	private $Met;
	private $Ettiquette;
	private $Apogee;
	private $Garde;

	public static function byId($_id) {
		$values = array(
			'id' => $_id
		);
		$sql = 'SELECT ' . DB::buildField(__CLASS__) . ' FROM mesVin WHERE id=:id';
		return DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW, PDO::FETCH_CLASS, __CLASS__);
	}
	public static function byName($_name) {
		$values = array(
			'Nom' => $_name
		);
		$sql = 'SELECT ' . DB::buildField(__CLASS__) . ' FROM mesVin WHERE Nom=:Nom';
		return DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW, PDO::FETCH_CLASS, __CLASS__);
	}
	public static function byMet($_met) {
		$values = array(
			'met' => $_name
		);
		$sql = 'SELECT ' . DB::buildField(__CLASS__) . ' FROM mesVin WHERE Met=:Met';
		return DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW, PDO::FETCH_CLASS, __CLASS__);
	}
	public static function byMillesime($_millesime) {
		$values = array(
			'Millesime' => $_millesime
		);
		$sql = 'SELECT ' . DB::buildField(__CLASS__) . ' FROM mesVin WHERE Millesime=:Millesime';
		return DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW, PDO::FETCH_CLASS, __CLASS__);
	}
	public static function all() {
		$sql = 'SELECT ' . DB::buildField(__CLASS__) . ' FROM mesVin ORDER BY Nom';
		return DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL, PDO::FETCH_CLASS, __CLASS__);
	}
	public function remove() {
		return DB::remove($this);
	}
	public function preSave() {
	
	
	}
	public function save() {
		return DB::save($this);
	}
	/*     * **********************Getteur Setteur*************************** */
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setNom($data) {
		$this->Nom = $data;
	}
	public function getNom() {
		return $this->Nom;
	}
	public function setCepage($data) {
		$this->Cepage = $data;
	}
	public function getCepage() {
		return $this->Cepage;
	}
	public function setCouleur($data) {
		$this->Couleur = $data;
	}
	public function getCouleur() {
		return $this->Couleur;
	}
	public function setMillesime($data) {
		$this->Millesime = $data;
	}
	public function getMillesime() {
		return $this->Millesime;
	}
	public function setTerroir($data) {
		$this->Terroir = $data;
	}
	public function getTerroir() {
		return $this->Terroir;
	}
	public function setDegreAlcoolique($data) {
		$this->DegreAlcoolique = $data;
	}
	public function getDegreAlcoolique() {
		return $this->DegreAlcoolique;
	}
	public function setVinification($data) {
		$this->Vinification = $data;
	}
	public function getVinification() {
		return $this->Vinification;
	}
	public function setTempIdeal($data) {
		$this->TempIdeal = $data;
	}
	public function getTempIdeal() {
		return $this->TempIdeal;
	}
	public function setDecanter($data) {
		$this->Decanter = $data;
	}
	public function getDecanter() {
		return $this->Decanter;
	}
	public function setVolume($data) {
		$this->Volume = $data;
	}
	public function getVolume() {
		return $this->Volume;
	}
	public function setMet($data) {
		$this->Met = $data;
	}
	public function getMet() {
		return $this->Met;
	}
	public function setEttiquette($data) {
		$this->Ettiquette = $data;
	}
	public function getEttiquette() {
		return $this->Ettiquette;
	}
	public function setApogee($data) {
		$this->Apogee = $data;
	}
	public function getApogee() {
		return $this->Apogee;
	}
	public function setGarde($data) {
		$this->Garde = $data;
	}
	public function getGarde() {
		return $this->Garde;
	}
	public function getNbVin() {
		$QtsTypeVin=0;
		/*
		$Caves=eqLogic::byTypeAndSearhConfiguration('CaveVin');
		if (is_array($Caves)){
			foreach ($Caves as $Cave){
				if (is_object($Cave)){
					$Qts=count($Cave->getCmd(null, $this->id,null,true));
					$QtsTypeVin=$QtsTypeVin+$Qts;
				}
			}
		}*/
		$Logements=cmd::searchConfiguration(array('vin'=>$this->id),'CaveVin');
		if (is_array($Logements)){
			foreach ($Logements as $Logement){
				if($Logement->getConfiguration('vin') == $this->id) 
					$QtsTypeVin++;
			}
		}
		return;
	}
}
?>
