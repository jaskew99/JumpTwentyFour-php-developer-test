<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\ReqresWrapper;

class ApiTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_users ()
    {
        $reqres_handler = new ReqresWrapper();

        $users = $reqres_handler->getUsers();

        foreach (['page', 'per_page', 'total', 'total_pages', 'data'] as $key)
            $this->assertTrue(property_exists($users, $key));

        foreach (['id', 'email', 'first_name', 'last_name', 'avatar'] as $key)
            $this->assertTrue(property_exists($users->data[0], $key));
    }
}
