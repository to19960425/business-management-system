export const API_BASE_URL = 'http://localhost:8000/api/v1';

export const API_ENDPOINTS = {
  AUTH: {
    LOGIN: '/auth/login',
    LOGOUT: '/auth/logout',
    REFRESH: '/auth/refresh',
    ME: '/auth/me',
  },
  STAFF: {
    LIST: '/staff',
    CREATE: '/staff',
    UPDATE: (id: number) => `/staff/${id}`,
    DELETE: (id: number) => `/staff/${id}`,
    DETAIL: (id: number) => `/staff/${id}`,
  },
  CLIENTS: {
    LIST: '/clients',
    CREATE: '/clients',
    UPDATE: (id: number) => `/clients/${id}`,
    DELETE: (id: number) => `/clients/${id}`,
    DETAIL: (id: number) => `/clients/${id}`,
  },
  PROJECTS: {
    LIST: '/projects',
    CREATE: '/projects',
    UPDATE: (id: number) => `/projects/${id}`,
    DELETE: (id: number) => `/projects/${id}`,
    DETAIL: (id: number) => `/projects/${id}`,
  },
} as const;

export const HTTP_STATUS = {
  OK: 200,
  CREATED: 201,
  NO_CONTENT: 204,
  BAD_REQUEST: 400,
  UNAUTHORIZED: 401,
  FORBIDDEN: 403,
  NOT_FOUND: 404,
  INTERNAL_SERVER_ERROR: 500,
} as const;