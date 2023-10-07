#!/bin/bash

: '
todo script: running this greps for all @* tags in the codebase so we can see what we need to work on

tags:
	- @TODO: features that need to be implemented
	- @CLEANUP: stuff thats ugly, incomplete, unsafe, etc.
'
echo "Things left to do:"
grep -r --exclude="TODO.sh" "@TODO" *
echo "Things to clean up:"
grep -r --exclude="TODO.sh" "@CLEANUP" *
