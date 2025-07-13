# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Docker Environment
```bash
# Start all services
docker compose up -d

# Stop all services
docker compose down

# View logs
docker compose logs -f [service_name]

# Rebuild services
docker compose build

# Access containers
docker compose exec backend bash
docker compose exec frontend sh
```

### Service Access
- Frontend: http://localhost:3000
- Backend API: http://localhost:8000
- phpMyAdmin: http://localhost:8081 (configurable via PHPMYADMIN_PORT)
- Mailhog: http://localhost:8025
- Nginx: http://localhost:80
- Redis: localhost:6379 (for caching)

### Database Operations
```bash
# Access MySQL CLI with correct credentials
docker compose exec db mysql -u bmuser -p'bmpass' business_management

# Run migrations
docker compose exec backend bin/cake migrations migrate

# Check migration status
docker compose exec backend bin/cake migrations status

# Rollback last migration
docker compose exec backend bin/cake migrations rollback

# Create new migration
docker compose exec backend bin/cake migrations create MigrationName
```

### Frontend Development Commands
```bash
# Run frontend in development mode
docker compose exec frontend npm run dev

# Build frontend for production
docker compose exec frontend npm run build

# Run frontend linting
docker compose exec frontend npm run lint

# Run frontend tests
docker compose exec frontend npm test
```

