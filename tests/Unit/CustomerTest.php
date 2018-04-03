<?php

namespace Tests\Unit;

use App\Agreement;
use App\Customer;
use App\Delivery;
use App\Invoice;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\CustomerController;

class CustomerTest extends TestCase
{
    /**
     * @var Customer
     */
    private $customer;

    public function setUp()
    {
        parent::setUp();

        $this->customer = factory(Customer::class)->create([
            'name' => 'Søren Petersen',
            'agreement_id' => factory(\App\Agreement::class)->create([
                'unit_price' => 12.00,
                'type' => Agreement::TYPE_WEEKLY,
            ])->id,
        ]);

        factory(Delivery::class)->create([
            'delivered_at' => Carbon::now()->subDays(3),
            'count' => 5,
            'customer_id' => $this->customer->id,
        ]);
        factory(Delivery::class)->create([
            'delivered_at' => Carbon::now()->subDays(8),
            'count' => 2,
            'customer_id' => $this->customer->id,
        ]);
        factory(Delivery::class)->create([
            'delivered_at' => Carbon::now()->subDays(80),
            'count' => 1,
            'customer_id' => $this->customer->id,
        ]);

        $this->customer2 = factory(Customer::class)->create([
            'name' => 'Søren Petersen',
            'agreement_id' => factory(\App\Agreement::class)->create([
                'unit_price' => 12.00,
                'type' => Agreement::TYPE_MONTHLY,
            ])->id,
        ]);

        factory(Delivery::class)->create([
            'delivered_at' => Carbon::now()->subDays(3),
            'count' => 5,
            'customer_id' => $this->customer2->id,
        ]);
        factory(Delivery::class)->create([
            'delivered_at' => Carbon::now()->subDays(8),
            'count' => 2,
            'customer_id' => $this->customer2->id,
        ]);
        factory(Delivery::class)->create([
            'delivered_at' => Carbon::now()->subDays(80),
            'count' => 1,
            'customer_id' => $this->customer2->id,
        ]);
    }

    public function testCreateWeeklyInvoice()
    {
        $this->customer->agreement->type = Agreement::TYPE_WEEKLY;

        $custCrtl = new CustomerController();
        $invoice = $custCrtl->CreateInvoice($this->customer->id);

        $this->assertEquals(60,$invoice->amount);
    }

    public function testCreateMonthlyInvoice()
    {
        $this->customer->agreement->type = Agreement::TYPE_MONTHLY;

        $custCrtl = new CustomerController();
        $invoice = $custCrtl->CreateInvoice($this->customer2->id);

        $this->assertEquals(84,$invoice->amount);
    }
}
