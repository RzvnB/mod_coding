#!/usr/bin/env sh


for classfile in *.class; do
    classname=${classfile%.*}
    #echo $classname

    #Execute fgrep with -q option to not display anything on stdout when the match is found
    if javap -public $classname | fgrep -q 'public static void main(java.lang.String[])'; then
        java $classname "$@"
        exit 0;
    fi
done
