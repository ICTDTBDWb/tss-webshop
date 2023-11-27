<?php


use JetBrains\PhpStorm\NoReturn;

if (!function_exists('dd')) {
    /**
     * Dumps the provided data and dies
     *
     * @param mixed $data
     *
     * @return void
     */
    #[NoReturn] function dd(mixed $data): void
    {
        print("<pre>");
        var_dump($data);
        print("</pre>");
        die();
    }
}