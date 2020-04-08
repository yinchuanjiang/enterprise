apidoc -i app/Http/Controllers -o public/apidoc
git add .
git commit -m 'commit'
git push
envoy run deploy