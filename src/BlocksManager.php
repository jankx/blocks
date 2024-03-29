<?php
namespace Jankx\Blocks;

use Jankx;
use Jankx\Blocks\WordPress\Widget;

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
                'jankx/template/site/content/pre',
                array($this, 'renderBlockContent'),
                10,
                3
            );
            add_filter(
                'jankx/template/page/template_names',
                array($this, 'filterBlockTemplates')
            );
            add_action('widgets_init', array($this, 'registerWidget'));
        }

        public function filterBlockTemplates($templates)
        {
            if (in_array('single-jankx_block', (array)$templates)) {
                return 'single-blank';
            }
            return $templates;
        }

        public function renderBlockContent($pre, $context, $templates)
        {
            if (!in_array('single-jankx_block', (array)$templates)) {
                return $pre;
            }
            ob_start();

            the_content();

            return ob_get_clean();
        }

        public function registerWidget()
        {
            register_widget(Widget::class);
        }
    }
}
