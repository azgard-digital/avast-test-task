<?php
declare(strict_types=1);

namespace App;

interface Storage
{
    public function addSubdomain(string $value): ?int;

    public function addCookie(string $key, string $value): void;
}