<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest0000()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Jørgen');
        $response->assertSeeText('Peter');
    }

    public function testBasicTest0001()
    {
        $response = $this->get('/invoices');

        $response->assertStatus(200);
        $response->assertSeeText('Invoices');
        $response->assertDontSeeText('invoices');

        $response->assertSeeText('Due');
        $response->assertSeeText('Amount');
        $response->assertSeeText('Customer');
    }

    public function testBasicTest0002()
    {
        $response = $this->get('/invoices/1');

        $response->assertStatus(404);
    }

    public function testBasicTest0003()
    {
        $response = $this->get('/customer/3');

        $response->assertStatus(404);
    }

    public function testBasicTest0004()
    {
        $response = $this->get('/customer/invoice/1');

        $response->assertRedirect('/customer/1');
    }
}
