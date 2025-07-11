FROM node:18-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    bash

# Set working directory
WORKDIR /app

# Copy package files
COPY frontend/package*.json ./

# Install dependencies
RUN npm ci --only=production=false

# Copy application files
COPY frontend/ .

# Build the application
RUN npm run build

# Expose port
EXPOSE 3000

# Development command
CMD ["npm", "run", "dev"]