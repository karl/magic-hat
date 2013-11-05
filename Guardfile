require './rake-guard'
require 'rb-fsevent'

guard 'rake', :task => 'build_uncompressed' do
  watch(%r{.+.coffee})
  watch(%r{^Rakefile.rb})
end
