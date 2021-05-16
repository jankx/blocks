<?php
use Jankx\Blocks\BlocksManager;

if (class_exists(BlocksManager::class)) {
    BlocksManager::getInstance();
}
