#!/usr/bin/env bash

container=$(buildah from ubuntu)
buildah run $container apt update
buildah run $container apt upgrade -y
buildah run $container apt install -y php php-imagick imagemagick exiftool darktable
buildah copy $container . /usr/src/ribollita/
buildah config --workingdir /usr/src/ribollita $container
buildah config --port 8000 $container
buildah config --cmd "php -S 0.0.0.0:8000" $container
buildah config --label description="Ribollita container image" $container
buildah config --label maintainer="dmpop@linux.com" $container
buildah config --label version="0.1" $container
buildah commit --squash $container ribollita
buildah rm $container