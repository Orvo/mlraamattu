#!/bin/bash
echo "Checking for updates..."

git remote update
LOCAL=$(git rev-parse @)
REMOTE=$(git rev-parse @{u})
BASE=$(git merge-base @ @{u})

if [ $LOCAL = $REMOTE ]; then
	echo "Local repository is already up to date."
elif [ $LOCAL = $BASE ]; then
	CHANGES=$(git diff --name-only "$LOCAL" "$REMOTE")
	git pull
	if [ $? -eq 0 ]; then
		echo "Repository updated."
		if grep -q "\.js$\|\.css$" <<< "$CHANGES"; then
			echo "Grunt build required. Building..."
			grunt build
	    	echo "Build done."
	    else
	    	echo "No Grunt build required."
	    fi
	else
	    echo "Repository update failed. Aborting..."
	fi
fi

echo "Deploy finished."