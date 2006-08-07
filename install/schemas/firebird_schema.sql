#
# Firebird Schema for phpBB 3.x - (c) phpBB Group, 2005
#
# $Id$
#


# Emulation of STRLEN, might need to be checked out for FB 2.0
DECLARE EXTERNAL FUNCTION STRLEN CSTRING(32767)
RETURNS INTEGER BY VALUE
ENTRY_POINT 'IB_UDF_strlen' MODULE_NAME 'ib_udf';;

# Emulation of LOWER, might need to be checked out for FB 2.0
DECLARE EXTERNAL FUNCTION LOWER CSTRING(80)
RETURNS CSTRING(80) FREE_IT 
ENTRY_POINT 'IB_UDF_lower' MODULE_NAME 'ib_udf';;

# Only used for insertion of binary strings as defaults
DECLARE EXTERNAL FUNCTION ASCII_CHAR INTEGER
RETURNS CSTRING(1) FREE_IT
ENTRY_POINT 'IB_UDF_ascii_char' MODULE_NAME 'ib_udf';;

# Table: 'phpbb_attachments'
CREATE TABLE phpbb_attachments (
	attach_id INTEGER NOT NULL,
	post_msg_id INTEGER DEFAULT 0 NOT NULL,
	topic_id INTEGER DEFAULT 0 NOT NULL,
	in_message INTEGER DEFAULT 0 NOT NULL,
	poster_id INTEGER DEFAULT 0 NOT NULL,
	physical_filename VARCHAR(255) DEFAULT '' NOT NULL,
	real_filename VARCHAR(255) DEFAULT '' NOT NULL,
	download_count INTEGER DEFAULT 0 NOT NULL,
	attach_comment BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	extension VARCHAR(100) DEFAULT '' NOT NULL,
	mimetype VARCHAR(100) DEFAULT '' NOT NULL,
	filesize INTEGER DEFAULT 0 NOT NULL,
	filetime INTEGER DEFAULT 0 NOT NULL,
	thumbnail INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_attachments ADD PRIMARY KEY (attach_id);;

CREATE INDEX phpbb_attachments_filetime ON phpbb_attachments(filetime);;
CREATE INDEX phpbb_attachments_post_msg_id ON phpbb_attachments(post_msg_id);;
CREATE INDEX phpbb_attachments_topic_id ON phpbb_attachments(topic_id);;
CREATE INDEX phpbb_attachments_poster_id ON phpbb_attachments(poster_id);;
CREATE INDEX phpbb_attachments_filesize ON phpbb_attachments(filesize);;

CREATE GENERATOR phpbb_attachments_gen;;
SET GENERATOR phpbb_attachments_gen TO 0;;

CREATE TRIGGER t_phpbb_attachments FOR phpbb_attachments
BEFORE INSERT
AS
BEGIN
	NEW.attach_id = GEN_ID(phpbb_attachments_gen, 1);
END;;


# Table: 'phpbb_acl_groups'
CREATE TABLE phpbb_acl_groups (
	group_id INTEGER DEFAULT 0 NOT NULL,
	forum_id INTEGER DEFAULT 0 NOT NULL,
	auth_option_id INTEGER DEFAULT 0 NOT NULL,
	auth_role_id INTEGER DEFAULT 0 NOT NULL,
	auth_setting INTEGER DEFAULT 0 NOT NULL
);;

CREATE INDEX phpbb_acl_groups_group_id ON phpbb_acl_groups(group_id);;
CREATE INDEX phpbb_acl_groups_auth_opt_id ON phpbb_acl_groups(auth_option_id);;

# Table: 'phpbb_acl_options'
CREATE TABLE phpbb_acl_options (
	auth_option_id INTEGER NOT NULL,
	auth_option VARCHAR(50) DEFAULT '' NOT NULL,
	is_global INTEGER DEFAULT 0 NOT NULL,
	is_local INTEGER DEFAULT 0 NOT NULL,
	founder_only INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_acl_options ADD PRIMARY KEY (auth_option_id);;

CREATE INDEX phpbb_acl_options_auth_option ON phpbb_acl_options(auth_option);;

CREATE GENERATOR phpbb_acl_options_gen;;
SET GENERATOR phpbb_acl_options_gen TO 0;;

CREATE TRIGGER t_phpbb_acl_options FOR phpbb_acl_options
BEFORE INSERT
AS
BEGIN
	NEW.auth_option_id = GEN_ID(phpbb_acl_options_gen, 1);
END;;


# Table: 'phpbb_acl_roles'
CREATE TABLE phpbb_acl_roles (
	role_id INTEGER NOT NULL,
	role_name VARCHAR(255) DEFAULT '' NOT NULL,
	role_description BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	role_type VARCHAR(10) DEFAULT '' NOT NULL,
	role_order INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_acl_roles ADD PRIMARY KEY (role_id);;

CREATE INDEX phpbb_acl_roles_role_type ON phpbb_acl_roles(role_type);;
CREATE INDEX phpbb_acl_roles_role_order ON phpbb_acl_roles(role_order);;

CREATE GENERATOR phpbb_acl_roles_gen;;
SET GENERATOR phpbb_acl_roles_gen TO 0;;

CREATE TRIGGER t_phpbb_acl_roles FOR phpbb_acl_roles
BEFORE INSERT
AS
BEGIN
	NEW.role_id = GEN_ID(phpbb_acl_roles_gen, 1);
END;;


# Table: 'phpbb_acl_roles_data'
CREATE TABLE phpbb_acl_roles_data (
	role_id INTEGER DEFAULT 0 NOT NULL,
	auth_option_id INTEGER DEFAULT 0 NOT NULL,
	auth_setting INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_acl_roles_data ADD PRIMARY KEY (role_id, auth_option_id);;


# Table: 'phpbb_acl_users'
CREATE TABLE phpbb_acl_users (
	user_id INTEGER DEFAULT 0 NOT NULL,
	forum_id INTEGER DEFAULT 0 NOT NULL,
	auth_option_id INTEGER DEFAULT 0 NOT NULL,
	auth_role_id INTEGER DEFAULT 0 NOT NULL,
	auth_setting INTEGER DEFAULT 0 NOT NULL
);;

CREATE INDEX phpbb_acl_users_user_id ON phpbb_acl_users(user_id);;
CREATE INDEX phpbb_acl_users_auth_option_id ON phpbb_acl_users(auth_option_id);;

# Table: 'phpbb_banlist'
CREATE TABLE phpbb_banlist (
	ban_id INTEGER NOT NULL,
	ban_userid INTEGER DEFAULT 0 NOT NULL,
	ban_ip VARCHAR(40) DEFAULT '' NOT NULL,
	ban_email VARCHAR(100) DEFAULT '' NOT NULL,
	ban_start INTEGER DEFAULT 0 NOT NULL,
	ban_end INTEGER DEFAULT 0 NOT NULL,
	ban_exclude INTEGER DEFAULT 0 NOT NULL,
	ban_reason BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	ban_give_reason BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_banlist ADD PRIMARY KEY (ban_id);;

CREATE INDEX phpbb_banlist_ban_end ON phpbb_banlist(ban_end);;
CREATE INDEX phpbb_banlist_ban_user ON phpbb_banlist(ban_userid, ban_exclude);;
CREATE INDEX phpbb_banlist_ban_email ON phpbb_banlist(ban_email, ban_exclude);;
CREATE INDEX phpbb_banlist_ban_ip ON phpbb_banlist(ban_ip, ban_exclude);;

CREATE GENERATOR phpbb_banlist_gen;;
SET GENERATOR phpbb_banlist_gen TO 0;;

CREATE TRIGGER t_phpbb_banlist FOR phpbb_banlist
BEFORE INSERT
AS
BEGIN
	NEW.ban_id = GEN_ID(phpbb_banlist_gen, 1);
END;;


# Table: 'phpbb_bbcodes'
CREATE TABLE phpbb_bbcodes (
	bbcode_id INTEGER DEFAULT 0 NOT NULL,
	bbcode_tag VARCHAR(16) DEFAULT '' NOT NULL,
	bbcode_helpline VARCHAR(255) DEFAULT '' NOT NULL,
	display_on_posting INTEGER DEFAULT 0 NOT NULL,
	bbcode_match VARCHAR(255) DEFAULT '' NOT NULL,
	bbcode_tpl BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	first_pass_match VARCHAR(255) DEFAULT '' NOT NULL,
	first_pass_replace VARCHAR(255) DEFAULT '' NOT NULL,
	second_pass_match VARCHAR(255) DEFAULT '' NOT NULL,
	second_pass_replace BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_bbcodes ADD PRIMARY KEY (bbcode_id);;

CREATE INDEX phpbb_bbcodes_display_on_post ON phpbb_bbcodes(display_on_posting);;

# Table: 'phpbb_bookmarks'
CREATE TABLE phpbb_bookmarks (
	topic_id INTEGER DEFAULT 0 NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	order_id INTEGER DEFAULT 0 NOT NULL
);;

CREATE INDEX phpbb_bookmarks_order_id ON phpbb_bookmarks(order_id);;
CREATE INDEX phpbb_bookmarks_topic_user_id ON phpbb_bookmarks(topic_id, user_id);;

# Table: 'phpbb_bots'
CREATE TABLE phpbb_bots (
	bot_id INTEGER NOT NULL,
	bot_active INTEGER DEFAULT 1 NOT NULL,
	bot_name BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	bot_agent VARCHAR(255) DEFAULT '' NOT NULL,
	bot_ip VARCHAR(255) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_bots ADD PRIMARY KEY (bot_id);;

CREATE INDEX phpbb_bots_bot_active ON phpbb_bots(bot_active);;

CREATE GENERATOR phpbb_bots_gen;;
SET GENERATOR phpbb_bots_gen TO 0;;

CREATE TRIGGER t_phpbb_bots FOR phpbb_bots
BEFORE INSERT
AS
BEGIN
	NEW.bot_id = GEN_ID(phpbb_bots_gen, 1);
END;;


# Table: 'phpbb_config'
CREATE TABLE phpbb_config (
	config_name VARCHAR(252) DEFAULT '' NOT NULL,
	config_value VARCHAR(255) DEFAULT '' NOT NULL,
	is_dynamic INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_config ADD PRIMARY KEY (config_name);;

CREATE INDEX phpbb_config_is_dynamic ON phpbb_config(is_dynamic);;

# Table: 'phpbb_confirm'
CREATE TABLE phpbb_confirm (
	confirm_id CHAR(32) DEFAULT '' NOT NULL,
	session_id CHAR(32) DEFAULT '' NOT NULL,
	confirm_type INTEGER DEFAULT 0 NOT NULL,
	code VARCHAR(8) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_confirm ADD PRIMARY KEY (session_id, confirm_id);;

CREATE INDEX phpbb_confirm_confirm_type ON phpbb_confirm(confirm_type);;

# Table: 'phpbb_disallow'
CREATE TABLE phpbb_disallow (
	disallow_id INTEGER NOT NULL,
	disallow_username VARCHAR(252) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_disallow ADD PRIMARY KEY (disallow_id);;


CREATE GENERATOR phpbb_disallow_gen;;
SET GENERATOR phpbb_disallow_gen TO 0;;

CREATE TRIGGER t_phpbb_disallow FOR phpbb_disallow
BEFORE INSERT
AS
BEGIN
	NEW.disallow_id = GEN_ID(phpbb_disallow_gen, 1);
END;;


# Table: 'phpbb_drafts'
CREATE TABLE phpbb_drafts (
	draft_id INTEGER NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	topic_id INTEGER DEFAULT 0 NOT NULL,
	forum_id INTEGER DEFAULT 0 NOT NULL,
	save_time INTEGER DEFAULT 0 NOT NULL,
	draft_subject BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	draft_message BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_drafts ADD PRIMARY KEY (draft_id);;

CREATE INDEX phpbb_drafts_save_time ON phpbb_drafts(save_time);;

CREATE GENERATOR phpbb_drafts_gen;;
SET GENERATOR phpbb_drafts_gen TO 0;;

CREATE TRIGGER t_phpbb_drafts FOR phpbb_drafts
BEFORE INSERT
AS
BEGIN
	NEW.draft_id = GEN_ID(phpbb_drafts_gen, 1);
END;;


# Table: 'phpbb_extensions'
CREATE TABLE phpbb_extensions (
	extension_id INTEGER NOT NULL,
	group_id INTEGER DEFAULT 0 NOT NULL,
	extension VARCHAR(100) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_extensions ADD PRIMARY KEY (extension_id);;


CREATE GENERATOR phpbb_extensions_gen;;
SET GENERATOR phpbb_extensions_gen TO 0;;

CREATE TRIGGER t_phpbb_extensions FOR phpbb_extensions
BEFORE INSERT
AS
BEGIN
	NEW.extension_id = GEN_ID(phpbb_extensions_gen, 1);
END;;


# Table: 'phpbb_extension_groups'
CREATE TABLE phpbb_extension_groups (
	group_id INTEGER NOT NULL,
	group_name VARCHAR(255) DEFAULT '' NOT NULL,
	cat_id INTEGER DEFAULT 0 NOT NULL,
	allow_group INTEGER DEFAULT 0 NOT NULL,
	download_mode INTEGER DEFAULT 1 NOT NULL,
	upload_icon VARCHAR(255) DEFAULT '' NOT NULL,
	max_filesize INTEGER DEFAULT 0 NOT NULL,
	allowed_forums BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	allow_in_pm INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_extension_groups ADD PRIMARY KEY (group_id);;


CREATE GENERATOR phpbb_extension_groups_gen;;
SET GENERATOR phpbb_extension_groups_gen TO 0;;

CREATE TRIGGER t_phpbb_extension_groups FOR phpbb_extension_groups
BEFORE INSERT
AS
BEGIN
	NEW.group_id = GEN_ID(phpbb_extension_groups_gen, 1);
END;;


# Table: 'phpbb_forums'
CREATE TABLE phpbb_forums (
	forum_id INTEGER NOT NULL,
	parent_id INTEGER DEFAULT 0 NOT NULL,
	left_id INTEGER DEFAULT 0 NOT NULL,
	right_id INTEGER DEFAULT 0 NOT NULL,
	forum_parents BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	forum_name BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	forum_desc BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	forum_desc_bitfield CHAR(255) DEFAULT '' NOT NULL,
	forum_desc_options INTEGER DEFAULT 0 NOT NULL,
	forum_desc_uid VARCHAR(5) DEFAULT '' NOT NULL,
	forum_link VARCHAR(255) DEFAULT '' NOT NULL,
	forum_password VARCHAR(40) DEFAULT '' NOT NULL,
	forum_style INTEGER DEFAULT 0 NOT NULL,
	forum_image VARCHAR(255) DEFAULT '' NOT NULL,
	forum_rules BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	forum_rules_link VARCHAR(255) DEFAULT '' NOT NULL,
	forum_rules_bitfield CHAR(255) DEFAULT '' NOT NULL,
	forum_rules_options INTEGER DEFAULT 0 NOT NULL,
	forum_rules_uid VARCHAR(5) DEFAULT '' NOT NULL,
	forum_topics_per_page INTEGER DEFAULT 0 NOT NULL,
	forum_type INTEGER DEFAULT 0 NOT NULL,
	forum_status INTEGER DEFAULT 0 NOT NULL,
	forum_posts INTEGER DEFAULT 0 NOT NULL,
	forum_topics INTEGER DEFAULT 0 NOT NULL,
	forum_topics_real INTEGER DEFAULT 0 NOT NULL,
	forum_last_post_id INTEGER DEFAULT 0 NOT NULL,
	forum_last_poster_id INTEGER DEFAULT 0 NOT NULL,
	forum_last_post_time INTEGER DEFAULT 0 NOT NULL,
	forum_last_poster_name VARCHAR(255) DEFAULT '' NOT NULL,
	forum_flags INTEGER DEFAULT 32 NOT NULL,
	display_on_index INTEGER DEFAULT 1 NOT NULL,
	enable_indexing INTEGER DEFAULT 1 NOT NULL,
	enable_icons INTEGER DEFAULT 1 NOT NULL,
	enable_prune INTEGER DEFAULT 0 NOT NULL,
	prune_next INTEGER DEFAULT 0 NOT NULL,
	prune_days INTEGER DEFAULT 0 NOT NULL,
	prune_viewed INTEGER DEFAULT 0 NOT NULL,
	prune_freq INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_forums ADD PRIMARY KEY (forum_id);;

CREATE INDEX phpbb_forums_left_right_id ON phpbb_forums(left_id, right_id);;
CREATE INDEX phpbb_forums_forum_lastpost_id ON phpbb_forums(forum_last_post_id);;

CREATE GENERATOR phpbb_forums_gen;;
SET GENERATOR phpbb_forums_gen TO 0;;

CREATE TRIGGER t_phpbb_forums FOR phpbb_forums
BEFORE INSERT
AS
BEGIN
	NEW.forum_id = GEN_ID(phpbb_forums_gen, 1);
END;;


# Table: 'phpbb_forums_access'
CREATE TABLE phpbb_forums_access (
	forum_id INTEGER DEFAULT 0 NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	session_id CHAR(32) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_forums_access ADD PRIMARY KEY (forum_id, user_id, session_id);;


# Table: 'phpbb_forums_track'
CREATE TABLE phpbb_forums_track (
	user_id INTEGER DEFAULT 0 NOT NULL,
	forum_id INTEGER DEFAULT 0 NOT NULL,
	mark_time INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_forums_track ADD PRIMARY KEY (user_id, forum_id);;


# Table: 'phpbb_forums_watch'
CREATE TABLE phpbb_forums_watch (
	forum_id INTEGER DEFAULT 0 NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	notify_status INTEGER DEFAULT 0 NOT NULL
);;

CREATE INDEX phpbb_forums_watch_forum_id ON phpbb_forums_watch(forum_id);;
CREATE INDEX phpbb_forums_watch_user_id ON phpbb_forums_watch(user_id);;
CREATE INDEX phpbb_forums_watch_notify_stat ON phpbb_forums_watch(notify_status);;

# Table: 'phpbb_groups'
CREATE TABLE phpbb_groups (
	group_id INTEGER NOT NULL,
	group_type INTEGER DEFAULT 1 NOT NULL,
	group_name VARCHAR(252) DEFAULT '' NOT NULL,
	group_desc BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	group_desc_bitfield CHAR(255) DEFAULT '' NOT NULL,
	group_desc_options INTEGER DEFAULT 0 NOT NULL,
	group_desc_uid VARCHAR(5) DEFAULT '' NOT NULL,
	group_display INTEGER DEFAULT 0 NOT NULL,
	group_avatar VARCHAR(255) DEFAULT '' NOT NULL,
	group_avatar_type INTEGER DEFAULT 0 NOT NULL,
	group_avatar_width INTEGER DEFAULT 0 NOT NULL,
	group_avatar_height INTEGER DEFAULT 0 NOT NULL,
	group_rank INTEGER DEFAULT 0 NOT NULL,
	group_colour VARCHAR(6) DEFAULT '' NOT NULL,
	group_sig_chars INTEGER DEFAULT 0 NOT NULL,
	group_receive_pm INTEGER DEFAULT 0 NOT NULL,
	group_message_limit INTEGER DEFAULT 0 NOT NULL,
	group_legend INTEGER DEFAULT 1 NOT NULL
);;

ALTER TABLE phpbb_groups ADD PRIMARY KEY (group_id);;

CREATE INDEX phpbb_groups_group_legend ON phpbb_groups(group_legend);;

CREATE GENERATOR phpbb_groups_gen;;
SET GENERATOR phpbb_groups_gen TO 0;;

CREATE TRIGGER t_phpbb_groups FOR phpbb_groups
BEFORE INSERT
AS
BEGIN
	NEW.group_id = GEN_ID(phpbb_groups_gen, 1);
END;;


# Table: 'phpbb_icons'
CREATE TABLE phpbb_icons (
	icons_id INTEGER NOT NULL,
	icons_url VARCHAR(255) DEFAULT '' NOT NULL,
	icons_width INTEGER DEFAULT 0 NOT NULL,
	icons_height INTEGER DEFAULT 0 NOT NULL,
	icons_order INTEGER DEFAULT 0 NOT NULL,
	display_on_posting INTEGER DEFAULT 1 NOT NULL
);;

ALTER TABLE phpbb_icons ADD PRIMARY KEY (icons_id);;

CREATE INDEX phpbb_icons_display_on_posting ON phpbb_icons(display_on_posting);;

CREATE GENERATOR phpbb_icons_gen;;
SET GENERATOR phpbb_icons_gen TO 0;;

CREATE TRIGGER t_phpbb_icons FOR phpbb_icons
BEFORE INSERT
AS
BEGIN
	NEW.icons_id = GEN_ID(phpbb_icons_gen, 1);
END;;


# Table: 'phpbb_lang'
CREATE TABLE phpbb_lang (
	lang_id INTEGER NOT NULL,
	lang_iso VARCHAR(30) DEFAULT '' NOT NULL,
	lang_dir VARCHAR(30) DEFAULT '' NOT NULL,
	lang_english_name VARCHAR(100) DEFAULT '' NOT NULL,
	lang_local_name VARCHAR(255) DEFAULT '' NOT NULL,
	lang_author VARCHAR(255) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_lang ADD PRIMARY KEY (lang_id);;

CREATE INDEX phpbb_lang_lang_iso ON phpbb_lang(lang_iso);;

CREATE GENERATOR phpbb_lang_gen;;
SET GENERATOR phpbb_lang_gen TO 0;;

CREATE TRIGGER t_phpbb_lang FOR phpbb_lang
BEFORE INSERT
AS
BEGIN
	NEW.lang_id = GEN_ID(phpbb_lang_gen, 1);
END;;


# Table: 'phpbb_log'
CREATE TABLE phpbb_log (
	log_id INTEGER NOT NULL,
	log_type INTEGER DEFAULT 0 NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	forum_id INTEGER DEFAULT 0 NOT NULL,
	topic_id INTEGER DEFAULT 0 NOT NULL,
	reportee_id INTEGER DEFAULT 0 NOT NULL,
	log_ip VARCHAR(40) DEFAULT '' NOT NULL,
	log_time INTEGER DEFAULT 0 NOT NULL,
	log_operation BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	log_data BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_log ADD PRIMARY KEY (log_id);;

CREATE INDEX phpbb_log_log_type ON phpbb_log(log_type);;
CREATE INDEX phpbb_log_forum_id ON phpbb_log(forum_id);;
CREATE INDEX phpbb_log_topic_id ON phpbb_log(topic_id);;
CREATE INDEX phpbb_log_reportee_id ON phpbb_log(reportee_id);;
CREATE INDEX phpbb_log_user_id ON phpbb_log(user_id);;

CREATE GENERATOR phpbb_log_gen;;
SET GENERATOR phpbb_log_gen TO 0;;

CREATE TRIGGER t_phpbb_log FOR phpbb_log
BEFORE INSERT
AS
BEGIN
	NEW.log_id = GEN_ID(phpbb_log_gen, 1);
END;;


# Table: 'phpbb_moderator_cache'
CREATE TABLE phpbb_moderator_cache (
	forum_id INTEGER DEFAULT 0 NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	username VARCHAR(252) DEFAULT '' NOT NULL,
	group_id INTEGER DEFAULT 0 NOT NULL,
	group_name VARCHAR(255) DEFAULT '' NOT NULL,
	display_on_index INTEGER DEFAULT 1 NOT NULL
);;

CREATE INDEX phpbb_moderator_cache_disp_idx ON phpbb_moderator_cache(display_on_index);;
CREATE INDEX phpbb_moderator_cache_forum_id ON phpbb_moderator_cache(forum_id);;

# Table: 'phpbb_modules'
CREATE TABLE phpbb_modules (
	module_id INTEGER NOT NULL,
	module_enabled INTEGER DEFAULT 1 NOT NULL,
	module_display INTEGER DEFAULT 1 NOT NULL,
	module_basename VARCHAR(255) DEFAULT '' NOT NULL,
	module_class VARCHAR(10) DEFAULT '' NOT NULL,
	parent_id INTEGER DEFAULT 0 NOT NULL,
	left_id INTEGER DEFAULT 0 NOT NULL,
	right_id INTEGER DEFAULT 0 NOT NULL,
	module_langname VARCHAR(255) DEFAULT '' NOT NULL,
	module_mode VARCHAR(255) DEFAULT '' NOT NULL,
	module_auth VARCHAR(255) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_modules ADD PRIMARY KEY (module_id);;

CREATE INDEX phpbb_modules_left_right_id ON phpbb_modules(left_id, right_id);;
CREATE INDEX phpbb_modules_module_enabled ON phpbb_modules(module_enabled);;
CREATE INDEX phpbb_modules_class_left_id ON phpbb_modules(module_class, left_id);;

CREATE GENERATOR phpbb_modules_gen;;
SET GENERATOR phpbb_modules_gen TO 0;;

CREATE TRIGGER t_phpbb_modules FOR phpbb_modules
BEFORE INSERT
AS
BEGIN
	NEW.module_id = GEN_ID(phpbb_modules_gen, 1);
END;;


# Table: 'phpbb_poll_options'
CREATE TABLE phpbb_poll_options (
	poll_option_id INTEGER DEFAULT 0 NOT NULL,
	topic_id INTEGER DEFAULT 0 NOT NULL,
	poll_option_text BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	poll_option_total INTEGER DEFAULT 0 NOT NULL
);;

CREATE INDEX phpbb_poll_options_poll_opt_id ON phpbb_poll_options(poll_option_id);;
CREATE INDEX phpbb_poll_options_topic_id ON phpbb_poll_options(topic_id);;

# Table: 'phpbb_poll_votes'
CREATE TABLE phpbb_poll_votes (
	topic_id INTEGER DEFAULT 0 NOT NULL,
	poll_option_id INTEGER DEFAULT 0 NOT NULL,
	vote_user_id INTEGER DEFAULT 0 NOT NULL,
	vote_user_ip VARCHAR(40) DEFAULT '' NOT NULL
);;

CREATE INDEX phpbb_poll_votes_topic_id ON phpbb_poll_votes(topic_id);;
CREATE INDEX phpbb_poll_votes_vote_user_id ON phpbb_poll_votes(vote_user_id);;
CREATE INDEX phpbb_poll_votes_vote_user_ip ON phpbb_poll_votes(vote_user_ip);;

# Table: 'phpbb_posts'
CREATE TABLE phpbb_posts (
	post_id INTEGER NOT NULL,
	topic_id INTEGER DEFAULT 0 NOT NULL,
	forum_id INTEGER DEFAULT 0 NOT NULL,
	poster_id INTEGER DEFAULT 0 NOT NULL,
	icon_id INTEGER DEFAULT 0 NOT NULL,
	poster_ip VARCHAR(40) DEFAULT '' NOT NULL,
	post_time INTEGER DEFAULT 0 NOT NULL,
	post_approved INTEGER DEFAULT 1 NOT NULL,
	post_reported INTEGER DEFAULT 0 NOT NULL,
	enable_bbcode INTEGER DEFAULT 1 NOT NULL,
	enable_smilies INTEGER DEFAULT 1 NOT NULL,
	enable_magic_url INTEGER DEFAULT 1 NOT NULL,
	enable_sig INTEGER DEFAULT 1 NOT NULL,
	post_username VARCHAR(252) DEFAULT '' NOT NULL,
	post_subject BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	post_text BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	post_checksum VARCHAR(32) DEFAULT '' NOT NULL,
	post_encoding VARCHAR(20) DEFAULT 'iso-8859-1' NOT NULL,
	post_attachment INTEGER DEFAULT 0 NOT NULL,
	bbcode_bitfield CHAR(255) DEFAULT '' NOT NULL,
	bbcode_uid VARCHAR(5) DEFAULT '' NOT NULL,
	post_postcount INTEGER DEFAULT 1 NOT NULL,
	post_edit_time INTEGER DEFAULT 0 NOT NULL,
	post_edit_reason BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	post_edit_user INTEGER DEFAULT 0 NOT NULL,
	post_edit_count INTEGER DEFAULT 0 NOT NULL,
	post_edit_locked INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_posts ADD PRIMARY KEY (post_id);;

CREATE INDEX phpbb_posts_forum_id ON phpbb_posts(forum_id);;
CREATE INDEX phpbb_posts_topic_id ON phpbb_posts(topic_id);;
CREATE INDEX phpbb_posts_poster_ip ON phpbb_posts(poster_ip);;
CREATE INDEX phpbb_posts_poster_id ON phpbb_posts(poster_id);;
CREATE INDEX phpbb_posts_post_approved ON phpbb_posts(post_approved);;
CREATE INDEX phpbb_posts_post_postcount ON phpbb_posts(post_postcount);;
CREATE INDEX phpbb_posts_post_time ON phpbb_posts(post_time);;

CREATE GENERATOR phpbb_posts_gen;;
SET GENERATOR phpbb_posts_gen TO 0;;

CREATE TRIGGER t_phpbb_posts FOR phpbb_posts
BEFORE INSERT
AS
BEGIN
	NEW.post_id = GEN_ID(phpbb_posts_gen, 1);
END;;


# Table: 'phpbb_privmsgs'
CREATE TABLE phpbb_privmsgs (
	msg_id INTEGER NOT NULL,
	root_level INTEGER DEFAULT 0 NOT NULL,
	author_id INTEGER DEFAULT 0 NOT NULL,
	icon_id INTEGER DEFAULT 0 NOT NULL,
	author_ip VARCHAR(40) DEFAULT '' NOT NULL,
	message_time INTEGER DEFAULT 0 NOT NULL,
	enable_bbcode INTEGER DEFAULT 1 NOT NULL,
	enable_smilies INTEGER DEFAULT 1 NOT NULL,
	enable_magic_url INTEGER DEFAULT 1 NOT NULL,
	enable_sig INTEGER DEFAULT 1 NOT NULL,
	message_subject BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	message_text BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	message_edit_reason BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	message_edit_user INTEGER DEFAULT 0 NOT NULL,
	message_encoding VARCHAR(20) DEFAULT 'iso-8859-1' NOT NULL,
	message_attachment INTEGER DEFAULT 0 NOT NULL,
	bbcode_bitfield CHAR(255) DEFAULT '' NOT NULL,
	bbcode_uid VARCHAR(5) DEFAULT '' NOT NULL,
	message_edit_time INTEGER DEFAULT 0 NOT NULL,
	message_edit_count INTEGER DEFAULT 0 NOT NULL,
	to_address BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	bcc_address BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_privmsgs ADD PRIMARY KEY (msg_id);;

CREATE INDEX phpbb_privmsgs_author_ip ON phpbb_privmsgs(author_ip);;
CREATE INDEX phpbb_privmsgs_message_time ON phpbb_privmsgs(message_time);;
CREATE INDEX phpbb_privmsgs_author_id ON phpbb_privmsgs(author_id);;
CREATE INDEX phpbb_privmsgs_root_level ON phpbb_privmsgs(root_level);;

CREATE GENERATOR phpbb_privmsgs_gen;;
SET GENERATOR phpbb_privmsgs_gen TO 0;;

CREATE TRIGGER t_phpbb_privmsgs FOR phpbb_privmsgs
BEFORE INSERT
AS
BEGIN
	NEW.msg_id = GEN_ID(phpbb_privmsgs_gen, 1);
END;;


# Table: 'phpbb_privmsgs_folder'
CREATE TABLE phpbb_privmsgs_folder (
	folder_id INTEGER NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	folder_name VARCHAR(255) DEFAULT '' NOT NULL,
	pm_count INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_privmsgs_folder ADD PRIMARY KEY (folder_id);;

CREATE INDEX phpbb_privmsgs_folder_user_id ON phpbb_privmsgs_folder(user_id);;

CREATE GENERATOR phpbb_privmsgs_folder_gen;;
SET GENERATOR phpbb_privmsgs_folder_gen TO 0;;

CREATE TRIGGER t_phpbb_privmsgs_folder FOR phpbb_privmsgs_folder
BEFORE INSERT
AS
BEGIN
	NEW.folder_id = GEN_ID(phpbb_privmsgs_folder_gen, 1);
END;;


# Table: 'phpbb_privmsgs_rules'
CREATE TABLE phpbb_privmsgs_rules (
	rule_id INTEGER NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	rule_check INTEGER DEFAULT 0 NOT NULL,
	rule_connection INTEGER DEFAULT 0 NOT NULL,
	rule_string VARCHAR(255) DEFAULT '' NOT NULL,
	rule_user_id INTEGER DEFAULT 0 NOT NULL,
	rule_group_id INTEGER DEFAULT 0 NOT NULL,
	rule_action INTEGER DEFAULT 0 NOT NULL,
	rule_folder_id INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_privmsgs_rules ADD PRIMARY KEY (rule_id);;

CREATE INDEX phpbb_privmsgs_rules_user_id ON phpbb_privmsgs_rules(user_id);;

CREATE GENERATOR phpbb_privmsgs_rules_gen;;
SET GENERATOR phpbb_privmsgs_rules_gen TO 0;;

CREATE TRIGGER t_phpbb_privmsgs_rules FOR phpbb_privmsgs_rules
BEFORE INSERT
AS
BEGIN
	NEW.rule_id = GEN_ID(phpbb_privmsgs_rules_gen, 1);
END;;


# Table: 'phpbb_privmsgs_to'
CREATE TABLE phpbb_privmsgs_to (
	msg_id INTEGER DEFAULT 0 NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	author_id INTEGER DEFAULT 0 NOT NULL,
	pm_deleted INTEGER DEFAULT 0 NOT NULL,
	pm_new INTEGER DEFAULT 1 NOT NULL,
	pm_unread INTEGER DEFAULT 1 NOT NULL,
	pm_replied INTEGER DEFAULT 0 NOT NULL,
	pm_marked INTEGER DEFAULT 0 NOT NULL,
	pm_forwarded INTEGER DEFAULT 0 NOT NULL,
	folder_id INTEGER DEFAULT 0 NOT NULL
);;

CREATE INDEX phpbb_privmsgs_to_msg_id ON phpbb_privmsgs_to(msg_id);;
CREATE INDEX phpbb_privmsgs_to_author_id ON phpbb_privmsgs_to(author_id);;
CREATE INDEX phpbb_privmsgs_to_usr_flder_id ON phpbb_privmsgs_to(user_id, folder_id);;

# Table: 'phpbb_profile_fields'
CREATE TABLE phpbb_profile_fields (
	field_id INTEGER NOT NULL,
	field_name VARCHAR(255) DEFAULT '' NOT NULL,
	field_type INTEGER DEFAULT 0 NOT NULL,
	field_ident VARCHAR(20) DEFAULT '' NOT NULL,
	field_length VARCHAR(20) DEFAULT '' NOT NULL,
	field_minlen VARCHAR(255) DEFAULT '' NOT NULL,
	field_maxlen VARCHAR(255) DEFAULT '' NOT NULL,
	field_novalue VARCHAR(255) DEFAULT '' NOT NULL,
	field_default_value VARCHAR(255) DEFAULT '' NOT NULL,
	field_validation VARCHAR(20) DEFAULT '' NOT NULL,
	field_required INTEGER DEFAULT 0 NOT NULL,
	field_show_on_reg INTEGER DEFAULT 0 NOT NULL,
	field_hide INTEGER DEFAULT 0 NOT NULL,
	field_no_view INTEGER DEFAULT 0 NOT NULL,
	field_active INTEGER DEFAULT 0 NOT NULL,
	field_order INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_profile_fields ADD PRIMARY KEY (field_id);;

CREATE INDEX phpbb_profile_fields_fld_type ON phpbb_profile_fields(field_type);;
CREATE INDEX phpbb_profile_fields_fld_ordr ON phpbb_profile_fields(field_order);;

CREATE GENERATOR phpbb_profile_fields_gen;;
SET GENERATOR phpbb_profile_fields_gen TO 0;;

CREATE TRIGGER t_phpbb_profile_fields FOR phpbb_profile_fields
BEFORE INSERT
AS
BEGIN
	NEW.field_id = GEN_ID(phpbb_profile_fields_gen, 1);
END;;


# Table: 'phpbb_profile_fields_data'
CREATE TABLE phpbb_profile_fields_data (
	user_id INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_profile_fields_data ADD PRIMARY KEY (user_id);;


# Table: 'phpbb_profile_fields_lang'
CREATE TABLE phpbb_profile_fields_lang (
	field_id INTEGER DEFAULT 0 NOT NULL,
	lang_id INTEGER DEFAULT 0 NOT NULL,
	option_id INTEGER DEFAULT 0 NOT NULL,
	field_type INTEGER DEFAULT 0 NOT NULL,
	lang_value VARCHAR(255) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_profile_fields_lang ADD PRIMARY KEY (field_id, lang_id, option_id);;


# Table: 'phpbb_profile_lang'
CREATE TABLE phpbb_profile_lang (
	field_id INTEGER DEFAULT 0 NOT NULL,
	lang_id INTEGER DEFAULT 0 NOT NULL,
	lang_name VARCHAR(255) DEFAULT '' NOT NULL,
	lang_explain BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	lang_default_value VARCHAR(255) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_profile_lang ADD PRIMARY KEY (field_id, lang_id);;


# Table: 'phpbb_ranks'
CREATE TABLE phpbb_ranks (
	rank_id INTEGER NOT NULL,
	rank_title VARCHAR(255) DEFAULT '' NOT NULL,
	rank_min INTEGER DEFAULT 0 NOT NULL,
	rank_special INTEGER DEFAULT 0 NOT NULL,
	rank_image VARCHAR(255) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_ranks ADD PRIMARY KEY (rank_id);;


CREATE GENERATOR phpbb_ranks_gen;;
SET GENERATOR phpbb_ranks_gen TO 0;;

CREATE TRIGGER t_phpbb_ranks FOR phpbb_ranks
BEFORE INSERT
AS
BEGIN
	NEW.rank_id = GEN_ID(phpbb_ranks_gen, 1);
END;;


# Table: 'phpbb_reports'
CREATE TABLE phpbb_reports (
	report_id INTEGER NOT NULL,
	reason_id INTEGER DEFAULT 0 NOT NULL,
	post_id INTEGER DEFAULT 0 NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	user_notify INTEGER DEFAULT 0 NOT NULL,
	report_closed INTEGER DEFAULT 0 NOT NULL,
	report_time INTEGER DEFAULT 0 NOT NULL,
	report_text BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_reports ADD PRIMARY KEY (report_id);;


CREATE GENERATOR phpbb_reports_gen;;
SET GENERATOR phpbb_reports_gen TO 0;;

CREATE TRIGGER t_phpbb_reports FOR phpbb_reports
BEFORE INSERT
AS
BEGIN
	NEW.report_id = GEN_ID(phpbb_reports_gen, 1);
END;;


# Table: 'phpbb_reports_reasons'
CREATE TABLE phpbb_reports_reasons (
	reason_id INTEGER NOT NULL,
	reason_title VARCHAR(255) DEFAULT '' NOT NULL,
	reason_description BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	reason_order INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_reports_reasons ADD PRIMARY KEY (reason_id);;


CREATE GENERATOR phpbb_reports_reasons_gen;;
SET GENERATOR phpbb_reports_reasons_gen TO 0;;

CREATE TRIGGER t_phpbb_reports_reasons FOR phpbb_reports_reasons
BEFORE INSERT
AS
BEGIN
	NEW.reason_id = GEN_ID(phpbb_reports_reasons_gen, 1);
END;;


# Table: 'phpbb_search_results'
CREATE TABLE phpbb_search_results (
	search_key VARCHAR(32) DEFAULT '' NOT NULL,
	search_time INTEGER DEFAULT 0 NOT NULL,
	search_keywords BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	search_authors BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_search_results ADD PRIMARY KEY (search_key);;


# Table: 'phpbb_search_wordlist'
CREATE TABLE phpbb_search_wordlist (
	word_id INTEGER NOT NULL,
	word_text VARCHAR(252) CHARACTER SET UNICODE_FSS DEFAULT '' NOT NULL,
	word_common INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_search_wordlist ADD PRIMARY KEY (word_id);;

CREATE UNIQUE INDEX phpbb_search_wordlist_wrd_txt ON phpbb_search_wordlist(word_text);;

CREATE GENERATOR phpbb_search_wordlist_gen;;
SET GENERATOR phpbb_search_wordlist_gen TO 0;;

CREATE TRIGGER t_phpbb_search_wordlist FOR phpbb_search_wordlist
BEFORE INSERT
AS
BEGIN
	NEW.word_id = GEN_ID(phpbb_search_wordlist_gen, 1);
END;;


# Table: 'phpbb_search_wordmatch'
CREATE TABLE phpbb_search_wordmatch (
	post_id INTEGER DEFAULT 0 NOT NULL,
	word_id INTEGER DEFAULT 0 NOT NULL,
	title_match INTEGER DEFAULT 0 NOT NULL
);;

CREATE INDEX phpbb_search_wordmatch_word_id ON phpbb_search_wordmatch(word_id);;
CREATE INDEX phpbb_search_wordmatch_post_id ON phpbb_search_wordmatch(post_id);;

# Table: 'phpbb_sessions'
CREATE TABLE phpbb_sessions (
	session_id CHAR(32) DEFAULT '' NOT NULL,
	session_user_id INTEGER DEFAULT 0 NOT NULL,
	session_last_visit INTEGER DEFAULT 0 NOT NULL,
	session_start INTEGER DEFAULT 0 NOT NULL,
	session_time INTEGER DEFAULT 0 NOT NULL,
	session_ip VARCHAR(40) DEFAULT '' NOT NULL,
	session_browser VARCHAR(150) DEFAULT '' NOT NULL,
	session_page VARCHAR(255) DEFAULT '' NOT NULL,
	session_viewonline INTEGER DEFAULT 1 NOT NULL,
	session_autologin INTEGER DEFAULT 0 NOT NULL,
	session_admin INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_sessions ADD PRIMARY KEY (session_id);;

CREATE INDEX phpbb_sessions_session_time ON phpbb_sessions(session_time);;
CREATE INDEX phpbb_sessions_session_user_id ON phpbb_sessions(session_user_id);;

# Table: 'phpbb_sessions_keys'
CREATE TABLE phpbb_sessions_keys (
	key_id CHAR(32) DEFAULT '' NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	last_ip VARCHAR(40) DEFAULT '' NOT NULL,
	last_login INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_sessions_keys ADD PRIMARY KEY (key_id, user_id);;

CREATE INDEX phpbb_sessions_keys_last_login ON phpbb_sessions_keys(last_login);;

# Table: 'phpbb_sitelist'
CREATE TABLE phpbb_sitelist (
	site_id INTEGER NOT NULL,
	site_ip VARCHAR(40) DEFAULT '' NOT NULL,
	site_hostname VARCHAR(255) DEFAULT '' NOT NULL,
	ip_exclude INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_sitelist ADD PRIMARY KEY (site_id);;


CREATE GENERATOR phpbb_sitelist_gen;;
SET GENERATOR phpbb_sitelist_gen TO 0;;

CREATE TRIGGER t_phpbb_sitelist FOR phpbb_sitelist
BEFORE INSERT
AS
BEGIN
	NEW.site_id = GEN_ID(phpbb_sitelist_gen, 1);
END;;


# Table: 'phpbb_smilies'
CREATE TABLE phpbb_smilies (
	smiley_id INTEGER NOT NULL,
	code VARCHAR(50) DEFAULT '' NOT NULL,
	emotion VARCHAR(50) DEFAULT '' NOT NULL,
	smiley_url VARCHAR(50) DEFAULT '' NOT NULL,
	smiley_width INTEGER DEFAULT 0 NOT NULL,
	smiley_height INTEGER DEFAULT 0 NOT NULL,
	smiley_order INTEGER DEFAULT 0 NOT NULL,
	display_on_posting INTEGER DEFAULT 1 NOT NULL
);;

ALTER TABLE phpbb_smilies ADD PRIMARY KEY (smiley_id);;

CREATE INDEX phpbb_smilies_display_on_post ON phpbb_smilies(display_on_posting);;

CREATE GENERATOR phpbb_smilies_gen;;
SET GENERATOR phpbb_smilies_gen TO 0;;

CREATE TRIGGER t_phpbb_smilies FOR phpbb_smilies
BEFORE INSERT
AS
BEGIN
	NEW.smiley_id = GEN_ID(phpbb_smilies_gen, 1);
END;;


# Table: 'phpbb_styles'
CREATE TABLE phpbb_styles (
	style_id INTEGER NOT NULL,
	style_name VARCHAR(252) DEFAULT '' NOT NULL,
	style_copyright VARCHAR(255) DEFAULT '' NOT NULL,
	style_active INTEGER DEFAULT 1 NOT NULL,
	template_id INTEGER DEFAULT 0 NOT NULL,
	theme_id INTEGER DEFAULT 0 NOT NULL,
	imageset_id INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_styles ADD PRIMARY KEY (style_id);;

CREATE UNIQUE INDEX phpbb_styles_style_name ON phpbb_styles(style_name);;
CREATE INDEX phpbb_styles_template_id ON phpbb_styles(template_id);;
CREATE INDEX phpbb_styles_theme_id ON phpbb_styles(theme_id);;
CREATE INDEX phpbb_styles_imageset_id ON phpbb_styles(imageset_id);;

CREATE GENERATOR phpbb_styles_gen;;
SET GENERATOR phpbb_styles_gen TO 0;;

CREATE TRIGGER t_phpbb_styles FOR phpbb_styles
BEFORE INSERT
AS
BEGIN
	NEW.style_id = GEN_ID(phpbb_styles_gen, 1);
END;;


# Table: 'phpbb_styles_template'
CREATE TABLE phpbb_styles_template (
	template_id INTEGER NOT NULL,
	template_name VARCHAR(252) DEFAULT '' NOT NULL,
	template_copyright VARCHAR(255) DEFAULT '' NOT NULL,
	template_path VARCHAR(100) DEFAULT '' NOT NULL,
	bbcode_bitfield CHAR(255) DEFAULT '' NOT NULL,
	template_storedb INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_styles_template ADD PRIMARY KEY (template_id);;

CREATE UNIQUE INDEX phpbb_styles_template_tmplte_nm ON phpbb_styles_template(template_name);;

CREATE GENERATOR phpbb_styles_template_gen;;
SET GENERATOR phpbb_styles_template_gen TO 0;;

CREATE TRIGGER t_phpbb_styles_template FOR phpbb_styles_template
BEFORE INSERT
AS
BEGIN
	NEW.template_id = GEN_ID(phpbb_styles_template_gen, 1);
END;;


# Table: 'phpbb_styles_template_data'
CREATE TABLE phpbb_styles_template_data (
	template_id INTEGER NOT NULL,
	template_filename VARCHAR(100) DEFAULT '' NOT NULL,
	template_included BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	template_mtime INTEGER DEFAULT 0 NOT NULL,
	template_data BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL
);;

CREATE INDEX phpbb_styles_template_data_tid ON phpbb_styles_template_data(template_id);;
CREATE INDEX phpbb_styles_template_data_tfn ON phpbb_styles_template_data(template_filename);;

CREATE GENERATOR phpbb_styles_template_data_gen;;
SET GENERATOR phpbb_styles_template_data_gen TO 0;;

CREATE TRIGGER t_phpbb_styles_template_data FOR phpbb_styles_template_data
BEFORE INSERT
AS
BEGIN
	NEW.template_id = GEN_ID(phpbb_styles_template_data_gen, 1);
END;;


# Table: 'phpbb_styles_theme'
CREATE TABLE phpbb_styles_theme (
	theme_id INTEGER NOT NULL,
	theme_name VARCHAR(252) DEFAULT '' NOT NULL,
	theme_copyright VARCHAR(255) DEFAULT '' NOT NULL,
	theme_path VARCHAR(100) DEFAULT '' NOT NULL,
	theme_storedb INTEGER DEFAULT 0 NOT NULL,
	theme_mtime INTEGER DEFAULT 0 NOT NULL,
	theme_data BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_styles_theme ADD PRIMARY KEY (theme_id);;

CREATE UNIQUE INDEX phpbb_styles_theme_theme_name ON phpbb_styles_theme(theme_name);;

CREATE GENERATOR phpbb_styles_theme_gen;;
SET GENERATOR phpbb_styles_theme_gen TO 0;;

CREATE TRIGGER t_phpbb_styles_theme FOR phpbb_styles_theme
BEFORE INSERT
AS
BEGIN
	NEW.theme_id = GEN_ID(phpbb_styles_theme_gen, 1);
END;;


# Table: 'phpbb_styles_imageset'
CREATE TABLE phpbb_styles_imageset (
	imageset_id INTEGER NOT NULL,
	imageset_name VARCHAR(252) DEFAULT '' NOT NULL,
	imageset_copyright VARCHAR(255) DEFAULT '' NOT NULL,
	imageset_path VARCHAR(100) DEFAULT '' NOT NULL,
	site_logo VARCHAR(200) DEFAULT '' NOT NULL,
	upload_bar VARCHAR(200) DEFAULT '' NOT NULL,
	poll_left VARCHAR(200) DEFAULT '' NOT NULL,
	poll_center VARCHAR(200) DEFAULT '' NOT NULL,
	poll_right VARCHAR(200) DEFAULT '' NOT NULL,
	icon_friend VARCHAR(200) DEFAULT '' NOT NULL,
	icon_foe VARCHAR(200) DEFAULT '' NOT NULL,
	forum_link VARCHAR(200) DEFAULT '' NOT NULL,
	forum_read VARCHAR(200) DEFAULT '' NOT NULL,
	forum_read_locked VARCHAR(200) DEFAULT '' NOT NULL,
	forum_read_subforum VARCHAR(200) DEFAULT '' NOT NULL,
	forum_unread VARCHAR(200) DEFAULT '' NOT NULL,
	forum_unread_locked VARCHAR(200) DEFAULT '' NOT NULL,
	forum_unread_subforum VARCHAR(200) DEFAULT '' NOT NULL,
	topic_moved VARCHAR(200) DEFAULT '' NOT NULL,
	topic_read VARCHAR(200) DEFAULT '' NOT NULL,
	topic_read_mine VARCHAR(200) DEFAULT '' NOT NULL,
	topic_read_hot VARCHAR(200) DEFAULT '' NOT NULL,
	topic_read_hot_mine VARCHAR(200) DEFAULT '' NOT NULL,
	topic_read_locked VARCHAR(200) DEFAULT '' NOT NULL,
	topic_read_locked_mine VARCHAR(200) DEFAULT '' NOT NULL,
	topic_unread VARCHAR(200) DEFAULT '' NOT NULL,
	topic_unread_mine VARCHAR(200) DEFAULT '' NOT NULL,
	topic_unread_hot VARCHAR(200) DEFAULT '' NOT NULL,
	topic_unread_hot_mine VARCHAR(200) DEFAULT '' NOT NULL,
	topic_unread_locked VARCHAR(200) DEFAULT '' NOT NULL,
	topic_unread_locked_mine VARCHAR(200) DEFAULT '' NOT NULL,
	sticky_read VARCHAR(200) DEFAULT '' NOT NULL,
	sticky_read_mine VARCHAR(200) DEFAULT '' NOT NULL,
	sticky_read_locked VARCHAR(200) DEFAULT '' NOT NULL,
	sticky_read_locked_mine VARCHAR(200) DEFAULT '' NOT NULL,
	sticky_unread VARCHAR(200) DEFAULT '' NOT NULL,
	sticky_unread_mine VARCHAR(200) DEFAULT '' NOT NULL,
	sticky_unread_locked VARCHAR(200) DEFAULT '' NOT NULL,
	sticky_unread_locked_mine VARCHAR(200) DEFAULT '' NOT NULL,
	announce_read VARCHAR(200) DEFAULT '' NOT NULL,
	announce_read_mine VARCHAR(200) DEFAULT '' NOT NULL,
	announce_read_locked VARCHAR(200) DEFAULT '' NOT NULL,
	announce_read_locked_mine VARCHAR(200) DEFAULT '' NOT NULL,
	announce_unread VARCHAR(200) DEFAULT '' NOT NULL,
	announce_unread_mine VARCHAR(200) DEFAULT '' NOT NULL,
	announce_unread_locked VARCHAR(200) DEFAULT '' NOT NULL,
	announce_unread_locked_mine VARCHAR(200) DEFAULT '' NOT NULL,
	global_read VARCHAR(200) DEFAULT '' NOT NULL,
	global_read_mine VARCHAR(200) DEFAULT '' NOT NULL,
	global_read_locked VARCHAR(200) DEFAULT '' NOT NULL,
	global_read_locked_mine VARCHAR(200) DEFAULT '' NOT NULL,
	global_unread VARCHAR(200) DEFAULT '' NOT NULL,
	global_unread_mine VARCHAR(200) DEFAULT '' NOT NULL,
	global_unread_locked VARCHAR(200) DEFAULT '' NOT NULL,
	global_unread_locked_mine VARCHAR(200) DEFAULT '' NOT NULL,
	pm_read VARCHAR(200) DEFAULT '' NOT NULL,
	pm_unread VARCHAR(200) DEFAULT '' NOT NULL,
	icon_contact_aim VARCHAR(200) DEFAULT '' NOT NULL,
	icon_contact_email VARCHAR(200) DEFAULT '' NOT NULL,
	icon_contact_icq VARCHAR(200) DEFAULT '' NOT NULL,
	icon_contact_jabber VARCHAR(200) DEFAULT '' NOT NULL,
	icon_contact_msnm VARCHAR(200) DEFAULT '' NOT NULL,
	icon_contact_pm VARCHAR(200) DEFAULT '' NOT NULL,
	icon_contact_yahoo VARCHAR(200) DEFAULT '' NOT NULL,
	icon_contact_www VARCHAR(200) DEFAULT '' NOT NULL,
	icon_post_delete VARCHAR(200) DEFAULT '' NOT NULL,
	icon_post_edit VARCHAR(200) DEFAULT '' NOT NULL,
	icon_post_info VARCHAR(200) DEFAULT '' NOT NULL,
	icon_post_quote VARCHAR(200) DEFAULT '' NOT NULL,
	icon_post_report VARCHAR(200) DEFAULT '' NOT NULL,
	icon_post_target VARCHAR(200) DEFAULT '' NOT NULL,
	icon_post_target_unread VARCHAR(200) DEFAULT '' NOT NULL,
	icon_topic_attach VARCHAR(200) DEFAULT '' NOT NULL,
	icon_topic_latest VARCHAR(200) DEFAULT '' NOT NULL,
	icon_topic_newest VARCHAR(200) DEFAULT '' NOT NULL,
	icon_topic_reported VARCHAR(200) DEFAULT '' NOT NULL,
	icon_topic_unapproved VARCHAR(200) DEFAULT '' NOT NULL,
	icon_user_online VARCHAR(200) DEFAULT '' NOT NULL,
	icon_user_offline VARCHAR(200) DEFAULT '' NOT NULL,
	icon_user_profile VARCHAR(200) DEFAULT '' NOT NULL,
	icon_user_search VARCHAR(200) DEFAULT '' NOT NULL,
	icon_user_warn VARCHAR(200) DEFAULT '' NOT NULL,
	button_pm_forward VARCHAR(200) DEFAULT '' NOT NULL,
	button_pm_new VARCHAR(200) DEFAULT '' NOT NULL,
	button_pm_reply VARCHAR(200) DEFAULT '' NOT NULL,
	button_topic_locked VARCHAR(200) DEFAULT '' NOT NULL,
	button_topic_new VARCHAR(200) DEFAULT '' NOT NULL,
	button_topic_reply VARCHAR(200) DEFAULT '' NOT NULL,
	user_icon1 VARCHAR(200) DEFAULT '' NOT NULL,
	user_icon2 VARCHAR(200) DEFAULT '' NOT NULL,
	user_icon3 VARCHAR(200) DEFAULT '' NOT NULL,
	user_icon4 VARCHAR(200) DEFAULT '' NOT NULL,
	user_icon5 VARCHAR(200) DEFAULT '' NOT NULL,
	user_icon6 VARCHAR(200) DEFAULT '' NOT NULL,
	user_icon7 VARCHAR(200) DEFAULT '' NOT NULL,
	user_icon8 VARCHAR(200) DEFAULT '' NOT NULL,
	user_icon9 VARCHAR(200) DEFAULT '' NOT NULL,
	user_icon10 VARCHAR(200) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_styles_imageset ADD PRIMARY KEY (imageset_id);;

CREATE UNIQUE INDEX phpbb_styles_imageset_imgset_nm ON phpbb_styles_imageset(imageset_name);;

CREATE GENERATOR phpbb_styles_imageset_gen;;
SET GENERATOR phpbb_styles_imageset_gen TO 0;;

CREATE TRIGGER t_phpbb_styles_imageset FOR phpbb_styles_imageset
BEFORE INSERT
AS
BEGIN
	NEW.imageset_id = GEN_ID(phpbb_styles_imageset_gen, 1);
END;;


# Table: 'phpbb_topics'
CREATE TABLE phpbb_topics (
	topic_id INTEGER NOT NULL,
	forum_id INTEGER DEFAULT 0 NOT NULL,
	icon_id INTEGER DEFAULT 0 NOT NULL,
	topic_attachment INTEGER DEFAULT 0 NOT NULL,
	topic_approved INTEGER DEFAULT 1 NOT NULL,
	topic_reported INTEGER DEFAULT 0 NOT NULL,
	topic_title BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	topic_poster INTEGER DEFAULT 0 NOT NULL,
	topic_time INTEGER DEFAULT 0 NOT NULL,
	topic_time_limit INTEGER DEFAULT 0 NOT NULL,
	topic_views INTEGER DEFAULT 0 NOT NULL,
	topic_replies INTEGER DEFAULT 0 NOT NULL,
	topic_replies_real INTEGER DEFAULT 0 NOT NULL,
	topic_status INTEGER DEFAULT 0 NOT NULL,
	topic_type INTEGER DEFAULT 0 NOT NULL,
	topic_first_post_id INTEGER DEFAULT 0 NOT NULL,
	topic_first_poster_name VARCHAR(255) DEFAULT '' NOT NULL,
	topic_last_post_id INTEGER DEFAULT 0 NOT NULL,
	topic_last_poster_id INTEGER DEFAULT 0 NOT NULL,
	topic_last_poster_name VARCHAR(255) DEFAULT '' NOT NULL,
	topic_last_post_time INTEGER DEFAULT 0 NOT NULL,
	topic_last_view_time INTEGER DEFAULT 0 NOT NULL,
	topic_moved_id INTEGER DEFAULT 0 NOT NULL,
	topic_bumped INTEGER DEFAULT 0 NOT NULL,
	topic_bumper INTEGER DEFAULT 0 NOT NULL,
	poll_title BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	poll_start INTEGER DEFAULT 0 NOT NULL,
	poll_length INTEGER DEFAULT 0 NOT NULL,
	poll_max_options INTEGER DEFAULT 1 NOT NULL,
	poll_last_vote INTEGER DEFAULT 0 NOT NULL,
	poll_vote_change INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_topics ADD PRIMARY KEY (topic_id);;

CREATE INDEX phpbb_topics_forum_id ON phpbb_topics(forum_id);;
CREATE INDEX phpbb_topics_forum_id_type ON phpbb_topics(forum_id, topic_type);;
CREATE INDEX phpbb_topics_last_post_time ON phpbb_topics(topic_last_post_time);;
CREATE INDEX phpbb_topics_fid_time_moved ON phpbb_topics(forum_id, topic_last_post_time, topic_moved_id);;

CREATE GENERATOR phpbb_topics_gen;;
SET GENERATOR phpbb_topics_gen TO 0;;

CREATE TRIGGER t_phpbb_topics FOR phpbb_topics
BEFORE INSERT
AS
BEGIN
	NEW.topic_id = GEN_ID(phpbb_topics_gen, 1);
END;;


# Table: 'phpbb_topics_track'
CREATE TABLE phpbb_topics_track (
	user_id INTEGER DEFAULT 0 NOT NULL,
	topic_id INTEGER DEFAULT 0 NOT NULL,
	forum_id INTEGER DEFAULT 0 NOT NULL,
	mark_time INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_topics_track ADD PRIMARY KEY (user_id, topic_id);;

CREATE INDEX phpbb_topics_track_forum_id ON phpbb_topics_track(forum_id);;

# Table: 'phpbb_topics_posted'
CREATE TABLE phpbb_topics_posted (
	user_id INTEGER DEFAULT 0 NOT NULL,
	topic_id INTEGER DEFAULT 0 NOT NULL,
	topic_posted INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_topics_posted ADD PRIMARY KEY (user_id, topic_id);;


# Table: 'phpbb_topics_watch'
CREATE TABLE phpbb_topics_watch (
	topic_id INTEGER DEFAULT 0 NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	notify_status INTEGER DEFAULT 0 NOT NULL
);;

CREATE INDEX phpbb_topics_watch_topic_id ON phpbb_topics_watch(topic_id);;
CREATE INDEX phpbb_topics_watch_user_id ON phpbb_topics_watch(user_id);;
CREATE INDEX phpbb_topics_watch_notify_stat ON phpbb_topics_watch(notify_status);;

# Table: 'phpbb_user_group'
CREATE TABLE phpbb_user_group (
	group_id INTEGER DEFAULT 0 NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	group_leader INTEGER DEFAULT 0 NOT NULL,
	user_pending INTEGER DEFAULT 1 NOT NULL
);;

CREATE INDEX phpbb_user_group_group_id ON phpbb_user_group(group_id);;
CREATE INDEX phpbb_user_group_user_id ON phpbb_user_group(user_id);;
CREATE INDEX phpbb_user_group_group_leader ON phpbb_user_group(group_leader);;

# Table: 'phpbb_users'
CREATE TABLE phpbb_users (
	user_id INTEGER NOT NULL,
	user_type INTEGER DEFAULT 0 NOT NULL,
	group_id INTEGER DEFAULT 3 NOT NULL,
	user_permissions BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	user_perm_from INTEGER DEFAULT 0 NOT NULL,
	user_ip VARCHAR(40) DEFAULT '' NOT NULL,
	user_regdate INTEGER DEFAULT 0 NOT NULL,
	username VARCHAR(252) DEFAULT '' NOT NULL,
	user_password VARCHAR(40) DEFAULT '' NOT NULL,
	user_passchg INTEGER DEFAULT 0 NOT NULL,
	user_email VARCHAR(100) DEFAULT '' NOT NULL,
	user_email_hash DOUBLE PRECISION DEFAULT 0 NOT NULL,
	user_birthday VARCHAR(10) DEFAULT '' NOT NULL,
	user_lastvisit INTEGER DEFAULT 0 NOT NULL,
	user_lastmark INTEGER DEFAULT 0 NOT NULL,
	user_lastpost_time INTEGER DEFAULT 0 NOT NULL,
	user_lastpage VARCHAR(200) DEFAULT '' NOT NULL,
	user_last_confirm_key VARCHAR(10) DEFAULT '' NOT NULL,
	user_last_search INTEGER DEFAULT 0 NOT NULL,
	user_warnings INTEGER DEFAULT 0 NOT NULL,
	user_last_warning INTEGER DEFAULT 0 NOT NULL,
	user_login_attempts INTEGER DEFAULT 0 NOT NULL,
	user_posts INTEGER DEFAULT 0 NOT NULL,
	user_lang VARCHAR(30) DEFAULT '' NOT NULL,
	user_timezone DOUBLE PRECISION DEFAULT 0 NOT NULL,
	user_dst INTEGER DEFAULT 0 NOT NULL,
	user_dateformat VARCHAR(30) DEFAULT 'd M Y H:i' NOT NULL,
	user_style INTEGER DEFAULT 0 NOT NULL,
	user_rank INTEGER DEFAULT 0 NOT NULL,
	user_colour VARCHAR(6) DEFAULT '' NOT NULL,
	user_new_privmsg INTEGER DEFAULT 0 NOT NULL,
	user_unread_privmsg INTEGER DEFAULT 0 NOT NULL,
	user_last_privmsg INTEGER DEFAULT 0 NOT NULL,
	user_message_rules INTEGER DEFAULT 0 NOT NULL,
	user_full_folder INTEGER DEFAULT -3 NOT NULL,
	user_emailtime INTEGER DEFAULT 0 NOT NULL,
	user_topic_show_days INTEGER DEFAULT 0 NOT NULL,
	user_topic_sortby_type VARCHAR(1) DEFAULT 't' NOT NULL,
	user_topic_sortby_dir VARCHAR(1) DEFAULT 'd' NOT NULL,
	user_post_show_days INTEGER DEFAULT 0 NOT NULL,
	user_post_sortby_type VARCHAR(1) DEFAULT 't' NOT NULL,
	user_post_sortby_dir VARCHAR(1) DEFAULT 'a' NOT NULL,
	user_notify INTEGER DEFAULT 0 NOT NULL,
	user_notify_pm INTEGER DEFAULT 1 NOT NULL,
	user_notify_type INTEGER DEFAULT 0 NOT NULL,
	user_allow_pm INTEGER DEFAULT 1 NOT NULL,
	user_allow_email INTEGER DEFAULT 1 NOT NULL,
	user_allow_viewonline INTEGER DEFAULT 1 NOT NULL,
	user_allow_viewemail INTEGER DEFAULT 1 NOT NULL,
	user_allow_massemail INTEGER DEFAULT 1 NOT NULL,
	user_options INTEGER DEFAULT 893 NOT NULL,
	user_avatar VARCHAR(255) DEFAULT '' NOT NULL,
	user_avatar_type INTEGER DEFAULT 0 NOT NULL,
	user_avatar_width INTEGER DEFAULT 0 NOT NULL,
	user_avatar_height INTEGER DEFAULT 0 NOT NULL,
	user_sig BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	user_sig_bbcode_uid VARCHAR(5) DEFAULT '' NOT NULL,
	user_sig_bbcode_bitfield CHAR(255) DEFAULT '' NOT NULL,
	user_from VARCHAR(100) DEFAULT '' NOT NULL,
	user_icq VARCHAR(15) DEFAULT '' NOT NULL,
	user_aim VARCHAR(255) DEFAULT '' NOT NULL,
	user_yim VARCHAR(255) DEFAULT '' NOT NULL,
	user_msnm VARCHAR(255) DEFAULT '' NOT NULL,
	user_jabber VARCHAR(255) DEFAULT '' NOT NULL,
	user_website VARCHAR(200) DEFAULT '' NOT NULL,
	user_occ VARCHAR(255) DEFAULT '' NOT NULL,
	user_interests BLOB SUB_TYPE TEXT DEFAULT '' NOT NULL,
	user_actkey VARCHAR(32) DEFAULT '' NOT NULL,
	user_newpasswd VARCHAR(32) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_users ADD PRIMARY KEY (user_id);;

CREATE INDEX phpbb_users_user_birthday ON phpbb_users(user_birthday);;
CREATE INDEX phpbb_users_user_email_hash ON phpbb_users(user_email_hash);;
CREATE INDEX phpbb_users_user_type ON phpbb_users(user_type);;
CREATE INDEX phpbb_users_username ON phpbb_users(username);;

CREATE GENERATOR phpbb_users_gen;;
SET GENERATOR phpbb_users_gen TO 0;;

CREATE TRIGGER t_phpbb_users FOR phpbb_users
BEFORE INSERT
AS
BEGIN
	NEW.user_id = GEN_ID(phpbb_users_gen, 1);
END;;


# Table: 'phpbb_warnings'
CREATE TABLE phpbb_warnings (
	warning_id INTEGER NOT NULL,
	user_id INTEGER DEFAULT 0 NOT NULL,
	post_id INTEGER DEFAULT 0 NOT NULL,
	log_id INTEGER DEFAULT 0 NOT NULL,
	warning_time INTEGER DEFAULT 0 NOT NULL
);;

ALTER TABLE phpbb_warnings ADD PRIMARY KEY (warning_id);;


CREATE GENERATOR phpbb_warnings_gen;;
SET GENERATOR phpbb_warnings_gen TO 0;;

CREATE TRIGGER t_phpbb_warnings FOR phpbb_warnings
BEFORE INSERT
AS
BEGIN
	NEW.warning_id = GEN_ID(phpbb_warnings_gen, 1);
END;;


# Table: 'phpbb_words'
CREATE TABLE phpbb_words (
	word_id INTEGER NOT NULL,
	word VARCHAR(255) DEFAULT '' NOT NULL,
	replacement VARCHAR(255) DEFAULT '' NOT NULL
);;

ALTER TABLE phpbb_words ADD PRIMARY KEY (word_id);;


CREATE GENERATOR phpbb_words_gen;;
SET GENERATOR phpbb_words_gen TO 0;;

CREATE TRIGGER t_phpbb_words FOR phpbb_words
BEFORE INSERT
AS
BEGIN
	NEW.word_id = GEN_ID(phpbb_words_gen, 1);
END;;


# Table: 'phpbb_zebra'
CREATE TABLE phpbb_zebra (
	user_id INTEGER DEFAULT 0 NOT NULL,
	zebra_id INTEGER DEFAULT 0 NOT NULL,
	friend INTEGER DEFAULT 0 NOT NULL,
	foe INTEGER DEFAULT 0 NOT NULL
);;

CREATE INDEX phpbb_zebra_user_id ON phpbb_zebra(user_id);;
CREATE INDEX phpbb_zebra_zebra_id ON phpbb_zebra(zebra_id);;

# Trigger for phpbb_forums bitfields
CREATE TRIGGER t_phpbb_forums_desc_bitf FOR phpbb_forums
ACTIVE BEFORE INSERT OR UPDATE POSITION 0
AS
BEGIN
	IF (NEW.forum_desc_bitfield is null) THEN
		NEW.forum_desc_bitfield = ASCII_CHAR(0);
END;;

CREATE TRIGGER t_phpbb_forums_rules_bitf FOR phpbb_forums
ACTIVE BEFORE INSERT OR UPDATE POSITION 0
AS
BEGIN
	IF (NEW.forum_rules_bitfield is null) THEN
		NEW.forum_rules_bitfield = ASCII_CHAR(0);
END;;

# Trigger for phpbb_groups bitfields
CREATE TRIGGER t_phpbb_groups_bitf FOR phpbb_groups
ACTIVE BEFORE INSERT OR UPDATE POSITION 0
AS
BEGIN
	IF (NEW.group_desc_bitfield is null) THEN
		NEW.group_desc_bitfield = ASCII_CHAR(0);
END;;

# Trigger for phpbb_posts bitfields
CREATE TRIGGER t_phpbb_posts_bitf FOR phpbb_posts
ACTIVE BEFORE INSERT OR UPDATE POSITION 0
AS
BEGIN
	IF (NEW.bbcode_bitfield is null) THEN
		NEW.bbcode_bitfield = ASCII_CHAR(0);
END;;

# Trigger for phpbb_privmsgs bitfields
CREATE TRIGGER t_phpbb_privmsgs_bitf FOR phpbb_privmsgs
ACTIVE BEFORE INSERT OR UPDATE POSITION 0
AS
BEGIN
	IF (NEW.bbcode_bitfield is null) THEN
		NEW.bbcode_bitfield = ASCII_CHAR(0);
END;;

# Trigger for phpbb_styles_template bitfields
CREATE TRIGGER t_phpbb_styles_template_bitf FOR phpbb_styles_template
ACTIVE BEFORE INSERT OR UPDATE POSITION 0
AS
BEGIN
	IF (NEW.bbcode_bitfield is null) THEN
		NEW.bbcode_bitfield = ASCII_CHAR(144) || ASCII_CHAR(216);
END;;

# Trigger for phpbb_users bitfields
CREATE TRIGGER t_phpbb_users_bitf FOR phpbb_users
ACTIVE BEFORE INSERT OR UPDATE POSITION 0
AS
BEGIN
	IF (NEW.user_sig_bbcode_bitfield is null) THEN
		NEW.user_sig_bbcode_bitfield = ASCII_CHAR(0);
END;;