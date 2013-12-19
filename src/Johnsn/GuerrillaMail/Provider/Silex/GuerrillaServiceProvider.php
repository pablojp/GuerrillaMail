<?php
/**
 * Created by PhpStorm.
 * User: nicholasjohns
 * Date: 12/19/13
 * Time: 9:27 PM
 */

namespace Johnsn\GuerrillaMail\Provider\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Johnsn\GuerrillaMail\GuerrillaMail as GuerrillaClient;
use Johnsn\GuerrillaMail\GuerrillaConnect\CurlConnection as GuerrillaConnection;

/**
 * Symfony Routing component Provider for URL generation.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class GuerrillaServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['gm.client_ip'] = $_SERVER['REMOTE_ADDR'];

        $app['gm.connection'] = $app->share(function($app) {
            return new GuerrillaConnection($app['gm.client_ip']);
        });

        $app['gm.client'] = $app->share(function ($app) {
            return new GuerrillaClient($app['gm.connection']);
        });
    }

    public function boot(Application $app)
    {
    }
}
