## 212 RestAPI Section CRUD Part1

+ `$ php artisan make:model Section -m`を実行<br>

+ `create_sections_table.php`を編集<br>

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->string('section_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
```

+ `app/Models/Section.php`を編集<br>

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];
}
```

+ `$ php artisan migrate`を実行<br>

+ `$ php artisan make:controller Api/SectionController`を実行<br>

+ `web.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Student Class Routes
Route::get('/class', [SclassController::class, 'index']);
Route::post('/class/store', [SclassController::class, 'store']);
Route::get('/class/edit/{id}', [SclassController::class, 'edit']);
Route::post('/class/update/{id}', [SclassController::class, 'update']);
Route::get('/class/delete/{id}', [SclassController::class, 'delete']);

// Subject Class Routes
Route::get('/subject', [SubjectController::class, 'index']);
Route::post('/subject/store', [SubjectController::class, 'store']);
Route::get('/subject/edit/{id}', [SubjectController::class, 'subEdit']);
Route::post('/subject/update/{id}', [SubjectController::class, 'update']);
Route::get('/subject/delete/{id}', [SubjectController::class, 'delete']);

// Section Routes
Route::post('/section/store', [SectionController::class, 'store']);
```

+ `SectionController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SectionController extends Controller
{
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_id' => 'required',
            'section_name' => 'required|unique:sections|max:25'
        ]);

        Section::insert([
            'class_id' => $request->class_id,
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Section Inserted Successfully');
    }
}
```

+ `Postman localhost/api/section/update`を入力(POST)<br>

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Student Class Routes
Route::get('/class', [SclassController::class, 'index']);
Route::post('/class/store', [SclassController::class, 'store']);
Route::get('/class/edit/{id}', [SclassController::class, 'edit']);
Route::post('/class/update/{id}', [SclassController::class, 'update']);
Route::get('/class/delete/{id}', [SclassController::class, 'delete']);

// Subject Class Routes
Route::get('/subject', [SubjectController::class, 'index']);
Route::post('/subject/store', [SubjectController::class, 'store']);
Route::get('/subject/edit/{id}', [SubjectController::class, 'subEdit']);
Route::post('/subject/update/{id}', [SubjectController::class, 'update']);
Route::get('/subject/delete/{id}', [SubjectController::class, 'delete']);

// Section Routes
Route::get('/section', [SectionController::class, 'sectionIndex']);
Route::post('/section/store', [SectionController::class, 'store']);
```

+ `SectionController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SectionController extends Controller
{
    public function sectionIndex()
    {
        $sections = Section::latest()->get();

        return response()->json($sections);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_id' => 'required',
            'section_name' => 'required|unique:sections|max:25'
        ]);

        Section::insert([
            'class_id' => $request->class_id,
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Section Inserted Successfully');
    }
}
```

+ `Postman(GET) localhost/api/section`を入力<br>

```
[
    {
        "id": 4,
        "class_id": 4,
        "section_name": "Section D",
        "created_at": "2021-12-07T08:28:23.000000Z",
        "updated_at": null
    },
    {
        "id": 3,
        "class_id": 2,
        "section_name": "Section C",
        "created_at": "2021-12-07T08:28:00.000000Z",
        "updated_at": null
    },
    {
        "id": 2,
        "class_id": 2,
        "section_name": "Section B",
        "created_at": "2021-12-07T08:27:35.000000Z",
        "updated_at": null
    },
    {
        "id": 1,
        "class_id": 3,
        "section_name": "Section A",
        "created_at": "2021-12-07T08:26:09.000000Z",
        "updated_at": null
    }
]
```

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Student Class Routes
Route::get('/class', [SclassController::class, 'index']);
Route::post('/class/store', [SclassController::class, 'store']);
Route::get('/class/edit/{id}', [SclassController::class, 'edit']);
Route::post('/class/update/{id}', [SclassController::class, 'update']);
Route::get('/class/delete/{id}', [SclassController::class, 'delete']);

// Subject Class Routes
Route::get('/subject', [SubjectController::class, 'sectionIndex']);
Route::post('/subject/store', [SubjectController::class, 'store']);
Route::get('/subject/edit/{id}', [SubjectController::class, 'subEdit']);
Route::post('/subject/update/{id}', [SubjectController::class, 'update']);
Route::get('/subject/delete/{id}', [SubjectController::class, 'delete']);

// Section Routes
Route::get('/section', [SectionController::class, 'sectionIndex']);
Route::post('/section/store', [SectionController::class, 'store']);
Route::get('/section/edit/{id}', [SectionController::class, 'sectionEdit']);
```

+ `SectionController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SectionController extends Controller
{
    public function sectionIndex()
    {
        $sections = Section::latest()->get();

        return response()->json($sections);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_id' => 'required',
            'section_name' => 'required|unique:sections|max:25'
        ]);

        Section::insert([
            'class_id' => $request->class_id,
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Section Inserted Successfully');
    }

    public function sectionEdit($id)
    {
        $section = Section::findOrFail($id);

        return response()->json($section);
    }
}
```

+ `Postman(GET) localhost/api/section/edit/2`を入力<br>

```
{
    "id": 2,
    "class_id": 2,
    "section_name": "Section B",
    "created_at": "2021-12-07T08:27:35.000000Z",
    "updated_at": null
}
```

## 213 RestAPI Section CRUD Part2

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Student Class Routes
Route::get('/class', [SclassController::class, 'index']);
Route::post('/class/store', [SclassController::class, 'store']);
Route::get('/class/edit/{id}', [SclassController::class, 'edit']);
Route::post('/class/update/{id}', [SclassController::class, 'update']);
Route::get('/class/delete/{id}', [SclassController::class, 'delete']);

// Subject Class Routes
Route::get('/subject', [SubjectController::class, 'sectionIndex']);
Route::post('/subject/store', [SubjectController::class, 'store']);
Route::get('/subject/edit/{id}', [SubjectController::class, 'subEdit']);
Route::post('/subject/update/{id}', [SubjectController::class, 'update']);
Route::get('/subject/delete/{id}', [SubjectController::class, 'delete']);

// Section Routes
Route::get('/section', [SectionController::class, 'sectionIndex']);
Route::post('/section/store', [SectionController::class, 'store']);
Route::get('/section/edit/{id}', [SectionController::class, 'sectionEdit']);
Route::post('/section/update/{id}', [SectionController::class, 'sectionUpdate']);
```

+ `SectionController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SectionController extends Controller
{
    public function sectionIndex()
    {
        $sections = Section::latest()->get();

        return response()->json($sections);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_id' => 'required',
            'section_name' => 'required|unique:sections|max:25'
        ]);

        Section::insert([
            'class_id' => $request->class_id,
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Section Inserted Successfully');
    }

    public function sectionEdit($id)
    {
        $section = Section::findOrFail($id);

        return response()->json($section);
    }

    public function sectionUpdate(Request $request, $id)
    {
        Section::findOrFail($id)->update([
            'class_id' => $request->class_id,
            'section_name' => $request->section_name,
        ]);

        return response('Student Section Updated Successfully');
    }
}
```

+ `Postman(POST) localhost/api/section/update/2`を入力して更新してみる<br>

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Student Class Routes
Route::get('/class', [SclassController::class, 'index']);
Route::post('/class/store', [SclassController::class, 'store']);
Route::get('/class/edit/{id}', [SclassController::class, 'edit']);
Route::post('/class/update/{id}', [SclassController::class, 'update']);
Route::get('/class/delete/{id}', [SclassController::class, 'delete']);

// Subject Class Routes
Route::get('/subject', [SubjectController::class, 'sectionIndex']);
Route::post('/subject/store', [SubjectController::class, 'store']);
Route::get('/subject/edit/{id}', [SubjectController::class, 'subEdit']);
Route::post('/subject/update/{id}', [SubjectController::class, 'update']);
Route::get('/subject/delete/{id}', [SubjectController::class, 'delete']);

// Section Routes
Route::get('/section', [SectionController::class, 'sectionIndex']);
Route::post('/section/store', [SectionController::class, 'store']);
Route::get('/section/edit/{id}', [SectionController::class, 'sectionEdit']);
Route::post('/section/update/{id}', [SectionController::class, 'sectionUpdate']);
Route::get('/section/delete/{id}', [SectionController::class, 'sectionDelete']);
```

+ `SecitonController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SectionController extends Controller
{
    public function sectionIndex()
    {
        $sections = Section::latest()->get();

        return response()->json($sections);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_id' => 'required',
            'section_name' => 'required|unique:sections|max:25'
        ]);

        Section::insert([
            'class_id' => $request->class_id,
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Section Inserted Successfully');
    }

    public function sectionEdit($id)
    {
        $section = Section::findOrFail($id);

        return response()->json($section);
    }

    public function sectionUpdate(Request $request, $id)
    {
        Section::findOrFail($id)->update([
            'class_id' => $request->class_id,
            'section_name' => $request->section_name,
        ]);

        return response('Student Section Updated Successfully');
    }

    public function sectionDelete($id)
    {
        Section::findOrFail($id)->delete();

        return response('Student Section Deleted Successfully');
    }
}
```

`Postman(GET) localhost/api/seciton/delete/4`を入力して削除してみる<br>
