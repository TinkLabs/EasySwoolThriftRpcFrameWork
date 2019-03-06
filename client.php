<?php
require_once __DIR__ . '/vendor/autoload.php';

//$timeout = 10;
$socket = new \Thrift\Transport\TSocket('127.0.0.1', 9501);
//$socket->setSendTimeout($timeout * 1000);
//$socket->setRecvTimeout($timeout * 1000);

$transport = new \Thrift\Transport\TFramedTransport($socket);
$protocol = new \Thrift\Protocol\TBinaryProtocol($transport);
$transport->open();

$testInput = new \Thrift\Protocol\TMultiplexedProtocol($protocol, "Test");
$testClient = new \Proto\Test\TestClient($testInput);

$echoInput = new \Thrift\Protocol\TMultiplexedProtocol($protocol, "Obj");
$echoClient = new \Proto\Obj\ObjClient($echoInput);


// 调用接口方法
$test = $testClient->sendMessage('php test');
echo date('Y-m-d H:i:s') . ' response: ' . $test . PHP_EOL;

$echo = $echoClient->echo(new \Proto\Obj\ObjReq(['msg' => "I'm php client"]));
echo date('Y-m-d H:i:s') . ' response: ' . $echo->msg . PHP_EOL;

$transport->close();