<?php
/***************************************************************************
*                           db_utilities.php  -  description
*                              -------------------
*     begin                : Thu May 31, 2001
*     copyright            : (C) 2001 The phpBB Group        
*     email                : support@phpbb.com                           
* 
*     $Id$

* 
****************************************************************************/
  
/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/

/***************************************************************************
*	We will attempt to create a file based backup of all of the data in the
*	users phpBB database.  The resulting file should be able to be imported by
*	the db_restore.php function, or by using the mysql command_line
*
*	Some functions are adapted from the upgrade_20.php script and others
*	adapted from the unoficial phpMyAdmin 2.2.0.
***************************************************************************/
// First we do a chdir as per Paul's suggestion, so that include paths will 
// be correrct ;)
chdir('../');

// Set VERBOSE to 1  for debugging info..
define("VERBOSE", "0");


// Bring in the necessary files to include functions we will use later.
include('extension.inc');
include('common.' . $phpEx);

// define a constant for the dbms so that we don't have to redeclare it 
// global for each function....
define('DBMS', "$dbms");
// Increase maximum execution time, but don't complain about it if it isn't 
// allowed.
@set_time_limit(600); 

function common_header()
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Strict//EN">
<HTML>
<HEAD>
<TITLE>phpBB - Database Backup</TITLE>
</HEAD>
<BODY BGCOLOR="#000000" TEXT="#FFFFFF" LINK="#11C6BD" VLINK="#11C6BD">
<?php
	return;
}

function common_footer()
{
?>
</BODY>
</HTML>
<?php
	return;
}

// The following functions are adapted from phpMyAdmin and upgrade_20.php
//
//
//	This fuction will return a talbes create definition to be used as an sql
// statement.

function get_table_def($db, $table, $crlf) 
{
	global $drop;
	$schema_create = "";
	// If the user has selected to drop existing tables when doing a restore.
	// Then we add the statement to drop the tables....
	if ($drop == 1)
	{
		$schema_create .= "DROP TABLE IF EXISTS $table;$crlf";
	}
	
	$schema_create .= "CREATE TABLE $table($crlf";

	// Ok lets grab the fields...
	switch(DBMS) 
	{
		case 'mysql':
			$field_query = "SHOW FIELDS FROM $table";
			$key_query = "SHOW KEYS FROM $table";
			break;
	}
	$result = $db->sql_query($field_query);
	if(!result)
	{
		$error = $db->sql_error();
		error_die(GENERAL_ERROR, 'Failed in get_table_def (show fields) : ' . $error['message']);
	}
	while ($row = $db->sql_fetchrow($result))
	{
		$schema_create .= '	' . $row['Field'] . ' ' . $row['Type'];
		if(!empty($row['Default']))
		{
			$schema_create .= ' DEFAULT \'' . $row['Default'] . '\'';
		}
		if($row['Null'] != "YES") 
		{
			$schema_create .= ' NOT NULL';
		}
		if($row['Extra'] != "")
		{
			$schema_create .= ' ' . $row['Extra'];
		}
		$schema_create .= ",$crlf";
	}
	// Drop the last ',$crlf' off ;)
	$schema_create = ereg_replace(',' . $crlf . '$', "", $schema_create);

	// Get any Indexed fields from the database...
	$result = $db->sql_query($key_query);
	if(!$result)
	{
		$error = $db->sql_error();
		error_die(GENERAL_ERROR, 'FAILED IN get_table_def (show keys) : ' . $error['message']);
	}
	while($row = $db->sql_fetchrow($result)) {
		$kname = $row['Key_name'];
		if(($kname != 'PRIMARY') && ($row['Non_unique'] == 0))
		{
			$kname = "UNIQUE|$kname";
		}
		if(!is_array($index[$kname])) 
		{
			$index[$kname] = array();
		}
		$index[$kname][] = $row['Column_name'];
	}
	while(list($x, $columns) = @each($index)) 
	{
		$schema_create .= ", $crlf";
		if($x == 'PRIMARY')
		{
			$schema_create .= '	PRIMARY KEY (' . implode($columns, ', ') . ')';
		} 
		elseif (substr($x,0,6) == 'UNIQUE')
		{
			$schema_create .= '	UNIQUE ' . substr($x,7) . ' (' . implode($columns, ', ') . ')';
		} 
		else
		{
			$schema_create .= "	KEY $x (" . implode($columns, ', ') . ')';
		}
	}
	$schema_create .= "$crlf);";
	if(get_magic_quotes_runtime()) 
	{
		return(stripslashes($schema_create));
	} 
	else 
	{
		return($schema_create);
	}
}

