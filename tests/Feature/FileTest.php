<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FileTest extends TestCase
{
    public function test_file_write_to_storage()
    {
        $response = $this->get(route('test'));
        $response->assertStatus(200);
    }
}
