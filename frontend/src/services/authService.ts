import apiClient from './api';
import { AuthResponse } from '../types/auth';

export const authService = {
  /**
   * Login user with email and password
   */
  async login(email: string, password: string): Promise<AuthResponse> {
    const response = await apiClient.post<AuthResponse>('/auth/login', {
      email,
      password,
    });
    return response.data;
  },

  /**
   * Logout current user
   */
  async logout(): Promise<void> {
    await apiClient.post('/auth/logout');
  },

  /**
   * Refresh access token using refresh token
   */
  async refreshToken(refreshToken: string): Promise<AuthResponse> {
    const response = await apiClient.post<AuthResponse>('/auth/refresh', {
      refresh_token: refreshToken,
    });
    return response.data;
  },

  /**
   * Verify current token validity
   */
  async verifyToken(): Promise<void> {
    // This would typically call a /auth/verify endpoint
    // For now, we'll make a simple authenticated request
    await apiClient.get('/health');
  },
};