//
// Get the data from the tables and format it as a series of INSERT statements.
// After every row a custom callback function $handler gets called.
// $handler must accept one parameter ($sql_insert);
//
function get_table_content($db, $table, $handler)
{
	$result = $db->sql_query("SELECT * FROM $table");
	if(!$result) 
	{
		$error = $db->sql_error();
		error_die(GENERAL_ERROR, 'Failed in get_table_content (select *): ' . $error['message']);
	}
	if($db->sql_numrows($result) > 0) 
	{
		$schema_insert = "\n#\n# Table Data for $table\n#\n";
	}
	else
	{
		$schema_insert = "";
	}
	$handler($schema_insert);
	while ($row = $db->sql_fetchrow($result))
	{
		$table_list = '(';
		$num_fields = $db->sql_numfields($result);
		for ($j = 0; $j < $num_fields; $j++)
		{
			$table_list .= $db->sql_fieldname($j, $result) . ', ';
		}
		$table_list = ereg_replace(', $', '', $table_list);
		$table_list .= ')';
		
		$schema_insert = "INSERT INTO $table $table_list VALUES(";
		for ($j = 0; $j < $num_fields; $j++)
		{
			if(!isset($row[$j]))
			{
				$schema_insert .= ' NULL, ';
			} 
			elseif ($row[$j] != '') 
			{
				$schema_insert .= ' \'' . addslashes($row[$j]) . '\',';
			} 
			else
			{
				$schema_insert .= '\'\',';
			}
		}
		$schema_insert = ereg_replace(',$', '', $schema_insert);
		$schema_insert .= ');';
		$handler(trim($schema_insert));
	}
	return(true);
}
function output_table_content($content)
{
	global $backup_sql;
	$backup_sql .= $content . "\n";
	return;
}
//
// remove_remarks will strip the sql comment lines out of an uploaded sql file
//
function remove_remarks($sql) {
  $i = 0; 
  while($i < strlen($sql)) { 
    if($sql[$i] == "#" and ($sql[$i-1] == "\n" or $i==0)) { 
      $j=1;
      while($sql[$i+$j] != "\n") $j++;
      $sql = substr($sql,0,$i) . substr($sql,$i+$j);
    }
    $i++;
  }
  return($sql);
}
//
// split_sql_file will split an uploaded sql file into single sql statements.
//
function split_sql_file($sql, $delimiter) {
	$sql = trim($sql);
	$char = "";
	$last_char = "";
	$ret = array();
	$in_string = true;
	
	for($i=0; $i<strlen($sql); $i++)
	{
		$char = $sql[$i];
		
		// if delimiter found, add the parsed part to the returned array
		if($char == $delimiter && !$in_string) 
		{
			$ret[] = substr($sql, 0, $i);
			$sql = substr($sql, $i + 1);
			$i = 0;
			$last_char = "";
		}
		if($last_char == $in_string && $char == ")")
		{
			$in_string = false;
		}
		if($char == $in_string && $last_char != "\\")
		{ 
			$in_string = false;
		}
		elseif(!$in_string && ($char == "\"" || $char == "'") && ($last_char != "\\"))
		{
			$in_string = $char;
		}
		$last_char = $char;
	}
	if (!empty($sql))
	{
		$ret[] = $sql;
	}
	return($ret);
}

//  
// End Functions
//

