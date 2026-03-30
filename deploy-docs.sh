#!/usr/bin/env sh

# abort on errors
set -e

# A few properties
repository="git@github.com:aedart/athenaeum.git"
branch="main:gh-pages"
build_directory=".build"

# Clear the build directory, but keep the directory
if [ -d "$build_directory" ]; then
    cd "$build_directory" || exit
    find . -mindepth 1 -delete
    cd ..
else
    echo "Error: Directory '$build_directory' does not exist." >&2
    exit 1
fi

# build the docs
if command -v "yarn" > /dev/null;
then
    yarn run docs:build-prod
else
    npm run docs:build-prod
fi

# navigate into the build output directory
cd "$build_directory"

# if you are deploying to a custom domain
# echo 'www.example.com' > CNAME

# Init repository and commit all files
git init
git add -A
git commit -m 'deploy docs'

# if you are deploying to https://<USERNAME>.github.io
# git push -f git@github.com:<USERNAME>/<USERNAME>.github.io.git main

# if you are deploying to https://<USERNAME>.github.io/<REPO>
git push -f $repository $branch

cd -
