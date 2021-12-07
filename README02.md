## RestAPI Subject CRUD Part1

+ `$ php artisan make:model Subject -m`を実行<br>

+ `create_subjects_table.php`を編集<br>

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->string('subject_name');
            $table->string('subject_code');
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
        Schema::dropIfExists('subjects');
    }
}
```

+ `app/Models/Subject.php`を編集<br>

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];
}
```

+ `php artisan migrate`を実行<br>

+ `php artisan make:controller Api/SubjectController`を実行<br>

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
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
Route::get('/subject/edit/{id}', [SubjectController::class, 'edit']);
Route::post('/subject/update/{id}', [SubjectController::class, 'update']);
Route::get('/subject/delete/{id}', [SubjectController::class, 'delete']);
```

+ `SubjectController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_id' => 'required',
            'subject_name' => 'required|unique:subjects|max:25',
        ]);

        Subject::insert([
            'class_id' => $request->class_id,
            'subject_name' => $request->subject_name,
            'subject_code' => $request->subject_code,
        ]);

        return response('Student Subject Inserted Successfully');
    }
}
```

+ `Postmanにて localhost/api/subject/store`にする(POST)<br>

+ `headersを選択`<br>

+ `KEYに Accept と入力`<br>

+ `VALUEに application/joson と入力`<br>

+ `KEYに Content-type と追加入力`<br>

+ `VALUEに application/json と追加入力`<br>

+ `Body`を選択<br>

+ `x-www-form-urlencoded`を選択<br>

+ `KEYにclass_id を入力 VALUEに 1`<br>

+ `KEYにsubject_name を追加入力 VALUEに English`<br>

+ `KEYにsubject_code を追加入力 VALUEに 101`<br>

+ `Send`をクリック<br>

+ `DBに登録されている`<br>

+ `SubjectController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::latest()->get();

        return response()->json($subjects);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_id' => 'required',
            'subject_name' => 'required|unique:subjects|max:25',
        ]);

        Subject::insert([
            'class_id' => $request->class_id,
            'subject_name' => $request->subject_name,
            'subject_code' => $request->subject_code,
        ]);

        return response('Student Subject Inserted Successfully');
    }
}
```

+ `Postmanに loclhost/api/subject `を入力(GET)<br>

+ `Send`をクリック<br>

```
[
    {
        "id": 1,
        "class_id": 1,
        "subject_name": "English",
        "subject_code": "101",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 2,
        "class_id": 3,
        "subject_name": "Hindi",
        "subject_code": "102",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 3,
        "class_id": 3,
        "subject_name": "Math",
        "subject_code": "103",
        "created_at": null,
        "updated_at": null
    }
]
```

