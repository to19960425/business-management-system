export interface User {
  id: number;
  email: string;
  name: string;
  role: 'admin' | 'staff' | 'client';
}

export interface Staff {
  id: number;
  user_id: number;
  employee_id: string;
  first_name: string;
  last_name: string;
  first_name_kana?: string;
  last_name_kana?: string;
  phone?: string;
  mobile?: string;
  position?: string;
  department?: string;
  hire_date?: string;
  salary?: string;
  hourly_rate?: string;
  notes?: string;
  active?: boolean;
  created?: string;
  modified?: string;
  user?: {
    id: number;
    email: string;
    username: string;
  };
}

export interface StaffCreateRequest {
  user_id: number;
  employee_id: string;
  first_name: string;
  last_name: string;
  first_name_kana?: string;
  last_name_kana?: string;
  phone?: string;
  mobile?: string;
  position?: string;
  department?: string;
  hire_date?: string;
  salary?: string;
  hourly_rate?: string;
  notes?: string;
  active?: boolean;
}

export interface StaffUpdateRequest {
  first_name?: string;
  last_name?: string;
  first_name_kana?: string;
  last_name_kana?: string;
  phone?: string;
  mobile?: string;
  position?: string;
  department?: string;
  hire_date?: string;
  salary?: string;
  hourly_rate?: string;
  notes?: string;
  active?: boolean;
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