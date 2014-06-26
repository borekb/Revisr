<?php
/**
 * functions.php
 *
 * Common functions used throughout the plugin.
 *
 * @package   Revisr
 * @license   GPLv3
 * @link      https://revisr.io
 * @copyright 2014 Expanded Fronts
 */

//Main git function used throughout the plugin.
function git($args)
{
	$current_dir = getcwd();
	$cmd = "git $args";
	chdir(ABSPATH);
	exec($cmd, $output);
	chdir($current_dir);
	return $output;	
}

//Used for pushes and pulls.
function git_passthru($args)
{
	$current_dir = getcwd();
	$cmd = "git $args";
	chdir(ABSPATH);
	passthru($cmd, $output);
	chdir($current_dir);
	return $output;	
}

//Returns the current branch.
function current_branch()
{
	$output = git("rev-parse --abbrev-ref HEAD");
	
	if (!empty($output)) {
		return $output[0];		
	}
}

//Returns the number of pending files.
function count_pending()
{
	$pending = git("status --short");
	return count($pending);
}

//Returns the status of a file. 
function get_status($status)
{
	if (strpos($status, "M") !== false){
		$status = "Modified";
	}
	elseif (strpos($status, "D") !== false){
		$status = "Deleted";
	}
	elseif (strpos($status, "A") !== false){
		$status = "Added";
	}
	elseif (strpos($status, "R") !== false){
		$status = "Renamed";
	}
	elseif (strpos($status, "U") !== false){
		$status = "Updated";
	}
	elseif (strpos($status, "C") !== false){
		$status = "Copied";
	}
	elseif (strpos($status, "??") !== false){
		$status = "Untracked";
	}
	else {
		$status = $status;
	}

	return $status;
}

//Makes sure we have the necessary functions.
function check_compatibility()
{
	$error = "";
	if (!function_exists('exec') || !function_exists('passthru')) {
		$error .= "<p><strong>WARNING:</strong> Your server does not appear to support php exec() and/or passthru(). <br> 
		These functions are necessary for Revisr to work correctly. Contact your web host if you're not sure how to activate these functions.</p>";
	}
	echo $error;
}
