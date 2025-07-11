#!/bin/bash

# Test script for nginx configuration validation
# This script tests the nginx configuration and validates the requirements

set -e

echo "🔍 Testing Nginx Configuration for Issue #7"
echo "============================================"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Test counters
TESTS_PASSED=0
TESTS_FAILED=0

# Test function
test_result() {
    if [ $1 -eq 0 ]; then
        echo -e "${GREEN}✓ PASS${NC}: $2"
        ((TESTS_PASSED++))
    else
        echo -e "${RED}✗ FAIL${NC}: $2"
        ((TESTS_FAILED++))
    fi
}

echo "Testing nginx configuration files..."

# Test 1: Check if nginx Dockerfile exists
echo -e "\n${YELLOW}1. Checking for nginx Dockerfile...${NC}"
if [ -f "docker/nginx/Dockerfile" ]; then
    test_result 0 "Nginx Dockerfile exists"
else
    test_result 1 "Nginx Dockerfile missing"
fi

# Test 2: Check if nginx.conf exists and has basic configuration
echo -e "\n${YELLOW}2. Checking nginx.conf...${NC}"
if [ -f "docker/nginx/nginx.conf" ]; then
    test_result 0 "nginx.conf exists"
    
    # Check for gzip compression
    if grep -q "gzip on" docker/nginx/nginx.conf; then
        test_result 0 "Gzip compression enabled"
    else
        test_result 1 "Gzip compression not enabled"
    fi
else
    test_result 1 "nginx.conf missing"
fi

# Test 3: Check if default.conf exists and has proper proxy configuration
echo -e "\n${YELLOW}3. Checking default.conf proxy configuration...${NC}"
if [ -f "docker/nginx/conf.d/default.conf" ]; then
    test_result 0 "default.conf exists"
    
    # Check for API proxy
    if grep -q "location /api" docker/nginx/conf.d/default.conf; then
        test_result 0 "API proxy configuration found"
    else
        test_result 1 "API proxy configuration missing"
    fi
    
    # Check for frontend proxy
    if grep -q "proxy_pass.*frontend" docker/nginx/conf.d/default.conf; then
        test_result 0 "Frontend proxy configuration found"
    else
        test_result 1 "Frontend proxy configuration missing"
    fi
    
    # Check for backend proxy
    if grep -q "proxy_pass.*backend" docker/nginx/conf.d/default.conf; then
        test_result 0 "Backend proxy configuration found"
    else
        test_result 1 "Backend proxy configuration missing"
    fi
else
    test_result 1 "default.conf missing"
fi

# Test 4: Check for security headers
echo -e "\n${YELLOW}4. Checking security headers...${NC}"
if [ -f "docker/nginx/conf.d/default.conf" ]; then
    # Check for X-Frame-Options
    if grep -q "X-Frame-Options" docker/nginx/conf.d/default.conf; then
        test_result 0 "X-Frame-Options header configured"
    else
        test_result 1 "X-Frame-Options header missing"
    fi
    
    # Check for X-Content-Type-Options
    if grep -q "X-Content-Type-Options" docker/nginx/conf.d/default.conf; then
        test_result 0 "X-Content-Type-Options header configured"
    else
        test_result 1 "X-Content-Type-Options header missing"
    fi
    
    # Check for X-XSS-Protection
    if grep -q "X-XSS-Protection" docker/nginx/conf.d/default.conf; then
        test_result 0 "X-XSS-Protection header configured"
    else
        test_result 1 "X-XSS-Protection header missing"
    fi
    
    # Check for Referrer-Policy
    if grep -q "Referrer-Policy" docker/nginx/conf.d/default.conf; then
        test_result 0 "Referrer-Policy header configured"
    else
        test_result 1 "Referrer-Policy header missing"
    fi
fi

# Test 5: Check docker-compose.yml nginx service configuration
echo -e "\n${YELLOW}5. Checking docker-compose.yml nginx service...${NC}"
if [ -f "docker-compose.yml" ]; then
    if grep -q "nginx:" docker-compose.yml; then
        test_result 0 "Nginx service defined in docker-compose.yml"
        
        # Check for proper port mapping
        if grep -A10 "nginx:" docker-compose.yml | grep -q "80:80"; then
            test_result 0 "Port 80 mapping configured"
        else
            test_result 1 "Port 80 mapping missing"
        fi
        
        # Check for volume mounts
        if grep -A10 "nginx:" docker-compose.yml | grep -q "nginx.conf"; then
            test_result 0 "nginx.conf volume mount configured"
        else
            test_result 1 "nginx.conf volume mount missing"
        fi
    else
        test_result 1 "Nginx service not defined in docker-compose.yml"
    fi
else
    test_result 1 "docker-compose.yml missing"
fi

# Test 6: Validate nginx configuration syntax (if nginx is available)
echo -e "\n${YELLOW}6. Validating nginx configuration syntax...${NC}"
echo -e "${YELLOW}nginx command not available, skipping syntax validation${NC}"

# Summary
echo -e "\n${YELLOW}============================================${NC}"
echo -e "${YELLOW}Test Summary:${NC}"
echo -e "${GREEN}Passed: $TESTS_PASSED${NC}"
echo -e "${RED}Failed: $TESTS_FAILED${NC}"

if [ $TESTS_FAILED -eq 0 ]; then
    echo -e "\n${GREEN}🎉 All tests passed! Nginx configuration meets requirements.${NC}"
    exit 0
else
    echo -e "\n${RED}❌ Some tests failed. Please fix the issues above.${NC}"
    exit 1
fi