# Dockerfile
FROM php:8.4-cli

RUN apt-get update && apt-get install -y inotify-tools

ARG HOST_UID
ARG HOST_GID

RUN groupadd -g $HOST_GID hostgroup && \
    useradd -m -u $HOST_UID -g $HOST_GID hostuser

USER hostuser
WORKDIR /app

CMD ["-c", "echo 'Container ready. Override CMD to run something.'"]
