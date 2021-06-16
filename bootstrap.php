<?php
use Jankx\Blocks\BlocksManager;
use Elementor\Plugin as Elementor;

if (class_exists(BlocksManager::class)) {
    BlocksManager::getInstance();
}

/**
 * Create block positions
 */
add_action('jankx_template_before_header', 'jankx_block_top_ads');
function jankx_block_top_ads()
{
    $elementor = Elementor::instance();
    echo $elementor->frontend->get_builder_content_for_display( 25 );
}
