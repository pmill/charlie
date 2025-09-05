<?php

namespace Feature\Http\Controllers\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customers_are_listed()
    {
        $user = User::factory(1)
            ->hasCustomers(30)
            ->create()
            ->first();

        $this->actingAs($user);

        $response = $this->get('/customers?page=1&limit=10&sort=name&direction=asc&search=');
        $response->assertStatus(200);

        $customerNames = $user->customers()->orderBy('name')->pluck('name')->take(10)->toArray();
        foreach ($customerNames as $customerName) {
            $response->assertSeeText($customerName);
        }
    }

    public function test_customers_can_be_filtered()
    {
        $user = User::factory(1)
            ->hasCustomers(30)
            ->create()
            ->first();

        $this->actingAs($user);

        $customer = $user->customers()->inRandomOrder()->first();

        $response = $this->get('/customers?page=1&limit=10&filter[organisation]=' . urlencode($customer->organisation));
        $response->assertStatus(200);

        $response->assertSeeText($customer->name);
    }

    public function test_customers_can_be_searched()
    {
        $user = User::factory(1)
            ->hasCustomers(10)
            ->create()
            ->first();

        $this->actingAs($user);

        $customer = $user->customers()->inRandomOrder()->first();

        $response = $this->get('/customers?page=1&limit=10&search=' . urlencode($customer->name));
        $response->assertStatus(200);

        $response->assertSeeText($customer->name);
    }

    public function test_customers_pagination_works()
    {
        $user = User::factory(1)
            ->hasCustomers(30)
            ->create()
            ->first();

        $this->actingAs($user);

        $customer = $user->customers()->orderBy('name')->offset(15)->first();

        $response = $this->get('/customers?page=2&limit=10&sort=name&search=' . urlencode($customer->name));
        $response->assertStatus(200);

        $response->assertSeeText($customer->name);
    }

    public function test_customers_listed_only_belong_to_user()
    {
        $otherUser = User::factory(1)
            ->hasCustomers(5)
            ->create()
            ->first();

        $this->actingAs($otherUser);
        $otherUsersCustomer = $otherUser->customers()->inRandomOrder()->first();

        $user = User::factory(1)
            ->hasCustomers(5)
            ->create()
            ->first();

        $this->actingAs($user);

        $response = $this->get('/customers?page=1&limit=10');
        $response->assertStatus(200);

        $response->assertDontSeeText($otherUsersCustomer->name);
    }

    public function test_customer_details_page()
    {
        $user = User::factory(1)
            ->hasCustomers(1)
            ->create()
            ->first();

        $this->actingAs($user);

        $customer = $user->customers()->first();

        $response = $this->get('/customers/' . urlencode($customer->hash) . '/' . $customer->name_slug);
        $response->assertStatus(200);

        $response->assertSeeText($customer->name);
    }

    public function test_customer_details_page_404s_on_other_users_customers()
    {
        $otherUser = User::factory(1)
            ->hasCustomers(5)
            ->create()
            ->first();

        $this->actingAs($otherUser);
        $otherUsersCustomer = $otherUser->customers()->inRandomOrder()->first();

        $user = User::factory(1)
            ->hasCustomers(5)
            ->create()
            ->first();

        $this->actingAs($user);

        $response = $this->get('/customers/' . urlencode($otherUsersCustomer->hash) . '/' . $otherUsersCustomer->name_slug);
        $response->assertStatus(404);
    }

    public function test_customer_can_be_deleted()
    {
        $user = User::factory(1)
            ->hasCustomers(1)
            ->create()
            ->first();

        $this->actingAs($user);

        $customer = $user->customers()->first();

        $response = $this->post('/customers/' . urlencode($customer->hash) . '/' . $customer->name_slug . '/delete');
        $response->assertRedirect();

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }

    public function test_customer_can_be_updated()
    {
        $user = User::factory(1)
            ->hasCustomers(1)
            ->create()
            ->first();

        $this->actingAs($user);

        $customer = $user->customers()->first();

        $response = $this->post('/customers/' . urlencode($customer->hash) . '/' . $customer->name_slug . '/update', [
            'name' => 'Updated Name',
            'email' => $customer->email,
        ]);
        $response->assertRedirect();

        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'Updated Name']);
    }

    public function test_customer_can_be_created()
    {
        $user = User::factory(1)
            ->create()
            ->first();

        $this->actingAs($user);

        $response = $this->post('/customers/add', [
            'name' => 'New Customer',
            'email' => 'new@example.com',
            'phone' => '1234567890',
            'organisation' => 'Test Organisation',
            'job_title' => 'Test Job Title',
            'date_of_birth' => '1990-01-01',
        ]);
        $response->assertRedirect();

        $this->assertDatabaseHas('customers', [
            'user_id' => $user->id,
            'name' => 'New Customer',
            'email' => 'new@example.com',
            'phone' => '1234567890',
            'organisation' => 'Test Organisation',
            'job_title' => 'Test Job Title',
            'date_of_birth' => '1990-01-01 00:00:00',
        ]);
    }

    public function test_customers_can_be_exported()
    {
        Excel::fake();

        $user = User::factory(1)
            ->hasCustomers(5)
            ->create()
            ->first();

        $this->actingAs($user);

        $response = $this->get('/customers/export');
        $response->assertStatus(200);

        Excel::assertDownloaded('customers.xlsx');
    }

    public function test_customers_can_be_imported()
    {
        Excel::fake();

        $user = User::factory(1)
            ->create()
            ->first();

        $this->actingAs($user);

        $file = new UploadedFile(
            base_path('tests/Fixtures/customers-import.xlsx'),
            'customers-import.xlsx',
            null,
            null,
            true
        );

        $this->post('/customers/import', ['import' => $file]);

        Excel::assertImported('customers-import.xlsx');
    }
}
