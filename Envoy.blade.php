@servers(['web' => 'root@49.235.226.229'])

@task('deploy', ['on' => ['web'], 'parallel' => true])
cd /www/wwwroot/enterprise
{{--git pull origin {{ $branch }}--}}
git reset --hard
git pull origin master
composer install --no-dev
php artisan migrate
chown -R www:www /www/wwwroot/enterprise
@endtask
