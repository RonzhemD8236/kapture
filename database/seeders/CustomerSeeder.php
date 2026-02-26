<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'title'       => 'Mr',
                'fname'       => 'John',
                'lname'       => 'Smith',
                'addressline' => '123 Main St',
                'town'        => 'New York',
                'zipcode'     => '10001',
                'phone'       => '555-001-0001',
                'user_id'     => 1,
            ],
            [
                'title'       => 'Ms',
                'fname'       => 'Jane',
                'lname'       => 'Doe',
                'addressline' => '456 Oak Ave',
                'town'        => 'Los Angeles',
                'zipcode'     => '90001',
                'phone'       => '555-002-0002',
                'user_id'     => 2,
            ],
            [
                'title'       => 'Mr',
                'fname'       => 'Bob',
                'lname'       => 'Johnson',
                'addressline' => '789 Pine Rd',
                'town'        => 'Chicago',
                'zipcode'     => '60601',
                'phone'       => '555-003-0003',
                'user_id'     => 3,
            ],
            [
                'title'       => 'Ms',
                'fname'       => 'Alice',
                'lname'       => 'Brown',
                'addressline' => '321 Elm St',
                'town'        => 'Houston',
                'zipcode'     => '77001',
                'phone'       => '555-004-0004',
                'user_id'     => 4,
            ],
            [
                'title'       => 'Mr',
                'fname'       => 'Charlie',
                'lname'       => 'Wilson',
                'addressline' => '654 Maple Dr',
                'town'        => 'Phoenix',
                'zipcode'     => '85001',
                'phone'       => '555-005-0005',
                'user_id'     => 5,
            ],
        ];

        foreach ($customers as $customerData) {
            $customer = new Customer();
            $customer->title       = $customerData['title'];
            $customer->fname       = $customerData['fname'];
            $customer->lname       = $customerData['lname'];
            $customer->addressline = $customerData['addressline'];
            $customer->town        = $customerData['town'];
            $customer->zipcode     = $customerData['zipcode'];
            $customer->phone       = $customerData['phone'];
            $customer->user_id     = $customerData['user_id'];
            $customer->save();
        }
    }
}