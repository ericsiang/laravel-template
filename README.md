# Laravel 11 Template

### Package Tool
1. knuckleswtf/scribe - 自動生成 API 文檔
    * url : https://scribe.knuckles.wtf/laravel/ 

2. spatie/laravel-permission - 用戶角色權限控制
    * url : https://spatie.be/docs/laravel-permission/v5/introduction

3. spatie/laravel-activitylog - 記錄用戶行為
    * url : https://spatie.be/docs/laravel-activitylog/v4/introduction

4. google/cloud (version 原本為"^0.187.0"，目前已更新為最新) - gcp 用 

5. pestphp/pest 測試框架

### command 
* 使用指令，```php artisan install:api```，建立安裝 api 機制
* 新增 make:service 
* 新增 make:repository

### Handler Exception 
* 新增 app/Exception/Handler.php 統一控制處理，需在 app/Providers/AppServiceProvider.php 內 register 生效

### middleware
* 在 bootstrap/app.php 設定 middleware
     ```
     ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('api/*')) {
                throw new AuthenticationException;
            }
        });
    })
     ```

### controller
* 在 app/Http/Controllers/Controller.php，新增 
```use AuthorizesRequests, ValidatesRequests;```

### 新增 app/Builders/RecordBuilder class
use example :
```
class UserController extends Controller
{
    private RecordBuilder $record;

    public function __construct(RecordBuilder $record)
    {
        $this->record = $record;
    }

    public function index(Request $request)
    {
        // Gate::authorize('early check in');
        $this->authorize('early check in');
        $this->record->setLogName('first_log')
                        ->setEvent('first_event')
                        ->setDescription('first_description')
                        ->record();
        return response()->json([], Response::HTTP_OK);
    } 
}
```

### 登入
* 使用 laravel Sanctum 產生 jwt 令牌
* 目前使用 line 登入 ，取得 line id 來當唯一辨識 user 
* 在 config/auth.php 設定 multi guards 來控制，新增 api-user(使用者) & api-admin(飯店內部人員) 

### RBAC 權限
參考：
[Disabling Cache](https://spatie.be/docs/laravel-permission/v6/advanced-usage/cache#content-disabling-cache)
[Using multiple guards](https://spatie.be/docs/laravel-permission/v6/basic-usage/multiple-guards)

* 使用 laravel-permission 設定權限機制
* 關閉 Cache，因為是使用無狀態 api，不該 Cache 狀態
     config/permission.php 內，更改設定為 'cache.store' => 'array' ，只會以當下這次 request 生效 
* 使用 multiple guards ，在新增 rule 跟 permission 要對應 guard_name

### ORM
* 資料表是否要改用 uuid 當 primary key 
* user 看要不要依照登入方式來分表 EX: facebook 、 google 登入的 user 分表
  


