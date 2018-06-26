FROM anapsix/alpine-java:8_jdk

ARG user=dumbdocker
ARG group=dumbdocker
ARG uid=1000
ARG gid=1000

RUN apk add --no-cache build-base bash

RUN mkdir -p /usr/src/app/
RUN mkdir /usr/scripts/
COPY ./javaRunner.sh /usr/scripts/
COPY ./build.sh /usr/scripts/

RUN addgroup -S -g ${gid} ${group} \
    && adduser -S -H -u ${uid} -G ${group} ${user} \
    && chown -R ${uid}:${gid} /usr/src/app/

VOLUME /usr/src/app
WORKDIR /usr/src/app
USER ${user}
