<?php

namespace App\Admin\Controllers\System;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Admin\Backup\MysqlBackup;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use View;
use Session;
use Storage;

/**
 * Created by BackupController.
 * @author: zouxiang
 * @date:
 */
class BackupController extends Controller
{

    public function index()
    {
        $list = MysqlBackup::showTable();

        //格式数据
        Collection::make($list)->each(function($item) {
            $item->Data_length = MysqlBackup::format_bytes($item->Data_length);
        });

        return View::make('admin::system.backup.index', [
            'list' => $list
        ]);
    }

    /**
     * 初始化备份数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function export(Request $request)
    {
        $tables = $request->tables;

        $this->isEmpty($tables);

        if(empty($tables) && !is_array($tables)) {
            throw new LogicException(1010001, '参数错误');
        }
        $path = config('filesystems.disks.backup.root');

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        //读取备份配置
        $config = array(
            'path' => realpath($path) . DIRECTORY_SEPARATOR,
            'part' => config('admin.data_backup_part_size'),
            'compress' => config('admin.data_backup_compress'),
            'level' => config('admin.data_backup_compress_level')
        );

        //检查是否有正在执行的任务
        $lock = "{$config['path']}backup.lock";

        if (is_file($lock)) {
            //throw new LogicException(1010001, '检测到有一个备份任务正在执行，请稍后再试！');
        } else {
            //创建锁文件
            file_put_contents($lock, time());
        }

        //检查备份目录是否可写
        if (!is_writeable($config['path'])) {
            throw new LogicException(1010001, '备份目录不存在或不可写，请检查后重试！');
        }

        Session::put('backup_config', $config);
        //生成备份文件信息
        $file = array('name' => date('Ymd-His', time()), 'part' => 1);
        Session::put('backup_file', $file);
        //缓存要备份的表
        Session::put('backup_tables', $tables);
        //创建备份文件
        Session::save();
        $Database = new MysqlBackup($file, $config);
        if(false !== $Database->create()) {
            $tab = ['id' => 0, 'start' => 0];
            return (new JsonResponse())->success(['tables' => $tables, 'tab' => $tab, 'msg'=> '初始化成功！']);
        } else {
            throw new LogicException(1010001, '初始化失败，备份文件创建失败！');
        }
    }

    /**
     * 备份表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function exportPut(Request $request)
    {
        $id = $request->id;
        $start = $request->start;

        if(!is_numeric($id) && !is_numeric($start)) {
            throw new LogicException(1010001, '参数错误');
        }

        //备份数据
        $tables = session('backup_tables');

        //备份指定表
        $database = new MysqlBackup(session('backup_file'), session('backup_config'));
        $start    = $database->backup($tables[$id], $start);
        if (false === $start) {
            //出错
            throw new LogicException(1010002, '备份出错');
        } elseif (0 === $start) {
            //下一表
            if (isset($tables[++$id])) {
                $tab = array('id' => $id, 'start' => 0);
                return (new JsonResponse())->success(['tab' => $tab, 'msg'=> "备份完成"]);
            } else {
                //备份完成，清空缓存
                unlink(session('backup_config.path') . 'backup.lock');
                Session::put('backup_config', null);
                //生成备份文件信息
                Session::put('backup_file', null);
                //缓存要备份的表
                Session::put('backup_tables', null);
                //创建备份文件
                Session::save();
                return (new JsonResponse())->success(['msg'=> "备份完成"]);
            }
        } else {
            $tab  = array('id' => $id, 'start' => $start[0]);
            $rate = floor(100 * ($start[0] / $start[1]));
            return (new JsonResponse())->success(['tab' => $tab, 'msg'=> "正在备份...({$rate}%)"]);
        }
    }


    /**
     * 优化表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function optimize(Request $request)
    {
        $tables = $request->tables;
        $this->isEmpty($tables);
        if(MysqlBackup::optimize($tables)) {
            return (new JsonResponse())->success('数据表优化完成');
        } else {
            throw new LogicException(1010001, '数据表优化出错请重试');
        }
    }

    /**
     * 修复表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function repair(Request $request)
    {
        $tables = $request->tables;

        $this->isEmpty($tables);
        if(MysqlBackup::repair($tables)) {
            return (new JsonResponse())->success('数据表修复完成');
        } else {
            throw new LogicException(1010001, '数据表修复出错请重试');
        }
    }

    /**
     * 渲染所有的备份文件
     * @return \Illuminate\Contracts\View\View
     */
    public function file()
    {

        $path = config('filesystems.disks.backup.root');
        //列出备份文件列表

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        $path = realpath($path);
        $flag = \FilesystemIterator::KEY_AS_FILENAME;
        $glob = new \FilesystemIterator($path, $flag);

        $list = array();
        foreach ($glob as $name => $file) {
            if (preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)) {
                $info['name']     = $name;
                $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');

                $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                $part = $name[6];

                if (isset($list["{$date} {$time}"])) {
                    $info         = $list["{$date} {$time}"];
                    $info['part'] = max($info['part'], $part);
                    $info['size'] = MysqlBackup::format_bytes($info['size'] + $file->getSize());
                } else {
                    $info['part'] = $part;
                    $info['size'] = MysqlBackup::format_bytes($file->getSize());
                }
                $extension        = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                $info['time']     = strtotime("{$date} {$time}");


                $list["{$date} {$time}"] = $info;
            }
        }

