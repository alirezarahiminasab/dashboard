<?php

namespace Edumall_Elementor;

use Elementor\Group_Control_Base;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor tooltip control.
 *
 * A base control for creating tooltip control.
 *
 * @since 1.0.0
 */
class Group_Control_Tooltip extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'tooltip';
	}

	protected function init_fields() {
		$fields = [];

		$fields['skin'] = [
			'label'   => esc_html__( 'Tooltip Skin', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				''        => esc_html__( 'Black', 'edumall' ),
				'white'   => esc_html__( 'White', 'edumall' ),
				'primary' => esc_html__( 'Primary', 'edumall' ),
			],
			'default' => '',
		];

		$fields['position'] = [
			'label'   => esc_html__( 'Tooltip Position', 'edumall' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'top'          => esc_html__( 'Top', 'edumall' ),
				'right'        => esc_html__( 'Right', 'edumall' ),
				'bottom'       => esc_html__( 'Bottom', 'edumall' ),
				'left'         => esc_html__( 'Left', 'edumall' ),
				'top-left'     => esc_html__( 'Top Left', 'edumall' ),
				'top-right'    => esc_html__( 'Top Right', 'edumall' ),
				'bottom-left'  => esc_html__( 'Bottom Left', 'edumall' ),
				'bottom-right' => esc_html__( 'Bottom Right', 'edumall' ),
			],
			'default' => 'top',
		];

		return $fields;
	}

	protected function get_default_options() {
		return [
			'popover' => [
				'starter_title' => _x( 'Tooltip', 'Tooltip Control', 'edumall' ),
				'starter_name'  => 'enable',
				'starter_value' => 'yes',
				'settings'      => [
					'render_type' => 'template',
				],
			],
		];
	}
}
