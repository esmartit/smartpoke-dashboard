#!/bin/sh
# This is a comment!
echo Hello World!!        # This is a comment, too!

docker build -t esmartit/smartpoke-dashboard:"$1" -t esmartit/smartpoke-dashboard:latest .
                            .