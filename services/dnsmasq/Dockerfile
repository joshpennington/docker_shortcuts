FROM alpine:3.14

RUN apk --no-cache add dnsmasq

ADD dnsmasq.conf /etc/dnsmasq.conf

ENTRYPOINT [ "dnsmasq", "-k" ]
