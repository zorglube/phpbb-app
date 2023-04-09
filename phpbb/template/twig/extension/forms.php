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

namespace phpbb\template\twig\extension;

use phpbb\template\twig\environment;
use phpbb\user;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class forms extends AbstractExtension
{
	/** @var user */
	protected $user;

	/**
	 * Constructor.
	 *
	 * @param user	$user			User object
	 */
	public function __construct(user $user)
	{
		$this->user = $user;
	}

	/**
	 * Returns the name of this extension.
	 *
	 * @return string						The extension name
	 */
	public function getName()
	{
		return 'forms';
	}

	/**
	 * Returns a list of functions to add to the existing list.
	 *
	 * @return TwigFunction[]			Array of twig functions
	 */
	public function getFunctions(): array
	{
		return [
			new TwigFunction('FormsBuildTemplate', [$this, 'build_template'], ['needs_environment' => true]),
			new TwigFunction('FormsDimension', [$this, 'dimension'], ['needs_environment' => true]),
			new TwigFunction('FormsInput', [$this, 'input'], ['needs_environment' => true]),
			new TwigFunction('FormsRadioButtons', [$this, 'radio_buttons'], ['needs_environment' => true]),
			new TwigFunction('FormsSelect', [$this, 'select'], ['needs_environment' => true]),
			new TwigFunction('FormsTextarea', [$this, 'textarea'], ['needs_environment' => true]),
		];
	}

	/**
	 * Renders a form template
	 *
	 * @param environment $environment
	 * @param array $form_data
	 *
	 * @return string Rendered form template
	 */
	public function build_template(environment $environment, array $form_data): string
	{
		try
		{
			return $environment->render('macros/forms/build_template.twig', [
				'form_data' => $form_data ?? [],
			]);
		}
		catch (\Twig\Error\Error $e)
		{
			return '';
		}
	}

	/**
	 * Renders form dimension fields
	 *
	 * @param environment $environment The twig environment
	 * @param array $form_data The form data
	 *
	 * @return string Form dimension fields
	 */
	public function dimension(environment $environment, array $form_data): string
	{
		try
		{
			return $environment->render('macros/forms/dimension.twig', [
				'WIDTH'		=> $form_data['width'],
				'HEIGHT'		=> $form_data['height'],
			]);
		}
		catch (\Twig\Error\Error $e)
		{
			return '';
		}
	}

	/**
	 * Renders a form input field
	 *
	 * @param environment	$environment		The twig environment
	 * @param array			$form_data			The form data
	 *
	 * @return string Form input field
	 */
	public function input(environment $environment, array $form_data): string
	{
		try
		{
			return $environment->render('macros/forms/input.twig', [
				'ID'		=> (string) ($form_data['id'] ?? ''),
				'TYPE'		=> (string) $form_data['type'],
				'NAME'		=> (string) $form_data['name'],
				'SIZE'		=> (int) ($form_data['size'] ?? 0),
				'MAXLENGTH'	=> (int) ($form_data['maxlength'] ?? 0),
				'MIN'		=> (int) ($form_data['min'] ?? 0),
				'MAX'		=> (int) ($form_data['max'] ?? 0),
				'STEP'		=> (int) ($form_data['step'] ?? 0),
				'CHECKED'	=> (bool) ($form_data['checked'] ?? false),
				'CLASS'		=> (string) ($form_data['class'] ?? ''),
				'VALUE'		=> (string) ($form_data['value']),
			]);
		}
		catch (\Twig\Error\Error $e)
		{
			return '';
		}
	}

	/**
	 * Renders form radio buttons
	 *
	 * @param environment $environment The twig environment
	 * @param array $form_data The form data
	 *
	 * @return string Form radio buttons
	 */
	public function radio_buttons(environment $environment, array $form_data): string
	{
		try
		{
			return $environment->render('macros/forms/radio_buttons.twig', [
				'FIRST_BUTTON'			=> $form_data['buttons'][0],
				'FIRST_BUTTON_LABEL'	=> $form_data['buttons'][0]['label'],
				'SECOND_BUTTON'			=> $form_data['buttons'][1],
				'SECOND_BUTTON_LABEL'	=> $form_data['buttons'][1]['label'],
			]);
		}
		catch (\Twig\Error\Error $e)
		{
			return '';
		}
	}

	/**
	 * Renders a form select field
	 *
	 * @param environment	$environment		The twig environment
	 * @param array			$form_data			The form data
	 *
	 * @return string Form select field
	 */
	public function select(environment $environment, array $form_data): string
	{
		try
		{
			return $environment->render('macros/forms/select.twig', [
				'ID'			=> (string) ($form_data['id'] ?? ''),
				'CLASS'			=> (string) ($form_data['class'] ?? ''),
				'NAME'			=> (string) $form_data['name'],
				'TOGGLEABLE'	=> (bool) ($form_data['toggleable'] ?? false),
				'OPTIONS'		=> $form_data['options'] ?? [],
				'GROUP_ONLY'	=> (bool) ($form_data['group_only'] ?? false),
			]);
		}
		catch (\Twig\Error\Error $e)
		{
			return '';
		}
	}

	/**
	 * Renders a form textarea field
	 *
	 * @param environment $environment
	 * @param array $form_data
	 *
	 * @return string Form textarea field
	 */
	public function textarea(environment $environment, array $form_data): string
	{
		try
		{
			return $environment->render('macros/forms/textarea.twig', [
				'ID'		=> (string) $form_data['id'],
				'NAME'		=> (string) $form_data['name'],
				'ROWS'		=> (int) $form_data['rows'],
				'COLS'		=> (int) $form_data['cols'],
				'CONTENT'	=> (string) $form_data['content'],
			]);
		}
		catch (\Twig\Error\Error $e)
		{
			return '';
		}
	}
}
