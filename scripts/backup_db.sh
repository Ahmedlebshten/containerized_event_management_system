#!/bin/bash

echo "Starting database backup..."

# Load environment variables
set -o allexport
source ./config/.env
set +o allexport

# Define constants
BACKUP_DIR="./db_backups"
CONTAINER_NAME="mysql_container"
BACKUP_FILE="$BACKUP_DIR/db_backup_$(date +'%Y-%m-%d_%H-%M-%S').sql"

# Create backup directory if it doesn't exist
mkdir -p "$BACKUP_DIR"

# Run the backup
if docker exec "$CONTAINER_NAME" sh -c "mysqldump -u$DB_USER -p$DB_PASS $DB_NAME 2>/dev/null" > "$BACKUP_FILE"; then
    echo "Backup saved at: $BACKUP_FILE"
else
    echo "Backup failed!"
fi
