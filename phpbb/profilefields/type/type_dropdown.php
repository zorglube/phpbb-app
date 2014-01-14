<?php
/**
*
* @package phpBB
* @copyright (c) 2014 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace phpbb\profilefields\type;

class type_dropdown implements type_interface
{
	/**
	*
	*/
	public function __construct(\phpbb\profilefields\profilefields $profilefields, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->profilefields = $profilefields;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
	}

	/**
	* {@inheritDoc}
	*/
	public function get_options($default_lang_id, $field_data)
	{
		$profile_row[0] = array(
			'var_name'				=> 'field_default_value',
			'field_id'				=> 1,
			'lang_name'				=> $field_data['lang_name'],
			'lang_explain'			=> $field_data['lang_explain'],
			'lang_id'				=> $default_lang_id,
			'field_default_value'	=> $field_data['field_default_value'],
			'field_ident'			=> 'field_default_value',
			'field_type'			=> FIELD_DROPDOWN,
			'lang_options'			=> $field_data['lang_options']
		);

		$profile_row[1] = $profile_row[0];
		$profile_row[1]['var_name'] = 'field_novalue';
		$profile_row[1]['field_ident'] = 'field_novalue';
		$profile_row[1]['field_default_value']	= $field_data['field_novalue'];

		$options = array(
			0 => array('TITLE' => $this->user->lang['DEFAULT_VALUE'], 'FIELD' => $this->profilefields->process_field_row('preview', $profile_row[0])),
			1 => array('TITLE' => $this->user->lang['NO_VALUE_OPTION'], 'EXPLAIN' => $this->user->lang['NO_VALUE_OPTION_EXPLAIN'], 'FIELD' => $this->profilefields->process_field_row('preview', $profile_row[1]))
		);

		return $options;
	}

	/**
	* {@inheritDoc}
	*/
	public function get_default_option_values()
	{
		return array(
			'field_length'		=> 0,
			'field_minlen'		=> 0,
			'field_maxlen'		=> 5,
			'field_validation'	=> '',
			'field_novalue'		=> 0,
			'field_default_value'	=> 0,
		);
	}

	/**
	* {@inheritDoc}
	*/
	public function get_default_field_value($field_data)
	{
		return $field_data['field_default_value'];
	}

	/**
	* {@inheritDoc}
	*/
	public function get_profile_field($profile_row)
	{
		$var_name = 'pf_' . $profile_row['field_ident'];
		return $this->request->variable($var_name, (int) $profile_row['field_default_value']);
	}

	/**
	* {@inheritDoc}
	*/
	public function validate_profile_field(&$field_value, $field_data)
	{
		$field_value = (int) $field_value;

		// retrieve option lang data if necessary
		if (!isset($this->profilefields->options_lang[$field_data['field_id']]) || !isset($this->profilefields->options_lang[$field_data['field_id']][$field_data['lang_id']]) || !sizeof($this->profilefields->options_lang[$file_data['field_id']][$field_data['lang_id']]))
		{
			$this->profilefields->get_option_lang($field_data['field_id'], $field_data['lang_id'], FIELD_DROPDOWN, false);
		}

		if (!isset($this->profilefields->options_lang[$field_data['field_id']][$field_data['lang_id']][$field_value]))
		{
			return $this->user->lang('FIELD_INVALID_VALUE', $field_data['lang_name']);
		}

		if ($field_value == $field_data['field_novalue'] && $field_data['field_required'])
		{
			return $this->user->lang('FIELD_REQUIRED', $field_data['lang_name']);
		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	public function get_profile_value($field_value, $field_data)
	{
		$field_id = $field_data['field_id'];
		$lang_id = $field_data['lang_id'];
		if (!isset($this->profilefields->options_lang[$field_id][$lang_id]))
		{
			$this->profilefields->get_option_lang($field_id, $lang_id, FIELD_DROPDOWN, false);
		}

		if ($field_value == $field_data['field_novalue'] && !$field_data['field_show_novalue'])
		{
			return null;
		}

		$field_value = (int) $field_value;

		// User not having a value assigned
		if (!isset($this->profilefields->options_lang[$field_id][$lang_id][$field_value]))
		{
			if ($field_data['field_show_novalue'])
			{
				$field_value = $field_data['field_novalue'];
			}
			else
			{
				return null;
			}
		}

		return $this->profilefields->options_lang[$field_id][$lang_id][$field_value];
	}

	/**
	* {@inheritDoc}
	*/
	public function generate_field($profile_row, $preview = false)
	{
		$profile_row['field_ident'] = (isset($profile_row['var_name'])) ? $profile_row['var_name'] : 'pf_' . $profile_row['field_ident'];
		$field_ident = $profile_row['field_ident'];
		$default_value = $profile_row['lang_default_value'];

		$value = ($this->request->is_set($field_ident)) ? $this->request->variable($field_ident, $default_value) : ((!isset($this->user->profile_fields[$field_ident]) || $preview) ? $default_value : $this->user->profile_fields[$field_ident]);

		if (!isset($this->profilefields->options_lang[$profile_row['field_id']]) || !isset($this->profilefields->options_lang[$profile_row['field_id']][$profile_row['lang_id']]) || !sizeof($this->profilefields->options_lang[$profile_row['field_id']][$profile_row['lang_id']]))
		{
			$this->profilefields->get_option_lang($profile_row['field_id'], $profile_row['lang_id'], FIELD_DROPDOWN, $preview);
		}

		$profile_row['field_value'] = (int) $value;
		$this->template->assign_block_vars('dropdown', array_change_key_case($profile_row, CASE_UPPER));

		foreach ($this->profilefields->options_lang[$profile_row['field_id']][$profile_row['lang_id']] as $option_id => $option_value)
		{
			$this->template->assign_block_vars('dropdown.options', array(
				'OPTION_ID'	=> $option_id,
				'SELECTED'	=> ($value == $option_id) ? ' selected="selected"' : '',
				'VALUE'		=> $option_value)
			);
		}
	}

	/**
	* {@inheritDoc}
	*/
	public function get_field_ident($field_data)
	{
		return 'pf_' . $field_data['field_ident'];
	}
}
