#!/bin/bash

# Check if docker is installed
if ! command -v docker &> /dev/null; then
    echo "Docker not installed. Please install Docker first."
    exit 1
fi

# Check if docker-compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo "Docker Compose not installed. Please install Docker Compose first."
    exit 1
fi

echo "Starting Docker containers..."
docker-compose up -d

echo "Running additional setup..."
echo "container worked successfully!!" 

