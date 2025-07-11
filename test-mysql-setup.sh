#!/bin/bash

# MySQL Docker Setup Test Script
# This script validates the MySQL Docker configuration and setup

echo "=== MySQL Docker Setup Test ==="
echo ""

# Test 1: Validate Dockerfile exists
echo "🔍 Testing MySQL Dockerfile existence..."
if [ -f "docker/mysql/Dockerfile" ]; then
    echo "✅ MySQL Dockerfile exists"
else
    echo "❌ MySQL Dockerfile is missing"
    exit 1
fi

# Test 2: Validate my.cnf configuration
echo ""
echo "🔍 Testing my.cnf configuration..."
if [ -f "docker/mysql/conf/my.cnf" ]; then
    echo "✅ my.cnf configuration file exists"
    
    # Check UTF-8 configuration
    if grep -q "character-set-server = utf8mb4" docker/mysql/conf/my.cnf; then
        echo "✅ UTF-8 character set configured"
    else
        echo "❌ UTF-8 character set not configured"
        exit 1
    fi
    
    # Check timezone configuration
    if grep -q "default-time-zone = '+09:00'" docker/mysql/conf/my.cnf; then
        echo "✅ Japanese timezone configured"
    else
        echo "❌ Japanese timezone not configured"
        exit 1
    fi
else
    echo "❌ my.cnf configuration file is missing"
    exit 1
fi

# Test 3: Validate init.sql
echo ""
echo "🔍 Testing init.sql database setup..."
if [ -f "docker/mysql/init/01-create-database.sql" ]; then
    echo "✅ Database initialization script exists"
    
    # Check database creation
    if grep -q "CREATE DATABASE IF NOT EXISTS business_management" docker/mysql/init/01-create-database.sql; then
        echo "✅ Database creation script found"
    else
        echo "❌ Database creation script missing"
        exit 1
    fi
    
    # Check user creation
    if grep -q "CREATE USER IF NOT EXISTS 'bmuser'@'%'" docker/mysql/init/01-create-database.sql; then
        echo "✅ User creation script found"
    else
        echo "❌ User creation script missing"
        exit 1
    fi
    
    # Check UTF-8 in database creation
    if grep -q "CHARACTER SET utf8mb4" docker/mysql/init/01-create-database.sql; then
        echo "✅ UTF-8 character set in database creation"
    else
        echo "❌ UTF-8 character set not specified in database creation"
        exit 1
    fi
    
    # Check privileges
    if grep -q "GRANT ALL PRIVILEGES ON business_management" docker/mysql/init/01-create-database.sql; then
        echo "✅ User privileges configuration found"
    else
        echo "❌ User privileges configuration missing"
        exit 1
    fi
else
    echo "❌ Database initialization script is missing"
    exit 1
fi

# Test 4: Test Docker build (if Docker is available)
echo ""
echo "🔍 Testing Docker build..."
if command -v docker &> /dev/null; then
    if docker build -t test-mysql docker/mysql/ > /dev/null 2>&1; then
        echo "✅ MySQL Docker image builds successfully"
        # Clean up test image
        docker rmi test-mysql > /dev/null 2>&1
    else
        echo "❌ MySQL Docker image build failed"
        exit 1
    fi
else
    echo "⚠️  Docker not available, skipping build test"
fi

# Test 5: Validate docker-compose integration
echo ""
echo "🔍 Testing docker-compose integration..."
if docker compose config > /dev/null 2>&1; then
    echo "✅ docker-compose.yml is valid"
    
    # Check if MySQL service is properly configured
    if docker compose config | grep -A 20 "^  db:" | grep -q "mysql"; then
        echo "✅ MySQL service is configured in docker-compose"
    else
        echo "❌ MySQL service not found in docker-compose"
        exit 1
    fi
else
    echo "❌ docker-compose.yml configuration is invalid"
    exit 1
fi

echo ""
echo "🎉 All MySQL setup tests passed!"
echo ""
echo "=== MySQL Configuration Summary ==="
echo "✅ UTF-8 support: utf8mb4 character set"
echo "✅ Timezone: Japan Standard Time (+09:00)"
echo "✅ Database: business_management"
echo "✅ User: bmuser with full privileges"
echo "✅ Docker integration: Ready"
echo "✅ Configuration files: Complete"