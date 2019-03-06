<?php

namespace EasySwoole\EasySwoole;

use Thrift\Server\TServer;

/**
 * Class TSwooleServer
 * @property TSwooleServerTransport $transport_
 */
class TSwooleServer extends TServer
{
    /**
     * Serves the server. This should never return
     * unless a problem permits it to do so or it
     * is interrupted intentionally
     *
     * @return void
     */
    public function serve()
    {
        // TODO: Implement serve() method.
    }

    public function onReceive(\swoole_server $server, $fd, $reactorId, $data)
    {
        /** @var TSwooleTransport $transport */
        $transport = $this->transport_->accept();
        $transport->setServer($server);
        $transport->setNetFD($fd);
        $transport->setData($data);
        $inputTransport = $this->inputTransportFactory_->getTransport($transport);
        $outputTransport = $this->outputTransportFactory_->getTransport($transport);
        $inputProtocol = $this->inputProtocolFactory_->getProtocol($inputTransport);
        $outputProtocol = $this->outputProtocolFactory_->getProtocol($outputTransport);
        try {
            $this->processor_->process($inputProtocol, $outputProtocol);
        } catch (\Exception $e) {
            $log = "remote call error: " . $e->getCode() . '--msg:' . $e->getMessage() . PHP_EOL . $e->getTraceAsString();
            Logger::getInstance()->log($log, 'ReceiveError');
        }
    }

    /**
     * Stops the server serving
     *
     * @return void
     */
    public function stop()
    {
        // TODO: Implement stop() method.
        $this->transport_->close();
    }
}