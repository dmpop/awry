#!/usr/bin/env bash

container=$(buildah from opensuse/leap)
buildah run $container zypper update
buildah run $container zypper -n install php7 php7-exif php7-imagick ImageMagick exiftool darktable
buildah copy $container . /usr/src/raw-cow/
buildah config --workingdir /usr/src/raw-cow $container
buildah config --port 8000 $container
buildah config --cmd "php -S 0.0.0.0:8000" $container
buildah config --label description="RAW Cow container image" $container
buildah config --label maintainer="dmpop@linux.com" $container
buildah config --label version="0.1" $container
buildah commit --squash $container raw-cow
buildah rm $container