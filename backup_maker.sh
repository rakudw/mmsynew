#!/bin/bash

# Store the location of the git repository
git_repo_path=`git rev-parse --show-toplevel`

# Get the list of files modified in the last git commit
files=`git log --name-only -3 --pretty=format: | sed '/^$/d'`

# The destination folder
destination_folder='/Users/rashid/workspace/tmp/mmsy_updates'

rm -rf "$destination_folder/*"

# Copy each file, preserving the folder structure
for file in $files; do
    # Create the destination folder, if it does not exist
    mkdir -p "$destination_folder/$(dirname "$file")"
    # Copy the file to the destination folder
    cp "$git_repo_path/$file" "$destination_folder/$file"
done