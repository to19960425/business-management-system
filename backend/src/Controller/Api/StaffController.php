<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Http\Response;
use Exception;

/**
 * Staff Controller
 *
 * @property \App\Model\Table\StaffTable $Staff
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StaffController extends ApiController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response
     */
    public function index(): Response
    {
        try {
            $staff = $this->Staff->find('all')
                ->contain(['Users'])
                ->where(['Staff.active' => true])
                ->orderAsc('Staff.created')
                ->toArray();

            return $this->apiResponse($staff, 'Staff list retrieved successfully');
        } catch (Exception $e) {
            $this->logApiError('Failed to retrieve staff list', 500, ['error' => $e->getMessage()]);

            return $this->apiError('Failed to retrieve staff list', 500);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response
     */
    public function view(?string $id = null): Response
    {
        try {
            $staff = $this->Staff->find()
                ->contain(['Users'])
                ->where(['Staff.id' => $id, 'Staff.active' => true])
                ->first();

            if (!$staff) {
                return $this->apiNotFound('Staff not found');
            }

            return $this->apiResponse($staff, 'Staff retrieved successfully');
        } catch (Exception $e) {
            $this->logApiError('Failed to retrieve staff', 500, ['id' => $id, 'error' => $e->getMessage()]);

            return $this->apiError('Failed to retrieve staff', 500);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response
     */
    public function add(): Response
    {
        try {
            $staff = $this->Staff->newEmptyEntity();
            $data = $this->request->getData();

            if ($this->request->is('post')) {
                $staff = $this->Staff->patchEntity($staff, $data);

                if ($this->Staff->save($staff)) {
                    $staff = $this->Staff->get($staff->id, [
                        'contain' => ['Users'],
                    ]);

                    return $this->apiResponse($staff, 'Staff created successfully', 201);
                }

                return $this->apiValidationError($staff->getErrors(), 'Validation failed');
            }

            return $this->apiError('Invalid request method', 405);
        } catch (Exception $e) {
            $this->logApiError('Failed to create staff', 500, ['data' => $data ?? null, 'error' => $e->getMessage()]);

            return $this->apiError('Failed to create staff', 500);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response
     */
    public function edit(?string $id = null): Response
    {
        try {
            $staff = $this->Staff->find()
                ->where(['Staff.id' => $id, 'Staff.active' => true])
                ->first();

            if (!$staff) {
                return $this->apiNotFound('Staff not found');
            }

            $data = $this->request->getData();

            if ($this->request->is(['patch', 'post', 'put'])) {
                $staff = $this->Staff->patchEntity($staff, $data);

                if ($this->Staff->save($staff)) {
                    $staff = $this->Staff->get($staff->id, [
                        'contain' => ['Users'],
                    ]);

                    return $this->apiResponse($staff, 'Staff updated successfully');
                }

                return $this->apiValidationError($staff->getErrors(), 'Validation failed');
            }

            return $this->apiError('Invalid request method', 405);
        } catch (Exception $e) {
            $this->logApiError('Failed to update staff', 500, ['id' => $id, 'data' => $data ?? null, 'error' => $e->getMessage()]);

            return $this->apiError('Failed to update staff', 500);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response
     */
    public function delete(?string $id = null): Response
    {
        try {
            $staff = $this->Staff->find()
                ->where(['Staff.id' => $id, 'Staff.active' => true])
                ->first();

            if (!$staff) {
                return $this->apiNotFound('Staff not found');
            }

            if ($this->request->is(['post', 'delete'])) {
                // Soft delete by setting active to false
                $staff->active = false;

                if ($this->Staff->save($staff)) {
                    return $this->apiResponse(null, 'Staff deleted successfully');
                }

                return $this->apiError('Failed to delete staff', 500);
            }

            return $this->apiError('Invalid request method', 405);
        } catch (Exception $e) {
            $this->logApiError('Failed to delete staff', 500, ['id' => $id, 'error' => $e->getMessage()]);

            return $this->apiError('Failed to delete staff', 500);
        }
    }
}
