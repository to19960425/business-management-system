#!/bin/bash

# Docker Compose Configuration Test Script
# This script validates the docker-compose.yml configuration

echo "=== Docker Compose Configuration Test ==="
echo ""

# Test 1: Validate docker-compose.yml syntax
echo "🔍 Testing docker-compose.yml syntax..."
if docker compose config > /dev/null 2>&1; then
    echo "✅ docker-compose.yml syntax is valid"
else
    echo "❌ docker-compose.yml syntax is invalid"
    exit 1
fi

# Test 2: Check if all required services are defined
echo ""
echo "🔍 Testing required services..."
required_services=("db" "backend" "frontend" "nginx" "phpmyadmin" "mailhog" "redis")
missing_services=()

for service in "${required_services[@]}"; do
    if docker compose config --services | grep -q "^${service}$"; then
        echo "✅ Service '${service}' is defined"
    else
        echo "❌ Service '${service}' is missing"
        missing_services+=("${service}")
    fi
done

if [ ${#missing_services[@]} -gt 0 ]; then
    echo "❌ Missing services: ${missing_services[*]}"
    exit 1
fi

# Test 3: Check port configurations
echo ""
echo "🔍 Testing port configurations..."
expected_ports=(
    "db:3306"
    "backend:8000"
    "frontend:3000"
    "nginx:80"
    "phpmyadmin:8080"
    "mailhog:1025"
    "mailhog:8025"
    "redis:6379"
)

for port_config in "${expected_ports[@]}"; do
    service=$(echo "$port_config" | cut -d: -f1)
    port=$(echo "$port_config" | cut -d: -f2)
    
    if docker compose config | grep -A 30 "^  ${service}:" | grep -q "published.*\"${port}\""; then
        echo "✅ Service '${service}' has correct port mapping (${port})"
    else
        echo "❌ Service '${service}' port mapping (${port}) is incorrect"
        exit 1
    fi
done

# Test 4: Check network configuration
echo ""
echo "🔍 Testing network configuration..."
if docker compose config | grep -q "business-management-network"; then
    echo "✅ Custom network 'business-management-network' is configured"
else
    echo "❌ Custom network 'business-management-network' is missing"
    exit 1
fi

# Test 5: Check volumes configuration
echo ""
echo "🔍 Testing volumes configuration..."
required_volumes=("db_data" "redis_data" "node_modules")
missing_volumes=()

for volume in "${required_volumes[@]}"; do
    if docker compose config | grep -q "^  ${volume}:"; then
        echo "✅ Volume '${volume}' is defined"
    else
        echo "❌ Volume '${volume}' is missing"
        missing_volumes+=("${volume}")
    fi
done

if [ ${#missing_volumes[@]} -gt 0 ]; then
    echo "❌ Missing volumes: ${missing_volumes[*]}"
    exit 1
fi

# Test 6: Check dependencies
echo ""
echo "🔍 Testing service dependencies..."
if docker compose config | grep -A 5 "depends_on:" | grep -q "db:"; then
    echo "✅ Services have proper database dependencies"
else
    echo "❌ Database dependencies are not configured"
    exit 1
fi

echo ""
echo "🎉 All tests passed! Docker Compose configuration is valid."
echo ""
echo "=== Configuration Summary ==="
echo "Services: $(docker compose config --services | wc -l | xargs)"
echo "Networks: $(docker compose config | grep -c "networks:" | xargs)"
echo "Volumes: $(docker compose config | grep -c "volumes:" | xargs)"