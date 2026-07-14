<?php

// @ToDo: revisar, verificar um local melhor para inicializar a sessão
if (getenv('ENVIRONMENT') == 'DOCKER') {
    ini_set('session.save_handler', 'redis');
    ini_set('session.save_path', 'tcp://redis:6379?prefix=cooper_leite_dev_');
}

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/core/basics.php';
require_once __DIR__ . '/../src/routes.php';

if (class_exists(\OpenTelemetry\API\Globals::class)) {
    $propagator = \OpenTelemetry\API\Trace\Propagation\TraceContextPropagator::getInstance();
    $context = $propagator->extract($_SERVER);

    $tracer = \OpenTelemetry\API\Globals::tracerProvider()->getTracer('cooper-leite');
    $span = $tracer->spanBuilder($_SERVER['REQUEST_METHOD'] . ' ' . ($_SERVER['REQUEST_URI'] ?? '/'))
        ->setParent($context)
        ->setSpanKind(\OpenTelemetry\API\Trace\SpanKind::KIND_SERVER)
        ->startSpan();
    $spanScope = $span->activate();

    try {
        $router->run($router->routes);
    } catch (\Throwable $e) {
        $span->recordException($e);
        $span->setStatus(\OpenTelemetry\API\Trace\StatusCode::STATUS_ERROR, $e->getMessage());
        throw $e;
    } finally {
        $span->end();
        $spanScope->detach();
    }
} else {
    $router->run($router->routes);
}
