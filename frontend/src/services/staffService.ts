import { apiService } from './api';
import type { Staff, StaffCreateRequest, StaffUpdateRequest, ApiResponse } from '../types';

export const staffService = {
  /**
   * Get all staff members
   */
  getAll: async (): Promise<ApiResponse<Staff[]>> => {
    return apiService.get<Staff[]>('/api/v1/staff');
  },

  /**
   * Get staff member by ID
   */
  getById: async (id: number): Promise<ApiResponse<Staff>> => {
    return apiService.get<Staff>(`/api/v1/staff/${id}`);
  },

  /**
   * Create new staff member
   */
  create: async (data: StaffCreateRequest): Promise<ApiResponse<Staff>> => {
    return apiService.post<Staff>('/api/v1/staff', data);
  },

  /**
   * Update staff member
   */
  update: async (id: number, data: StaffUpdateRequest): Promise<ApiResponse<Staff>> => {
    return apiService.put<Staff>(`/api/v1/staff/${id}`, data);
  },

  /**
   * Delete staff member (soft delete)
   */
  delete: async (id: number): Promise<ApiResponse<void>> => {
    return apiService.delete<void>(`/api/v1/staff/${id}`);
  },
};