### Backend Development Commands
```bash
# Install PHP dependencies
docker compose exec backend composer install

# Run backend tests (full integration tests)
docker compose exec backend composer test

# Run unit tests only (faster, no database required - covers Middleware & API Controllers)
docker compose exec backend vendor/bin/phpunit -c phpunit-unit.xml

# Run code style checks
docker compose exec backend composer cs-check

# Fix code style issues
docker compose exec backend composer cs-fix

# Run static analysis
docker compose exec backend composer stan

# Run all checks (tests + code style)
docker compose exec backend composer check

# Generate API documentation (when bake is configured)
docker compose exec backend bin/cake bake
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
- **Authentication**: JWT tokens with Bearer authentication
- **Response Format**: Standardized JSON with `success`, `data`, `message` fields
- **CORS**: Enabled for frontend origins (localhost:3000, localhost:80)
- **Implemented Endpoints**:
  - `/api/v1/health` - Basic health check
  - `/api/v1/health/database` - Database connectivity check
  - `/api/v1/auth/login` - Complete JWT authentication
  - `/api/v1/auth/logout` - Token invalidation
  - `/api/v1/auth/refresh` - Access token refresh
  - `/api/v1/test/protected` - JWT authentication test endpoint
  - `/api/v1/staff/*` - Complete staff management CRUD operations
- **Next Implementation Priority**:
  - `/api/v1/clients/*` - Client management (Issue #55)
  - `/api/v1/projects/*` - Project management

### Frontend Architecture
The React application follows a structured approach:
- `src/components/` - Reusable components (common/, auth/)
- `src/pages/` - Page-level components (Login.tsx, Dashboard, etc.)
- `src/services/` - API communication (api.ts, authService.ts)
- `src/contexts/` - React Context providers (AuthContext.tsx)
- `src/types/` - TypeScript definitions (auth.ts, etc.)
- `src/constants/` - Application constants (routes.ts)
- `src/utils/` - Utility functions

### Backend Architecture
CakePHP follows MVC pattern:
- `src/Controller/Api/` - API controllers (ApiController base, AuthController, TestController, StaffController)
- `src/Model/` - Database models (Entity + Table classes)
- `src/Service/` - Business logic layer (JwtService, SecurityValidationService)
- `src/Middleware/` - Request processing middleware (CorsMiddleware, JwtAuthenticationMiddleware, ApiCsrfProtectionMiddleware)

### Database Schema
Key tables include:
- `users` - User authentication
- `staff` - Employee information
- `clients` - Customer management
- `projects` - Project tracking
- `outsourcing_companies` - External partner companies
- `project_tasks` - Task management within projects
- `time_records` - Time tracking and billing
- `sales_records` - Revenue and invoice management

## Development Notes

### Current Status
This project has completed **Phase 4 (Basic CRUD Operations)** with staff management implemented. The system includes:
- Docker multi-service setup with health checks
- **Complete JWT authentication system** (JwtService, middleware, login/logout/refresh)
- **Staff management system** with full CRUD operations
- **Enhanced security features** (SecurityValidationService, ApiCsrfProtectionMiddleware)
- React authentication context with protected routes
- CakePHP 5.x backend with complete API foundation
- CORS middleware for frontend-backend communication
- Standardized API response format and error handling
- Comprehensive logging system (api.log, auth.log)
- React + TypeScript frontend with Vite build system
- MySQL database with phpMyAdmin interface
- Nginx reverse proxy configuration

**Next Priority**: Client Management implementation (Issue #55)

### Environment Variables
Copy `.env.example` to `.env` and configure:
- Database credentials (DB_HOST, DB_USERNAME, DB_PASSWORD)
- JWT secrets (JWT_SECRET, SECURITY_SALT, ENCRYPTION_KEY)
- Application settings (APP_DEBUG, APP_ENV, APP_TIMEZONE)
- API configuration (API_PREFIX, API_RATE_LIMIT)
- Email settings (MAIL_HOST, MAIL_FROM_ADDRESS)
- CORS origins (CORS_ALLOWED_ORIGINS)

**Important**: Generate secure random strings for production using `openssl rand -base64 32`

### Security Considerations
- JWT tokens for authentication
- Password hashing with bcrypt
- Input validation on all endpoints
- CORS properly configured for frontend-backend communication

### Key Features Status
1. ✅ **Authentication & Authorization** - JWT system complete with enhanced security
2. ✅ **Staff Management** - Complete CRUD operations implemented
3. 🚧 **Client Management** - Next priority (Issue #55)
4. 📋 **Project Management** - Planned (Issues #57-59)
5. 📋 **Dashboard with KPIs** - Planned (Issue #60)
6. 📋 **PDF/CSV export capabilities** - Planned
7. 📋 **Progress tracking and deadlines** - Planned

### Testing Strategy
- **Frontend**: Vitest (configured in package.json)
- **Backend**: PHPUnit + CakePHP Test Suite with XML configuration
- **Code Quality**: ESLint for frontend, PHPCS + PHPStan for backend
- **E2E**: Cypress or Playwright (planned)

### Development Workflow
1. Use Docker for consistent development environment
2. Follow the phase-based development plan in `docs/tasks/`
3. API-first approach with clear contracts
4. Component-based frontend architecture
5. Service layer for business logic in backend

### Architecture Patterns & Conventions

#### API Development Pattern
- **Base Controller**: Extend `ApiController` for all API endpoints
- **Response Format**: Always use `apiResponse()`, `apiError()`, `apiValidationError()` methods
- **Authentication**: Use `JwtAuthenticationMiddleware` for protected routes
- **Validation**: Implement validation in controller actions using CakePHP validation
- **Error Handling**: Consistent error responses with proper HTTP status codes

#### Frontend Development Pattern
- **Components**: Separate into `common/`, feature-specific folders (e.g., `auth/`, `staff/`)
- **State Management**: Use React Context for auth, consider Redux Toolkit for complex state
- **API Communication**: Use centralized API service with proper error handling
- **Routing**: Protected routes using authentication context
- **Form Handling**: React Hook Form with Material-UI components

#### Security Implementation
- **Environment Variables**: Use `SecurityValidationService` pattern for validation
- **CSRF Protection**: Implement smart skipping for API routes using `ApiCsrfProtectionMiddleware` pattern
- **JWT Tokens**: Follow existing `JwtService` pattern for token management
- **Password Handling**: Always use bcrypt with proper salt validation

## Code Quality and Standards

### PHP Standards
- Follows CakePHP coding standards via `phpcs.xml`
- PHPStan static analysis at level 8 
- PSR-4 autoloading for `App\` namespace
- Use composer scripts: `composer check` runs both tests and code style checks

### TypeScript/React Standards  
- ESLint with TypeScript, React, and React Hooks plugins
- Vite build system with TypeScript support
- Material-UI (MUI) for consistent component styling
- Vitest for unit testing

### Testing Commands
```bash
# Run single backend test file
docker compose exec backend vendor/bin/phpunit tests/TestCase/Service/DatabaseConnectionServiceTest.php

# Run unit tests only (faster, no database required - covers Middleware & API Controllers)
docker compose exec backend vendor/bin/phpunit -c phpunit-unit.xml

# Run specific unit test files
docker compose exec backend vendor/bin/phpunit -c phpunit-unit.xml tests/TestCase/Middleware/CorsMiddlewareTest.php
docker compose exec backend vendor/bin/phpunit -c phpunit-unit.xml tests/TestCase/Service/SecurityValidationServiceTest.php

# Run API-specific unit tests
docker compose exec backend vendor/bin/phpunit -c phpunit-unit.xml tests/TestCase/Controller/Api/

# Run integration tests (requires database)
docker compose exec backend vendor/bin/phpunit tests/TestCase/Integration/

# Run single frontend test (when tests exist)
docker compose exec frontend npm test -- --run SpecificTestFile

# Run frontend tests in watch mode
docker compose exec frontend npm test
```

### Debugging and Development Tools
- Backend logs: `docker compose logs -f backend`
- API logs: `docker compose exec backend tail -f logs/api.log`
- Auth logs: `docker compose exec backend tail -f logs/auth.log`
- Frontend HMR: Vite provides hot module reloading on port 3000
- Database GUI: phpMyAdmin at http://localhost:8081
- Email testing: Mailhog at http://localhost:8025
- Health checks configured for database and nginx services

## API Implementation Details

### Response Format
All API endpoints follow this standardized format:
```json
{
  "success": true|false,
  "data": {} | null,
  "message": "Success message"
}
```
Error responses include additional `errors` field for validation details.

### Error Handling
- **ApiController** base class provides standardized error methods:
  - `apiResponse()` - Success responses (200)
  - `apiError()` - General errors (400, 500, etc.)
  - `apiValidationError()` - Validation errors (422)
  - `apiUnauthorized()` - Authentication errors (401)
  - `apiForbidden()` - Authorization errors (403)
  - `apiNotFound()` - Resource not found (404)

### Middleware Architecture
- **CorsMiddleware**: Handles CORS for `/api/*` routes only
- **JwtAuthenticationMiddleware**: Validates Bearer tokens for protected API routes
- **ApiCsrfProtectionMiddleware**: CSRF protection with smart skipping for OPTIONS, JWT auth, and auth endpoints
- **SecurityValidationService**: Validates JWT secrets and security salts with environment variable fallback
- Applied in `src/Application.php` before routing

### Logging Strategy
- Request logging: All API requests logged with IP, method, URL
- Authentication logging: Login attempts with success/failure tracking
- Error logging: API errors with full context and stack traces
- Scoped logging: Separate files for different concerns (api, auth)

## Database Implementation Details

### Migration System
- All table migrations created with proper foreign key constraints
- Seed data migration with initial users, staff, clients, and outsourcing companies
- Schema dump automatically generated for diff tracking
- UTF-8mb4 encoding with proper collation for Japanese text support

### Model Architecture
- **Entity Classes**: Define accessible fields and data transformation
- **Table Classes**: Handle associations, validation, and business rules
- **Associations**: Properly configured relationships:
  - users (1) ↔ (1) staff
  - clients (1) → (n) projects
  - staff (1) → (n) projects (manager)
  - projects (1) → (n) project_tasks
  - projects (1) → (n) time_records
  - projects (1) → (n) sales_records
  - outsourcing_companies (1) → (n) projects

### Validation and Business Rules
- Comprehensive field validation (required, types, lengths, formats)
- Unique constraints enforced at database and application level
- Foreign key existence validation
- Custom business rules for data integrity

### Database Design Principles
- **International Support**: UTF-8mb4 encoding for Japanese text
- **Audit Trail**: created/modified timestamps on all tables
- **Soft Deletes**: active field for logical deletion
- **Performance**: Strategic indexing on foreign keys and search fields
- **Data Integrity**: Foreign key constraints with appropriate cascade rules

## Security & Production Readiness

### ✅ Security Features Implemented
- **JWT Authentication**: Complete system with proper token validation
- **CSRF Protection**: ApiCsrfProtectionMiddleware with intelligent request skipping
- **Environment Variable Validation**: SecurityValidationService ensures proper configuration
- **Password Security**: Bcrypt hashing with proper salt validation
- **Input Validation**: Comprehensive validation on all API endpoints
- **CORS Configuration**: Properly configured for frontend-backend communication

### 📋 Current Development Phase
**Phase 5: Client Management System**
- Primary focus: Client Management (Issue #55)
- Secondary: Project Management planning
- Estimated timeline: 2-3 weeks

### 🔧 Technical Debt
- Performance optimization needed (Issue #83)
- Test coverage gaps (Issue #84)
- UX improvements pending (Issue #85)
- Infrastructure hardening required (Issue #86)

## Important Notes for Development

### Recent Changes
- **Security Enhancements**: Complete security overhaul implemented (Issue #88)
  - SecurityValidationService with environment variable fallback
  - ApiCsrfProtectionMiddleware with intelligent request skipping
  - Proper JWT secret and security salt validation
- **Staff Management**: Full CRUD implementation completed
- **Testing Infrastructure**: Unit tests and integration tests properly configured

### Key Implementation Files
- `backend/src/Controller/Api/ApiController.php` - Base API controller with standardized responses
- `backend/src/Service/JwtService.php` - JWT token management
- `backend/src/Service/SecurityValidationService.php` - Security configuration validation
- `backend/src/Middleware/ApiCsrfProtectionMiddleware.php` - Smart CSRF protection
- `frontend/src/services/api.ts` - Centralized API communication
- `frontend/src/contexts/AuthContext.tsx` - Authentication state management