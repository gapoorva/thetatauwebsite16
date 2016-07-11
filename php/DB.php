<?php

	$servername = "localhost";
	$username = "thetatau_user";
	$password = "mysql";
	$dbname = "thetatau_db";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 


	$token_auth_stmt = $conn->prepare("SELECT COUNT(*) FROM auth WHERE userid=? AND token=?");
	$login_stmt = $conn->prepare("UPDATE auth SET token=? WHERE userid=? AND pw=?");
	$mast_stmt = $conn->prepare("SELECT mastimg, quote, credit FROM mastcontent");

	function validate_token() {
		global $token_auth_stmt;
		if(!isset($_COOKIE['token'])) return false;
		$token_auth_stmt->bind_param("ss", $_COOKIE['token'], $_COOKIE['userid']);
		$token_auth_stmt->execute();
		$token_auth_stmt->bind_result($auths);
		while($token_auth_stmt->fetch()) {
			if ($auths == 1) { // should only matching one...
				return true;
			} else return false;
		}
		return false; // just cause
	}

	function salted_pw($u, $p) {
		return hash("sha256", hash("sha256", $p).$u);
	}

	function login($userid, $pw) {
		// salted sha256 pw hash
		global $login_stmt, $conn;
		$now = time();
		$pw = salted_pw($userid, $pw);
		$token = hash("sha256", $pw.strval($now));

		$login_stmt->bind_param("sss", $token, $userid, $pw);
		$login_stmt->execute();

		$auths = $conn->affected_rows;
		
		if ($auths != 1) return false; // didn't properly execute
		else {
			// set cookie before returning true
			setcookie("token", $token, $time()+12*3600); // Login is good for 12 hrs.
			return true;
		}
	}

	function getMastContent() {
		global $mast_stmt;

		$mast_stmt->execute();
		$mast_stmt->bind_result($img, $quote, $credit);

		$content = array();

		while($mast_stmt->fetch()) {
			$content[] = array (
					"img" => $img,
					"quote" => $quote,
					"credit" => $credit
				);
		}
		return $content;
	}

	
// /*
// 	CondExp:

// 	A Conditional Expression is passed to a Query object
// 	to provide an interface to express complex logical 
// 	selection on the dataset.

// 	The interface allows the creation of objects that can
// 	be created once and be used many times over. 
	
// 	To facillitate the compilation of the statement into
// 	a database specific layer, the interface has some
// 	recursive methods. This encourages but doesn't force
// 	a recursive implementation.
// */

// 	interface CondExp {
// 		const opNone = "";
// 		const opEqual = "=";
// 		const opNotEqual = "!=";
// 		const opLess = "<";
// 		const opLessEqual = "<=";
// 		const opGreater = ">";
// 		const opGreaterEqual = ">=";
// 		public function setFalse();
// 		public function setTrue();
// 		public function addCond($literal1, /*string*/ $operator, $literal2); //second 2 params should be optional
// 		public function addANDCondExp(/*CondExp*/ $condexp);
// 		public function addORCondExp(/*CondExp*/ $condexp);
// 		public function addANDCond($literal1, /*string*/ $operator, $literal2);
// 		public function addORCond($literal1, /*string*/ $operator, $literal2);
// 		public function removeCond(); // removes and returns last CondExp set
// 		public function compile();
// 	}

// /*

// 	Query:

// 	A Query object is returned from a Database object. The
// 	Database Object should return one of several variants 
// 	on the Query object. Every variant obeys the interface
// 	below, but can actually evaluate a query differently.

// 	See the Database object for the usual variants of the
// 	Query Object.

// 	The Query object can be initalized with CondExps, a
// 	Sorting Specification on a Datapoint, and a set of
// 	focused datapoints. From these parameters, the Query
// 	Object can build a query. This performs client-side
// 	type checking and validation. 

// 	It then creates an internal representation of the query 
// 	that varies based on the specific database implemented,
// 	and returns an ID by which that representation can be
// 	accessed. 
	
// 	The ID can then be used evaluate the query. This returns
// 	a QueryResult object which can then be used to supply 
// 	the calling application with data. The evaluate method
// 	also loads the query properties for hot-swapping new
// 	properties efficiently

// 	In this way, the Query object is highly re-usable and
// 	performant. 

// */

// 	interface Query {
// 		public function newCondExp(); // returns a condition expression
// 		public function setCondExp(/*CondExp*/ $condexp);
// 		public function unsetCondExp();
// 		public function getCondExp();
// 		public function sortOn(/*string*/ $datapoint);
// 		public function evaluate(); // executes the query and returns a QueryResult
// 	}

