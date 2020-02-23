<?php

namespace App\tests\Controller;

use App\Entity\Status;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class StatusEntityTest extends WebTestCase
{
    public function getEntity() {
        return (new Status())
        ->setCode("123")
        ->setCreatedAt(new DateTime());
    }
    
    public function assertHasErrors($count , Status $status){

        self::bootKernel();
        $errors=self::$container->get("validator")->validate($status);
        $messages=[];
        /**@var ConstraintViolation $error */
        foreach($errors as $error){
            $messages[] = $error->getPropertyPath() ." => ".$error->getMessage();
        }
        $this->assertCount($count,$errors, implode(",",$messages));
    }
    public function testValidCodeEntity()
    {
        $status= $this->getEntity();
        $this->assertHasErrors(0,$status);
       
    }
    public function testInvalidCodeEntity()
    {
        $status= $this->getEntity();
        $status->setCode("40a");
        $this->assertHasErrors(1,$status);
       
    }

   
}
