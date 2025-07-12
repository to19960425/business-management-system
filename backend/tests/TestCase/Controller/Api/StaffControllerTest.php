<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api;

use Cake\TestSuite\IntegrationTestTrait;

/**
 * App\Controller\Api\StaffController Test Case
 *
 * @uses \App\Controller\Api\StaffController
 */
class StaffControllerTest extends ApiTestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Users',
        'app.Staff',
        'app.TimeRecords',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->get('/api/v1/staff');
        $this->assertResponseOk();
        $this->assertContentType('application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals('Staff list retrieved successfully', $response['message']);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->get('/api/v1/staff/1');
        $this->assertResponseOk();
        $this->assertContentType('application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals('Staff retrieved successfully', $response['message']);
    }

    /**
     * Test view method with invalid id
     *
     * @return void
     */
    public function testViewNotFound(): void
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->get('/api/v1/staff/999');
        $this->assertResponseCode(404);
        $this->assertContentType('application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertFalse($response['success']);
        $this->assertEquals('Staff not found', $response['message']);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $data = [
            'user_id' => 1,
            'employee_id' => 'EMP001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'first_name_kana' => 'ジョン',
            'last_name_kana' => 'ドウ',
            'phone' => '03-1234-5678',
            'mobile' => '090-1234-5678',
            'position' => 'Developer',
            'department' => 'IT',
            'hire_date' => '2024-01-01',
            'salary' => '5000000',
            'hourly_rate' => '3000',
            'notes' => 'Test staff member',
            'active' => true,
        ];

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->post('/api/v1/staff', json_encode($data));
        $this->assertResponseCode(201);
        $this->assertContentType('application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals('Staff created successfully', $response['message']);
        $this->assertEquals($data['employee_id'], $response['data']['employee_id']);
    }

    /**
     * Test add method with validation errors
     *
     * @return void
     */
    public function testAddValidationError(): void
    {
        $data = [
            'employee_id' => '', // Required field missing
            'first_name' => '', // Required field missing
            'last_name' => '', // Required field missing
        ];

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->post('/api/v1/staff', json_encode($data));
        $this->assertResponseCode(422);
        $this->assertContentType('application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertFalse($response['success']);
        $this->assertArrayHasKey('errors', $response);
        $this->assertEquals('Validation failed', $response['message']);
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $data = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'position' => 'Senior Developer',
        ];

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->put('/api/v1/staff/1', json_encode($data));
        $this->assertResponseOk();
        $this->assertContentType('application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals('Staff updated successfully', $response['message']);
        $this->assertEquals($data['first_name'], $response['data']['first_name']);
    }

    /**
     * Test edit method with invalid id
     *
     * @return void
     */
    public function testEditNotFound(): void
    {
        $data = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
        ];

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->put('/api/v1/staff/999', json_encode($data));
        $this->assertResponseCode(404);
        $this->assertContentType('application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertFalse($response['success']);
        $this->assertEquals('Staff not found', $response['message']);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->delete('/api/v1/staff/1');
        $this->assertResponseOk();
        $this->assertContentType('application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertTrue($response['success']);
        $this->assertEquals('Staff deleted successfully', $response['message']);
    }

    /**
     * Test delete method with invalid id
     *
     * @return void
     */
    public function testDeleteNotFound(): void
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->delete('/api/v1/staff/999');
        $this->assertResponseCode(404);
        $this->assertContentType('application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertFalse($response['success']);
        $this->assertEquals('Staff not found', $response['message']);
    }
}
