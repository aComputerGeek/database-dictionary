<?php

namespace CjwDBMD\src;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseMarkdownController
{
    public function index(Request $request)
    {
        if (empty($request->url)) {
            return redirect($request->url() . '/?url=index');
        }
        switch ($request->url) {
            //首页
            case 'index':
                return $this->main($request);
                break;
            //获取模块信息
            case 'modules':
                return $this->modules($request);
                break;
            // 添加一个模块
            case 'modulesAdd':
                return $this->modulesAdd($request);
                break;
            // 删除一个模块
            case 'modulesDel':
                return $this->modulesDel($request);
                break;
            // 修改一个模块
            case 'modulesUpdate':
                return $this->modulesUpdate($request);
                break;
            // 获取内容信息
            case 'getContain':
                return $this->getContain($request);
                break;
            // 获取表的信息
            case 'getTableInfo':
                return $this->getTableInfo($request);
                break;
            // 修改表的信息
            case 'updateTableInfo':
                return $this->updateTableInfo($request);
                break;
            // 文成文件
            case 'getFile':
                return $this->getFile();
                break;

            default:
                return ['ServerNo' => 404, 'ServerMessage' => 'not found', 'ServerData' => null];;
        }
    }

    /**
     * 主要入口视图
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @Author jiaWen.chen
     */
    public function main(Request $request)
    {
        return view('vendor.mr-jiawen.database-markdown.index');
    }

    /**
     * @param Request $request
     * @return array
     * @Author jiaWen.chen
     */
    public function modules(Request $request)
    {
        $modules = DB::table('database_markdown')->where(['type' => 1])->orderBy('order', 'asc')->get()->toArray();

        return ['ServerNo' => 200, 'ServerMessage' => '请求成功', 'ServerData' => $modules];
    }

    /**
     * 新添加一个模块
     * @param Request $request
     * @return array
     * @Author jiaWen.chen
     */
    public function modulesAdd(Request $request)
    {
        $modules = DB::table('database_markdown')->insert([
            'name' => "请对模块起一个名字",
            'type' => 1,
            'father_id' => 0,
            'order' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return ['ServerNo' => 200, 'ServerMessage' => '请求成功', 'ServerData' => $modules];
    }

    /**
     * 删除一个模块
     * @param Request $request
     * @return array
     * @Author jiaWen.chen
     */
    public function modulesDel(Request $request)
    {
        $modules = DB::table('database_markdown')->delete([
            'id' => $request->id
        ]);

        return ['ServerNo' => 200, 'ServerMessage' => '请求成功', 'ServerData' => $modules];
    }

    /**
     * 修改一个模块的基本信息
     * @param Request $request
     * @return array
     * @Author jiaWen.chen
     */
    public function modulesUpdate(Request $request)
    {
        $modules = DB::table('database_markdown')->where(['id' => $request->id])->update([
            'name' => $request->name,
            'order' => $request->order,
        ]);

        return ['ServerNo' => 200, 'ServerMessage' => '请求成功', 'ServerData' => $modules];
    }

    /**
     * 得到一个模块下面的所有表
     * @param Request $request
     * @return array
     * @Author jiaWen.chen
     */
    public function getContain(Request $request)
    {
        $id = $request->id;

        if ($id == 0) {
            $table = DB::select("select * from information_schema.TABLES where TABLE_SCHEMA='" . env('DB_DATABASE') . "';");

            $tableList = array_map(function ($item) {
                return $item->TABLE_NAME;
            }, $table);

            $model = DB::table("database_markdown")->whereIn("name", $tableList)->get()->toArray();

            $model = array_map(function ($item) {
                return $item->name;
            }, $model);

            $response = [];
            foreach ($table as $item) {
                if (!in_array($item->TABLE_NAME, $model)) {
                    $response[] = $item;
                }
            }

            return ['ServerNo' => 200, 'ServerMessage' => '请求成功', 'ServerData' => ['tableInfo' => $response, 'moduleInfo' => []],];
        }

        $model = DB::table("database_markdown")->where("father_id", $id)->orderBy('order', 'asc')->get()->toArray();
        $modelName = array_map(function ($item) {
            return $item->name;
        }, $model);
        $modelStr = implode("','", $modelName);
        $response = DB::select("select * from information_schema.TABLES where TABLE_SCHEMA='" . env('DB_DATABASE') . "'and TABLE_NAME in('" . $modelStr . "');");

        $result = [];
        foreach ($model as $key => $item) {
            foreach ($response as $one) {
                if ($one->TABLE_NAME == $item->name) {
                    $result[$key] = $one;
                }
            }
        }
        return ['ServerNo' => 200, 'ServerMessage' => '请求成功', 'ServerData' => ['tableInfo' => $result, 'moduleInfo' => $model]];
    }

    /**
     * 查询表结构
     * @param Request $request
     * @return array
     * @Author jiaWen.chen
     */
    public function getTableInfo(Request $request)
    {
        $tableInfo = DB::select('show full columns from ' . $request->name);

        return ['ServerNo' => 200, 'ServerMessage' => '请求成功', 'ServerData' => $tableInfo];
    }

    /**
     * 更新表所在模板信息
     * @param Request $request
     * @return array
     * @Author jiaWen.chen
     */
    public function updateTableInfo(Request $request)
    {
        if (!empty($request->delete)) {
            DB::table("database_markdown")->where("name", $request->name)->delete();
        } elseif (!empty($request->father_id)) {
            DB::table("database_markdown")->insert(['name' => $request->name, 'type' => 2, 'father_id' => $request->father_id, 'order' => 1, 'created_at' => date('Y-m-d H:i:s')]);
        } else {
            DB::table("database_markdown")->where("name", $request->name)->update(['order' => $request->order, 'updated_at' => date('Y-m-d H:i:s')]);
        }

        return ['ServerNo' => 200, 'ServerMessage' => '请求成功', 'ServerData' => null];
    }

    /**
     * 生成文件
     * @return array
     * @Author jiaWen.chen
     */
    public function getFile()
    {
        $modules = DB::table('database_markdown')->where(['type' => 1])->orderBy('order', 'asc')->get()->toArray();

        foreach ($modules as $module) {
            $datatables = DB::table('database_markdown')->where(['type' => 2, 'father_id' => $module->id])->orderBy('order', 'asc')->get()->toArray();;

            $fileName = $module->name . '.md';

            $str = '';

            foreach ($datatables as $datatable) {
                $datatableConstruct = DB::select('show full columns from ' . $datatable->name);
                $datatableInfo = DB::select("select * from information_schema.TABLES where TABLE_SCHEMA='" . env('DB_DATABASE') . "' and TABLE_NAME='" . $datatable->name . "';");
                $str .= '#### ' . $datatable->order . '. ' . $datatable->name . ' ' . $datatableInfo[0]->TABLE_COMMENT . "\r\n\r\n";
                $str .= "|字段|类型|是否为空|名称|\r\n";
                $str .= "|---|---|---|---|---|\r\n";
                foreach ($datatableConstruct as $value) {
                    $str .= "|{$value->Field}|{$value->Type}|{$value->Null}|{$value->Comment}|\r\n";
                }
                $str .= "\r\n";

            }
            if (!\File::exists(storage_path('database/'))) {
                mkdir(storage_path('database/'));
            }
            \File::put(storage_path('database/' . $fileName), $str);
        }
        return ['ServerNo' => 200, 'ServerMessage' => '请求成功', 'ServerData' => null];
    }
}
