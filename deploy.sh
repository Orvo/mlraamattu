#!/bin/bash
echo "Checking for updates..."
git remote update
LOCAL=$(git rev-parse @)
REMOTE=$(git rev-parse @{u})
BASE=$(git merge-base @ @{u})

if [ $LOCAL = $REMOTE ]; then
	echo "Local repository is already up to date."
elif [ $LOCAL = $BASE ]; then
	git pull
	if [ $? -eq 0 ]; then
		echo "Updated repository. Building with Grunt..."
		grunt build
	    echo "Build done."
	else
	    echo "Repository update failed. Aborting..."
	fi
fi