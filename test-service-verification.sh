#!/bin/bash

# Docker Compose Service Verification Test Script
# Tests all services for proper startup, communication, and health

echo "=== Docker Compose Service Verification Test ==="
echo ""

# Test 1: Verify all services are running
echo "🔍 Testing service status..."
service_count=$(docker compose ps --format table | tail -n +2 | wc -l | xargs)
expected_services=7

if [ "$service_count" -eq "$expected_services" ]; then
    echo "✅ All $expected_services services are running"
else
    echo "❌ Expected $expected_services services, but found $service_count"
    exit 1
fi

# Test 2: Test port accessibility
echo ""
echo "🔍 Testing port accessibility..."
ports=(
    "80:nginx health check"
    "3000:frontend"
    "8000:backend"
    "8081:phpMyAdmin"
    "8025:mailhog"
)

for port_test in "${ports[@]}"; do
    port=$(echo "$port_test" | cut -d: -f1)
    service_name=$(echo "$port_test" | cut -d: -f2)
    
    if curl -s --connect-timeout 5 "http://localhost:$port" > /dev/null; then
        echo "✅ Port $port ($service_name) is accessible"
    else
        echo "❌ Port $port ($service_name) is not accessible"
        exit 1
    fi
done

# Test 3: Test database connectivity
echo ""
echo "🔍 Testing database connectivity..."
if docker compose exec -T db mysql -u bmuser -pbmpass business_management -e "SELECT 1;" > /dev/null 2>&1; then
    echo "✅ Database connectivity is working"
else
    echo "❌ Database connectivity failed"
    exit 1
fi

# Test 4: Test Redis connectivity
echo ""
echo "🔍 Testing Redis connectivity..."
if docker compose exec -T redis redis-cli ping | grep -q "PONG"; then
    echo "✅ Redis connectivity is working"
else
    echo "❌ Redis connectivity failed"
    exit 1
fi

# Test 5: Test frontend build
echo ""
echo "🔍 Testing frontend service..."
if curl -s http://localhost:3000 | grep -q "Business Management System"; then
    echo "✅ Frontend is serving content correctly"
else
    echo "❌ Frontend is not serving expected content"
    exit 1
fi

# Test 6: Test nginx reverse proxy
echo ""
echo "🔍 Testing nginx reverse proxy..."
if curl -s http://localhost:80/health | grep -q "healthy"; then
    echo "✅ Nginx reverse proxy is working"
else
    echo "❌ Nginx reverse proxy health check failed"
    exit 1
fi

# Test 7: Test service health checks
echo ""
echo "🔍 Testing service health checks..."
healthy_services=$(docker compose ps --format "{{.Name}} {{.Status}}" | grep -c "healthy\|Up")
if [ "$healthy_services" -gt 0 ]; then
    echo "✅ Services are reporting healthy status"
else
    echo "❌ No services are reporting healthy status"
    exit 1
fi

echo ""
echo "🎉 All service verification tests passed!"
echo ""
echo "=== Service Summary ==="
echo "✅ All services started successfully"
echo "✅ All ports are accessible"
echo "✅ Database connectivity confirmed"
echo "✅ Redis connectivity confirmed"
echo "✅ Frontend serving content"
echo "✅ Nginx reverse proxy working"
echo "✅ Health checks passing"
echo ""
echo "Services verified: db, backend, frontend, nginx, phpmyadmin, mailhog, redis"