<?php

namespace Edumall_Elementor;

use Elementor\Group_Control_Base;
use Elementor\Controls_Manager;

defined('ABSPATH') || exit;

/**
 * Elementor advanced border control.
 *
 * A base control for creating border control. Displays input fields to define
 * border type, border width and border color.
 *
 * @since 1.0.0
 */
class Group_Control_Advanced_Border extends Group_Control_Base
{

	/**
	 * Fields.
	 *
	 * Holds all the border control fields.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @static
	 *
	 * @var array Border control fields.
	 */
	protected static $fields;

	/**
	 * Get border control type.
	 *
	 * Retrieve the control type, in this case `advanced-border`.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 * @return string Control type.
	 */
	public static function get_type()
	{
		return 'advanced-border';
	}

	/**
	 * Init fields.
	 *
	 * Initialize border control fields.
	 *
	 * @since  1.2.2
	 * @access protected
	 *
	 * @return array Control fields.
	 */
	protected function init_fields()
	{
		$fields = [];

		$fields['type'] = [
			'label'     => _x('Type', 'Border Control', 'edumall-child'),
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				''       => __('Default', 'edumall-child'),
				'none'   => __('None', 'edumall-child'),
				'solid'  => _x('Solid', 'Border Control', 'edumall-child'),
				'double' => _x('Double', 'Border Control', 'edumall-child'),
				'dotted' => _x('Dotted', 'Border Control', 'edumall-child'),
				'dashed' => _x('Dashed', 'Border Control', 'edumall-child'),
				'groove' => _x('Groove', 'Border Control', 'edumall-child'),
			],
			'selectors' => [
				'{{SELECTOR}}' => 'border-style: {{VALUE}};',
			],
		];

		$fields['color'] = [
			'label'     => _x('Color', 'Border Control', 'edumall-child'),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{SELECTOR}}' => 'border-color: {{VALUE}};',
			],
		];

		$fields['width'] = [
			'label'      => _x('Width', 'Border Control', 'edumall-child'),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => [
				'{{SELECTOR}}' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'responsive' => true,
		];

		$fields['radius'] = [
			'label'      => _x('Rounded', 'Border Control', 'edumall-child'),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%'],
			'selectors'  => [
				'{{SELECTOR}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		];

		return $fields;
	}

	/**
	 * Get default options.
	 *
	 * Retrieve the default options of the border control. Used to return the
	 * default options while initializing the border control.
	 *
	 * @since  1.9.0
	 * @access protected
	 *
	 * @return array Default border control options.
	 */
	protected function get_default_options()
	{
		return [
			'popover' => [
				'starter_title' => _x('Border', 'Advanced Border Control', 'edumall-child'),
				'starter_name'  => 'enable',
				'starter_value' => 'yes',
				'settings'      => [
					'render_type' => 'ui',
				],
			],
		];
	}
}
