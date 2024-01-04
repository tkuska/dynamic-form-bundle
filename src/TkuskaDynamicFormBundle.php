<?php

namespace Tkuska\DynamicFormBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TkuskaDynamicFormBundle extends Bundle
{

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
