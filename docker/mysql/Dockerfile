FROM mysql:8.0

# Set environment variables for UTF-8 and timezone
ENV MYSQL_ROOT_PASSWORD=rootpass
ENV MYSQL_DATABASE=business_management
ENV MYSQL_USER=bmuser
ENV MYSQL_PASSWORD=bmpass

# Set timezone to Japan
ENV TZ=Asia/Tokyo

# Install timezone data
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Copy configuration files
COPY conf/my.cnf /etc/mysql/conf.d/
COPY init/ /docker-entrypoint-initdb.d/

# Expose MySQL port
EXPOSE 3306

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
  CMD mysqladmin ping -h localhost -u root -p$MYSQL_ROOT_PASSWORD || exit 1