task :build => [:coffee_script, :compress_js]
task :build_uncompressed => [:coffee_script, :concat_js]

task :coffee_script do
    puts '= Coffee Script ='
    `coffee --output scripts --compile coffee-scripts/*`
end

task :compress_js do
    puts '= Compress JS ='
    `cat scripts-lib/jquery.js scripts-lib/underscore.js scripts-lib/backbone.js scripts/Main.js | ./node_modules/.bin/uglifyjs --output app.js`
end

task :concat_js do
    puts '= Concat JS ='
    `cat scripts-lib/jquery.js scripts-lib/underscore.js scripts-lib/backbone.js scripts/Main.js > app.js`
end

