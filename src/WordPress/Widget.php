<?php
namespace Jankx\Blocks\WordPress;

use WP_Widget;
use Jankx;
use Jankx\Blocks\PostType;
use Elementor\Plugin;

/**
 * WordPress Widget use to load Jankx Blocks
 */

class Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'jankx-blocks',
            sprintf('%s %s', Jankx::templateName(), __('Blocks')),
            array(
                'classname' => 'jankx-blocks',
                'description' => sprintf(__('Load %s blocks as widget', 'jankx_blocks'), Jankx::templateName()),
            )
        );
    }

    protected function get_blocks()
    {
        return get_posts(array(
            'post_type' => PostType::BLOCK_POST_TYPE,
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ));
    }

    public function form($instances)
    {
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('jankx-blocks'); ?>"></label>
            <select class="widefat" name="<?php echo $this->get_field_name('jankx_block'); ?>" id="<?php echo $this->get_field_id('jankx-blocks'); ?>">
                <option value=""><?php echo __('Choose block', 'jankx_blocks'); ?></option>
                <?php foreach ($this->get_blocks() as $block) : ?>
                    <option value="<?php echo $block->ID; ?>"><?php echo $block->post_title; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    public function widget($args, $instance)
    {
        $block = get_post(array_get($instance, 'jankx_block'));
        if (!$block) {
            return;
        }

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'];
                echo $instance['title'];
            echo $args['after_title'];
        }

        if (class_exists(Plugin::class)) {
            $elementor = Plugin::instance();
            if ($elementor->db->is_built_with_elementor($block->ID)) {
                echo $elementor->frontend->get_builder_content_for_display($block->ID);

                echo $args['after_widget'];
                return;
            }
        }
            echo apply_filters('the_content', $block->post_content);
        echo $args['after_widget'];
    }
}
