<?php
declare(strict_types=1);

namespace App;

interface Parser
{
    public function export(): iterable;
}