<?php
 // $Id$
 // $Author$
 // Defines FreeMED.CurrentProblems.* namespace

class CurrentProblems {

	function add($patient, $problem) {
		global $sql;

		// Perform search
		$query = "SELECT ptproblems FROM patient WHERE id='".addslashes($patient)."'";
		$result = $sql->query($query);
		if ($sql->results($result)) { extract($sql->fetch_array($result)); }
	
		// Same as in problems module... expand
		$my_problems = sql_expand($ptproblems);
		//foreach ($my_problems AS $k => $v) { print "$k = $v\n"; }
		if (!is_array($my_problems)) { $my_problems = array ($my_problems); }

		// Add a new member to the array
		$my_problems[] = $problem;

		// Remove empties
		foreach ($my_problems AS $k => $v) {
			if (empty($v)) unset($my_problems[$k]);
		}

		// Recombine
		$problems = sql_squash($my_problems);

		// Actually update the patient record
		$res = $sql->query($sql->update_query(
				"patient",
				array("ptproblems" => $problems),
				array("id" => $patient)
			));
		return CreateObject('PHP.xmlrpcresp',
			CreateObject('PHP.xmlrpcval', $res, 'boolean')
		);
	} // end method add

	function get($patient) {
		global $sql;

		// Perform search
		$query = "SELECT ptproblems FROM patient WHERE id='".addslashes($patient)."'";
		$result = $sql->query($query);

		if ($sql->results($result)) {
			$r = $sql->fetch_array($result);
			$_a = sql_expand($r['ptproblems']);
			if (!is_array($_a)) $_a = array($_a);
			foreach ($_a as $k => $v) {
				$a[] = CreateObject('PHP.xmlrpcval', $v, 'string');
			}
			return CreateObject('PHP.xmlrpcresp',
				CreateObject('PHP.xmlrpcval', $a, 'array')
			);
		} else {
			return CreateObject('PHP.xmlrpcresp',
				CreateObject('PHP.xmlrpcval', false, 'boolean')
			);
		}
	} // end method get

	function remove($patient, $problem) {
		global $sql;
	
		// Perform search
		$query = "SELECT ptproblems FROM patient WHERE id='".addslashes($patient)."'";
		$result = $sql->query($query);
		if ($sql->results($result)) { extract($sql->fetch_array($result)); }
	
		// Same as in problems module... expand
		$my_problems = sql_expand($ptproblems);
		//foreach ($my_problems AS $k => $v) { print "$k = $v\n"; }
		if (!is_array($my_problems)) { $my_problems = array ($my_problems); }
	
		// Removal
		foreach ($my_problems AS $k => $v) {
			// Remove empties or matches
			if (empty($v) or ($v == $problem)){
				unset($my_problems[$k]);
			}
		}
	
		// Recombine
		$problems = sql_squash($my_problems);
	
		// Actually update the patient record
		$res = $sql->query($sql->update_query(
				"patient",
				array("ptproblems" => $problems),
				array("id" => $patient)
			));
		return CreateObject('PHP.xmlrpcresp',
			CreateObject('PHP.xmlrpcval', $res, 'boolean')
		);
	} // end method remove

} // end class CurrentProblems

?>
