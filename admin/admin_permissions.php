<?php
/***************************************************************************
 *                           admin_permissions.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id$
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !empty($setmodules) )
{
	if ( !$auth->acl_get('a_auth') )
	{
		return;
	}

	$filename = basename(__FILE__);
	$module['Forums']['Permissions']   = $filename . $SID . '&amp;mode=forums';
	$module['Forums']['Moderators']   = $filename . $SID . '&amp;mode=moderators';
	$module['Forums']['Super_Moderators']   = $filename . $SID . '&amp;mode=supermoderators';
	$module['General']['Administrators']   = $filename . $SID . '&amp;mode=administrators';

	return;
}

define('IN_PHPBB', 1);
//
// Include files
//
$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

// Do we have forum admin permissions?
if ( !$auth->acl_get('a_auth') )
{
	message_die(MESSAGE, $lang['No_admin']);
}

// Define some vars
if ( isset($_GET['f']) || isset($_POST['f']) )
{
	$forum_id = ( isset($_POST['f']) ) ? intval($_POST['f']) : intval($_GET['f']);
	$forum_sql = " WHERE forum_id = $forum_id";
}
else
{
	$forum_id = 0;
	$forum_sql = '';
}

if ( isset($_GET['mode']) || isset($_POST['mode']) )
{
	$mode = ( isset($_POST['mode']) ) ? $_POST['mode'] : $_GET['mode'];
}
else
{
	$mode = '';
}

//
// Start program proper
//
switch ( $mode )
{
	case 'forums':
		$l_title = $lang['Permissions'];
		$l_title_explain = $lang['Permissions_explain'];
		$l_can = '_can';
		break;
	case 'moderators':
		$l_title = $lang['Moderators'];
		$l_title_explain = $lang['Moderators_explain'];
		$l_can = '_can';
		break;
	case 'supermoderators':
		$l_title = $lang['Super_Moderators'];
		$l_title_explain = $lang['Super_Moderators_explain'];
		$l_can = '_can';
		break;
	case 'administrators':
		$l_title = $lang['Administrators'];
		$l_title_explain = $lang['Administrators_explain'];
		$l_can = '_can_admin';
		break;
}

//
// Brief explanation of how things work when updating ...
//
// Granting someone any admin permissions grants them permissions
// to all other options, e.g. Moderator and Forums across the board.
// This is done via the acl class
//
if ( isset($_POST['update']) )
{
	$auth_admin = new auth_admin();

	switch ( $_POST['type'] )
	{
		case 'user':
			$set = 'acl_set_user';
			break;

		case 'group':
			$set = 'acl_set_group';
			break;
	}

	foreach ( $_POST['entries'] as $id )
	{
		$auth_admin->$set($forum_id, $id, $_POST['option']);
	}

	message_die(MESSAGE, 'Permissions updated successfully');
}
else if ( isset($_POST['delete']) )
{
	$auth_admin = new auth_admin();

	switch ( $_POST['type'] )
	{
		case 'user':
			$set = 'acl_delete_user';
			break;

		case 'group':
			$set = 'acl_delete_group';
			break;
	}

	$option_ids = false;
	if ( !empty($_POST['option']) )
	{
		$sql = "SELECT auth_option_id
			FROM " . ACL_OPTIONS_TABLE . "
			WHERE auth_value LIKE '" . $_POST['option'] . "_%'";
		$result = $db->sql_query($sql);

		if ( $row = $db->sql_fetchrow($result) )
		{
			$option_ids = array();
			do
			{
				$option_ids[] = $row['auth_option_id'];
			}
			while( $row = $db->sql_fetchrow($result) );
		}
		$db->sql_freeresult($result);
	}

	foreach ( $_POST['entries'] as $id )
	{
		$auth_admin->$set($forum_id, $id, $option_ids);
	}

	message_die(MESSAGE, 'Permissions updated successfully');
}

//
// Get required information, either all forums if
// no id was specified or just the requsted if it
// was
//
if ( !empty($forum_id) || $mode == 'administrators' || $mode == 'supermoderators' )
{
	//
	// Clear some vars, grab some info if relevant ...
	//
	$s_hidden_fields = '';
	if ( !empty($forum_id) )
	{
		$sql = "SELECT forum_name
			FROM " . FORUMS_TABLE . "
			WHERE forum_id = $forum_id";
		$result = $db->sql_query($sql);

		$forum_info = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$l_title .= ' : <i>' . $forum_info['forum_name'] . '</i>';
	}

	//
	// Generate header
	//
	page_header($l_title);

?>

<h1><?php echo $l_title; ?></h1>

<p><?php echo $l_title_explain; ?></p>

<?php

	switch ( $mode )
	{
		case 'forums':
			$type_sql = 'f';
			$forum_sql = "AND a.forum_id = $forum_id";
			break;

		case 'moderators':
			$type_sql = 'm';
			$forum_sql = "AND a.forum_id = $forum_id";
			break;

		case 'supermoderators':
			$type_sql = 'm';
			$forum_sql = '';
			break;

		case 'administrators':
			$type_sql = 'a';
			$forum_sql = '';
			break;
	}

	$sql = "SELECT group_id, group_name
		FROM " . GROUPS_TABLE . "
		ORDER BY group_name";
	$result = $db->sql_query($sql);

	$group_list = '';
	while ( $row = $db->sql_fetchrow($result) )
	{
		$group_list .= '<option value="' . $row['group_id'] . '">' . ( ( !empty($lang[$row['group_name']]) ) ? $lang[$row['group_name']] : $row['group_name'] ) . '</option>';
	}
	$db->sql_freeresult($result);

	if ( empty($_POST['advanced']) || empty($_POST['entries']) )
	{

?>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td align="center"><h1><?php echo $lang['Users']; ?></h1></td>
		<td align="center"><h1><?php echo $lang['Groups']; ?></h1></td>
	</tr>
	<tr>

		<td><form method="post" action="<?php echo "admin_permissions.$phpEx$SID&amp;mode=$mode"; ?>"><table width="90%" class="bg" cellspacing="1" cellpadding="4" border="0" align="center">
<?php

		$sql = "SELECT DISTINCT u.user_id, u.username
			FROM " . USERS_TABLE . " u, " . ACL_USERS_TABLE . " a, " . ACL_OPTIONS_TABLE . " o
			WHERE o.auth_value LIKE '" . $type_sql . "_%'
				AND a.auth_option_id = o.auth_option_id
				$forum_sql
				AND u.user_id = a.user_id
			ORDER BY u.username, u.user_regdate ASC";
		$result = $db->sql_query($sql);

		$users = '';
		while ( $row = $db->sql_fetchrow($result) )
		{
			$users .= '<option value="' . $row['user_id'] . '">' . $row['username'] . '</option>';
		}
		$db->sql_freeresult($result);

?>
			<tr>
				<th><?php echo $lang['Manage_users']; ?></th>
			</tr>
			<tr>
				<td class="row1" align="center"><select style="width:280px" name="entries[]" multiple="multiple" size="5"><?php echo $users; ?></select></td>
			</tr>
			<tr>
				<td class="cat" align="center"><input class="liteoption" type="submit" name="delete" value="<?php echo $lang['Remove_selected']; ?>" /> &nbsp; <input class="liteoption" type="submit" name="advanced" value="<?php echo $lang['Advanced']; ?>" /><input type="hidden" name="type" value="user" /><input type="hidden" name="f" value="<?php echo $forum_id; ?>" /><input type="hidden" name="option" value="<?php echo $type_sql; ?>" /></td>
			</tr>
		</table></form></td>

		<td align="center"><form method="post" name="admingroups" action="<?php echo "admin_permissions.$phpEx$SID&amp;mode=$mode"; ?>"><table width="90%" class="bg" cellspacing="1" cellpadding="4" border="0" align="center">
<?php

		$sql = "SELECT DISTINCT g.group_id, g.group_name
			FROM " . GROUPS_TABLE . " g, " . ACL_GROUPS_TABLE . " a, " . ACL_OPTIONS_TABLE . " o
			WHERE o.auth_value LIKE '" . $type_sql . "_%'
				$forum_sql
				AND a.auth_option_id = o.auth_option_id
				AND g.group_id = a.group_id
			ORDER BY g.group_name ASC";
		$result = $db->sql_query($sql);

		$groups = '';
		while ( $row = $db->sql_fetchrow($result) )
		{
			$groups .= '<option value="' . $row['group_id'] . '">' . ( ( !empty($lang[$row['group_name']]) ) ? $lang[$row['group_name']] : $row['group_name'] ) . '</option>';
		}
		$db->sql_freeresult($result);

?>
		<tr>
			<th><?php echo $lang['Manage_groups']; ?></th>
		</tr>
		<tr>
			<td class="row1" align="center"><select style="width:280px" name="entries[]" multiple="multiple" size="5"><?php echo $groups; ?></select></td>
		</tr>
		<tr>
			<td class="cat" align="center"><input class="liteoption" type="submit" name="delete" value="<?php echo $lang['Remove_selected']; ?>" /> &nbsp; <input class="liteoption" type="submit" name="advanced" value="<?php echo $lang['Advanced']; ?>" /><input type="hidden" name="type" value="group" /><input type="hidden" name="f" value="<?php echo $forum_id; ?>" /><input type="hidden" name="option" value="<?php echo $type_sql; ?>" /></td>
		</tr>
	</table></form></td>

	</tr>
	<tr>

		<td><form method="post" action="<?php echo "admin_permissions.$phpEx$SID&amp;mode=$mode"; ?>"><table class="bg" width="90%" cellspacing="1" cellpadding="4" border="0" align="center">
			<tr>
				<th><?php echo $lang['Add_users']; ?></th>
			</tr>
			<tr>
				<td class="row1" align="center"><textarea cols="40" rows="4" name="entries"></textarea></td>
			</tr>
			<tr>
				<td class="cat" align="center"> <input type="submit" name="add" value="<?php echo $lang['Submit']; ?>" class="mainoption" />&nbsp; <input type="reset" value="<?php echo $lang['Reset']; ?>" class="liteoption" />&nbsp; <input type="submit" name="usersubmit" value="<?php echo $lang['Find_username']; ?>" class="liteoption" onClick="window.open('<?php echo "../search.$phpEx$SID"; ?>&amp;mode=searchuser&amp;form=2&amp;field=entries', '_phpbbsearch', 'HEIGHT=500,resizable=yes,scrollbars=yes,WIDTH=650');return false;" /><input type="hidden" name="type" value="user" /><input type="hidden" name="advanced" value="1" /><input type="hidden" name="new" value="1" /><input type="hidden" name="f" value="<?php echo $forum_id; ?>" /></td>
			</tr>
		</table></form></td>

		<td><form method="post" action="<?php echo "admin_permissions.$phpEx$SID&amp;mode=$mode"; ?>"><table width="90%" class="bg" cellspacing="1" cellpadding="4" border="0" align="center">
			<tr>
				<th><?php echo $lang['Add_groups']; ?></th>
			</tr>
			<tr>
				<td class="row1" align="center"><select name="entries[]" multiple="multiple" size="4"><?php echo $group_list; ?></select></td>
			</tr>
			<tr>
				<td class="cat" align="center"> <input type="submit" name="add" value="<?php echo $lang['Submit']; ?>" class="mainoption" />&nbsp; <input type="reset" value="<?php echo $lang['Reset']; ?>" class="liteoption" /><input type="hidden" name="type" value="group" /><input type="hidden" name="advanced" value="1" /><input type="hidden" name="new" value="1" /><input type="hidden" name="f" value="<?php echo $forum_id; ?>" /></td>
			</tr>
		</table></form></td>

	</tr>
</table>

<?php

	}
	else
	{

		// Founder only operations ... these operations can
		// only be altered by someone with founder status
		$founder_sql = ( !$userdata['user_founder'] ) ? ' AND founder_only <> 1' : '';

		$sql = "SELECT auth_option_id, auth_value
			FROM " . ACL_OPTIONS_TABLE . "
			WHERE auth_value LIKE '" . $type_sql . "_%'
				AND auth_value <> '" . $type_sql . "_'
				$founder_sql";
		$result = $db->sql_query($sql);

		$auth_options = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$auth_options[] = $row;
		}
		$db->sql_freeresult($result);

		if ( $_POST['type'] == 'user' && !empty($_POST['new']) )
		{
			$_POST['entries'] = explode("\n", $_POST['entries']);
		}

		$where_sql = '';
		foreach ( $_POST['entries'] as $value )
		{
			$where_sql .= ( ( $where_sql != '' ) ? ', ' : '' ) . ( ( $_POST['type'] == 'user' && !empty($_POST['new']) ) ? '\'' . $value . '\'' : intval($value) );
		}

		switch ( $_POST['type'] )
		{
			case 'group':
				$l_type = 'Group';

				$sql = ( empty($_POST['new']) ) ? "SELECT g.group_id AS id, g.group_name AS name, o.auth_value, a.auth_allow_deny FROM " . GROUPS_TABLE . " g, " . ACL_GROUPS_TABLE . " a, " . ACL_OPTIONS_TABLE . " o WHERE o.auth_value LIKE '" . $type_sql . "_%' AND a.auth_option_id = o.auth_option_id $forum_sql AND g.group_id = a.group_id AND g.group_id IN ($where_sql) ORDER BY g.group_name ASC" : "SELECT group_id AS id, group_name AS name FROM " . GROUPS_TABLE . " WHERE group_id IN ($where_sql) ORDER BY group_name ASC";
				break;

			case 'user':
				$l_type = 'User';

				$sql = ( empty($_POST['new']) ) ? "SELECT u.user_id AS id, u.username AS name, u.user_founder, o.auth_value, a.auth_allow_deny FROM " . USERS_TABLE . " u, " . ACL_USERS_TABLE . " a, " . ACL_OPTIONS_TABLE . " o WHERE o.auth_value LIKE '" . $type_sql . "_%' AND a.auth_option_id = o.auth_option_id $forum_sql AND u.user_id = a.user_id AND u.user_id IN ($where_sql) ORDER BY u.username, u.user_regdate ASC" : "SELECT user_id AS id, username AS name, user_founder FROM " . USERS_TABLE . " WHERE username IN ($where_sql) ORDER BY username, user_regdate ASC";
				break;
		}

		$result = $db->sql_query($sql);

		$ug = '';;
		$ug_hidden = '';
		$auth = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$ug_test = ( !empty($lang[$row['name']]) ) ? $lang[$row['name']] : $row['name'];
			$ug .= ( !strstr($ug, $ug_test) ) ? $ug_test . "\n" : '';

			$ug_test = '<input type="hidden" name="entries[]" value="' . $row['id'] . '" />';
			$ug_hidden .= ( !strstr($ug_hidden, $ug_test) ) ? $ug_test : '';

			$auth[$row['auth_value']] = ( isset($auth_group[$row['auth_value']]) ) ?  min($auth_group[$row['auth_value']], $row['auth_allow_deny']) : $row['auth_allow_deny'];
		}
		$db->sql_freeresult($result);

?>

<p><?php echo $lang['Permissions_extra_explain']; ?></p>

<p><?php echo $lang['Permissions_extra2_explain']; ?></p>

<form method="post" action="<?php echo "admin_permissions.$phpEx$SID&amp;mode=$mode"; ?>"><table class="bg" cellspacing="1" cellpadding="4" border="0" align="center">
	<tr>
		<th>&nbsp;<?php echo $lang[$l_type . $l_can]; ?>&nbsp;</th>
		<th>&nbsp;<?php echo $lang['Permit']; ?>&nbsp;</th>
		<th>&nbsp;<?php echo $lang['Allow']; ?>&nbsp;</th>
		<th>&nbsp;<?php echo $lang['Deny']; ?>&nbsp;</th>
		<th>&nbsp;<?php echo $lang['Prevent']; ?>&nbsp;</th>
	</tr>
<?php

		for($i = 0; $i < sizeof($auth_options); $i++)
		{
			$row_class = ( $row_class == 'row1' ) ? 'row2' : 'row1';

			$l_can_cell = ( !empty($lang['acl_' . $auth_options[$i]['auth_value']]) ) ? $lang['acl_' . $auth_options[$i]['auth_value']] : $auth_options[$i]['auth_value'];

			$permit_type = ( $auth[$auth_options[$i]['auth_value']] == ACL_PERMIT ) ? ' checked="checked"' : '';
			$allow_type = ( $auth[$auth_options[$i]['auth_value']] == ACL_ALLOW ) ? ' checked="checked"' : '';
			$deny_type = ( $auth[$auth_options[$i]['auth_value']] == ACL_DENY ) ? ' checked="checked"' : '';
			$prevent_type = ( $auth[$auth_options[$i]['auth_value']] == ACL_PREVENT ) ? ' checked="checked"' : '';

?>
	<tr>
		<td class="<?php echo $row_class; ?>"><?php echo $l_can_cell; ?></td>
		<td class="<?php echo $row_class; ?>" align="center"><input type="radio" name="option[<?php echo $auth_options[$i]['auth_option_id']; ?>]" value="<?php echo ACL_PERMIT; ?>"<?php echo $permit_type; ?> /></td>
		<td class="<?php echo $row_class; ?>" align="center"><input type="radio" name="option[<?php echo $auth_options[$i]['auth_option_id']; ?>]" value="<?php echo ACL_ALLOW; ?>"<?php echo $allow_type; ?> /></td>
		<td class="<?php echo $row_class; ?>" align="center"><input type="radio" name="option[<?php echo $auth_options[$i]['auth_option_id']; ?>]" value="<?php echo ACL_DENY; ?>"<?php echo $deny_type; ?> /></td>
		<td class="<?php echo $row_class; ?>" align="center"><input type="radio" name="option[<?php echo $auth_options[$i]['auth_option_id']; ?>]" value="<?php echo ACL_PREVENT; ?>"<?php echo $prevent_type; ?> /></td>
	</tr>
<?php

		}

?>
	<tr>
		<th colspan="5"><?php echo $lang['Applies_to_' . $l_type]; ?></th>
	</tr>
	<tr>
		<td class="row1" colspan="5" align="center"><textarea cols="40" rows="3"><?php echo trim($ug); ?></textarea></td>
	</tr>
	<tr>
		<td class="cat" colspan="5" align="center"><input class="mainoption" type="submit" name="update" value="<?php echo $lang['Update']; ?>" />&nbsp;&nbsp;<input class="liteoption" type="submit" name="cancel" value="<?php echo $lang['Cancel']; ?>" /><input type="hidden" name="f" value="<?php echo $forum_id; ?>" /><input type="hidden" name="type" value="<?php echo $_POST['type']; ?>" /><?php echo $ug_hidden; ?></td>
	</tr>
</table></form>

<?php

	}

}
else
{

	$select_list = make_forum_select('f');

	page_header($l_title);

?>

<h1><?php echo $l_title; ?></h1>

<p><?php echo $l_title_explain ?></p>

<form method="post" action="<?php echo "admin_permissions.$phpEx$SID&amp;mode=$mode"; ?>"><table class="bg" cellspacing="1" cellpadding="4" border="0" align="center">
	<tr>
		<th align="center"><?php echo $lang['Select_a_Forum']; ?></th>
	</tr>
	<tr>
		<td class="row1" align="center">&nbsp;<?php echo $select_list; ?> &nbsp;<input type="submit" value="<?php echo $lang['Look_up_Forum']; ?>" class="mainoption" />&nbsp;</td>
	</tr>
</table></form>

<?php

}

page_footer();

?>