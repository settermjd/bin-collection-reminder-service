<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;
use Settermjd\StaticPages\Handler\StaticPagesHandler;

/**
 * FastRoute route configuration
 *
 * @see https://github.com/nikic/FastRoute
 *
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\SubscribeFormHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/{id:\d+}', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    // Subscribe routes
    $app->get('/', App\Handler\SubscribeFormHandler::class, 'home');
    $app->post('/subscribe', \App\Handler\SubscribeProcessorHandler::class, 'subscribe.processor');
    $app->get('/subscribe/confirmation', \App\Handler\SubscribeConfirmationHandler::class, 'subscribe.confirmation');

    // Unsubscribe routes
    $app->get('/unsubscribe', \App\Handler\UnsubscribeFormHandler::class, 'unsubscribe.form');
    $app->post('/unsubscribe', \App\Handler\UnsubscribeProcessorHandler::class, 'unsubscribe.processor');
    $app->get('/unsubscribe/confirmation', \App\Handler\UnsubscribeConfirmationHandler::class, 'unsubscribe.confirmation');

    // Static routes
    $app->get('/privacy', StaticPagesHandler::class, 'static.privacy');
    $app->get('/terms', StaticPagesHandler::class, 'static.terms');

    // Health routes
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');
};
