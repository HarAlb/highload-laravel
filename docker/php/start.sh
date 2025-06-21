#!/bin/bash

echo "⏳ Waiting for PostgreSQL (db:5432)..."
until echo > /dev/tcp/db/5432; do
  sleep 1
done
echo "✅ PostgreSQL is up!"

echo "⏳ Waiting for Redis (redis:6379)..."
until echo > /dev/tcp/redis/6379; do
  sleep 1
done
echo "✅ Redis is up!"

echo "⏳ Waiting for RabbitMQ (rabbitmq:5672)..."
until echo > /dev/tcp/rabbitmq/5672; do
  sleep 1
done
echo "✅ RabbitMQ is up!"

php-fpm &

exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf -n
