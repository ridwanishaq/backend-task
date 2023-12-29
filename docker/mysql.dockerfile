# Use the official MySQL image as a parent image
FROM mysql:8.0

# Set the root password
ENV MYSQL_ROOT_PASSWORD='${ROOT_PASSWORD}'

# Create a database and user
ENV MYSQL_DATABASE='${DB_DATABASE}'
ENV MYSQL_USER='${DB_USERNAME}'
ENV MYSQL_PASSWORD='${DB_PASSWORD}'

# Expose port 3306 for MySQL
EXPOSE 3306
