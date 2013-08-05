<?php

namespace Sarasa\Models;

class Template extends \Sarasa\Core\Template
{
    public function __construct($full = true)
    {
        parent::__construct($full);

        # Declare plugins for template if necessary
    }

    public function cache()
    {
        if (\Sarasa\Core\FrontController::config('production')) {
            $this->setCaching(parent::CACHING_LIFETIME_SAVED);
            $this->setCacheLifetime(\Sarasa\Core\FrontController::config('cache_lifetime'));
            $this->setCompileCheck(false);
        }
    }
}
