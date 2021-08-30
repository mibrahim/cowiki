#!/usr/bin/env bash
SUDO="sudo"
unameOut="$(uname -s)"
case "${unameOut}" in
    CYGWIN*)    SUDO="";;
    MINGW*)     SUDO="";;
esac
$SUDO docker ps | grep cowiki | cut -d\  -f1

