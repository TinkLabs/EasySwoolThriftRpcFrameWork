<?php
namespace Services;

use Proto\Obj\ObjIf;
use Proto\Obj\ObjReq;
use Proto\Obj\ObjRes;

class ObjService implements ObjIf
{
    public function echo(ObjReq $req)
    {
        // TODO: Implement echo() method.
        echo "ObjService: $req->msg \n";

        return new ObjRes(['msg' => 'success']);
    }

}