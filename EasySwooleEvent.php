<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;

use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Factory\TTransportFactory;
use Thrift\TMultiplexedProcessor;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        $conf = Config::getInstance()->getConf('MAIN_SERVER');
        $transport = new TSwooleServerTransport($conf['LISTEN_ADDRESS'], $conf['PORT'], $conf['SETTING']);

        $outFactory = $inFactory = new TTransportFactory();
        $outProtocol = $inProtocol = new TBinaryProtocolFactory(true, true);

        $tServer = new TSwooleServer(self::registerProcessor(), $transport, $inFactory, $outFactory, $inProtocol, $outProtocol);
        $register->add($register::onReceive, [$tServer, 'onReceive']);
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }

    private static function registerProcessor(): TMultiplexedProcessor
    {
        $multiplexedProcessor = new TMultiplexedProcessor();
        foreach (glob(__DIR__ . '/Services/*Service.php') as $serviceFile) {
            $serviceClass = 'Services\\' . basename($serviceFile, '.php');
            $serviceName = basename($serviceFile, 'Service.php');
            $processorClass = 'Proto\\' . $serviceName . '\\' . $serviceName . 'Processor';
            $processor = new $processorClass(new $serviceClass);
            $multiplexedProcessor->registerProcessor($serviceName, $processor);
        }
        return $multiplexedProcessor;
    }
}