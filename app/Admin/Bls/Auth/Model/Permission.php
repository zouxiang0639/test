<?php

namespace App\Admin\Bls\Auth\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Permission extends Model
{

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'http_method' => 'array',
    ];

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'http_method', 'http_path'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.permissions_table'));

        parent::__construct($attributes);
    }

    /**
     * Permission belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_role_permissions', 'permission_id', 'role_id');
    }

    /**
     * Permission belongs to many user.
     *
     * @return BelongsToMany
     */
    public function adminUser()
    {
        return $this->belongsToMany(Administrator::class, 'admin_user_permissions', 'permission_id', 'user_id');
    }

    /**
     * If request should pass through the current permission.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function shouldPassThrough(Request $request) : bool
    {
        if (empty($this->http_method) && empty($this->http_path)) {
            return true;
        }

        $method = $this->http_method;

        $matches = array_map(function ($path) use ($method) {
            $path = trim(config('admin.route.prefix'), '/').$path;

            if (Str::contains($path, ':')) {
                list($method, $path) = explode(':', $path);
                $method = explode(',', $method);
            }

            return compact('method', 'path');
        }, explode("\r\n", $this->http_path));

        foreach ($matches as $match) {
            if ($this->matchRequest($match, $request)) {
                return true;
            }
        }

        return false;
    }

    /**
     * If a request match the specific HTTP method and path.
     *
     * @param array   $match
     * @param Request $request
     *
     * @return bool
     */
    protected function matchRequest(array $match, Request $request) : bool
    {
        if (!$request->is(trim($match['path'], '/'))) {
            return false;
        }

        $method = collect($match['method'])->filter()->map(function ($method) {
            return strtoupper($method);
        });

        return $method->isEmpty() || $method->contains($request->method());
    }

    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->roles()->detach();
        });
    }
}
