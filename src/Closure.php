<?php

namespace panlatent\craft\actions\bundle;

use panlatent\craft\actions\abstract\Action;
use panlatent\craft\actions\abstract\ContextInterface;

class Closure extends Action
{
    public ?\Closure $closure = null;

    protected function execute(ContextInterface $context): bool
    {
        if ($this->closure) {
            $this->closure($context);
        }
        return true;
    }
}