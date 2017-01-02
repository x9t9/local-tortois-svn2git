<?php
/*
*
* A Script to automate migration process for SVN2GIT
*
* Requierments : git ( installed into PATH ) , svn server ( svnserve.exe ), RUBY , Gem svn2git ,XAMPP ( or any other *AMP stack )
*
*/

error_reporting(E_ALL); 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
set_time_limit(300); // Just to be sure ..


/*
*
* Example of how to execute a shell command from PHP
*
*/

// shell_exec("cd d:/MIG && dir>d:/MIG/dir.txt");
// $output = shell_exec($cmd2);
// echo "<pre>$output</pre>";
// exec('some_command 2>&1', $output);


/*
*
* Set your variables here 
*
*/

$dirs = array_filter(glob('*'), 'is_dir');
print_r( $dirs);
$SVNroot = "D:/Repositories"; // no trailing slash
$GITroot = "D:/MIG";
$SVNusername = "Magic-OFFICE"; // SVN username to access SVN repos .

/*
* Map Authors from svnUsername to git UserName.
*/
$usersMap = array (
							'Magic-OFFICE' => 'krembo99 <krembo99@yahoo.com> ',
							'Krembo99' => 'krembo99 <krembo99@yahoo.com> ',
							'krembo99' => 'krembo99 <krembo99@yahoo.com> ',
							);						
/*
* OPTIONAL - add surfix, prefix or filter repos names .
*/
						
// $prefix = '';
// $surfix = '';
// $replace_in_name = array ('_rep' =>'','_REP' => '','wc' => '');

/*
*
* STOP EDITING 
*
*/

$directories = glob($SVNroot  . '/*' , GLOB_ONLYDIR);

// print_r( $directories); // Debug 

foreach ( $directories as $repo ) {
	$repoName = str_replace($SVNroot.'/' , '' , $repo );
	echo ' </br>Starting migration on '. $repoName . PHP_EOL . '</br>';
	
	// Replace unwanted strings , Surfix , Prefix 
	if ( isset($replace_in_name) || !empty($replace_in_name)) {
		foreach ($replace_in_name as $oldstr => $newstr ) {
			$repoName = str_replace($oldstr,$newstr,$repoName );
			
		}
	}
	if ( isset($prefix)) {
		foreach ($replace_in_name as $oldstr => $newstr ) {
			$repoName = $prefix .$repoName;
			
		}
	}
	if ( isset($surfix)) {
		foreach ($replace_in_name as $oldstr => $newstr ) {
			$repoName = $repoName . $surfix;
			
		}
	}
	
	$GITrepoPath = $GITroot.'/'.$repoName;
	
	if (!file_exists($GITrepoPath)) {
			mkdir($GITrepoPath, 0755, true);
			echo $GITrepoPath . ' CREATED .. ' . PHP_EOL . "<br>";

			// Create authors.txt file requiered for migration ...
			$myfile = fopen($GITrepoPath."/authors.txt", "a") or die("Unable to open file!");
			$txt = "";
			foreach ( $usersMap as $SVNuser => $GITuser   ) {
			$txt .=  $SVNuser . "=" . $GITuser . PHP_EOL . "<br>";
			}
			
			fwrite($myfile, "\n". $txt);
			fclose($myfile);
			
			// Launch SVN2GIT
			// $cmd = $GITrepoPath. '/ svn2git svn://192.168.1.10/'.$repoName.'/ --username '.$SVNusername .' --authors authors.txt --notags --nobranches --notrunk';
			
		
			/*
			* Working 
			*/
			// $cmd = "cd ".$GITrepoPath." && dir>".$GITrepoPath."/dir.txt";
			
			// $cmd = "cd ".$GITrepoPath." && svn2git svn://192.168.1.10/". $repoName . " --username " .$SVNusername ." --authors authors.txt --notags --nobranches --notrunk";
			
			/*
			cd d:/MIG && start Git  will start git - but will not execute...
			*/
			
			// we need to put git into PATH 
			//http://stackoverflow.com/questions/26620312/installing-git-in-path-with-github-client-for-windows
			
			// $cmd = "cd c:/Users/Magic-OFFICE/AppData/Local/GitHub/GitHub.appref-ms --open-shell && svn2git svn://192.168.1.10/". $repoName . " --username " .$SVNusername ." --authors authors.txt --notags --nobranches --notrunk";
			$cmd = "cd ".$GITrepoPath." && svn2git svn://127.0.0.1/". $repoName . " --username " .$SVNusername ." --authors authors.txt --notags --nobranches --notrunk";
			$output = shell_exec($cmd);
			echo "<pre>$output</pre>";
			echo "<pre>$cmd</pre>";
			
			// system("cmd /c cd D: cd MIG\\ dir>dir.txt");
			$cmd2 = $GITrepoPath . '/ ' . 'dir>dir.txt';

			echo '$repoName -- > ' .$repoName . "<br>";
			echo '$GITrepoPath -- > ' .$GITrepoPath. "<br>";
			echo '$repoName -- > svn://127.0.0.1/' .$repoName. "<br>";

		} else {
			echo $GITrepoPath . " Already exists ..";
		}
	}

?>