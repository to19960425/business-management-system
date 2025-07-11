# Business Management System

Modern business management system built with React + TypeScript + CakePHP + Docker

## Technology Stack

### Frontend
- React 18 + TypeScript
- Material-UI (MUI)
- Redux Toolkit / Zustand for state management
- React Router v6
- Axios + React Query
- React Hook Form + Yup validation

### Backend
- CakePHP 5.x
- RESTful API
- JWT Authentication
- MySQL 8.0
- TCPDF for PDF generation

### Development Environment
- Docker + Docker Compose
- Node.js 18+ Alpine
- PHP 8.2 + Apache
- Nginx (reverse proxy)
- phpMyAdmin

## Features

Based on the original SOU system with modernized architecture:

1. **Authentication & Authorization**
2. **Staff Management** - Employee information and permissions
3. **Client Management** - Customer information management
4. **Partner Management** - External partner companies
5. **Project Management** - Order and internal project tracking
6. **Sales Management** - Revenue tracking and targets
7. **Progress Tracking** - Deadline and time management
8. **Dashboard** - KPI overview and alerts
9. **Personal Dashboard** - Individual work management
10. **Reporting** - PDF/CSV export capabilities

## Development Setup

```bash
# Clone repository
git clone <repository-url>
cd business-management-system

# Start development environment
docker-compose up -d

# Access applications
Frontend: http://localhost:3000
Backend API: http://localhost:8000
phpMyAdmin: http://localhost:8080
```

## Project Structure

```
business-management-system/
├── frontend/                    # React + TypeScript
├── backend/                     # CakePHP API
├── docker/                      # Docker configurations
├── docs/                        # API documentation
├── docker-compose.yml
└── README.md
```

## Development Phases

1. **Phase 1**: Infrastructure setup (Docker + basic frameworks)
2. **Phase 2**: Database design and migrations
3. **Phase 3**: Authentication system
4. **Phase 4**: Basic CRUD operations
5. **Phase 5**: Project management features
6. **Phase 6**: Dashboard and analytics
7. **Phase 7**: Additional features
8. **Phase 8**: Testing and deployment preparation

## Contributing

This project is tracked using GitHub Issues with detailed task breakdown. See the Issues tab for the current development status and upcoming tasks.

## License

MIT License