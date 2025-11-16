#!/bin/sh

IMAGE=ghcr.io/the-toster/dcq:latest

docker pull $IMAGE
docker tag $IMAGE dcq:current

INSTALL_TO=~/.local/bin/dcq
> $INSTALL_TO

