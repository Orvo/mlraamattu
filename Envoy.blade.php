@servers(['ranska' => 'root@uusi.raamattuavautuu.fi'])

@task('deploy', ['on' => 'ranska'])
    cd /home/www/mlraamattu/html/
    ./dobackup.sh
    ./deploy.sh
@endtask
