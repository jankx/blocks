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
            $jankxInstance  = Jankx::getInstance();
            $blocksInstance = &$this;
            $jankx->blocks  = function () use ($blocksInstance) {
                return $blocksInstance;
            };
        }
    }

    BlocksManager::getInstance();
}
