#!/bin/bash

exec 0< $"./input"
exec  1> $"./logfile"
exec  2> $"./errorfile"

TIMEOUT=$1
EXEC=$2
COMPILER=$3
FILENAME=$4
shift 4
FLAGS=$@


timeout -t $TIMEOUT $COMPILER $FILENAME $FLAGS \
	&& timeout -t $TIMEOUT $EXEC

