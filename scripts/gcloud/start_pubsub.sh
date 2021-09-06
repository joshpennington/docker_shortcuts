#! /bin/bash

export PUBSUB_EMULATOR_HOST=127.0.0.1:8085
/usr/lib/google-cloud-sdk/platform/pubsub-emulator/bin/cloud-pubsub-emulator --host=0.0.0.0 --port=8085