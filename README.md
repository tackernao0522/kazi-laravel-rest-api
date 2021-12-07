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

