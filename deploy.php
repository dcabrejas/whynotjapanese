<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'my_project');

// Project repository
set('repository', 'git@github.com:dcabrejas/whynotjapanese.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
set('shared_files', ['GeoLite2-City.mmdb', 'public/google16dd7211875b63af.html']);
set('shared_dirs', ['logs', 'public/assets/img']);

// Writable dirs by web server 
set('writable_dirs', []);
set('allow_anonymous_stats', false);

//Keep releases
set('keep_releases', 3);

// Hosts
host('wnj')
    ->stage('production')
    ->roles('app')
    ->set('branch', 'master')
    ->set('deploy_path', '/home/whynotja/___deployment');
    

// Tasks
desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

task('composer:install', function () {
    cd('{{release_path}}');
    run('composer install');
    writeln("Dependencies installed");
});

task('settings:copy', function () {
    cd('{{deploy_path}}/shared');
    run('cp src/settings.php {{release_path}}/src/.');
    writeln("settings copied");
});

task('remove:cache', function () {
    cd('{{release_path}}');
    run('rm -rf cache');
    writeln("Cache cleared");
});

after('deploy:vendors', 'composer:install');
after('deploy:clear_paths', 'settings:copy');
after('cleanup', 'remove:cache');
