<?php

namespace organic_widget_area;

/**
 * Class WidgetArea
 * @package organic_widget_area
 */
class WidgetArea {

	/**
	 * Block Name.
	 */
	private static $block_name = 'organic/widget-area';

	/**
	 * Options setting name.
	 */
	private static $option_name = 'organic_widget-area';

	/**
	 * WidgetArea constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_widget_block' ], 0 );
		add_action( 'widgets_init', [ $this, 'register_widget_sidebar' ], 0 );
		add_action( 'enqueue_block_editor_assets', [ $this, 'load_scripts' ], 10 );
		add_action( 'save_post', [ $this, 'update_widgets_log' ], 10, 3 );
		add_action( 'delete_post', [ $this, 'delete_widgets_log' ], 10 );
	}

	/**
	 * Register widget block type.
	 */
	public function register_widget_block() {
		register_block_type( self::$block_name, [
			'attributes'      => [
				'widget_area_title' => [
					'type'    => 'string',
					'default' => '',
				],
			],
			'render_callback' => [ $this, 'render_widget_area' ],
		] );
	}

	/**
	 * Load JS and CSS scripts for Block
	 */
	public function load_scripts() {
		// Scripts.
		wp_enqueue_script(
			Utilities::get_prefix() . 'block-admin-js',
			Utilities::get_block_js( 'dist/blocks.build.js' ),
			[ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' ],
			Utilities::get_version()
		);

		// Styles.
		wp_enqueue_style(
			Utilities::get_prefix() . 'block-admin-style',
			Utilities::get_block_css( 'dist/blocks.style.build.css' ),
			[ 'wp-edit-blocks' ],
			Utilities::get_version()
		);
		wp_enqueue_style(
			Utilities::get_prefix() . 'block-admin-editor',
			Utilities::get_block_css( 'dist/blocks.editor.build.css' ),
			[ 'wp-edit-blocks' ],
			Utilities::get_version()
		);
	}

	/**
	 * Callback for block render.
	 *
	 * @param array $attribute
	 */
	public function render_widget_area( $attribute ) {

		ob_start();

		$widget_area_title = $attribute['widget_area_title'];

		dynamic_sidebar( sanitize_title( $widget_area_title ) );

		$output = ob_get_clean();

		return $output;
	}

	/**
	 * Load widgets area for all pages/posts.
	 */
	public function register_widget_sidebar() {

		$saved_widgets = get_option( self::$option_name, [] );

		if ( ! empty( $saved_widgets ) ) {
			foreach ( $saved_widgets as $post_id => $widgets ) {
				if ( false !== get_post_status( $post_id ) ) {
					foreach ( $widgets as $widget_name ) {
						if ( '' !== trim( $widget_name ) ) {
							$side_bar_id = register_sidebar(
								array(
									'name'          => __( $widget_name, 'organic-widget-area' ),
									'id'            => sanitize_title( $widget_name ),
									'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'organic-widget-area' ),
									'before_widget' => '<div id="%1$s" class="organic-widget widget %2$s">',
									'after_widget'  => '</div>',
									'before_title'  => '<h2 class="widget-title">',
									'after_title'   => '</h2>',
								)
							);
						}
					}
				}
			}
		}

	}

	/**
	 * Save newly added widgets in options on post save.
	 *
	 * @param int    $post_id post id.
	 * @param object $post
	 * @param string $update
	 */
	public function update_widgets_log( $post_id, $post, $update ) {
		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		$saved_widgets = get_option( self::$option_name, [] );

		$blocks = parse_blocks( $post->post_content );
		if ( isset( $saved_widgets[ $post_id ] ) ) {
			unset( $saved_widgets[ $post_id ] );
		}

		if ( ! empty( $blocks ) ) {
			foreach ( $blocks as $block ) {
				if ( isset( $block['blockName'] ) && self::$block_name === $block['blockName'] ) {
					if ( '' !== trim( $block['attrs']['widget_area_title'] ) ) {
						$saved_widgets[ $post_id ][] = $block['attrs']['widget_area_title'];
					}
				}
			}
		}

		update_option( self::$option_name, $saved_widgets, true );

	}

	/**
	 * Update when a post deleted for widgets in options.
	 *
	 * @param int    $post_id post id.
	 */
	public function delete_widgets_log( $post_id ) {
		$saved_widgets = get_option( self::$option_name, [] );

		if ( isset( $saved_widgets[ $post_id ] ) ) {
			unset( $saved_widgets[ $post_id ] );
		}

		update_option( self::$option_name, $saved_widgets, true );
	}
}
