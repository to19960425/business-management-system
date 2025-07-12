import axios, { AxiosResponse, AxiosError } from 'axios';
import { API_BASE_URL, HTTP_STATUS } from '../constants/api';
import type { ApiResponse } from '../types';

const apiClient = axios.create({
  baseURL: API_BASE_URL,
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
  },
});

apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('authToken');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

apiClient.interceptors.response.use(
  (response: AxiosResponse) => {
    return response;
  },
  async (error: AxiosError) => {
    if (error.response?.status === HTTP_STATUS.UNAUTHORIZED) {
      localStorage.removeItem('authToken');
      localStorage.removeItem('refreshToken');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

export const apiService = {
  get: async <T>(url: string): Promise<ApiResponse<T>> => {
    try {
      const response = await apiClient.get<ApiResponse<T>>(url);
      return response.data;
    } catch (error) {
      return handleApiError(error);
    }
  },

  post: async <T>(url: string, data?: any): Promise<ApiResponse<T>> => {
    try {
      const response = await apiClient.post<ApiResponse<T>>(url, data);
      return response.data;
    } catch (error) {
      return handleApiError(error);
    }
  },

  put: async <T>(url: string, data?: any): Promise<ApiResponse<T>> => {
    try {
      const response = await apiClient.put<ApiResponse<T>>(url, data);
      return response.data;
    } catch (error) {
      return handleApiError(error);
    }
  },

  delete: async <T>(url: string): Promise<ApiResponse<T>> => {
    try {
      const response = await apiClient.delete<ApiResponse<T>>(url);
      return response.data;
    } catch (error) {
      return handleApiError(error);
    }
  },
};

const handleApiError = (error: any): ApiResponse => {
  if (error.response) {
    const { status, data } = error.response;
    return {
      success: false,
      error: data?.error || data?.message || `HTTP ${status} Error`,
    };
  } else if (error.request) {
    return {
      success: false,
      error: 'ネットワークエラーが発生しました。接続を確認してください。',
    };
  } else {
    return {
      success: false,
      error: '予期しないエラーが発生しました。',
    };
  }
};

export default apiClient;