namespace go Proto.Test
namespace php Proto.Test

/**
* * 规 范
* namespace最后一个单词需与service名一致
* service命名需大写开头 + 驼峰命名法
* 每个thrift中只允许有一个service
* 可以有多个function、struct
*
* 生成对应语言命令: thrift版本需一致
* thrift -r -out ../ --gen go test.thrift
* thrift -r -out ../ --gen php:server test.thrift
**/

service Test{
    string sendMessage(1:string msg)
}