        return View::make('admin::system.backup.file', [
            'list' => $list
        ]);
    }

    /**
     * 删除备份文件
     * @param $file
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function destroy($file)
    {
        if (Storage::disk('backup')->delete($file)) {
            return (new JsonResponse())->success('备份文件删除成功');
        } else {
            throw new LogicException(1010001, '备份文件删除失败，请检查权限！');
        }
    }

    /**
     * 下载数据库备份
     * @param $file
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($file)
    {
        return Storage::disk('backup')->download($file);
    }

    /**
     * 导入数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function import(Request $request)
    {
        $time = $request->time;
        $part = $request->part;
        $start = $request->start;

        if (is_numeric($time) && is_null($part) && is_null($start)) {
            //初始化
            //获取备份文件信息
            $name  = date('Ymd-His', $time) . '-*.sql*';

            $path  = realpath(config('filesystems.disks.backup.root')) . DIRECTORY_SEPARATOR . $name;
            $files = glob($path);
            $list  = array();
            foreach ($files as $name) {
                $basename        = basename($name);
                $match           = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
                $gz              = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
                $list[$match[6]] = array($match[6], $name, $gz);
            }
            ksort($list);

            //检测文件正确性
            $last = end($list);
            if (count($list) === $last[0]) {
                Session::put('backup_list', $list); //缓存备份列表
                Session::save();
                return (new JsonResponse())->success(['part' => 1, 'start' => 0, 'msg'=> "初始化完成"]);
            } else {
                throw new LogicException(1010001, '备份文件可能已经损坏，请检查！');
            }
        }
    }

    /**
     * 导入数据 分卷导入
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function importPut(Request $request)
    {

        $part = $request->part;
        $start = $request->start;

        if(!is_numeric($part) && !is_numeric($start)) {
            throw new LogicException(1010001, '参数错误');
        }

        $list = session('backup_list');
        $db = new MysqlBackup($list[$part], ['path' => realpath(config('filesystems.disks.backup.root')) . DIRECTORY_SEPARATOR, 'compress' => $list[$part][2]]);

        $start = $db->import($start);


        if (false === $start) {
            return $this->error('还原数据出错！');
        } elseif (0 === $start) {
            //下一卷
            if (isset($list[++$part])) {
                $data = ['part' => $part, 'start' => 0, 'msg' =>"正在还原...#{$part}"];
                return (new JsonResponse())->success($data);
            } else {
                session('backup_list', null);
                return (new JsonResponse())->success(['msg'=>'还原完成!']);
            }
        } else {
            $data = array('part' => $part, 'start' => $start[0]);
            if ($start[1]) {
                $rate = floor(100 * ($start[0] / $start[1]));
                return (new JsonResponse())->success(array_merge($data, ['msg' => "正在还原...#{$part} ({$rate}%)"]));

            } else {
                $data['gz'] = 1;
                return (new JsonResponse())->success(array_merge($data, ['msg' => "正在还原...#{$part}"]));
            }
        }
    }
}
