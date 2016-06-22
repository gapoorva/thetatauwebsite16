<?php
	include_once 'DB.php'; // includes interfaces
	include_once 'MySQLDBConfig.php'; // includes DBConfig

	class MySQLCondExp implements CondExp {
		const LISTS = 3;
		const CONDANDLIST = 6;
		const CONDORLIST = 5;
		const ALL = 7;
		private $condition; // single condition
		private $ANDList; // list of CondExps
		private $ORList;  // list of CondExps
		private function typecast($lit) {
			if (is_string($lit)) {
				return "\"".str_replace('"', "", $lit)."\"";
			} 
			return strval($lit);
		}
		private function nullify($t) {
			$this->condition = ($t & 4) ? NULL : $this->condition;
			$this->ANDList = ($t & 2) ? NULL : $this->ANDList;
			$this->ORList = ($t & 1) ? NULL : $this->ORList;
		}
		public function __construct($lit1 = NULL, $op = CondExp::opNone, $lit2 = NULL) {
			if ($lit1 != NULL && $op != CondExp::opNone && $lit2 != NULL) {
				// construct a full condition
				$this->addCond($lit1, $op, $lit2);
			} else if ($lit1 != NULL) {
				$this->setCond($lit1);
			} else { // empty condition
				$this->setFalse();
			}
		} 
		public function setTrue() {
			$condition = array(TRUE);
			$this->nullify(MySQLCondExp::LISTS);
		}
		public function setFalse() {
			$this->nullify(MySQLCondExp::ALL);
		}
		public function addCond($literal1, /*string*/ $operator = CondExp::opNone, $literal2 = NULL){
			if ($operator != CondExp::opNone && $literal1 != NULL) {
				$this->condition = array($this->typecast($literal1), $operator, $this->typecast($literal2));				
			} else {
				$this->condition = array($this->typecast($literal1));
			}
			$this->nullify(MySQLCondExp::LISTS);
			return $this;
		}
		public function addANDCondExp(/*CondExp*/ $condexp) {
			if (!($condexp instanceof CondExp)) {
				die("Tried to add an non-CondExp AND condition");
			}
			$this->nullify(MySQLCondExp::CONDORLIST);
			$this->ANDList[] = $condexp;
			return $this;
		}
		public function addORCondExp(/*CondExp*/ $condexp) {
			if (!($condexp instanceof CondExp)) {
				die("Tried to add an non-CondExp AND condition");
			}
			$this->nullify(MySQLCondExp::CONDANDLIST);
			$this->ORList[] = $condexp;
			return $this;
		}
		public function addANDCond($literal1, /*string*/ $operator = CondExp::opNone, $literal2 = NULL) {
			$this->nullify(MySQLCondExp::CONDORLIST);
			$this->ANDList[] = new MySQLCondExp($literal1, $operator, $literal2);
			return $this;
		}
		public function addORCond($literal1, /*string*/ $operator = CondExp::opNone, $literal2 = NULL) {
			$this->nullify(MySQLCondExp::CONDANDLIST);
			$this->ORList[] = new MySQLCondExp($literal1, $operator, $literal2);
			return $this;
		}
		public function removeCond() {
			if ($this->condition == NULL && $this->ANDList == NULL && $this->ORList == NULL) {
				// Empty/Null CondExp
				return NULL;
			}
			// sanity checks
			if ($this->ANDList == NULL && $this->ORList == NULL) {
				if (count($this->condition) == 1) {
					$v = new MySQLCondExp($this->condition[0]);
					$this->condition = NULL;
					return $v;
				} else {
					$v = new MySQLCondExp($this->condition[0], $this->condition[1], $this->condition[2]);
					$this->condition = NULL;
					return $v;
				}
			}
			if ($this->condition == NULL && $this->ORList == NULL) {
				if (count($this->ANDList) > 0) {
					return array_pop($this->ANDList);
				} else {
					return NULL;
				}
			}
			if ($this->condition == NULL && $this->ANDList == NULL) {
				if (count($this->ORList) > 0) {
					return array_pop($this->ORList);
				} else {
					return NULL;
				}
			}
			return NULL; // catch-all
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

	/*$useriddp = new DataPoint("users", "userid", "string", true);
	$roledp = new DataPoint("roles", "roleid", "string", true);

	$c = new MySQLCondExp();
	$c->addORCond($useriddp, CondExp::opEqual, "gapoorva")
		->addORCond($useriddp, CondExp::opEqual, "mmangle")
		->addORCond($useriddp, CondExp::opNotEqual, "jparus");
	//$c->setCond("TRUE", CondExp::opEqual, "FALSE");
	//$c->addANDCond("roll", CondExp::opGreaterEqual, 39);

	$subgroup = new MySQLCondExp();
	$subgroup->addORCond($roledp, CondExp::opEqual, "regent")
		->addORCond($roledp, CondExp::opEqual, "vice-regent");

	$c->addORCondExp($subgroup);

	echo $c->compile() . "<br>";
	echo $subgroup->compile() ."<br>";

	$subgroup->removeLogicUnit();
	echo $subgroup->compile();*/

	/////////////////////////////////////////////

	class MySQLDBGetQuery /*implements Query*/ {
		private $condexp;
		private $sorton;
		private $mysql;
		private $scopes;
		private function getAlias($code) {
			if ($code >= 0 && $code <= 9) 
				return "_".chr($code+48);
			if ($code >= 10 && $code <= 35)
				return chr($code+65-10);
			if ($code >= 36 && $code <= 61)
				return chr($code+97-36);
			die("NO ALIAS CODE FOR".strval($code));
		}
		private function fillAlias($alias, $str) {
			return preg_replace("/\\$#[\\w]+#\\$/", $alias, $str);
		}
		private function keyLink($scope1, $scope2) {
			$k1 = $this->scopes[$scope1]->getKeys();
			$k2 = $this->scopes[$scope2]->getKeys();
			foreach($k1 as $dp1) 
				foreach($k2 as $dp2) 
					if ($dp1->equalTo($dp2)) 
						return $dp1;
			return NULL;

		}
		public function __construct($mysql_conn, $relevant_scopes) {
			$this->condexp = new MySQLCondExp();
			$this->sorton = NULL;
			$this->mysql = $mysql_conn;
			$this->scopes = $relevant_scopes; // expecting map of scopes
		}
		public function newCondExp() {
			return new MySQLCondExp();
		}
		public function setCondExp(/*CondExp*/ $condexp) {
			$this->condexp = $condexp;
			return $this;
		}
		public function unsetCondExp() {
			$v = $this->condexp;
			$this->condexp = NULL;
			return $v;
		}
		public function sortOn(/*string*/ $datapoint) {
			$this->sorton = $datapoint;
			return $this;
		}
		// evaluate a built query and return the result
		public function evaluate() {


			// type resolution
			$command = "SELECT ";
			$aliases = array();
			$alias_code = 0;
	
			// for gets, need to check if scopes are related
			$numscopes = count($this->scopes);
			if ($numscopes == 0) {
				$command = NULL; // sanity check
				break;
			}
			
			if ($numscopes == 1) {
				//special case of only having 1 scope to deal with
				//get everything in this one scope
				foreach($this->scopes as $i => $scope) { // even tho it's 1
					$aliases[$scope->name()] = $this->getAlias($alias_code++);
					$command .= 
						$this->fillAlias($aliases[$scope->name()], $scope->getDPList())
						." FROM ".$scope->name() 
						." AS ". $aliases[$scope->name()]
						." WHERE ".$this->
							fillAlias($aliases[$scope->name()], $this->condexp->compile());
					if($this->sorton != NULL) {
						$command .= " ORDER BY ". $this->
							fillAlias($aliases[$scope->name()], strval($this->sorton));
					}
				}
			} else {
				// multi-scope case - for efficiency, need to find join keys
				// restriction: query will only succeed if all scopes can be joined
				// create a graph of scopes and connections by *keys* only (n-1 edges)
				$edges = array();
				$innies = array(0); // first node is in
				$outies = range(1, count($this->scopes)-1);
				while(count($outies) != 0) {
					$start = count($edges);
					foreach($outies as $outie) {
						foreach($innies as $innie) {
							$link = $this->keyLink($innie, $outie);
							if($link != NULL) {
								$edges[] = array($innie, $outie, $link);
								$innies[] = $outie;
								$outies = array_diff($outies, array($outie));
								break 2;
							}
						}
					}
					if ($start == count($edges)) { 
						// we didn't add anything. This means there's a scope that can't be connected.
						die("INVALID SET OF UNRELATED SCOPES");
					}


				}	

			}
		} // returns a QueryResult
	}

	// for puts, and dels determine which scopes are affected
	// this directly translates to the number of queries
	// needed in SQL to make the appropriate insert/delete queries



	///////////// MySQLQuery Tests: ///////////////

	// $scope_array = array($MySQLDBConfig->getScope("profile"));
	// $query = new MySQLDBGetQuery(NULL, $scope_array);
	// $cond = $query->newCondExp();
	// $cond->addORCond($scope_array[0]->getDP("major_ug"), CondExp::opEqual, "CSE");
	// $cond->addORCond($scope_array[0]->getDP("major_ug"), CondExp::opEqual, "ME");
	// $cond->addORCond($scope_array[0]->getDP("major_ug"), CondExp::opEqual, "IOE");
	// $query->sortOn($scope_array[0]->getDP("userid"));
	// $query->setCondExp($cond);
	// echo $query->evaluate();

	///////////////////////////////////////////////



?>