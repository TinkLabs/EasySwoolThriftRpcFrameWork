# EasySwoolThriftRpcFrameWork

基于Swoole和Thrift的RPC开发框架。

## Getting Started

```
composer install
php server start
```
## Generated thrift files
```
thrift -r -out ../ --gen php:server test.thrift
```