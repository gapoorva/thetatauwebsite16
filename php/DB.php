<?php
	
	interface CondExp {
		const opNone = "";
		const opEqual = "=";
		const opNotEqual = "!=";
		const opLess = "<";
		const opLessEqual = "<=";
		const opGreater = ">";
		const opGreaterEqual = ">=";
		public function addCond($literal1, /*string*/ $operator, $literal2); //second 2 params should be optional
		public function addANDCondExp(/*CondExp*/ $condexp);
		public function addORCondExp(/*CondExp*/ $condexp);
		public function addANDCond($literal1, /*string*/ $operator, $literal2);
		public function addORCond($literal1, /*string*/ $operator, $literal2);
		public function compile();
	}

	interface Query {
		public function newCondExp(); // returns a condition expression
		public function setCondExp(/*CondExp*/ $condexp);
		public function setSortingDataPoint(/*string*/ $datapoint);
		public function unsetCondExp();
		public function evaluate(); // returns a QueryResult
	}

	interface QueryResult {
		public function getDataPointList(); // an ordered list of
		public function getRawData(); // returns array of arrays of data in datapointlist order
		public function reset(); // resets internal pointer
		public function next(); // returns next row as associative array or NULL
		public function count(); // num results
	}

	interface DB {
		public function get(/*array*/ $datapoints); //returns new provisioned getquery object
		public function put(/*array*/ $keyvaluemap); //returns new provisioned putquery object
		public function del(/*array*/ $scopes); //returns new provisioned delquery object
		public function desc(/*string*/ $scopename); //returns new provisioned descquery object
	}


	// STANDARDIZED GENERIC HELPER CLASSES

	class DBCreds {
		// Properties
		private $credmap;
		// Methods
		public function __construct() {
			$this->credmap = array();
		}
		public function addCred(/*string*/ $key, $value) {
			$this->credmap[$key] = $value;
			return $this;
		}
		public function getCred(/*string*/ $key) {
			return $this->credmap[$key];
		}
	}

	class Scope {
	// Properties
	private $dataPoints;
	private $key;
	// Methods
	public function __construct() {
		$this->dataPoints = array();
		$this->key = "";
	}
	// $type is required to be a string in {"boolean","integer","double","string"}
	// $req is required to be a type boolean
	public function addDP(/*string*/ $key, /*string*/ $type, /*bool*/ $req) {
		$this->dataPoints[$key] = array("type" => $type, "req" => $req);
		return $this;
	}
	public function declareKey(/*string*/ $key) {
		if (!array_key_exists($key, $this->dataPoints)) {
			die("Attempted to declare a key that doesn't exist in this scope:" . (string)$key);
		}
		$this->key = $key;
		return $this;
		}
	}

	class DBconf {
		public $scopes;
		public $credentials;
		public $logfile;
		public function __construct() {
			$this->scopes = array();
			$this->credentials = new DBCreds();
		}
		public function addScope(/*string*/ $name) {
			$this->scopes[$name] = array("scope" => new Scope(), "req" => false);
			return $this->scopes[$name]["scope"];
		}
		public function getScope(/*string*/ $name) {
			return $this->scopes[$name]["scope"];
		}
		public function getActiveScopes() {
			$active_scopes = array();
			foreach($this->scopes as $name => $scope) {
				if ($scope["req"]) {
					$active_scopes[$name] = $scope["scope"];
				}
			}
			return $active_scopes;
		}
		public function activateScopes(/*array*/ $scopelist) {
			foreach($scopelist as $name) {
				if (array_key_exists($name, $this->scopes)) {
					$this->scopes[$name]["req"] = true;
				}
			}
			return $this;
		}
	}
?>