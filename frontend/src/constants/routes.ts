export const ROUTES = {
  HOME: '/',
  LOGIN: '/login',
  DASHBOARD: '/dashboard',
  STAFF: {
    LIST: '/staff',
    CREATE: '/staff/create',
    EDIT: (id: number) => `/staff/edit/${id}`,
    DETAIL: (id: number) => `/staff/${id}`,
  },
  CLIENTS: {
    LIST: '/clients',
    CREATE: '/clients/create',
    EDIT: (id: number) => `/clients/edit/${id}`,
    DETAIL: (id: number) => `/clients/${id}`,
  },
  PROJECTS: {
    LIST: '/projects',
    CREATE: '/projects/create',
    EDIT: (id: number) => `/projects/edit/${id}`,
    DETAIL: (id: number) => `/projects/${id}`,
  },
} as const;