<?php

namespace App\Tests\Core\Invoice\Domain;

use App\Core\Invoice\Domain\Exception\InvoiceException;
use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Status\InvoiceStatus;
use App\Core\User\Domain\Status\UserStatus;
use App\Core\User\Domain\User;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    public function testConstructor()
    {
        $user = new User('test@test.pl'); 
        $amount = 100;

        $invoice = new Invoice($user, $amount);

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertEquals($user, $invoice->getUser());
        $this->assertEquals($amount, $invoice->getAmount());
        $this->assertEquals(InvoiceStatus::NEW, $invoice->getStatus());

    }

    public function testConstructorWithInvalidAmount()
    {
        $user = new User('test@test.pl'); 
        $amount = 0;

        $this->expectException(InvoiceException::class);
        $this->expectExceptionMessage('Kwota faktury musi być większa od 0');

        new Invoice($user, $amount);
    }

    public function testConstructorWithInactiveUser()
    {
        $user = new User('test@test.pl');
        $user->setStatus(UserStatus::INACTIVE); 
        $amount = 100;

        $this->expectException(InvoiceException::class);
        $this->expectExceptionMessage('Nie można utworzyć faktury dla nieaktywnego użytkownika');

        new Invoice($user, $amount);
    }

}
