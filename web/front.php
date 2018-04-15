<?php
require_once __DIR__ . '/../vendor/autoload.php';

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require_once __DIR__ . '' . '/../src/Pipe/container.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;

$request = Request::createFromGlobals();
$routes = include __DIR__ . '/../src/routes.php';

$context = new Routing\RequestContext();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$controllerResolver = new HttpKernel\Controller\ControllerResolver();
$argumentResolver = new HttpKernel\Controller\ArgumentResolver();

$framework = new Pipe\Framework($container, $matcher, $controllerResolver, $argumentResolver);

$framework->handle($request)->send();
