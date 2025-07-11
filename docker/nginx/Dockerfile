# Nginx Dockerfile for Business Management System
# This Dockerfile sets up an optimized nginx server for reverse proxy functionality

FROM nginx:alpine

# Install additional packages for security and performance
RUN apk add --no-cache \
    curl \
    ca-certificates \
    tzdata

# Set timezone to Asia/Tokyo (Japanese business context)
ENV TZ=Asia/Tokyo

# Remove default nginx configuration
RUN rm -f /etc/nginx/conf.d/default.conf

# Copy custom nginx configuration
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/conf.d/ /etc/nginx/conf.d/

# Create nginx cache directory
RUN mkdir -p /var/cache/nginx/client_temp \
    /var/cache/nginx/proxy_temp \
    /var/cache/nginx/fastcgi_temp \
    /var/cache/nginx/uwsgi_temp \
    /var/cache/nginx/scgi_temp

# Create log directory
RUN mkdir -p /var/log/nginx

# Set proper permissions
RUN chown -R nginx:nginx /var/cache/nginx /var/log/nginx /etc/nginx/conf.d

# Test nginx configuration
# RUN nginx -t

# Expose ports
EXPOSE 80 443

# Add health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
  CMD curl -f http://localhost/health || exit 1

# Start nginx
CMD ["nginx", "-g", "daemon off;"]