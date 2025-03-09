<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class WeatherAPITest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/api/subscribe?email=test@test.com&location=sofia');
        $response->assertStatus(200);
    }

    public function test_the_app_returns_a_successful_response_when_using_coordinates(): void
    {
        $response = $this->get('/api/subscribe?email=test@test.com&location=40.7831,-73.9712');
        $response->assertStatus(200);
    }

    public function test_the_app_returns_bad_request_when_email_and_location_are_not_sent(): void
    {
        $response = $this->get('/api/subscribe');
        $response->assertStatus(400);
    }

    public function test_the_app_returns_bad_request_when_location_is_not_sent(): void
    {
        $response = $this->get('/api/subscribe?email=test@test.com');
        $response->assertStatus(400);
    }

    public function test_the_app_returns_bad_request_when_email_is_not_sent(): void
    {
        $response = $this->get('/api/subscribe?location=sofia');
        $response->assertStatus(400);
    }

    public function test_the_app_returns_bad_request_when_email_is_not_in_correct_format(): void
    {
        $response = $this->get('/api/subscribe?email=test@test&location=sofia');
        $response->assertStatus(400);
    }

    public function test_the_app_returns_bad_request_when_email_is_not_in_correct_format_2(): void
    {
        $response = $this->get('/api/subscribe?email=testtest.com&location=sofia');
        $response->assertStatus(400);
    }

    public function test_the_app_returns_bad_request_when_email_is_already_registered(): void
    {
        $response = $this->get('/api/subscribe?email=test@test.com&location=sofia');
        $response->assertStatus(200);

        $response = $this->get('/api/subscribe?email=test@test.com&location=varna');
        $response->assertStatus(400);
    }

    public function test_unsubscribtion_works(): void
    {
        $response = $this->get('/api/subscribe?email=test@test.com&location=sofia');
        $response->assertStatus(200);

        $response = $this->get('/api/unsubscribe?email=test@test.com');
        $response->assertStatus(200);
    }
}
