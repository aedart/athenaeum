#!/usr/bin/env sh

# abort on errors
set -e

# TODO: Clear out built first, or risk of "error: src refspec main does not match any"... or similar issues..

# build
if command -v "yarn" > /dev/null;
then
    yarn run docs:build-prod
else
    npm run docs:build-prod
fi

# navigate into the build output directory
cd .build

# if you are deploying to a custom domain
# echo 'www.example.com' > CNAME

git init
git add -A
git commit -m 'deploy docs'

# if you are deploying to https://<USERNAME>.github.io
# git push -f git@github.com:<USERNAME>/<USERNAME>.github.io.git main

# if you are deploying to https://<USERNAME>.github.io/<REPO>
git push -f git@github.com:aedart/athenaeum.git main:gh-pages

cd -
