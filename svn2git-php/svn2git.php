<!DOCTYPE html>
<?php
/*
*
* A Script to automate migration process for SVN2GIT
*
* Requierments : git ( installed into PATH ) , svn server ( svnserve.exe ), RUBY , Gem svn2git / 
*
*/
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SVN2GIT</title>
</head>
<body>
<?php
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

$SVNserver = "127.0.0.1";
$SVNprotocol = "svn://"; // svn:// , https://, file\\\, 
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

// $dirs = array_filter(glob('*'), 'is_dir');
// print_r( $dirs);


$directories = glob($SVNroot  . '/*' , GLOB_ONLYDIR);

// print_r( $directories); // Debug 

echo nl2br('Starting process for '.count($directories).' directories.');

foreach ( $directories as $repo ) {
	$repoName = str_replace($SVNroot.'/' , '' , $repo );
	
	echo ' <h2>Starting migration on '. $repoName . PHP_EOL . '</h2>';
	
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
			echo $GITrepoPath . nl2br('folder was created ..\n ') ;

			// Create authors.txt file requiered for migration ...
			$myfile = fopen($GITrepoPath."/authors.txt", "a") or die("Unable to open file!");
			$txt = "";
			foreach ( $usersMap as $SVNuser => $GITuser   ) {
				$txt .=  $SVNuser . "=" . $GITuser . PHP_EOL . "<br>";
			}
			
			fwrite($myfile, "\n". $txt);
			echo nl2br( $GITrepoPath . '/ authors.txt was created ..\n ') ;
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
			// @see : http://stackoverflow.com/questions/26620312/installing-git-in-path-with-github-client-for-windows
			
			// $cmd = "cd c:/Users/Magic-OFFICE/AppData/Local/GitHub/GitHub.appref-ms --open-shell && svn2git svn://192.168.1.10/". $repoName . " --username " .$SVNusername ." --authors authors.txt --notags --nobranches --notrunk";
			$cmd = "cd ".$GITrepoPath." && svn2git svn://127.0.0.1/". $repoName . " --username " .$SVNusername ." --authors authors.txt --notags --nobranches --notrunk";
			
			// @see : http://stackoverflow.com/questions/41420717/cmd-from-php-script-get-feedback/41421196#41421196
			
			// $output_storage = [];
			// $output_showed = [];
			// $result = null;
			
			// exec($cmd, $output_storage, $result);
			
			// while( $result === null ){
				// $diff = array_diff($output_storage, $output_showed);
				// if( $diff ){
					// // all new outputs here as $diff
					// $output_showed = $diff;
					// echo $output_showed;
				// }
			// }
			
			$output = shell_exec($cmd);
			echo "<pre>$output</pre>";
			echo "<pre>$cmd</pre>";
			
			// system("cmd /c cd D: cd MIG\\ dir>dir.txt");
			$cmd2 = $GITrepoPath . '/ ' . 'dir>dir.txt';

			echo '[ var $repoName ] == > ' .$repoName . "<br>";
			echo '[ var $GITrepoPath ] == > ' .$GITrepoPath. "<br>";
			echo '[ SVN server , repo location  ] == > ' . $SVNprotocol . $SVNserver. '/'.$repoName. "<br>";

		} else {
			echo nl2br("Aborting - <b>"). $GITrepoPath . nl2br("</b> Folder Already exists ..");
		}
	}

?>
</body>
</html>