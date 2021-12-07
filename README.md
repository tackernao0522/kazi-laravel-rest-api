## 206 RestAPI API php, Web php, Channels php, Console php

+ `$ php artisan migrate`を実行<br>


## 207 RestAPI MCR, First Route and Method

+ `$ php artisan make:model Sclass -m`を実行<br>

+ `create_sclasses_table.php`を編集<br>

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSclassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sclasses', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');
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
        Schema::dropIfExists('sclasses');
    }
}
```

+ `App/Models/Sclass.php`を編集<br>

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sclass extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_name',
    ];
}
```

+ `$ php artisan migrate`を実行<br>

+ `$ php artisan make:controller Api/SclassController`を実行<br>

+ `phpMyAdminのclass_nameに直接入力`<br>

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/class', [SclassController::class, 'index']);
```

+ `SclassController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sclass;
use Illuminate\Http\Request;

class SclassController extends Controller
{
    public function index()
    {
        $sclass = Sclass::latest()->get();

        return response()->json($sclass);
    }
}
```

+ `localhost/api/class`にアクセスしてみる<br>

```
[{"id":1,"class_name":"Class One","created_at":null,"updated_at":null}]
```
と表示される<br>

+ `Postmanでlocalhost/api/class`を表示してみる<br>

```
[
    {
        "id": 1,
        "class_name": "Class One",
        "created_at": null,
        "updated_at": null
    }
]
```

## 208 RestAPI Class CRUD Part1

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/class', [SclassController::class, 'index']);
Route::post('/class/store', [SclassController::class, 'store']);
```

+ `SclassController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sclass;
use Illuminate\Http\Request;

class SclassController extends Controller
{
    public function index()
    {
        $sclass = Sclass::latest()->get();

        return response()->json($sclass);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_name' => 'required|unique:sclasses|max:25',
        ]);

        Sclass::insert([
            'class_name' => $request->class_name,
        ]);

        return response('Student Class Inserted Successfully');
    }
}
```

+ `Postmanにて localhost/api/class/store`にする<br>

+ `headersを選択`<br>

+ `KEYに Accept と入力`<br>

+ `VALUEに application/joson と入力`<br>

+ `KEYに Content-type と追加入力`<br>

+ `VALUEに application/json と追加入力`<br>

+ `Body`を選択<br>

+ `x-www-form-urlencoded`を選択<br>

+ `KEYにclass_name を入力`<br>

+ `VALUEに Class Two を入力してみる`<br>

+ `Send`をクリック<br>

+ `Bodyに下記が表示されてDBに登録されている`<br>

```
Student Class Inserted Successfully
```
+ `class_nameのClass Twoを Class Threeに変えてSendする`<br>

+ `DBにClass Threeが追加されている`<br>

+ `Postmanでlocalhost/api/class`を表示してみる(GET)<br>

```
[
    {
        "id": 1,
        "class_name": "Class One",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 2,
        "class_name": "Class Two",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 3,
        "class_name": "Class Three",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 4,
        "class_name": "Class Four",
        "created_at": null,
        "updated_at": null
    }
]
```

+ `reoutes.api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/class', [SclassController::class, 'index']);
Route::post('/class/store', [SclassController::class, 'store']);
Route::get('/class/edit/{id}', [SclassController::class, 'edit']);
```

+ `SclasssController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sclass;
use Illuminate\Http\Request;

class SclassController extends Controller
{
    public function index()
    {
        $sclass = Sclass::latest()->get();

        return response()->json($sclass);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_name' => 'required|unique:sclasses|max:25',
        ]);

        Sclass::insert([
            'class_name' => $request->class_name,
        ]);

        return response('Student Class Inserted Successfully');
    }

    public function edit($id)
    {
        $sclass = Sclass::findOrFail($id);

        return response()->json($sclass);
    }
}
```

+ `Postmanに localhost/api/class/edit/3`と入力してみる(GET)<br>

+ `Sendをクリック`<br>

```
{
    "id": 3,
    "class_name": "Class Three",
    "created_at": null,
    "updated_at": null
}
```

## 209 RestAPI Class CRUD Part2

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/class', [SclassController::class, 'index']);
Route::post('/class/store', [SclassController::class, 'store']);
Route::get('/class/edit/{id}', [SclassController::class, 'edit']);
Route::post('/class/update/{id}', [SclassController::class, 'update']);
```

+ `SclassController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sclass;
use Illuminate\Http\Request;

class SclassController extends Controller
{
    public function index()
    {
        $sclass = Sclass::latest()->get();

        return response()->json($sclass);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_name' => 'required|unique:sclasses|max:25',
        ]);

        Sclass::insert([
            'class_name' => $request->class_name,
        ]);

        return response('Student Class Inserted Successfully');
    }

    public function edit($id)
    {
        $sclass = Sclass::findOrFail($id);

        return response()->json($sclass);
    }

    public function update(Request $request, $id)
    {
        Sclass::findOrFail($id)->update([
            'class_name' => $request->class_name,
        ]);

        return response('Student Class Updated Successfully');
    }
}
```

+ `Postmanで localhost/api/class/update/2`と入力(POST)<br>

+ `headersを選択`<br>

+ `KEYに Accept と入力`<br>

+ `VALUEに application/joson と入力`<br>

+ `KEYに Content-type と追加入力`<br>

+ `VALUEに application/json と追加入力`<br>

+ `Body`を選択<br>

+ `x-www-form-urlencoded`を選択<br>

+ `KEYにclass_name を入力`<br>

+ `VALUEに Class Two New を入力してみる`<br>

+ `Send`をクリック<br>

+ `更新される`<br>

+ `routes/api.php`を編集<br>

```
<?php

use App\Http\Controllers\Api\SclassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/class', [SclassController::class, 'index']);
Route::post('/class/store', [SclassController::class, 'store']);
Route::get('/class/edit/{id}', [SclassController::class, 'edit']);
Route::post('/class/update/{id}', [SclassController::class, 'update']);
Route::get('/class/delete/{id}', [SclassController::class, 'delete']);
```

+ `SclassController.php`を編集<br>

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sclass;
use Illuminate\Http\Request;

class SclassController extends Controller
{
    public function index()
    {
        $sclass = Sclass::latest()->get();

        return response()->json($sclass);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_name' => 'required|unique:sclasses|max:25',
        ]);

        Sclass::insert([
            'class_name' => $request->class_name,
        ]);

        return response('Student Class Inserted Successfully');
    }

    public function edit($id)
    {
        $sclass = Sclass::findOrFail($id);

        return response()->json($sclass);
    }

    public function update(Request $request, $id)
    {
        Sclass::findOrFail($id)->update([
            'class_name' => $request->class_name,
        ]);

        return response('Student Class Updated Successfully');
    }

    public function delete($id)
    {
        Sclass::findOrFail($id)->delete();

        return response('Student Class Deleted Successfully');
    }
}
```

+ `Postmanに localhost/api/class/delete/2`を入力してSendをクリック<br>

+ `対象IDが削除される`<br>
