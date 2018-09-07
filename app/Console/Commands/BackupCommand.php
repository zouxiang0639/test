<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\DbDumper\Databases\MySql;
use Mail;

class BackupCommand extends Command
{
    /** @var string */
    protected $signature = 'backup:run';

    /** @var string */
    protected $description = '备份数据库';

    public function handle()
    {
        $this->line('开始备份mysql数据');
        $path = config('filesystems.disks.backup.root');
        $name = date('Ymd-His', time()).'-1.sql.gz';
        $mysqlConfig = config('database.connections.mysql');
        MySql::create()
            ->setDumpBinaryPath(config('admin.data_backup_dump_binary_path'))
            ->setDbName($mysqlConfig['database'])
            ->setUserName($mysqlConfig['username'])
            ->setPassword($mysqlConfig['password'])
            ->enableCompression()
            ->dumpToFile($path.'/'.$name);

        $email = config('admin.data_backup_seed_email');
        if($email) {
            Mail::send('admin::email.content',['content'=>'数据库备份'],function($message) use ($path, $email, $name){
                $message->to($email)->subject('数据库备份文件'.$name);

                //在邮件中上传附件
                $message->attach($path.'/'.$name);
            });
        }

        $this->line('完成');

    }


}
