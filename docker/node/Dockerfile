FROM node:18-alpine

# Install system dependencies for development
RUN apk add --no-cache \
    git \
    curl \
    bash \
    dumb-init

# Create app directory
RUN mkdir -p /app && chown -R node:node /app

# Set working directory
WORKDIR /app

# Switch to non-root user
USER node

# Copy package files (copy to a temporary location first to avoid permission issues)
COPY --chown=node:node frontend/package*.json ./

# Install dependencies
# Using npm ci for faster, reliable, reproducible builds
RUN npm install --include=dev

# Copy application files
COPY --chown=node:node frontend/ .

# Create necessary directories
RUN mkdir -p node_modules/.cache && \
    mkdir -p build && \
    mkdir -p .vite

# Expose port
EXPOSE 3000

# Use dumb-init to handle signals properly
ENTRYPOINT ["dumb-init", "--"]

# Development command with hot reload
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]