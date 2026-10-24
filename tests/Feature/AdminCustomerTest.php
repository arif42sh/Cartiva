<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminCustomerTest extends TestCase
{
    protected User $admin;
    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('role', 'admin')->first();
        $this->customer = User::where('role', 'customer')->first();
    }

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Cartiva Administrator Dashboard');
    }

    public function test_admin_can_view_customers_index(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/customers');
        $response->assertStatus(200);
        $response->assertSee('Customer Management');
        $response->assertSee($this->customer->name);
    }

    public function test_admin_can_filter_customers_by_search(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/customers?q=' . urlencode($this->customer->name));
        $response->assertStatus(200);
        $response->assertSee($this->customer->email);
    }

    public function test_admin_can_view_customer_details(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/customers/' . $this->customer->id);
        $response->assertStatus(200);
        $response->assertSee($this->customer->name);
        $response->assertSee('Customer Profile &amp; Lifecycle', false);
    }

    public function test_admin_can_toggle_customer_suspension_status(): void
    {
        // 1. Suspend customer
        $response = $this->actingAs($this->admin)->post('/admin/customers/' . $this->customer->id . '/toggle-status', [
            'reason' => 'Suspicious fraudulent group activity',
        ]);
        $response->assertRedirect();
        
        $this->customer->refresh();
        $this->assertEquals('suspended', $this->customer->status);
        $this->assertEquals('Suspicious fraudulent group activity', $this->customer->status_reason);

        // 2. Reactivate customer
        $response = $this->actingAs($this->admin)->post('/admin/customers/' . $this->customer->id . '/toggle-status');
        $response->assertRedirect();

        $this->customer->refresh();
        $this->assertEquals('active', $this->customer->status);
        $this->assertNull($this->customer->status_reason);
    }
}
