require 'guard/guard'

module Guard
  class Rake < Guard

    def initialize(watchers = [], options = {})
      super

      @task = options[:task]
      @title = options[:title]
      @title ||= options[:task]
    end

    def start
        do_run
    end

    def run_all
        do_run
    end

    def run_on_change(paths)
        do_run
    end

    def run_on_deletion(paths)
        do_run
    end

    def do_run
      UI.info "Running task '#{@task}'"

      output = `rake #{@task} 2>&1`
      success = $?.exitstatus == 0

      UI.info output

      if success
        # Notifier.notify('', :title => @title, :image => :success)
        # Temporary fix until terminal-notifier-guard works on OSX 10.9
        `terminal-notifier -message '#{}' -title '#{@title}' -sender com.apple.GameCenter`
      else
        # Notifier.notify(output[0..250] + '...', :title => @title, :image => :failed)
        # Temporary fix until terminal-notifier-guard works on OSX 10.9
        `terminal-notifier -message '#{output[0..250] + '...'}' -title '#{@title}' -sender com.apple.Terminal`
      end

    end

  end
end
