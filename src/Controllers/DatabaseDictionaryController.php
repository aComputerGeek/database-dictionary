<?php

namespace Jw\Database\Dictionary\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jw\Database\Dictionary\Models\DatabaseDictionary;
use Jw\Database\Dictionary\Models\Table;

class DatabaseDictionaryController extends Controller
{
    public function index(Request $request)
    {
        $databaseDictionary = DatabaseDictionary::when(!empty($request['type']), function ($query) use ($request) {
            return $query->where(['type' => $request['type']]);
        })->when(!empty($request['father_id']), function ($query) use ($request) {
            return $query->with('table_data')->where(['father_id' => $request['father_id']]);
        })
            ->orderBy('order', 'asc')
            ->get();

        return $databaseDictionary->toArray();
    }

    public function store(Request $request)
    {
        $databaseDictionary = new DatabaseDictionary();

        $databaseDictionary->title = $request->title ?: '';
        $databaseDictionary->order = $request->order ?: 0;
        $databaseDictionary->type = $request->type ?: 1;
        $databaseDictionary->father_id = $request->father_id ?: 0;

        $databaseDictionary->save();

        return ['ServerNo' => 200];
    }

    public function update(Request $request)
    {
        $databaseDictionary = DatabaseDictionary::findOrFail($request->id);

        $databaseDictionary->title = $request->title ?: '';
        $databaseDictionary->order = $request->order ?: 0;
        $databaseDictionary->type = $request->type ?: 1;

        $databaseDictionary->save();

        return ['ServerNo' => 200];
    }

    public function destroy(Request $request)
    {
        DatabaseDictionary::destroy($request->id);
        return ['ServerNo' => 200];
    }

    public function getAllTable()
    {
        $databaseDictionary = DatabaseDictionary::with('child')->where(['type' => 1])->get();

        $tableName = [''];
        $databaseDictionary->each(function ($item) use (&$tableName) {
            $item->child->each(function ($item) use (&$tableName) {
                $tableName[] = $item->title;
            });
        });

        return Table::whereNotIn('TABLE_NAME', $tableName)->get();
    }

    public function tableConstruct(Request $request)
    {
        return DB::select('show full columns from ' . $request->tableName);
    }

    public function markdown()
    {
        $modules = DatabaseDictionary::with('child')->where(['type' => 1])->orderBy('order', 'asc')->get();

        $modules->each(function ($module) {
            $fileName = $module->title . '.md';
            $content = '';
            $module->child->each(function ($child) use (&$content) {
                $tableConstruct = DB::select('show full columns from ' . $child->title);

                $content .= '#### ' . $child->order . '. ' . $child->title . ' ' . $child->table_data->TABLE_COMMENT . "\r\n\r\n";
                $content .= "|Field|Type|Null|Key|Default|Extra|Comment|\r\n";
                $content .= "|---|---|---|---|---|---|---|\r\n";
                foreach ($tableConstruct as $value) {
                    $content .= "|{$value->Field}|{$value->Type}|{$value->Null}|{$value->Key}|{$value->Default}|{$value->Extra}|{$value->Comment}|\r\n";
                }
                $content .= "\r\n";
            });
            if (!\File::exists(storage_path('database/'))) {
                mkdir(storage_path('database/'));
            }
            \File::put(storage_path('database/' . $fileName), $content);
        });
        return ['ServerNo' => 200];
    }
}
