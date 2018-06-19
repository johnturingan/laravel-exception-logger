<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 15/03/2018
 * Time: 1:24 PM
 */

namespace Snp\Logger\Providers;

use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\GelfMessageFormatter;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\GelfHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonoLogger;
use Snp\Logger\Logger;


/**
 * Class UnifiedLogLumenProvider
 * @package Snp\Logger\Providers
 */
class LumenProvider extends ServiceProvider
{

    /**
     * Boot Up Provider
     */
    public function boot ()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__.'/../config/logging.php', 'logging'
        );

        $this->app->singleton('snp_e_log', function (){

            $transport = new UdpTransport(
                config('logging.connection.host'),
                config('logging.connection.port'),
                UdpTransport::CHUNK_MAX_COUNT
            );

            $publisher = new Publisher($transport);

            return new Logger($this->app->environment(), [
                $this->prepareHandler(new GelfHandler($publisher), new GelfMessageFormatter())
            ]);

        });

        $this->app->singleton('base-monolog', function (){

            $method = 'configure'.ucfirst($this->app->make('config')->get('logging.log')).'Handler';

            return new MonoLogger($this->app->environment(), [
                $this->prepareHandler($this->{$method}(), new LineFormatter(null, null, true, true))
            ]);

        });

    }

    /**
     * Prepare the handler for usage by Monolog.
     *
     * @param  \Monolog\Handler\HandlerInterface $handler
     * @param FormatterInterface $formatter
     * @return HandlerInterface
     */
    protected function prepareHandler(HandlerInterface $handler, FormatterInterface $formatter)
    {
        return $handler->setFormatter($formatter);
    }

    /**
     * @return StreamHandler
     */
    private function configureDailyHandler ()
    {

        $max = $this->app->make('config')->get('logging.log_max_files', 5 );

        return new RotatingFileHandler(
            $this->app->storagePath().'/logs/'. $this->app->make('config')->get('logging.file_name' ),
            $max,
            $this->app->make('config')->get('logging.log_level', 'debug')
        );
    }

    /**
     * @return StreamHandler
     */
    private function configureSingleHandler ()
    {

        return new StreamHandler(
            $this->app->storagePath().'/logs/'. $this->app->make('config')->get('logging.file_name' ),
            $this->app->make('config')->get('logging.log_level', 'debug')
        );

    }

}