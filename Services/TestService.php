<?php
namespace Services;


use Proto\Test\TestIf;

class TestService implements TestIf
{
    function sendMessage($msg)
    {
        echo "TestService: $msg \n";
        return "well received from " . $msg;
    }
}