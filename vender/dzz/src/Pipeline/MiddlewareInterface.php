<?php

namespace Dzz\Pipeline;

interface MiddlewareInterface
{
    public function handle($passable, $next);
}