set :application, "dependency"
set :domain,      "dependency.me"
set :deploy_to,   "/home/data/www/dependency/me/sites/www"
set :app_path,    "app"
set :user,        "deploy-dependencyme"


# Permissions
set :writable_dirs,       ["app/cache", "app/logs"]
set :webserver_user,      "www-data"
set :permission_method,   :acl
set :use_set_permissions, true
before "deploy:restart", "deploy:set_permissions"


# CSM
set :repository,  "git@dependency.me:/var/git/composout.git"
set :scm,         :git
set :branch,      "master"

# DB
set :model_manager, "doctrine"

# Local configuration
set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]
set :use_composer, true


role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Symfony2 migrations will run


# Be more verbose by uncommenting the following line
#logger.level = Logger::MAX_LEVEL

set   :use_sudo,      false
set   :keep_releases, 3
#default_run_options[:pty] = true
