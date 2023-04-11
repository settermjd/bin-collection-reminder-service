<?php

declare(strict_types=1);

use App\Handler\SubscribeConfirmationHandler;
use App\Handler\SubscribeFormHandler;
use App\Handler\SubscribeProcessorHandler;
use App\Handler\UnsubscribeConfirmationHandler;
use App\Handler\UnsubscribeFormHandler;
use App\Handler\UnsubscribeProcessorHandler;
use Mezzio\Application;
use Mezzio\Flash\FlashMessageMiddleware;
use Mezzio\MiddlewareFactory;
use Mezzio\Session\SessionMiddleware;
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
    $app->get(
        '/',
        [
            SessionMiddleware::class,
            FlashMessageMiddleware::class,
            SubscribeFormHandler::class,
        ],
        'home'
    );
    $app->post(
        '/subscribe',
        [
            SessionMiddleware::class,
            FlashMessageMiddleware::class,
            SubscribeProcessorHandler::class,
        ],
        'subscribe.processor'
    );
    $app->get(
        '/subscribe/confirmation',
        [
            SessionMiddleware::class,
            FlashMessageMiddleware::class,
            SubscribeConfirmationHandler::class,
        ],
        'subscribe.confirmation'
    );

    // Unsubscribe routes
    $app->get(
        '/unsubscribe',
        [
            SessionMiddleware::class,
            FlashMessageMiddleware::class,
            UnsubscribeFormHandler::class,
        ],
        'unsubscribe.form');
    $app->post(
        '/unsubscribe',
        [
            SessionMiddleware::class,
            FlashMessageMiddleware::class,
            UnsubscribeProcessorHandler::class,
        ],
        'unsubscribe.processor'
    );
    $app->get(
        '/unsubscribe/confirmation',
        [
            SessionMiddleware::class,
            FlashMessageMiddleware::class,
            UnsubscribeConfirmationHandler::class,
        ],
        'unsubscribe.confirmation'
    );

    // Static routes
    $app->get('/privacy', StaticPagesHandler::class, 'static.privacy');
    $app->get('/terms', StaticPagesHandler::class, 'static.terms');

    // Health routes
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');
};
