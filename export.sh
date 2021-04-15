#!/usr/bin/env bash

if [[ $1 == *-v* ]] ; then
docker exec php_test_avast php console.php upload-xml $2 true
else
docker exec php_test_avast php console.php upload-xml $1 false
fi;