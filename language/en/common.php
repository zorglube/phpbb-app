<?php
/** 
*
* common [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'ENCODING'		=> 'iso-8859-1',
	'DIRECTION'		=> 'ltr',
	'LEFT'			=> 'left',
	'RIGHT'			=> 'right',
	'DATE_FORMAT'	=> '|d M Y|',


	'1_DAY'					=> '1 Day',
	'1_MONTH'				=> '1 Month',
	'1_YEAR'				=> '1 Year',
	'2_WEEKS'				=> '2 Weeks',
	'3_MONTHS'				=> '3 Months',
	'6_MONTHS'				=> '6 Months',
	'7_DAYS'				=> '7 Days',

	'ACCOUNT_ALREADY_ACTIVATED'		=> 'Your account is already activated',
	'ACCOUNT_NOT_ACTIVATED'			=> 'Your account has not been activated yet',
	'ACP'							=> 'Administration Control Panel',
	'ACTIVE_ERROR'					=> 'You have specified an inactive username. Please activate your account and try again. If you continue to have problems please contact a board administrator.',
	'ADMINISTRATOR'					=> 'Administrator',
	'ADMINISTRATORS'				=> 'Administrators',
	'ALLOWED'						=> 'Allowed',
	'ALL_FORUMS'					=> 'All Forums',
	'ALL_MESSAGES'					=> 'All Messages',
	'ALL_POSTS'						=> 'All Posts',
	'ALL_TIMES'						=> 'All times are %1$s %2$s',
	'ALL_TOPICS'					=> 'All Topics',
	'AND'							=> 'And',
	'ARE_WATCHING_FORUM'			=> 'You have subscribed to receive updates on this forum',
	'ARE_WATCHING_TOPIC'			=> 'You have subscribed to receive updates on this topic.',
	'ASCENDING'						=> 'Ascending',
	'ATTACHMENTS'					=> 'Attachments',
	'AUTHOR'						=> 'Author',
	'AVATAR_DISALLOWED_EXTENSION'	=> 'The Extension %s is not allowed',
	'AVATAR_EMPTY_REMOTE_DATA'		=> 'Avatar could not be uploaded, please try uploading the file manually.',
	'AVATAR_INVALID_FILENAME'		=> '%s is an invalid filename',
	'AVATAR_NOT_UPLOADED'			=> 'Avatar could not be uploaded.',
	'AVATAR_NO_SIZE'				=> 'Could not obtain width or height of linked avatar, please enter them manually.',
	'AVATAR_PHP_SIZE_NA'			=> 'The avatar is too huge in filesize.<br />Could not determine the maximum size defined by PHP in php.ini.',
	'AVATAR_PHP_SIZE_OVERRUN'		=> 'The avatar is too huge in filesize, maximum upload size is %d MB.<br />Please note this is set in php.ini and cannot be overriden.',
	'AVATAR_URL_INVALID'			=> 'The URL you specified is invalid.',
	'AVATAR_WRONG_FILESIZE'			=> 'The avatar must be between 0 and %1d %2s.',
	'AVATAR_WRONG_SIZE'				=> 'The avatar must be at least %1$d pixels wide, %2$d pixels high and at most %3$d pixels wide and %4$d pixels high.',

	'BACK_TO_TOP'			=> 'Top',
	'BBCODE_GUIDE'			=> 'BBCode Guide',
	'BCC'					=> 'Bcc',
	'BIRTHDAYS'				=> 'Birthdays',
	'BOARD_BAN_PERM'		=> 'You have been <b>permanently</b> banned from this board.<br /><br />Please contact the %2$sBoard Administrator%3$s for more information.',
	'BOARD_BAN_REASON'		=> 'Reason given for ban: <b>%s</b>',
	'BOARD_BAN_TIME'		=> 'You have been banned from this board until <b>%1$s</b>.<br /><br />Please contact the %2$sBoard Administrator%3$s for more information.',
	'BOARD_DISABLE'			=> 'Sorry but this board is currently unavailable',
	'BOARD_UNAVAILABLE'		=> 'Sorry but the board is temporarily unavailable, please try again in a few minutes',
	'BROWSING_FORUM_GUEST'	=> 'Users browsing this forum: %1$s and %2$d guest',
	'BROWSING_FORUM_GUESTS'	=> 'Users browsing this forum: %1$s and %2$d guests',
	'BYTES'					=> 'Bytes',
	'BY'						=> 'By',

	'CANCEL'				=> 'Cancel',
	'CHANGE'				=> 'Change',
	'CLICK_VIEW_PRIVMSG'	=> 'Click %sHere%s to visit your Inbox',
	'CONFIRM'				=> 'Confirm',
	'CONFIRM_CODE'			=> 'Confirmation code',
	'CONFIRM_CODE_EXPLAIN'	=> 'Enter the code exactly as you see it in the image, it is case sensitive, zero has a diagonal line through it.',
	'CONFIRM_CODE_WRONG'	=> 'The confirmation code you entered was incorrect.',
	'CONGRATULATIONS'		=> 'Congratulations to',
	'CONNECTION_FAILED'		=> 'Connection failed',
	'CONNECTION_SUCCESS'	=> 'Connection was successful!',
	'COOKIES_DELETED'		=> 'All Board Cookies successfully deleted.',
	'CURRENT_TIME'			=> 'The time is %s',

	'DAY'					=> 'Day',
	'DAYS'					=> 'Days',
	'DELETE'				=> 'Delete',
	'DELETE_ALL'			=> 'Delete All',
	'DELETE_COOKIES'		=> 'Delete all board cookies',
	'DELETE_MARKED'			=> 'Delete Marked',
	'DELETE_POST'			=> 'Delete Post',
	'DELIMITER'				=> 'Delimiter',
	'DESCENDING'			=> 'Descending',
	'DISABLED'				=> 'Disabled',
	'DISPLAY'				=> 'Display',
	'DISPLAY_GUESTS'		=> 'Display Guests',
	'DISPLAY_MESSAGES'		=> 'Display messages from previous',
	'DISPLAY_POSTS'			=> 'Display posts from previous',
	'DISPLAY_TOPICS'		=> 'Display topics from previous',
	'DOWNLOADED'			=> 'Downloaded',
	'DOWNLOADING_FILE'		=> 'Downloading file',
	'DOWNLOAD_COUNT'		=> '%d Time',
	'DOWNLOAD_COUNTS'		=> '%d Times',
	'DOWNLOAD_NONE'			=> '0 Times',

	'EDIT_POST'							=> 'Edit Post',
	'EMAIL'								=> 'Email',
	'EMAIL_ADDRESS'						=> 'Email address',
	'EMPTY_SUBJECT'						=> 'You must specify a subject when posting a new topic.',
	'ENABLED'							=> 'Enabled',
	'ENCLOSURE'							=> 'Enclosure',
	'ERR_CONNECTING_SERVER'				=> 'Error connecting to the server',
	'EXTENSION'							=> 'Extension',
	'EXTENSION_DISABLED_AFTER_POSTING'	=> 'The extension <b>%s</b> has been deactivated and can no longer be displayed',

	'FAQ'					=> 'FAQ',
	'FAQ_EXPLAIN'			=> 'Frequently Asked Questions',
	'FILENAME'				=> 'Filename',
	'FILESIZE'				=> 'Filesize',
	'FILE_COMMENT'			=> 'File comment',
	'FILE_NOT_FOUND'		=> 'The requested file could not be found',
	'FIND_USERNAME'			=> 'Find a member',
	'FOLDER'				=> 'Folder',
	'FORGOT_PASS'			=> 'I forgot my password',
	'FORUM'					=> 'Forum',
	'FORUMS'				=> 'Forums',
	'FORUMS_MARKED'			=> 'All forums have been marked read',
	'FORUM_INDEX'			=> 'Board Index',
	'FORUM_LOCATION'		=> 'Forum Location',
	'FORUM_LOCKED'			=> 'Forum Locked',
	'FORUM_RULES'			=> 'Forum Rules',
	'FORUM_RULES_LINK'		=> 'Please click to view the forum rules',
	'FROM'					=> 'from',

	'FTP_HOST'					=> 'FTP Host',
	'FTP_HOST_EXPLAIN'			=> 'FTP Server used to connect your site',
	'FTP_PASSWORD'				=> 'FTP Password',
	'FTP_PASSWORD_EXPLAIN'		=> 'Password for your FTP Username',
	'FTP_PORT'					=> 'FTP Port',
	'FTP_PORT_EXPLAIN'			=> 'Port used to connect to your server',
	'FTP_ROOT_PATH'				=> 'Path to phpBB',
	'FTP_ROOT_PATH_EXPLAIN'		=> 'Path from the root to your phpBB board',
	'FTP_TIMEOUT'				=> 'FTP Timeout',
	'FTP_TIMEOUT_EXPLAIN'		=> 'The amount of time, in seconds, that the system will wait for a reply from your server',
	'FTP_USERNAME'				=> 'FTP Username',
	'FTP_USERNAME_EXPLAIN'		=> 'Username used to connect to your server',

	'GO'						=> 'Go',
	'GOTO_PAGE'					=> 'Goto page',
	'GROUP'						=> 'Group',
	'GROUPS'					=> 'Groups',
	'GROUP_ERR_DESC_LONG'		=> 'Group description too long.',
	'GROUP_ERR_TYPE'			=> 'Inappropriate group type specified.',
	'GROUP_ERR_USERNAME'		=> 'No group name specified.',
	'GROUP_ERR_USER_LONG'		=> 'Group name too long.',
	'GUEST'						=> 'Guest',
	'GUEST_USERS_ONLINE'		=> 'There are %d Guest users online',
	'GUEST_USERS_TOTAL'			=> '%d Guests',
	'GUEST_USERS_ZERO_ONLINE'	=> 'There are 0 Guest users online',
	'GUEST_USERS_ZERO_TOTAL'	=> '0 Guests',
	'GUEST_USER_ONLINE'			=> 'There is %d Guest user online',
	'GUEST_USER_TOTAL'			=> '%d Guest',
	'G_ADMINISTRATORS'			=> 'Administrators',
	'G_BOTS'					=> 'Bots',
	'G_GUESTS'					=> 'Guests',
	'G_INACTIVE'				=> 'Unapproved Users',
	'G_INACTIVE_COPPA'			=> 'Unapproved COPPA Users',
	'G_REGISTERED'				=> 'Registered Users',
	'G_REGISTERED_COPPA'		=> 'Registered COPPA Users',
	'G_SUPER_MODERATORS'		=> 'Super Moderators',

	'HIDDEN_USERS_ONLINE'		=> '%d Hidden users online',
	'HIDDEN_USERS_TOTAL'		=> '%d Hidden and ',
	'HIDDEN_USERS_ZERO_ONLINE'	=> '0 Hidden users online',
	'HIDDEN_USERS_ZERO_TOTAL'	=> '0 Hidden and ',
	'HIDDEN_USER_ONLINE'		=> '%d Hidden user online',
	'HIDDEN_USER_TOTAL'			=> '%d Hidden and ',
	'HIDE_GUESTS'				=> 'Hide Guests',
	'HIDE_ME'					=> 'Hide my online status this session',
	'HOURS'						=> 'Hours',
	'HOME'						=> 'Home',

	'ICQ_STATUS'			=> 'ICQ Status',
	'IF'					=> 'If',
	'IN'					=> 'in',
	'INDEX'					=> 'Index page',
	'INFORMATION'			=> 'Information',
	'INTERESTS'				=> 'Interests',
	'INVALID_EMAIL_LOG'		=> '<b>%s</b> possibly an invalid email address?',
	'IP'					=> 'IP',

	'JOINED'				=> 'Joined',
	'JUMP_PAGE'				=> 'Enter the page number you wish to goto',
	'JUMP_TO'				=> 'Jump to',
	'JUMP_TO_PAGE'			=> 'Click to jump to page...',

	'KB'				=> 'KB',

	'LAST_POST'				=> 'Last Post',
	'LAST_UPDATED'			=> 'Last Updated',
	'LDAP_DN'				=> 'LDAP base dn',
	'LDAP_DN_EXPLAIN'		=> 'This is the Distinguished Name, locating the user information, e.g. o=My Company,c=US',
	'LDAP_SERVER'			=> 'LDAP server name',
	'LDAP_SERVER_EXPLAIN'	=> 'If using LDAP this is the name or IP address of the server.',
	'LDAP_UID'				=> 'LDAP uid',
	'LDAP_UID_EXPLAIN'		=> 'This is the key under which to search for a given login identity, e.g. uid, sn, etc.',
	'LEGEND'				=> 'Legend',
	'LOCATION'				=> 'Location',
	'LOCK_POST'				=> 'Lock Post',
	'LOCK_POST_EXPLAIN'		=> 'Prevent editing',
	'LOCK_TOPIC'			=> 'Lock Topic',
	'LOGIN'					=> 'Login',
	'LOGIN_CHECK_PM'		=> 'Log in to check your private messages',
	'LOGIN_CONFIRMATION'	=> 'Confirmation of login',
	'LOGIN_CONFIRM_EXPLAIN'	=> 'To prevent brute forcing accounts the board administrator requires you to enter a confirmation code after a maximum amount of failed logins. The code is displayed in the image you should see below. If you are visually impaired or cannot otherwise read this code please contact the %sBoard Administrator%s.',
	'LOGIN_ERROR_ATTEMPTS'	=> 'You exceeded the maximum allowed number of login attempts. In addition to your username and password you now have to additionally confirm the image you see below.',
	'LOGIN_ERROR_PASSWORD'	=> 'You have specified an incorrect password. Please check your password and try again. If you continue to have problems please contact a board administrator.',
	'LOGIN_ERROR_USERNAME'	=> 'You have specified an incorrect username. Please check your username and try again. If you continue to have problems please contact a board administrator.',
	'LOGIN_FORUM'			=> 'To view or post in this forum you must enter a password.',
	'LOGIN_INFO'			=> 'In order to login you must be registered. Registering takes only a few seconds but gives you increased capabilies. The board administrator may also grant additional permissions to registered users. Before you login please ensure you are familiar with our terms of use and related policies. Please ensure you read any forum rules as you navigate around the board.',
	'LOGIN_VIEWFORUM'		=> 'The board administrator requires you to be registered and logged in to view this forum.',
	'LOGOUT'				=> 'Logout',
	'LOGOUT_USER'			=> 'Logout [ %s ]',
	'LOG_ADMIN_AUTH_FAIL'	=> '<b>Failed administration login attempt</b>',
	'LOG_ADMIN_AUTH_SUCCESS'=> '<b>Sucessful administration login</b>',
	'LOG_DELETE_POST'		=> '<b>Deleted post</b><br />&#187; %s',
	'LOG_DELETE_TOPIC'		=> '<b>Deleted topic</b><br />&#187; %s',
	'LOG_ME_IN'				=> 'Log me on automatically each visit',
	'LOG_USER_FEEDBACK'		=> '<b>Added user feedback</b><br />&#187; %s',
	'LOG_USER_GENERAL'		=> '%s',
	'LOG_USER_WARNING'		=> '<b>Added user warning</b><br />&#187;%s',
	'LOG_USER_WARNING_BODY'	=> '<b>The following warning was issued to this user</b><br />&#187;%s',

	'MARK'				=> 'Mark',
	'MARK_ALL'			=> 'Mark all',
	'MARK_FORUMS_READ'	=> 'Mark Forums Read',
	'MB'				=> 'MB',
	'MCP'				=> 'Moderator Control Panel',
	'MEMBERLIST'		=> 'Members',
	'MEMBERLIST_EXPLAIN'	=> 'View complete list of members',
	'MERGE_TOPIC'		=> 'Merge Topic',
	'MESSAGE'			=> 'Message',
	'MESSAGE_BODY'		=> 'Message body',
	'MINUTES'			=> 'Minutes',
	'MODERATE'			=> 'Moderate',
	'MODERATOR'			=> 'Moderator',
	'MODERATORS'		=> 'Moderators',
	'MONTH'				=> 'Month',
	'MOVE'				=> 'Move',

	'NA'				=> 'N/A',
	'NEWEST_USER'		=> 'Our newest member <b>%s%s%s</b>',
	'NEW_MESSAGE'		=> 'New Message',
	'NEW_MESSAGES'		=> 'New Messages',
	'NEW_PM'			=> '<b>%d</b> new message',
	'NEW_PMS'			=> '<b>%d</b> new messages',
	'NEW_POST'			=> 'New post',
	'NEW_POSTS'			=> 'New posts',
	'NEXT'				=> 'Next',
	'NO'				=> 'No',
	'NONE'				=> 'None',
	'NOT_WATCHING_FORUM'=> 'You no subscribe to updates on this forum',
	'NOT_WATCHING_TOPIC'=> 'You are no longer subscribed to this topic.',
	'NO_AUTH_OPERATION'	=> 'You do not have the neccessary permissions to complete this operation.',
	'NO_BIRTHDAYS'		=> 'No birthdays today',
	'NO_FORUM'			=> 'The forum you selected does not exist',
	'NO_FORUMS'			=> 'This board has no forums',
	'NO_GROUP'			=> 'The requested usergroup does not exist.',
	'NO_MEMBERS'		=> 'No members found for this search criteria',
	'NO_MESSAGES'		=> 'No Messages',
	'NO_NEW_MESSAGES'	=> 'No new messages',
	'NO_NEW_PM'			=> '<b>0</b> new messages',
	'NO_NEW_POSTS'		=> 'No new posts',
	'NO_POSTS'			=> 'No Posts',
	'NO_TOPIC'			=> 'The requested topic does not exist.',
	'NO_TOPICS'			=> 'There are no topics or posts in this forum.',
	'NO_UNREAD_PM'		=> '<b>0</b> unread messages',
	'NO_USER'			=> 'The requested user does not exist.',
	'NO_USERS'			=> 'The requested users do not exist',

	'OCCUPATION'				=> 'Occupation',
	'OFFLINE'					=> 'Offline',
	'ONLINE'					=> 'Online',
	'ONLINE_BUDDIES'			=> 'Online Buddies',
	'ONLINE_USERS_TOTAL'		=> 'In total there are <b>%d</b> users online :: ',
	'ONLINE_USERS_ZERO_TOTAL'	=> 'In total there are <b>0</b> users online :: ',
	'ONLINE_USER_TOTAL'			=> 'In total there is <b>%d</b> user online :: ',
	'OPTIONS'					=> 'Options',

	'PAGE_OF'			=> 'Page <b>%1$d</b> of <b>%2$d</b>',
	'PASSWORD'			=> 'Password',
	'PM'				=> 'PM',
	'POSTING_MESSAGE'	=> 'Posting message in %s',
	'POST'				=> 'Post',
	'POST_ANNOUNCEMENT'	=> 'Announce',
	'POST_STICKY'		=> 'Sticky',
	'POSTED'			=> 'Posted',
	'POSTS'				=> 'Posts',
	'POST_BY_FOE'		=> 'This post was made by <b>%1$s</b> who is currently on your ignore list. To display this post click %2$sHERE%3$s.',
	'POST_DAY'			=> '%.2f posts per day',
	'POST_DETAILS'		=> 'Post Details',
	'POST_NEW_TOPIC'	=> 'Post new topic',
	'POST_PCT'			=> '%.2f%% of all posts',
	'POST_REPORTED'		=> 'Click to view reports',
	'POST_SUBJECT'		=> 'Post Subject',
	'POST_TIME'			=> 'Post time',
	'POST_UNAPPROVED'	=> 'Click to approve post',
	'PREVIEW'			=> 'Preview',
	'PREVIOUS'			=> 'Previous',
	'PRIVACY'			=> 'Privacy Policy',
	'PRIVATE_MESSAGE'	=> 'Private Message',
	'PRIVATE_MESSAGES'	=> 'Private Messages',
	'PRIVATE_MESSAGING'	=> 'Private Messaging',
	'PROFILE'			=> 'User Control Panel',

	'READING_FORUM'				=> 'Viewing topics in %s',
	'READING_GLOBAL_ANNOUNCE'	=> 'Reading global announcement',
	'READING_TOPIC'				=> 'Reading topic in %s',
	'READ_PROFILE'				=> 'Profile',
	'REASON'					=> 'Reason',
	'RECORD_ONLINE_USERS'		=> 'Most users ever online was <b>%1$s</b> on %2$s',
	'REDIRECTS'					=> 'Total redirects',
	'REGISTER'					=> 'Register',
	'REGISTERED_USERS'			=> 'Registered Users:',
	'REG_USERS_ONLINE'			=> 'There are %d Registered users and ',
	'REG_USERS_TOTAL'			=> '%d Registered, ',
	'REG_USERS_ZERO_ONLINE'		=> 'There are 0 Registered users and ',
	'REG_USERS_ZERO_TOTAL'		=> '0 Registered, ',
	'REG_USER_ONLINE'			=> 'There is %d Registered user and ',
	'REG_USER_TOTAL'			=> '%d Registered, ',
	'REMOVE'					=> 'Remove',
	'REMOVE_INSTALL'			=> 'Please delete, move or rename the install directory.',
	'REPLIES'					=> 'Replies',
	'REPLY_WITH_QUOTE'			=> 'Reply with quote',
	'REPLYING_GLOBAL_ANNOUNCE'	=> 'Replying to global announcement',
	'REPLYING_MESSAGE'			=> 'Replying to message in %s',
	'REPORT_BY'					=> 'Report by',
	'REPORT_POST'				=> 'Report this post',
	'REPORTING_POST'			=> 'Reporting post',
	'RESEND_ACTIVATION'			=> 'Resend activation email',
	'RESET'						=> 'Reset',
	'RETURN_INDEX'				=> 'Click %sHere%s to return to the index',
	'RETURN_FORUM'				=> 'Click %sHere%s to return to the forum',
	'RETURN_PAGE'				=> 'Click %sHere%s to return to the previous page',
	'RETURN_TOPIC'				=> 'Click %sHere%s to return to the topic',
	'RETURN_TO'					=> 'Return to',
	'RULES_ATTACH_CAN'			=> 'You <b>can</b> post attachments in this forum',
	'RULES_ATTACH_CANNOT'		=> 'You <b>cannot</b> post attachments in this forum',
	'RULES_DELETE_CAN'			=> 'You <b>can</b> delete your posts in this forum',
	'RULES_DELETE_CANNOT'		=> 'You <b>cannot</b> delete your posts in this forum',
	'RULES_DOWNLOAD_CAN'		=> 'You <b>can</b> download attachments in this forum',
	'RULES_DOWNLOAD_CANNOT'		=> 'You <b>cannot</b> download attachments in this forum',
	'RULES_EDIT_CAN'			=> 'You <b>can</b> edit your posts in this forum',
	'RULES_EDIT_CANNOT'			=> 'You <b>cannot</b> edit your posts in this forum',
	'RULES_LOCK_CAN'			=> 'You <b>can</b> lock your topics in this forum',
	'RULES_LOCK_CANNOT'			=> 'You <b>cannot</b> lock your topics in this forum',
	'RULES_POST_CAN'			=> 'You <b>can</b> post new topics in this forum',
	'RULES_POST_CANNOT'			=> 'You <b>cannot</b> post new topics in this forum',
	'RULES_REPLY_CAN'			=> 'You <b>can</b> reply to topics in this forum',
	'RULES_REPLY_CANNOT'		=> 'You <b>cannot</b> reply to topics in this forum',
	'RULES_VOTE_CAN'			=> 'You <b>can</b> vote in polls in this forum',
	'RULES_VOTE_CANNOT'			=> 'You <b>cannot</b> vote in polls in this forum',

	'SEARCH'					=> 'Search',
	'SEARCH_ADV'				=> 'Advanced Search',
	'SEARCH_ADV_EXPLAIN'		=> 'View the advanced search options',
	'SEARCH_KEYWORDS'			=> 'Enter search keywords',
	'SEARCHING_FORUMS'			=> 'Searching forums',
	'SELECT_DESTINATION_FORUM'	=> 'Please select a forum for destination',
	'SEARCH_ACTIVE_TOPICS'		=> 'View active topics',
	'SEARCH_FOR'				=> 'Search for',
	'SEARCH_NEW'				=> 'View new posts',
	'SEARCH_SELF'				=> 'View your posts',
	'SEARCH_UNANSWERED'			=> 'View unanswered posts',
	'SELECT'					=> 'Select',
	'SELECT_FORUM'				=> 'Select a forum',
	'SEND_EMAIL'				=> 'Email',
	'SEND_PRIVATE_MESSAGE'		=> 'Send private message',
	'SIGNATURE'					=> 'Signature',
	'SKIP'						=> 'Skip to content',
	'SORRY_AUTH_READ'			=> 'You are not authorized to read this forum',
	'SORT_BY'					=> 'Sort by',
	'SORT_JOINED'				=> 'Joined Date',
	'SORT_LOCATION'				=> 'Location',
	'SORT_RANK'					=> 'Rank',
	'SORT_TOPIC_TITLE'			=> 'Topic Title',
	'SORT_USERNAME'				=> 'Username',
	'SPLIT_TOPIC'				=> 'Split Topic',
	'SQL_ERROR_OCCURRED'		=> 'An sql error occurred while fetching this page. Please contact an administrator if this problem persist.',
	'STATISTICS'				=> 'Statistics',
	'START_WATCHING_FORUM'		=> 'Subscribe Forum',
	'START_WATCHING_TOPIC'		=> 'Subscribe Topic',
	'STOP_WATCHING_FORUM'		=> 'Unsubscribe Forum',
	'STOP_WATCHING_TOPIC'		=> 'Unsubscribe Topic',
	'SUBFORUM'					=> 'Subforum',
	'SUBFORUMS'					=> 'Subforums',
	'SUBJECT'					=> 'Subject',
	'SUBMIT'					=> 'Submit',

	'TERMS_USE'			=> 'Terms of Use',
	'TEST_CONNECTION'	=> 'Test Connection',
	'THE_TEAM'			=> 'The team',
	'TIME'				=> 'Time',

	'TOO_LONG_USER_PASSWORD'		=> 'The password you entered is too long.',
	'TOO_MANY_VOTE_OPTIONS'			=> 'You have tried to vote for too many options.',
	'TOO_SHORT_NEW_PASSWORD'		=> 'The password you entered is too short.',
	'TOO_SHORT_PASSWORD_CONFIRM'	=> 'The password confirmation you entered is too short.',
	'TOO_SHORT_USER_PASSWORD'		=> 'The password you entered is too short.',
	'TOO_SHORT_USERNAME'			=> 'The username you entered is too short.',
	'TOO_SHORT_EMAIL'				=> 'The email address you entered is too short.',
	'TOO_SHORT_EMAIL_CONFIRM'		=> 'The email address confirmation you entered is too short.',

	'TOPIC'				=> 'Topic',
	'TOPICS'			=> 'Topics',
	'TOPIC_ICON'		=> 'Topic icon',
	'TOPIC_LOCKED'		=> 'This topic is locked you cannot edit posts or make replies',
	'TOPIC_MOVED'		=> 'Moved Topic',
	'TOPIC_REVIEW'		=> 'Topic review',
	'TOPIC_TITLE'		=> 'Topic Title',
	'TOPIC_UNAPPROVED'	=> 'This topic has not been approved',
	'TOTAL_ATTACHMENTS'	=> 'Attachment(s)',
	'TOTAL_LOG'			=> '1 log',
	'TOTAL_LOGS'		=> '%d logs',
	'TOTAL_NO_PM'		=> '0 private messages in total',
	'TOTAL_PM'			=> '1 private messages in total',
	'TOTAL_PMS'			=> '$d private messages in total',
	'TOTAL_POSTS'		=> 'Total posts',
	'TOTAL_POSTS_OTHER'	=> 'Total posts <b>%d</b>',
	'TOTAL_POSTS_ZERO'	=> 'Total posts <b>0</b>',
	'TOTAL_TOPICS_OTHER'=> 'Total topics <b>%d</b>',
	'TOTAL_TOPICS_ZERO'	=> 'Total topics <b>0</b>',
	'TOTAL_USERS_OTHER'	=> 'Total members <b>%d</b>',
	'TOTAL_USERS_ZERO'	=> 'Total members <b>0</b>',

	'UNKNOWN_BROWSER'		=> 'Unknown Browser',
	'UNMARK_ALL'			=> 'Unmark all',
	'UNREAD_MESSAGES'		=> 'Unread Messages',
	'UNREAD_PM'				=> '<b>%d</b> unread message',
	'UNREAD_PMS'			=> '<b>%d</b> unread messages',
	'UNWATCHED_FORUMS'		=> 'You are no longer watching the selected forums.',
	'UNWATCHED_TOPICS'		=> 'You are no longer watching the selected topics.',
	'UPLOAD_IN_PROGRESS'	=> 'The upload is currently in progress',
	'URL_REDIRECT'			=> 'If your browser does not support meta redirection please click %sHERE%s to be redirected.',
	'USERGROUPS'			=> 'Groups',
	'USERNAME'				=> 'Username',
	'USERNAMES'				=> 'Usernames',
	'USER_POST'				=> '%d Post',
	'USER_POSTS'			=> '%d Posts',
	'USERS'					=> 'Users',

	'VIEWED'					=> 'Viewed',
	'VIEWING_FAQ'				=> 'Viewing FAQ',
	'VIEWING_MEMBERS'			=> 'Viewing member details',
	'VIEWING_ONLINE'			=> 'Viewing who is online',
	'VIEWING_PROFILE'			=> 'Viewing member profile',
	'VIEWING_UCP'				=> 'Viewing user control panel',
	'VIEWS'						=> 'Views',
	'VIEW_BOOKMARKS'			=> 'View bookmarks',
	'VIEW_FORUM_LOGS'			=> 'View Logs',
	'VIEW_LATEST_POST'			=> 'View latest post',
	'VIEW_NEWEST_POST'			=> 'View newest post',
	'VIEW_NOTES'				=> 'View user notes',
	'VIEW_ONLINE_TIME'			=> 'This data is based on users active over the past %d minute',
	'VIEW_ONLINE_TIMES'			=> 'This data is based on users active over the past %d minutes',
	'VIEW_TOPIC'				=> 'View topic',
	'VIEW_TOPIC_ANNOUNCEMENT'	=> 'Announcement: ',
	'VIEW_TOPIC_LOCKED'			=> 'Locked: ',
	'VIEW_TOPIC_LOGS'			=> 'View Logs',
	'VIEW_TOPIC_MOVED'			=> 'Moved: ',
	'VIEW_TOPIC_POLL'			=> 'Poll: ',
	'VIEW_TOPIC_STICKY'			=> 'Sticky: ',

	'WARNINGS'			=> 'Warnings',
	'WARN_USER'			=> 'Warn user',
	'WELCOME_SUBJECT'	=> 'Welcome to %s Forums',
	'WEBSITE'			=> 'Website',
	'WHOIS'				=> 'Whois',
	'WHO_IS_ONLINE'		=> 'Who is Online',
	'WRONG_PASSWORD'	=> 'You entered an incorrect password.',

	'YEAR'				=> 'Year',
	'YES'				=> 'Yes',
	'YOU_LAST_VISIT'	=> 'Last visit was: %s',
	'YOU_NEW_PM'		=> 'A new private message is waiting for you in your Inbox',
	'YOU_NEW_PMS'		=> 'New private messages are waiting for you in your Inbox',
	'YOU_NO_NEW_PM'		=> 'No new private messages are waiting for you',

	'datetime'			=> array(
		'TODAY'		=> 'Today, ',
		'YESTERDAY'	=> 'Yesterday, ',

		'Sunday'	=> 'Sunday',
		'Monday'	=> 'Monday',
		'Tuesday'	=> 'Tuesday',
		'Wednesday'	=> 'Wednesday',
		'Thursday'	=> 'Thursday',
		'Friday'	=> 'Friday',
		'Saturday'	=> 'Saturday',

		'Sun'		=> 'Sun',
		'Mon'		=> 'Mon',
		'Tue'		=> 'Tue',
		'Wed'		=> 'Wed',
		'Thu'		=> 'Thu',
		'Fri'		=> 'Fri',
		'Sat'		=> 'Sat',

		'January'	=> 'January',
		'February'	=> 'February',
		'March'		=> 'March',
		'April'		=> 'April',
		'May'		=> 'May',
		'June'		=> 'June',
		'July'		=> 'July',
		'August'	=> 'August',
		'September' => 'September',
		'October'	=> 'October',
		'November'	=> 'November',
		'December'	=> 'December',

		'Jan'		=> 'Jan',
		'Feb'		=> 'Feb',
		'Mar'		=> 'Mar',
		'Apr'		=> 'Apr',
		'Jun'		=> 'Jun',
		'Jul'		=> 'Jul',
		'Aug'		=> 'Aug',
		'Sep'		=> 'Sep',
		'Oct'		=> 'Oct',
		'Nov'		=> 'Nov',
		'Dec'		=> 'Dec',

		'TODAY'		=> 'Today',
		'YESTERDAY'	=> 'Yesterday',
	),

	'tz'				=> array(
		'-12'	=> 'GMT - 12 Hours',
		'-11'	=> 'GMT - 11 Hours',
		'-10'	=> 'GMT - 10 Hours',
		'-9'	=> 'GMT - 9 Hours',
		'-8'	=> 'GMT - 8 Hours',
		'-7'	=> 'GMT - 7 Hours',
		'-6'	=> 'GMT - 6 Hours',
		'-5'	=> 'GMT - 5 Hours',
		'-4'	=> 'GMT - 4 Hours',
		'-3.5'	=> 'GMT - 3.5 Hours',
		'-3'	=> 'GMT - 3 Hours',
		'-2'	=> 'GMT - 2 Hours',
		'-1'	=> 'GMT - 1 Hour',
		'0'		=> 'GMT',
		'1'		=> 'GMT + 1 Hour',
		'2'		=> 'GMT + 2 Hours',
		'3'		=> 'GMT + 3 Hours',
		'3.5'	=> 'GMT + 3.5 Hours',
		'4'		=> 'GMT + 4 Hours',
		'4.5'	=> 'GMT + 4.5 Hours',
		'5'		=> 'GMT + 5 Hours',
		'5.5'	=> 'GMT + 5.5 Hours',
		'6'		=> 'GMT + 6 Hours',
		'6.5'	=> 'GMT + 6.5 Hours',
		'7'		=> 'GMT + 7 Hours',
		'8'		=> 'GMT + 8 Hours',
		'9'		=> 'GMT + 9 Hours',
		'9.5'	=> 'GMT + 9.5 Hours',
		'10'	=> 'GMT + 10 Hours',
		'11'	=> 'GMT + 11 Hours',
		'12'	=> 'GMT + 12 Hours',
		'dst'	=> '[ DST ]',
	),

	'tz_zones'	=> array(
		'-12'	=> '[GMT-12] Eniwetok, Kwaialein',
		'-11'	=> '[GMT-11] Midway Island, Samoa',
		'-10'	=> '[GMT-10] Hawaii, Honolulu',
		'-9'	=> '[GMT-9] Alaska',
		'-8'	=> '[GMT-8] Anchorage, Los Angeles, San Francisco, Seattle',
		'-7'	=> '[GMT-7] Denver, Edmonton, Phoenix, Salt Lake City, Santa Fe',
		'-6'	=> '[GMT-6] Chicago, Guatamala, Mexico City, Saskatchewan East',
		'-5'	=> '[GMT-5] Bogota, Kingston, Lima, New York',
		'-4'	=> '[GMT-4] Caracas, Labrador, La Paz, Maritimes, Santiago',
		'-3.5'	=> '[GMT-3.5] Standard Time [Canada], Newfoundland',
		'-3'	=> '[GMT-3] Brazilia, Buenos Aires, Georgetown, Rio de Janero',
		'-2'	=> '[GMT-2] Mid-Atlantic',
		'-1'	=> '[GMT-1] Azores, Cape Verde Is.',
		'0'		=> '[GMT] Dublin, Edinburgh, Iceland, Lisbon, London, Casablanca',
		'1'		=> '[GMT+1] Amsterdam, Berlin, Bern, Brussells, Madrid, Paris, Rome, Oslo, Vienna',
		'2'		=> '[GMT+2] Athens, Bucharest, Harare, Helsinki, Israel, Istanbul',
		'3'		=> '[GMT+3] Ankara, Baghdad, Bahrain, Beruit, Kuwait, Moscow, Nairobi, Riyadh',
		'3.5'	=> '[GMT+3.5] Iran',
		'4'		=> '[GMT+4] Abu Dhabi, Kabul, Muscat, Tbilisi, Volgograd',
		'4.5'	=> '[GMT+4.5] Afghanistan',
		'5'		=> '[GMT+5] Calcutta, Madras, New Dehli',
		'5.5'	=> '[GMT+5.5] India',
		'6'		=> '[GMT+6] Almaty, Dhakar, Kathmandu',
		'6.5'	=> '[GMT+6.5] Rangoon',
		'7'		=> '[GMT+7] Bangkok, Hanoi, Jakarta, Phnom Penh',
		'8'		=> '[GMT+8] Beijing, Hong Kong, Kuala Lumpar, Manila, Perth, Singapore, Taipei',
		'9'		=> '[GMT+9] Osaka, Sapporo, Seoul, Tokyo, Yakutsk',
		'9.5'	=> '[GMT+9.5] Adelaide, Darwin',
		'10'	=> '[GMT+10] Brisbane, Canberra, Guam, Hobart, Melbourne, Port Moresby, Sydney',
		'11'	=> '[GMT+11] Magadan, New Caledonia, Solomon Is.',
		'12'	=> '[GMT+12] Auckland, Fiji, Kamchatka, Marshall Is., Suva, Wellington'
	),

	// The value is only an example and will get replaced by the current time on view
	'dateformats'	=> array(
		'|d M Y| H:i'			=> '10 Jan 2005 17:54 [Relative days]',
		'd M Y, H:i'			=> '10 Jan 2005, 17:57',
		'd M Y H:i'				=> '10 Jan 2005 17:57',
		'D M d, Y g:i a'		=> 'Mon Jan 10, 2005 5:57 pm',
		'M j, y, H:i'			=> 'Jan 10, 05, 5:57 pm',
		'F j, Y, g:i a'			=> 'January 10, 2005, 5:57 pm'
	),

));

?>