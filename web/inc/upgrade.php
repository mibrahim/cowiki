<?php

// Upgrade the database to the current version
$highestversion = $dbver;

if ($highestversion < "0001") {
	// Upgrade to version 0001
	query("BEGIN TRANSACTION");

	query("CREATE TABLE variables(name text, value text)");

	query("CREATE TABLE pages(
			key INTEGER PRIMARY KEY AUTOINCREMENT, 
			site text, 
			title text, 
			content text, 
			parent INTEGER,
			lastmodified INTEGER, 
			json text)");

	query("CREATE INDEX idx_parent on pages(parent)");
	query("CREATE INDEX idx_site on pages(site)");
	query("CREATE INDEX idx_title on pages(title)");

	query("COMMIT");

	$highestversion = "0001";
}

if ($highestversion < $sysversion) {
	die("Error while upgrading system");
}

setVar("sysversion", $highestversion);
