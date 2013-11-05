require 'rubygems'
require './lib/Runner'

environments = {
  :dev => {
    :name => 'Dev',
    :dir  => '/home/karl/hosting/web/monket.net/magic-hat-dev',
    :host => 'tastycake.net'
  },

  :live => {
    :name => 'Live',
    :dir  => '/home/karl/hosting/web/monket.net/magic-hat',
    :host => 'tastycake.net'
  }
}

task :build => [:coffee_script, :compress_js]
task :build_uncompressed => [:coffee_script, :concat_js]

task :default => [:build]
task :build_and_deploy_to_live => [:build, :deploy_to_live]

task :coffee_script do
  puts '= Coffee Script ='
  run './node_modules/.bin/coffee --output scripts --compile coffee-scripts/*'
end

task :compress_js do
  puts '= Compress JS ='
  run 'cat scripts-lib/jquery.js scripts-lib/underscore.js scripts-lib/backbone.js scripts/Main.js | ./node_modules/.bin/uglifyjs --output app.js'
end

task :concat_js do
  puts '= Concat JS ='
  run 'cat scripts-lib/jquery.js scripts-lib/underscore.js scripts-lib/backbone.js scripts/Main.js > app.js'
end

task :deploy_to_live do
  deploy_to environments[:live]
end

def deploy_to(env)
  host = env[:host]

  puts "== Deploy to #{env[:name]} =="

  # Remove old upload
  ssh "rm -r '#{env[:dir]}-upload'", host, :ignore_failure => true

  # Upload new version
  scp ".", "#{env[:dir]}-upload", host, :excludes => [".git"]

  # Remove any uploaded groups
  ssh "rm -r '#{env[:dir]}-upload'/groups/*.json", host, :ignore_failure => true

  # Copy groups from live deployment
  ssh "cp -R '#{env[:dir]}/groups' '#{env[:dir]}-upload/'", host, :ignore_failure => true

  # Set directory permissions
  ssh "chmod -R 777 '#{env[:dir]}-upload/groups'", host

  # Remove old backup
  ssh "rm -R '#{env[:dir]}-backup'", host, :ignore_failure => true

  # Move live to backup and new to live
  ssh "mv '#{env[:dir]}' '#{env[:dir]}-backup' ; mv '#{env[:dir]}-upload' '#{env[:dir]}'", host
end

def run(command, ignore_failure = false)
  Runner.new($stdout).run command, ignore_failure
end

def ssh(command, domain, options = {})
  options = { :user => 'karl', :port => 22, :ignore_failure => false }.merge(options)

  # Some shell magic to quote and single quotes in the command
  escaped_command = command.gsub("'", "'\\\\''")
  Runner.new($stdout).run "ssh -p #{options[:port].to_s} #{options[:user]}@#{domain} '#{escaped_command} 2>&1'", options[:ignore_failure]
end

def scp(from, to, domain, options = {})
  options = { :user => 'karl', :port => 22, :ignore_failure => false, :excludes => [] }.merge(options)
  excludes = options[:excludes].map { |exclude| "--exclude \"#{exclude}\"" }.join(" ")
  Runner.new($stdout).run "rsync --delete -a --rsh='ssh -p#{options[:port].to_s}' #{excludes} #{from} #{options[:user]}@#{domain}:#{to}", options[:ignore_failure]
end
