<?php
	include_once 'DB.php'; // includes interfaces
	include_once 'MySQLDBConfig.php'; // includes DBConfig

	class MySQLCondExp implements CondExp {
		private $condition; // single condition
		private $ANDList; // list of CondExps
		private $ORList;  // list of CondExps
		public function __construct($lit1 = NULL, $op = CondExp::opNone, $lit2 = NULL) {
			if ($lit1 != NULL && $op != CondExp::opNone && $lit2 != NULL) {
				// construct a full condition
				$this->condition = array($lit1, $op, $lit2);
				$this->ANDList = NULL;
				$this->ORList = NULL;
			} else if ($lit1 != NULL) {
				$condition = array($lit1);
				$this->ANDList = NULL;
				$this->ORList = NULL;
			} else { // empty condition
				$condition = NULL;
				$this->ANDList = NULL;
				$this->ORList = NULL;
			}
		} 
		public function addCond($literal1, /*string*/ $operator = CondExp::opNone, $literal2 = NULL){
			if ($operator != CondExp::opNone && $literal1 != NULL) {
				$this->condition = array($literal1, $operator, $literal2);				
			} else {
				$this->condition = array($literal1);
			}
			$this->ANDList = NULL;
			$this->ORList = NULL;
			return $this;
		}
		public function addANDCondExp(/*CondExp*/ $condexp) {
			if (!($condexp instanceof CondExp)) {
				die("Tried to add an non-CondExp AND condition");
			}
			$this->condition = NULL;
			$this->ORList = NULL;
			$this->ANDList[] = $condexp;
			return $this;
		}
		public function addORCondExp(/*CondExp*/ $condexp) {
			if (!($condexp instanceof CondExp)) {
				die("Tried to add an non-CondExp AND condition");
			}
			$this->condition = NULL;
			$this->ANDList = NULL;
			$this->ORList[] = $condexp;
			return $this;
		}
		public function addANDCond($literal1, /*string*/ $operator = CondExp::opNone, $literal2 = NULL) {
			$this->condition = NULL;
			$this->ORList = NULL;
			$this->ANDList[] = new MySQLCondExp($literal1, $operator, $literal2);
			return $this;
		}
		public function addORCond($literal1, /*string*/ $operator = CondExp::opNone, $literal2 = NULL) {
			$this->condition = NULL;
			$this->ANDList = NULL;
			$this->ORList[] = new MySQLCondExp($literal1, $operator, $literal2);
			return $this;
		}
		public function compile() {
			if ($this->condition == NULL && $this->ANDList == NULL && $this->ORList == NULL) {
				// Empty/Null CondExp
				return "FALSE";
			}
			// We can assume that at least 1 item is non null
			// We can also assume that due to maintained invariants,
			// Exactly 1 item is non null. Test the other two
			if ($this->ANDList == NULL && $this->ORList == NULL) { // single Condition
				$compiled = "";
				foreach($this->condition as $component) {
					$compiled .= (string)$component;
				}
				return $compiled;
			}
			if ($this->ANDList == NULL && $this->condition == NULL) { // OR list
				$compiled = "(". $this->ORList[0]->compile();
				foreach ($this->ORList as $i => $condexp) {
					if ($i == 0) continue; // skip 
					$compiled .= " OR " . $condexp->compile();
				}
				return $compiled.")";
			}
			if ($this->ORList == NULL && $this->condition == NULL) { // OR list
				$compiled = "(".$this->ANDList[0]->compile();
				foreach ($this->ANDList as $i => $condexp) {
					if ($i == 0) continue; // skip 
					$compiled .= " AND " . $condexp->compile();
				}
				return $compiled.")";
			}
			return "FALSE"; // Failsafe case
		}
	}


	///////////// CondExp Tests: ///////////////

	// $c = new MySQLCondExp();
	// $c->addORCond("userid", CondExp::opEqual, "gapoorva")
	// 	->addORCond("userid", CondExp::opEqual, "mmangle")
	// 	->addORCond("userid", CondExp::opNotEqual, "jparus");
	// $c->addCond("TRUE", CondExp::opEqual, "FALSE");
	// $c->addANDCond("roll", CondExp::opGreaterEqual, 39);

	// $subgroup = new MySQLCondExp();
	// $subgroup->addORCond("roleid", CondExp::opEqual, "regent")
	// 	->addORCond("roleid", CondExp::opEqual, "vice-regent");

	// $c->addANDCondExp($subgroup);

	// echo $c->compile();
	//echo $subgroup->compile();

	/////////////////////////////////////////////
?>