<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\EloquentExtend;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Arr;

class Model extends EloquentModel
{
    use EloquentExtend;

    /**
     * @param string $table
     * @return Model|null
     */
    public static function getModelByTable(string $table): ?Model
    {
        $className = self::getModelClassNameByTable($table);
        $model = null;
        if ($className) {
            try {
                $model = app()->make($className);
            } catch (\Exception $e) {

            }
        }

        return $model;
    }

    public function getTableColumns()
    {
        if (!Arr::has(static::$schema, $this->getTable())) {
            $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
            Arr::set(static::$schema, $this->getTable(), $columns);
        }

        return Arr::get(static::$schema, $this->getTable());
    }

    /**
     * @param array $attributes
     * @param bool $overrideFilled - перезаписывать уже заполненное поле
     * @return $this
     */
    public function fillExisting(array $attributes, $overrideFilled = true): self
    {
        $schema = array_flip($this->getTableColumns());

        $attributes = array_filter($attributes, function ($value, $column) use ($schema) {
            $exists = Arr::exists($schema, $column);
            $isGuarded = $this->isGuarded($column);

            return ($exists && !$isGuarded);
        }, ARRAY_FILTER_USE_BOTH);

        foreach ($attributes as $attribute => $value) {
            if (!$overrideFilled && $this->isDirty($attribute)) {
                continue;
            }
            $this->setAttribute($attribute, $value);
        }

        return $this;
    }

    public function showSql($qb, $fields = [])
    {
        $qb = clone $qb;

        if (!empty($fields)) {
            $qb->select($fields);
        }

        // Получаем sql вопрос с ? вместо параметров
        $sql = $qb->toSql();

        // Получаем параметры
        $bindings = $qb->getBindings();

        // Экранируем знак вопроса(
        $regex = '/' . preg_quote('?') . '/';

        foreach ($bindings as $binding) {
            $sql = preg_replace($regex, $binding, $sql, 1);
        }

        dd($sql);
    }
}



