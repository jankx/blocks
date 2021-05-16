<?php
namespace Jankx\Blocks;

class PostType
{
    const BLOCK_POST_TYPE = 'jankx_block';

    public function register_post_type()
    {
        $labels = array(
            'name' => __('Blocks', 'jankx'),
            'add_new_item' => __('Add New Block', 'jankx'),
        );

        register_post_type(static::BLOCK_POST_TYPE, apply_filters('jankx_blocks_post_type_args', array(
            'public' => true,
            'labels' => $labels,
        )));
    }
}
