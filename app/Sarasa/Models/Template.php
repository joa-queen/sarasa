<?php

namespace Sarasa\Models;

class Template extends \Sarasa\Core\Template
{
    public function __construct($full = true)
    {
        parent::__construct($full);

        # Declare plugins for template if necessary
    }
}
