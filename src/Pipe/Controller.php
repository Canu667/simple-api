<?php

namespace Pipe;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

abstract class Controller implements ContainerAwareInterface
{
    use ContainerAwareTrait;
}
