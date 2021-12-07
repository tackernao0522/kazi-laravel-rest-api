## 214 RestAPI Section CRUD Part1

+ `$ php artisan make:model Student -m`を実行<br>

+ `create_students_table.php`を編集<br>

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->integer('section_id');
            $table->string('name');
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->string('password');
            $table->string('photo');
            $table->string('gender');
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
        Schema::dropIfExists('students');
    }
}
```

+ `app/Models/Student.php`を編集<br>

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];
}
```

+ `$ php artisan migrate`を実行<br>

+ `$ php artisan make:controller Api/StudentController`を実行<br>

+ `public/upload`ディレクトリを作成<br>

+ `public/upload/students`ディレクトリを作成<br>

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\StudentController;
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

// Student Routes
Route::post('/student/store', [StudentController::class, 'studentStore']);
```

+ `StudentController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function studentStore(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:students|max:25',
            'email' => 'required|unique:students|max:25'
        ]);

        Student::insert([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $request->photo,
            'gender' => $request->gender,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Inserted Successfully');
    }
}
```

+ `Postman(POST) localhost/api/student/store`を入力<br>

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubjectController;
use App\Models\Subject;
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

// Student Routes
Route::get('student', [StudentController::class, 'studentIndex']);
Route::post('/student/store', [StudentController::class, 'studentStore']);
```

+ `StudentController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function studentIndex()
    {
        $students = Student::latest()->get();

        return response()->json($students);
    }

    public function studentStore(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:students|max:25',
            'email' => 'required|unique:students|max:25'
        ]);

        Student::insert([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $request->photo,
            'gender' => $request->gender,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Inserted Successfully');
    }
}
```

+ `Postman(GET) localhost/api/student`を入力<br>

```
[
    {
        "id": 2,
        "class_id": 2,
        "section_id": 112,
        "name": "Takabo",
        "address": "Ciba",
        "phone": "09014382914",
        "email": "takaproject777@gmail.com",
        "password": "$2y$10$T03Ytj4ckdP5Qi9xfrLRZ.hS2mpT7.I/rGwd1qXmt0XA70dQX7hP.",
        "photo": "upload/students/student.jpg",
        "gender": "Male",
        "created_at": "2021-12-07T10:23:04.000000Z",
        "updated_at": null
    },
    {
        "id": 1,
        "class_id": 1,
        "section_id": 11,
        "name": "Naomi",
        "address": "Tokyo",
        "phone": "09061500317",
        "email": "takaki55730317@gmail.com",
        "password": "$2y$10$41WDdxwS77vfVQ0yMkNL3O6v83T0BJfO2TTayt8KFIexa10ZRYshC",
        "photo": "upload/students/student.jpg",
        "gender": "Female",
        "created_at": "2021-12-07T10:15:21.000000Z",
        "updated_at": null
    }
]
```

## 215 RestAPI Student CRUD Part2

+ `routes.api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubjectController;
use App\Models\Subject;
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

// Student Routes
Route::get('student', [StudentController::class, 'studentIndex']);
Route::post('/student/store', [StudentController::class, 'studentStore']);
Route::get('/student/edit/{id}', [StudentController::class, 'studentEdit']);
```

+ `StudentController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function studentIndex()
    {
        $students = Student::latest()->get();

        return response()->json($students);
    }

    public function studentStore(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:students|max:25',
            'email' => 'required|unique:students|max:25'
        ]);

        Student::insert([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $request->photo,
            'gender' => $request->gender,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Inserted Successfully');
    }

    public function studentEdit($id)
    {
        $student = Student::findOrFail($id);

        return response()->json($student);
    }
}
```

+ `Postman(GET) localhost/api/student/edit/2`を入力してみる

```
{
    "id": 2,
    "class_id": 2,
    "section_id": 112,
    "name": "Takabo",
    "address": "Ciba",
    "phone": "09014382914",
    "email": "takaproject777@gmail.com",
    "password": "$2y$10$T03Ytj4ckdP5Qi9xfrLRZ.hS2mpT7.I/rGwd1qXmt0XA70dQX7hP.",
    "photo": "upload/students/student.jpg",
    "gender": "Male",
    "created_at": "2021-12-07T10:23:04.000000Z",
    "updated_at": null
}
```

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubjectController;
use App\Models\Subject;
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

// Student Routes
Route::get('student', [StudentController::class, 'studentIndex']);
Route::post('/student/store', [StudentController::class, 'studentStore']);
Route::get('/student/edit/{id}', [StudentController::class, 'studentEdit']);
Route::post('/student/update/{id}', [StudentController::class, 'studentUpdate']);
```

+ `StudentController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function studentIndex()
    {
        $students = Student::latest()->get();

        return response()->json($students);
    }

    public function studentStore(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:students|max:25',
            'email' => 'required|unique:students|max:25'
        ]);

        Student::insert([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $request->photo,
            'gender' => $request->gender,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Inserted Successfully');
    }

    public function studentEdit($id)
    {
        $student = Student::findOrFail($id);

        return response()->json($student);
    }

    public function studentUpdate(Request $request, $id)
    {
        Student::findOrFail($id)->update([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $request->photo,
            'gender' => $request->gender,
        ]);

        return response('Student Updated Successfully');
    }
}
```

+ `Postman(POST) localhost/api/student/update/1`を入力して更新してみる<br>

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubjectController;
use App\Models\Subject;
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

// Student Routes
Route::get('student', [StudentController::class, 'studentIndex']);
Route::post('/student/store', [StudentController::class, 'studentStore']);
Route::get('/student/edit/{id}', [StudentController::class, 'studentEdit']);
Route::post('/student/update/{id}', [StudentController::class, 'studentUpdate']);
Route::get('/student/delete/{id}', [StudentController::class, 'studentDelete']);
```

+ `StudentController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function studentIndex()
    {
        $students = Student::latest()->get();

        return response()->json($students);
    }

    public function studentStore(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:students|max:25',
            'email' => 'required|unique:students|max:25'
        ]);

        Student::insert([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $request->photo,
            'gender' => $request->gender,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Inserted Successfully');
    }

    public function studentEdit($id)
    {
        $student = Student::findOrFail($id);

        return response()->json($student);
    }

    public function studentUpdate(Request $request, $id)
    {
        Student::findOrFail($id)->update([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $request->photo,
            'gender' => $request->gender,
        ]);

        return response('Student Updated Successfully');
    }

    public function studentDelete($id)
    {
        Student::findOrFail($id)->delete();

        return response('Student Deleted Successfully');
    }
}
```

+ `Postman(GET) localhost/api/student/delete/3`を入力して削除してみる<br>
