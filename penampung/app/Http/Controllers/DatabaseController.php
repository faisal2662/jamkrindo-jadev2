<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;




class DatabaseController extends Controller
{

    public function index()
    {
        return view('master-table.tambah');
    }
    public function createTable(Request $request)
    {
        // dd($request->all());
        // Validasi input
        // Validasi input
        $request->validate([
            'tableName' => 'required|string|alpha_dash',
            'columnName.*' => 'required|string|alpha_dash',
            'columnType.*' => 'required|string',
            'lengthValue.*' => 'required|string',
        ]);

        // Ambil nama tabel
        $tableName = $request->input('tableName');

        // Hapus tabel jika sudah ada
        Schema::dropIfExists($tableName);

        // Buat tabel baru
        Schema::create($tableName, function (Blueprint $table) use ($request) {
            $table->increments($request->input('columnName')[0]);


            // Laravel secara otomatis akan menambahkan kolom 'id' jika Anda tidak menyebutkannya
            foreach ($request->input('columnName') as $index => $columnName) {
                if ($index === 0) {
                    continue;
                }

                $columnType = $request->input('columnType')[$index];
                $lengthValue = $request->input('lengthValue')[$index];

                switch ($columnType) {
                    case 'string':
                       $column = $table->string($columnName, $lengthValue);
                        break;
                    case 'integer':
                        $column = $table->integer($columnName);
                        break;
                    case 'boolean':
                        $column =   $table->boolean($columnName);
                        break;
                    case 'date':
                        $column = $table->date($columnName);
                        break;
                    case 'text':
                        $column = $table->text($columnName);
                        break;
                    case 'timestamp':
                        $column =  $table->timestamp($columnName);
                        break;
                    default:
                        break;
                }

                // Jika kolom diatur sebagai nullable
                if ($request->has('asNull_'. $index) ) {
                    $column->nullable();
                }

                // Jika kolom diatur sebagai default
                if ($request->has('asDefined_' .$index) ) {
                    $defaultValue = $request->input('defaultValue')[$index] ?? null;
                    $column->default($defaultValue);
                }
                // // Jika kolom diatur sebagai nullable
                // if ($request->has('asNull') && in_array($index, $request->input('asNull'))) {
                //     $table->nullable();
                // }

                // // Jika kolom diatur sebagai default
                // if ($request->has('asDefined') && in_array($index, $request->input('asDefined'))) {

                //     $defaultValue = $request->input('defaultValue')[$index] ?? null;
                //     $table->default($defaultValue);
                // }
            }
        });
        return redirect()->back()->with('success', 'Tabel berhasil dibuat!');
    }



    public function getAllTables()
    {
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);

        return response()->json(['tables' => $tableNames]);
    }

    // public function getTableDetails($tableName)
    // {
    //     // Memeriksa apakah tabel ada
    //     if (!Schema::hasTable($tableName)) {
    //         return response()->json(['error' => 'Table does not exist'], 404);
    //     }

    //     // Mengambil daftar kolom
    //     $columns = Schema::getColumnListing($tableName);
    //     $columnDetails = [];

    //     // Mengambil tipe kolom untuk setiap kolom
    //     foreach ($columns as $column) {
    //         $columnDetails[$column] = [
    //             'type' => Schema::getColumnType($tableName, $column),
    //             'nullable' => Schema::getConnection()->getSchemaBuilder()->getColumn($tableName, $column)->nullable,
    //             'default' => Schema::getConnection()->getSchemaBuilder()->getColumn($tableName, $column)->default,
    //         ];
    //     }

    //     // Mengembalikan respons JSON
    //     return response()->json([
    //         'table' => $tableName,
    //         'columns' => $columnDetails,
    //     ]);
    // }

    public function getTableDetails($tableName)
{
    // Memeriksa apakah tabel ada
    if (!Schema::hasTable($tableName)) {
        return response()->json(['error' => 'Table does not exist'], 404);
    }

    // Mengambil daftar kolom
    $columns = Schema::getColumnListing($tableName);
    $columnDetails = [];

    // Mengambil informasi kolom untuk setiap kolom
    foreach ($columns as $column) {
        // Mengambil tipe kolom
        $columnType = Schema::getColumnType($tableName, $column);

        // Mengambil informasi kolom dari database
            $columnInfo = DB::select("SHOW COLUMNS FROM `$tableName` LIKE '$column'");
            // dd($columnInfo);

        // Memeriksa apakah kolom ditemukan
        if (count($columnInfo) > 0) {
            $columnDetails[$column] = [
                'type' => $columnType,
                'length' => $columnInfo[0]->Type,
                'key' => $columnInfo[0]->Key,
                'default' => $columnInfo[0]->Default,
                'nullable' => $columnInfo[0]->Null === 'YES',
            ];
        }
    }

    // Mengembalikan respons JSON
    return response()->json([
        'table' => $tableName,
        'columns' => $columnDetails,
    ]);
}



    public function updateTable(Request $request)
    {
        $tableName = $request->input('table_name');
        $columns = $request->input('columns');

        Schema::table($tableName, function (Blueprint $table) use ($columns) {
            foreach ($columns as $column) {
                $columnName = $column['name'];
                $columnType = $column['type'];
                $autoIncrement = $column['auto_increment'] ?? false;
                $nullable = $column['nullable'] ?? false;
                $default = $column['default'] ?? null;
                $action = $column['action'] ?? 'modify';

                if ($action == 'add') {
                    $columnDefinition = $table->$columnType($columnName);
                } elseif ($action == 'modify') {
                    $columnDefinition = $table->$columnType($columnName)->change();
                } elseif ($action == 'drop') {
                    $table->dropColumn($columnName);
                    continue;
                }

                if ($autoIncrement) {
                    $columnDefinition->autoIncrement();
                }

                if ($nullable) {
                    $columnDefinition->nullable();
                }

                if ($default !== null) {
                    $columnDefinition->default($default);
                }
            }
        });

        return response()->json(['message' => 'Table updated successfully']);
    }
    public function updateTableData(Request $request)
    {
        $tableName = $request->input('table_name');
        $data = $request->input('data');
        $conditions = $request->input('conditions');

        $query = DB::table($tableName);

        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }

        $query->update($data);

        return response()->json(['message' => 'Table data updated successfully']);
    }
}
