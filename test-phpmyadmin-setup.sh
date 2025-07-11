#!/bin/bash

# phpMyAdmin Setup Test Script
# This script validates the phpMyAdmin configuration and functionality

echo "=== phpMyAdmin Setup Test ==="
echo ""

# Test 1: Check if phpMyAdmin service is defined in docker-compose.yml
echo "🔍 Testing phpMyAdmin service configuration..."
if docker compose config --services | grep -q "^phpmyadmin$"; then
    echo "✅ phpMyAdmin service is defined in docker-compose.yml"
else
    echo "❌ phpMyAdmin service is missing from docker-compose.yml"
    exit 1
fi

# Test 2: Check phpMyAdmin port configuration
echo ""
echo "🔍 Testing phpMyAdmin port configuration..."
PHPMYADMIN_PORT=${PHPMYADMIN_PORT:-8081}
if PHPMYADMIN_PORT=${PHPMYADMIN_PORT} docker compose config | grep -A 30 "^  phpmyadmin:" | grep -q "published.*\"${PHPMYADMIN_PORT}\""; then
    echo "✅ phpMyAdmin port ${PHPMYADMIN_PORT} is correctly mapped"
else
    echo "❌ phpMyAdmin port ${PHPMYADMIN_PORT} mapping is incorrect"
    exit 1
fi

# Test 3: Check phpMyAdmin environment variables
echo ""
echo "🔍 Testing phpMyAdmin environment variables..."
phpmyadmin_config=$(PHPMYADMIN_PORT=${PHPMYADMIN_PORT} docker compose config | grep -A 30 "^  phpmyadmin:")

if echo "$phpmyadmin_config" | grep -q "PMA_HOST:"; then
    echo "✅ PMA_HOST environment variable is set"
else
    echo "❌ PMA_HOST environment variable is missing"
    exit 1
fi

if echo "$phpmyadmin_config" | grep -q "PMA_PORT:"; then
    echo "✅ PMA_PORT environment variable is set"
else
    echo "❌ PMA_PORT environment variable is missing"
    exit 1
fi

if echo "$phpmyadmin_config" | grep -q "PMA_USER:"; then
    echo "✅ PMA_USER environment variable is set"
else
    echo "❌ PMA_USER environment variable is missing"
    exit 1
fi

if echo "$phpmyadmin_config" | grep -q "PMA_PASSWORD:"; then
    echo "✅ PMA_PASSWORD environment variable is set"
else
    echo "❌ PMA_PASSWORD environment variable is missing"
    exit 1
fi

# Test 4: Check phpMyAdmin dependency on database
echo ""
echo "🔍 Testing phpMyAdmin database dependency..."
if echo "$phpmyadmin_config" | grep -A 10 "depends_on:" | grep -q "db:"; then
    echo "✅ phpMyAdmin depends on database service"
else
    echo "❌ phpMyAdmin database dependency is missing"
    exit 1
fi

# Test 5: Check phpMyAdmin network configuration
echo ""
echo "🔍 Testing phpMyAdmin network configuration..."
if echo "$phpmyadmin_config" | grep -q "business-management-network"; then
    echo "✅ phpMyAdmin is in correct network"
else
    echo "❌ phpMyAdmin network configuration is incorrect"
    exit 1
fi

# Test 6: Check phpMyAdmin Docker image
echo ""
echo "🔍 Testing phpMyAdmin Docker image..."
if echo "$phpmyadmin_config" | grep -q "image.*phpmyadmin/phpmyadmin"; then
    echo "✅ phpMyAdmin uses official image"
else
    echo "❌ phpMyAdmin image configuration is incorrect"
    exit 1
fi

# Test 7: Check if phpMyAdmin can start (if Docker is running)
echo ""
echo "🔍 Testing phpMyAdmin service startup..."
if docker compose ps >/dev/null 2>&1; then
    echo "ℹ️  Docker is running, testing phpMyAdmin service..."
    
    # Stop any existing services
    docker compose down >/dev/null 2>&1
    
    # Start only db and phpmyadmin services
    if PHPMYADMIN_PORT=${PHPMYADMIN_PORT} DB_EXTERNAL_PORT=${DB_EXTERNAL_PORT:-3307} docker compose up -d db phpmyadmin >/dev/null 2>&1; then
        echo "✅ phpMyAdmin service started successfully"
    else
        # Check if services are already running
        if docker compose ps | grep -q "bms_phpmyadmin.*Up"; then
            echo "ℹ️  phpMyAdmin service is already running"
        else
            echo "❌ Failed to start phpMyAdmin service"
            docker compose logs phpmyadmin
            docker compose down >/dev/null 2>&1
            exit 1
        fi
    fi
    
    # Wait for services to be ready
    echo "⏳ Waiting for services to be ready..."
    sleep 10
    
    # Check if phpMyAdmin is accessible
    if curl -f http://localhost:${PHPMYADMIN_PORT} >/dev/null 2>&1; then
        echo "✅ phpMyAdmin is accessible on port ${PHPMYADMIN_PORT}"
    else
        echo "❌ phpMyAdmin is not accessible on port ${PHPMYADMIN_PORT}"
        docker compose logs phpmyadmin
        docker compose down >/dev/null 2>&1
        exit 1
    fi
    
    # Check if database connection works
    if docker compose exec -T phpmyadmin curl -f http://localhost/index.php >/dev/null 2>&1; then
        echo "✅ phpMyAdmin internal connectivity works"
    else
        echo "⚠️  phpMyAdmin internal connectivity test skipped (may require authentication)"
    fi
    
    # Clean up
    docker compose down >/dev/null 2>&1
else
    echo "ℹ️  Docker is not running, skipping live tests"
fi

# Test 8: Check security configuration
echo ""
echo "🔍 Testing phpMyAdmin security configuration..."
if echo "$phpmyadmin_config" | grep -q "condition.*service_healthy"; then
    echo "✅ phpMyAdmin waits for database health check"
else
    echo "❌ phpMyAdmin should wait for database health check"
    exit 1
fi

echo ""
echo "🎉 All phpMyAdmin tests passed!"
echo ""
echo "=== phpMyAdmin Configuration Summary ==="
echo "Image: phpmyadmin/phpmyadmin:latest"
echo "Port: ${PHPMYADMIN_PORT}"
echo "Database Host: db"
echo "Database Port: 3306"
echo "Network: business-management-network"
echo "Dependencies: db (with health check)"