<?php
/**
*
* This file is part of the phpBB Forum Software package.
*
* @copyright (c) phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
* For full copyright and license information, please see
* the docs/CREDITS.txt file.
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'ABOUT_USER'			=> 'Profile',
	'ACTIVE_IN_FORUM'		=> 'Most active forum',
	'ACTIVE_IN_TOPIC'		=> 'Most active topic',
	'ADD_FOE'				=> 'Add foe',
	'ADD_FRIEND'			=> 'Add friend',
	'AFTER'					=> 'After',

	'ALL'					=> 'All',

	'BEFORE'				=> 'Before',

	'CC_SENDER'				=> 'Send a copy of this email to yourself.',
	'CONTACT_ADMIN'			=> 'Contact a Board Administrator',

	'DEST_LANG'				=> 'Language',
	'DEST_LANG_EXPLAIN'		=> 'Select an appropriate language (if available) for the recipient of this message.',

	'EDIT_PROFILE'			=> 'Edit profile',

	'EMAIL_BODY_EXPLAIN'	=> 'This message will be sent as plain text, do not include any HTML or BBCode. The return address for this message will be set to your email address.',
	'EMAIL_DISABLED'		=> 'Sorry but all email related functions have been disabled.',
	'EMAIL_SENT'			=> 'The email has been sent.',
	'EMAIL_TOPIC_EXPLAIN'	=> 'This message will be sent as plain text, do not include any HTML or BBCode. Please note that the topic information is already included in the message. The return address for this message will be set to your email address.',
	'EMPTY_ADDRESS_EMAIL'	=> 'You must provide a valid email address for the recipient.',
	'EMPTY_MESSAGE_EMAIL'	=> 'You must enter a message to be emailed.',
	'EMPTY_MESSAGE_IM'		=> 'You must enter a message to be send.',
	'EMPTY_NAME_EMAIL'		=> 'You must enter the real name of the recipient.',
	'EMPTY_SENDER_EMAIL'	=> 'You must provide a valid email address.',
	'EMPTY_SENDER_NAME'		=> 'You must provide a name.',
	'EMPTY_SUBJECT_EMAIL'	=> 'You must specify a subject for the email.',
	'EQUAL_TO'				=> 'Equal to',

	'FIND_USERNAME_EXPLAIN'	=> 'Use this form to search for specific members. You do not need to fill out all fields. To match partial data use * as a wildcard. When entering dates use the format <kbd>YYYY-MM-DD</kbd>, e.g. <samp>2004-02-29</samp>. Use the mark checkboxes to select one or more usernames (several usernames may be accepted depending on the form itself) and click the Select Marked button to return to the previous form.',
	'FLOOD_EMAIL_LIMIT'		=> 'You cannot send another email at this time. Please try again later.',

	'GROUP_LEADER'			=> 'Group leader',

	'HIDE_MEMBER_SEARCH'	=> 'Hide member search',

	'IM_ADD_CONTACT'		=> 'Add Contact',
	'IM_DOWNLOAD_APP'		=> 'Download application',
	'IM_MESSAGE'			=> 'Your message',
	'IM_NAME'				=> 'Your Name',
	'IM_NO_DATA'			=> 'There is no suitable contact information for this user.',
	'IM_RECIPIENT'			=> 'Recipient',
	'IM_SEND'				=> 'Send message',
	'IM_SEND_MESSAGE'		=> 'Send message',
	'IM_USER'				=> 'Send an instant message',

	'LAST_ACTIVE'				=> 'Last active',
	'LESS_THAN'					=> 'Less than',
	'LIST_USERS'				=> array(
		1	=> '%d user',
		2	=> '%d users',
	),
	'LOGIN_EXPLAIN_TEAM'		=> 'The board requires you to be registered and logged in to view the team listing.',
	'LOGIN_EXPLAIN_MEMBERLIST'	=> 'The board requires you to be registered and logged in to access the memberlist.',
	'LOGIN_EXPLAIN_SEARCHUSER'	=> 'The board requires you to be registered and logged in to search users.',
	'LOGIN_EXPLAIN_VIEWPROFILE'	=> 'The board requires you to be registered and logged in to view profiles.',

	'MANAGE_GROUP'			=> 'Manage Group',
	'MORE_THAN'				=> 'More than',

	'NO_CONTACT_FORM'		=> 'The board administrator contact form has been disabled.',
	'NO_CONTACT_PAGE'		=> 'The board administrator contact page has been disabled.',
	'NO_EMAIL'				=> 'You are not permitted to send email to this user.',
	'NO_VIEW_USERS'			=> 'You are not authorised to view the member list or profiles.',

	'ORDER'					=> 'Order',
	'OTHER'					=> 'Other',

	'POST_IP'				=> 'Posted from IP/domain',

	'REAL_NAME'				=> 'Recipient name',
	'RECIPIENT'				=> 'Recipient',
	'REMOVE_FOE'			=> 'Remove foe',
	'REMOVE_FRIEND'			=> 'Remove friend',

	'SELECT_MARKED'			=> 'Select marked',
	'SELECT_SORT_METHOD'	=> 'Select sort method',
	'SENDER_EMAIL_ADDRESS'	=> 'Your email address',
	'SENDER_NAME'			=> 'Your name',
	'SEND_ICQ_MESSAGE'		=> 'Send ICQ message',
	'SEND_IM'				=> 'Instant messaging',
	'SEND_MESSAGE'			=> 'Message',
	'SEND_YIM_MESSAGE'		=> 'Send YIM message',
	'SORT_EMAIL'			=> 'Email',
	'SORT_LAST_ACTIVE'		=> 'Last active',
	'SORT_POST_COUNT'		=> 'Post count',

	'USERNAME_BEGINS_WITH'	=> 'Username begins with',
	'USER_ADMIN'			=> 'Administer user',
	'USER_BAN'				=> 'Banning',
	'USER_FORUM'			=> 'User statistics',
	'USER_LAST_REMINDED'	=> array(
		0		=> 'No reminder sent at this time',
		1		=> '%1$d reminder sent<br />» %2$s',
		2		=> '%1$d reminder sent<br />» %2$s',
	),
	'USER_ONLINE'			=> 'Online',
	'USER_PRESENCE'			=> 'Board presence',
	'USERS_PER_PAGE'		=> 'Users per page',

	'VIEWING_PROFILE'		=> 'Viewing profile - %s',
	'VIEW_FACEBOOK_PROFILE'	=> 'View Facebook Profile',
	'VIEW_SKYPE_PROFILE'	=> 'View Skype Profile',
	'VIEW_TWITTER_PROFILE'	=> 'View Twitter Profile',
	'VIEW_YOUTUBE_PROFILE'	=> 'View YouTube Profile',
));
