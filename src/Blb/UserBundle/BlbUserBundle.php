<?php

namespace Blb\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BlbUserBundle extends Bundle
{
    public function getParent()
    {
      return 'FOSUserBundle';
    }
}
