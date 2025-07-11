# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Docker Environment
```bash
# Start all services
docker-compose up -d

# Stop all services
docker-compose down

# View logs
docker-compose logs -f [service_name]

# Rebuild services
docker-compose build

# Access containers
docker-compose exec backend bash
docker-compose exec frontend sh
```

### Service Access
- Frontend: http://localhost:3000
- Backend API: http://localhost:8000
- phpMyAdmin: http://localhost:8081
- Mailhog: http://localhost:8025
- Nginx: http://localhost:80

### Database Operations
```bash
# Access MySQL CLI
docker-compose exec db mysql -u bmuser -p business_management

# Run migrations (when implemented)
docker-compose exec backend bin/cake migrations migrate
```

## Project Architecture

### Technology Stack
- **Frontend**: React 18 + TypeScript + Vite + Material-UI (MUI)
- **Backend**: CakePHP 5.x + PHP 8.2 + Apache
- **Database**: MySQL 8.0
- **Infrastructure**: Docker + Docker Compose + Nginx

### Directory Structure
```
business-management-system/
├── frontend/           # React + TypeScript application
├── backend/            # CakePHP API
├── docker/             # Docker configurations
│   ├── mysql/         # MySQL setup and init scripts
│   ├── nginx/         # Nginx reverse proxy config
│   ├── node/          # Node.js Dockerfile
│   └── php/           # PHP + Apache Dockerfile
├── docs/              # Technical documentation
└── docker-compose.yml # Multi-service orchestration
```

### API Design
- **Base URL**: `/api/v1`
- **Authentication**: JWT tokens
- **Response Format**: Standardized JSON with `success`, `data`, `error` fields
- **Main Endpoints**:
  - `/api/v1/auth/*` - Authentication
  - `/api/v1/staff/*` - Staff management
  - `/api/v1/clients/*` - Client management
  - `/api/v1/projects/*` - Project management

### Frontend Architecture
The React application follows a structured approach:
- `src/components/` - Reusable components
- `src/pages/` - Page-level components
- `src/services/` - API communication
- `src/types/` - TypeScript definitions
- `src/utils/` - Utility functions

### Backend Architecture
CakePHP follows MVC pattern:
- `src/Controller/Api/` - API controllers
- `src/Model/` - Database models (Entity + Table)
- `src/Service/` - Business logic layer
- `src/Middleware/` - Request processing middleware

### Database Schema
Key tables include:
- `users` - User authentication
- `staff` - Employee information
- `clients` - Customer management
- `projects` - Project tracking

## Development Notes

### Current Status
This project is in Phase 1 (Infrastructure Setup) with Docker environment and basic framework setup complete. The frontend and backend directories may not yet exist as the project is still in initial setup phase.

### Environment Variables
Copy `.env.example` to `.env` and configure:
- Database credentials
- JWT secret
- Application debug settings

### Security Considerations
- JWT tokens for authentication
- Password hashing with bcrypt
- Input validation on all endpoints
- CORS properly configured for frontend-backend communication

### Key Features (Planned)
1. Authentication & Authorization
2. Staff Management
3. Client Management
4. Project Management
5. Dashboard with KPIs
6. PDF/CSV export capabilities
7. Progress tracking and deadlines

### Testing Strategy
- **Frontend**: Jest + React Testing Library
- **Backend**: PHPUnit + CakePHP Test Suite
- **E2E**: Cypress or Playwright (planned)

### Development Workflow
1. Use Docker for consistent development environment
2. Follow the phase-based development plan in `docs/tasks/`
3. API-first approach with clear contracts
4. Component-based frontend architecture
5. Service layer for business logic in backend