# A sample Guardfile

gem 'growl'

notification :growl

guard 'rake', :task => 'build_uncompressed' do
  watch(%r{.+.coffee})
  watch(%r{^Rakefile.rb})
end
