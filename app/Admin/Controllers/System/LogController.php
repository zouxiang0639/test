<?php

namespace App\Admin\Controllers\System;


use App\Http\Controllers\Controller;
use App\Library\Admin\Log\LogViewer;
use Illuminate\Http\Request;
use View;

class LogController extends Controller
{
    public function index(Request $request)
    {

        if ($request->file === null) {
            $request->file = (new LogViewer())->getLastModifiedLog();
        }

        $offset = $request->get('offset');
        $viewer = new LogViewer($request->file);
        return View::make('admin::system.log.index', [
            'logs'      => $viewer->fetch($offset),
            'logFiles'  => $viewer->getLogFiles(),
            'fileName'  => $viewer->file,
            'prevUrl'   => $viewer->getPrevPageUrl(),
            'nextUrl'   => $viewer->getNextPageUrl(),
            'filePath'  => $viewer->getFilePath(),
            'size'      => static::bytesToHuman($viewer->getFilesize()),
        ]);
    }


    protected static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2).' '.$units[$i];
    }
}
