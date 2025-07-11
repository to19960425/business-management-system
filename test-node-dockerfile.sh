#!/bin/bash

# Node.js Dockerfile Test Script
# This script validates the Node.js Dockerfile configuration

echo "=== Node.js Dockerfile Test ==="
echo ""

# Test 1: Check if Dockerfile exists
echo "🔍 Testing Node.js Dockerfile existence..."
if [ -f "docker/node/Dockerfile" ]; then
    echo "✅ Node.js Dockerfile exists"
else
    echo "❌ Node.js Dockerfile not found"
    exit 1
fi

# Test 2: Validate Node.js version
echo ""
echo "🔍 Testing Node.js version..."
if grep -q "FROM node:18-alpine" docker/node/Dockerfile; then
    echo "✅ Node.js 18 Alpine is specified"
else
    echo "❌ Node.js 18 Alpine not found"
    exit 1
fi

# Test 3: Check development dependencies
echo ""
echo "🔍 Testing development dependencies..."
required_deps=("git" "curl" "bash" "dumb-init")
missing_deps=()

for dep in "${required_deps[@]}"; do
    if grep -q "${dep}" docker/node/Dockerfile; then
        echo "✅ Dependency '${dep}' is included"
    else
        echo "❌ Dependency '${dep}' is missing"
        missing_deps+=("${dep}")
    fi
done

if [ ${#missing_deps[@]} -gt 0 ]; then
    echo "❌ Missing dependencies: ${missing_deps[*]}"
    exit 1
fi

# Test 4: Check working directory
echo ""
echo "🔍 Testing working directory setup..."
if grep -q "WORKDIR /app" docker/node/Dockerfile; then
    echo "✅ Working directory is set to /app"
else
    echo "❌ Working directory not properly set"
    exit 1
fi

# Test 5: Check security (non-root user)
echo ""
echo "🔍 Testing security configuration..."
if grep -q "USER node" docker/node/Dockerfile; then
    echo "✅ Non-root user (node) is configured"
else
    echo "❌ Non-root user is not configured"
    exit 1
fi

# Test 6: Check hot reload configuration
echo ""
echo "🔍 Testing hot reload configuration..."
if grep -q "npm.*run.*dev" docker/node/Dockerfile && grep -q "0.0.0.0" docker/node/Dockerfile; then
    echo "✅ Hot reload is properly configured"
else
    echo "❌ Hot reload configuration is missing"
    exit 1
fi

# Test 7: Check port exposure
echo ""
echo "🔍 Testing port exposure..."
if grep -q "EXPOSE 3000" docker/node/Dockerfile; then
    echo "✅ Port 3000 is exposed"
else
    echo "❌ Port 3000 is not exposed"
    exit 1
fi

# Test 8: Check proper signal handling
echo ""
echo "🔍 Testing signal handling..."
if grep -q "dumb-init" docker/node/Dockerfile && grep -q "ENTRYPOINT.*dumb-init" docker/node/Dockerfile; then
    echo "✅ Proper signal handling with dumb-init"
else
    echo "❌ Signal handling not properly configured"
    exit 1
fi

# Test 9: Check package management
echo ""
echo "🔍 Testing package management..."
if grep -q "npm ci" docker/node/Dockerfile; then
    echo "✅ Using npm ci for deterministic builds"
else
    echo "❌ npm ci not used for package installation"
    exit 1
fi

# Test 10: Check development dependencies inclusion
echo ""
echo "🔍 Testing development dependencies inclusion..."
if grep -q "include=dev" docker/node/Dockerfile; then
    echo "✅ Development dependencies are included"
else
    echo "❌ Development dependencies not included"
    exit 1
fi

echo ""
echo "🎉 All tests passed! Node.js Dockerfile is properly configured."
echo ""
echo "=== Configuration Summary ==="
echo "Base Image: Node.js 18 Alpine"
echo "Working Directory: /app"
echo "User: node (non-root)"
echo "Port: 3000"
echo "Hot Reload: Enabled"
echo "Signal Handling: dumb-init"
echo "Package Manager: npm ci"