if(isset($perform))
{
	switch($perform)
	{
		case 'backup':
			$tables = array('auth_access', 'auth_forums', 'banlist', 'categories', 'config', 'disallow', 'forum_access', 'forum_mods', 'forums', 'groups', 'posts', 'posts_text', 'privmsgs', 'ranks', 'session', 'session_keys', 'smilies', 'themes', 'themes_name', 'topics', 'user_group', 'users', 'words');
			if(!isset($additional_tables) && !empty($additional_tables)) 
			{
				if(ereg(',', $additional_tables)) {
					$additional_tables = split(',', $additional_tables);
					foreach($additional_tables as $table_name) 
					{
						$tables[] = trim($table_name);
					}
				} else
				{
					$tables[] = trim($table_name);
				}
			}
			if(!isset($backupstart))
			{
				common_header();
				echo "<H2>This will perform a backup of all phpBB2 related tables.</H2><BR>";
				echo "<P>If you have any additional custom tables in the same database with phpBB that you would like to back up as well please enter their names seperated by commas in the Additional Tables textbox below.<BR>\n";
				echo "Otherwise just select the form of backup you want to perform and click the Start Backup button below.</P><BR>\n\n";
				echo "<CENTER><FORM METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
				echo "<TABLE BORDER=0>\n";
				echo "<TR><TD>Additional Tables:</TD><TD><INPUT TYPE=\"text\" NAME=\"more_tables\"></TD></TR>\n";
				echo "<TR><TD>Full Backup:</TD><TD><INPUT TYPE=\"radio\" NAME=\"backup_type\" VALUE=\"full\" SELECTED></TD></TR>\n";
				echo "<TR><TD>Table Structure Only:</TD><TD><INPUT TYPE=\"radio\" NAME=\"backup_type\" VALUE=\"structure\"></TD></TR>\n";
				echo "<TR><TD>Table Data Only:</TD><TD><INPUT TYPE=\"radio\" NAME=\"backup_type\" VALUE=\"data\"></TD></TR>\n";
				echo "</TABLE><INPUT TYPE=\"hidden\" NAME=\"perform\" VALUE=\"backup\">\n";
				echo "<INPUT TYPE=\"hidden\" NAME=\"drop\" VALUE=\"1\">";
				echo "<INPUT TYPE=\"submit\" NAME=\"backupstart\" VALUE=\"Start Backup\" ONCLICK=\"setTimeout('document.location=\'$PHP_SELF?backup_done=1\'', 2000);\"></FORM></P>\n";
				common_footer();
				exit;
			}
			// Build the sql script file...
			$backup_sql = "#\n";
			$backup_sql .= "# phpBB Backup Script\n";
			$backup_sql .= "# Dump of tables for $dbname\n";
			$backup_sql .= "#\n# DATE : " .  gmdate("d-m-Y H:i:s", time()) . " GMT\n";
			$backup_sql .= "#\n";
			for($i = 0; $i < count($tables); $i++)
			{
				$table_name = $tables[$i];
				if($backup_type != 'data')
				{
					$backup_sql .= "#\n# TABLE: " . $table_prefix . $table_name . "\n#\n";
					$backup_sql .= get_table_def($db, $table_prefix . $table_name, "\n") . "\n";
				} 
				if($backup_type != 'structure')
				{
					get_table_content($db, $table_prefix . $table_name, "output_table_content");
				}
			}
			// move forward with sending the file across...
			header("Content-Type: text/x-delimtext; name=\"phpbb_db_backup.sql\"");
			header("Content-disposition: attachment; filename=phpbb_db_backup.sql");
			header("Pragma: no-cache");
         echo $backup_sql;
			exit;
			break;
		case 'restore':
			if(!isset($restore_start)) 
			{	
				common_header();
				echo "<H2>This will perform a full restore of a previously Backed up phpBB database</H2><BR>\n";
				echo "<P><b>WARNING: This will overwrite any existing data</b><br>\n";
				echo "<FORM ENCTYPE=\"multipart/form-data\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
				echo "<INPUT TYPE=\"hidden\" NAME=\"perform\" VALUE=\"restore\">\n";
				echo "Backup File:<INPUT TYPE=\"file\" NAME=\"backup_file\">\n";
				echo "<INPUT TYPE=\"submit\" NAME=\"restore_start\" VALUE=\"Start Restore\">\n";
				echo "</FORM></P>\n";
				common_footer();
			} else 
			{	
				// Handle the file upload ....
				if($backup_file == "none")
				{
					error_die(GENERAL_ERROR, 'Backup file upload failed...');
					exit;
				}
				if(ereg("^php[0-9A-Za-z_.-]+$", basename($backup_file)))
				{
					$sql_query = fread(fopen($backup_file, 'r'), filesize($backup_file));
					if(get_magic_quotes_runtime() == 1) 
					{
						$sql_query = stripslashes($sql_query);
					}
				} else
				{
					error_die(GENERAL_ERROR, 'Trouble Accessing uploaded file...');
					exit;
				}
				$sql_query = trim($sql_query);
				if($sql_query != "") 
				{
					// Strip out sql comments...
					$sql_query = remove_remarks($sql_query);
					$pieces = split_sql_file($sql_query, ";");
					for($i = 0; $i < count($pieces); $i++)
					{
						$sql = trim($pieces[$i]);
						if(!empty($sql) and $sql[0] != "#")
						{	
							if(VERBOSE == 1) 
							{
								echo "Executing: $sql\n<br>";
							}
							$result = $db->sql_query($sql);
							if(!$result)
							{
								$error = $db->sql_error();
								error_die(GENERAL_ERROR, 'Error importing backup file : ' . $error['message'] . "\n$sql");
							}
						}
					}
				}
				common_header();
				echo "<CENTER><H2>The Database has been successfully restored..</H2>\n";
				echo "<P><BR>Your board should be back to the state it was when the backup was made.<BR>\n";
				echo '<A HREF="index.' . $phpEx . '">Go back to the Admin</A>';
				echo '</P></CENTER>';
				common_footer();
			}
			exit;
			break;
	}
} 
elseif (isset($backup_done))
{
	common_header();
	echo "<CENTER><H2>Your backup file should be downloading now</H2></CENTER><br>\n";
	echo "<A HREF=\"$PHP_SELF\">Click Here to return to the Database Utilities</A><br>\n";
	common_footer();
}
else 
{
	common_header();
	echo "<TABLE ALIGN=\"center\"><TR><TD ALIGN=\"CENTER\"><H2>Database Utilities</H2></TD></TR>\n";
	echo "<TR><TD><A HREF=\"$PHP_SELF?perform=backup\">Backup Database</A></TD></TR>\n";
	echo "<TR><TD><A HREF=\"$PHP_SELF?perform=restore\">Restore Database</A></TD></TR>\n";
	common_footer();
}
?>
