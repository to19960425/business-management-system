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
- **Next Implementation Priority**:
  - `/api/v1/staff/*` - Staff management (Issue #54)
  - `/api/v1/clients/*` - Client management
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
- `src/Controller/Api/` - API controllers (ApiController base, AuthController, TestController)
- `src/Model/` - Database models (Entity + Table classes)
- `src/Service/` - Business logic layer (JwtService for authentication)
- `src/Middleware/` - Request processing middleware (CorsMiddleware, JwtAuthenticationMiddleware)

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
This project has completed **Phase 3 (Authentication System)** and is ready for Phase 4 (CRUD Operations). The system includes:
- Docker multi-service setup with health checks
- **Complete JWT authentication system** (JwtService, middleware, login/logout/refresh)
- React authentication context with protected routes
- CakePHP 5.x backend with complete API foundation
- CORS middleware for frontend-backend communication
- Standardized API response format and error handling
- Comprehensive logging system (api.log, auth.log)
- React + TypeScript frontend with Vite build system
- MySQL database with phpMyAdmin interface
- Nginx reverse proxy configuration

**Next Priority**: Staff Management implementation (Issue #54)

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
1. ✅ **Authentication & Authorization** - JWT system complete
2. 🚧 **Staff Management** - Next priority (Issue #54)
3. 📋 **Client Management** - Planned (Issue #55)
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

# Run single unit test file (no database required)
docker compose exec backend vendor/bin/phpunit -c phpunit-unit.xml tests/TestCase/Middleware/CorsMiddlewareTest.php

# Run API-specific unit tests
docker compose exec backend vendor/bin/phpunit -c phpunit-unit.xml tests/TestCase/Controller/Api/

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
- Applied in `src/Application.php` before routing
- **Important**: CSRF protection currently disabled (Issue #82 - security concern)

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

## Critical Issues & Priorities

### 🚨 Immediate Security Concerns (Issue #82)
**MUST fix before production deployment:**
- JWT_SECRET using default value `your-super-secret-jwt-key-here`
- SECURITY_SALT using hardcoded default value
- CSRF protection completely disabled
- Error messages potentially leaking sensitive information

### 📋 Current Development Phase
**Phase 4: Basic CRUD Operations**
- Primary focus: Staff Management (Issue #54) 
- Secondary: Client Management (Issue #55)
- Estimated timeline: 2-3 weeks

### 🔧 Technical Debt
- Performance optimization needed (Issue #83)
- Test coverage gaps (Issue #84)
- UX improvements pending (Issue #85)
- Infrastructure hardening required (Issue #86)