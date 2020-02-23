<?php

namespace App\tests\Validator;

use App\Validator\EmailDomain;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

class EmailDomainValidatorTest extends TestCase
{
    public function testRequiredParamaters()
    {
        $this->expectException(MissingOptionsException::class);
        new EmailDomain();
    }

    public function testBadShapeParameters()
    {
        $this->expectException(ConstraintDefinitionException::class);
        new EmailDomain(['blocked' => "zza"]);
    }

    public function testOptionIsSetProperty()
    {
        $arr=["a","nb"];
        $domain = new EmailDomain(['blocked'=>$arr]);
        $this->assertEquals($arr,$domain->blocked);
    }
}