// 	interface QueryResult {
// 		public function getDataPointList(); // an ordered list of data points
// 		public function getRawData(); // returns array of maps of data in datapointlist order
// 		public function reset(); // resets internal pointer
// 		public function next(); // returns next row as associative array or NULL
// 		public function count(); // num results
// 	}

// 	interface DB {
// 		public function get(/*array*/ $datapoints); //returns new provisioned getquery object
// 		public function put(/*array*/ $keyvaluemap); //returns new provisioned putquery object
// 		public function del(/*array*/ $scopes); //returns new provisioned delquery object
// 		public function scopes(); // returns a map of active scopes.
// 	}


// 	// STANDARDIZED GENERIC HELPER CLASSES

// 	class DBCreds {
// 		// Properties
// 		private $credmap;
// 		// Methods
// 		public function __construct() {
// 			$this->credmap = array();
// 		}
// 		public function addCred(/*string*/ $key, $value) {
// 			$this->credmap[$key] = $value;
// 			return $this;
// 		}
// 		public function getCred(/*string*/ $key) {
// 			return $this->credmap[$key];
// 		}
// 	}

// 	class DataPoint {
// 		public $type;
// 		public $req;
// 		public $scopename;
// 		public $dpname;
// 		public function __construct($scopename, $dpname, $type = "string", $req = false) {
// 			$this->scopename = $scopename;
// 			$this->dpname = $dpname;
// 			$this->type = $type;
// 			$this->req = $req;
// 		}
// 		public function __toString() {
// 			return "$#".$this->scopename."#$.".$this->dpname; // unique pattern meant for easy-aliasing
// 		}
// 		public function equalTo($DP) {
// 			return $this->$dpname == $DP->dpname && $this->$type && $DP->dpname && $this->req == $DP->req;
// 		}

// 	}

// 	class Scope {
// 		// Properties
// 		private $dataPoints;
// 		private $keys;
// 		private $name;
// 		// Methods
// 		public function __construct($name) {
// 			$this->dataPoints = array();
// 			$this->keys = array();
// 			$this->name = $name;
// 		}
// 		// $type is required to be a string in {"boolean","integer","double","string"}
// 		// $req is required to be a type boolean
// 		private function assert($DP) {
// 			if(!array_key_exists($DP, $this->dataPoints)) {
// 				die("Attempted to access a DP: ".$DP." that doesn't exist in scope: ".$this->name);
// 			}
// 		}
// 		public function name() {return $this->name;}
// 		public function addDP(/*string*/ $key, /*string*/ $type, /*bool*/ $req) {
// 			$this->dataPoints[$key] = new DataPoint($this->name, $key, $type, $req);
// 			return $this;
// 		}
// 		public function getDP($DP) {
// 			$this->assert($DP);
// 			return $this->dataPoints[$DP];
// 		}
// 		public function getDPList() { // returns a single quote list of DPs

// 			return implode(", ", array_values($this->dataPoints));
// 		}
// 		public function declareKey(/*string*/ $key) {
// 			$this->assert($key);
// 			$this->keys[] = $this->dataPoints[$key];
// 			return $this;
// 		}
// 		public function getKeys() {return $this->keys;}
		
// 		public function typeCheck($DP, $type) {
// 			return $this->dataPoints[$DP]->$type == $type;
// 		}
// 	}

// 	class DBconf {
// 		public $scopes;
// 		public $credentials;
// 		public $logfile;
// 		public function __construct() {
// 			$this->scopes = array(); //map of scopes
// 			$this->credentials = new DBCreds();
// 		}
// 		public function addScope(/*string*/ $name) {
// 			$this->scopes[$name] = array("scope" => new Scope($name), "req" => false);
// 			return $this->scopes[$name]["scope"];
// 		}
// 		public function getScope(/*string*/ $name) {
// 			return $this->scopes[$name]["scope"];
// 		}
// 		public function getActiveScopes() {
// 			$active_scopes = array();
// 			foreach($this->scopes as $name => $scope) {
// 				if ($scope["req"]) {
// 					$active_scopes[$name] = $scope["scope"];
// 				}
// 			}
// 			return $active_scopes;
// 		}
// 		public function activateScopes(/*array*/ $scopelist) {
// 			foreach($scopelist as $name) {
// 				if (array_key_exists($name, $this->scopes)) {
// 					$this->scopes[$name]["req"] = true;
// 				}
// 			}
// 			return $this;
// 		}
// 	}
?>