export interface User {
  id: number;
  email: string;
  name: string;
  role: 'admin' | 'staff' | 'client';
}

export interface Staff {
  id: number;
  name: string;
  email: string;
  position: string;
  department?: string;
  joinDate: string;
  isActive: boolean;
}

export interface Client {
  id: number;
  name: string;
  email: string;
  company?: string;
  phone?: string;
  address?: string;
  createdAt: string;
  isActive: boolean;
}

export interface Project {
  id: number;
  name: string;
  description?: string;
  clientId: number;
  status: 'planning' | 'in_progress' | 'completed' | 'cancelled';
  startDate: string;
  endDate?: string;
  budget?: number;
  progress: number;
}

export interface ApiResponse<T = any> {
  success: boolean;
  data?: T;
  error?: string;
  message?: string;
}

export interface PaginatedResponse<T> {
  data: T[];
  total: number;
  page: number;
  pageSize: number;
  totalPages: number;
}

export interface LoginRequest {
  email: string;
  password: string;
}

export interface AuthToken {
  token: string;
  refreshToken: string;
  expiresAt: string;
}