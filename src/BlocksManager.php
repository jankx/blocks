<?php
namespace Jankx\Blocks;

use Jankx;

if (!class_exists(BlocksManager::class)) {
    class BlocksManager
    {
        protected static $instance;

        public static function getInstance()
        {
            if (is_null(static::$instance)) {
                static::$instance = new static();
            }
            return static::$instance;
        }

        private function __construct()
        {
            /**
             * Create block closure for Jankx class
             */
            $jankxInstance  = Jankx::instance();
            $blocksInstance = &$this;

            $jankxInstance->blocks  = function () use ($blocksInstance) {
                return $blocksInstance;
            };

            $this->init_hooks();
        }

        protected function init_hooks()
        {
            $postType = new PostType();
            add_action('init', array($postType, 'register_post_type'));
            add_filter(
                'jankx_template_page_pre_content',
                array($this, 'renderBlockContent'),
                10,
                3
            );
            add_filter(
                'jankx_template_page_template_names',
                array($this, 'filterBlockTemplates')
            );
        }

        public function filterBlockTemplates($templates)
        {
            if (in_array('single-jankx_block', (array)$templates)) {
                return 'single-blank';
            }
            return $templates;
        }

        public function renderBlockContent($pre, $context, $templates) {
            if ('single' !== $context ) {
                return $pre;
            }
            return get_the_content();
        }
    }
}
