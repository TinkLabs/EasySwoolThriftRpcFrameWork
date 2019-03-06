namespace go Proto.Obj
namespace php Proto.Obj

/**
* * 规 范
* namespace最后一个单词需与service名一致
* service命名需大写开头 + 驼峰命名法
* 每个thrift中只允许有一个service
* 可以有多个function、struct
*
* 生成对应语言命令:
* thrift -r -out ../ --gen go obj.thrift
* thrift -r -out ../ --gen php:server obj.thrift
**/

struct ObjReq {
    1: string msg;
}

struct ObjRes {
    1: string msg;
}

service Obj {
    ObjRes echo(1: ObjReq req);
}