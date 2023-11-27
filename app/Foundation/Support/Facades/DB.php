<?php

namespace App\Foundation\Support\Facades;

use App\Foundation\Database\DatabaseManager;

/**
 * Database Facade for interacting with the underlying database service.
 */
class DB extends Facade
{
    /**
     * Get the registered binding by name
     *
     * @return string
     */
    protected static function getServiceBinding(): string { return DatabaseManager::class; }
}