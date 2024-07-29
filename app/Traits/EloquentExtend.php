<?php

namespace App\Traits;

use DateTimeInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

trait EloquentExtend
{
    protected static $schema = [];

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

    public function getPrimaryValue()
    {
        $key = $this->getKeyName();
        $key = Arr::wrap($key);
        $key = array_shift($key);
        return $this->getAttribute($key);
    }

    public static function findByUrl(string $url): ?self
    {
        return self::whereUrl($url)->first();
    }

    /**
     * @throws Exception
     */
    public static function findByAliasOrFail(string $alias)
    {
        $model = self::whereAlias($alias)->first();

        if ($model) {
            return $model;
        } else {
            abort(404);
        }
    }

    public function getLangColumn(string $column)
    {
        try {
            if (classImplementsInterface($this, HasLocalized::class) && $this->lang) {
                return $this->lang->{$column} ?? '';
            }
            if (Arr::has($this->attributes, $column)) {
                return Arr::get($this->attributes, $column);
            }
        } catch (Exception $e) {
            app(LoggerHelper::class)->error($e);
        }
        return '';
    }

    public function getCreatedAt(): ?Carbon
    {
        return ($date = $this->{$this->getCreatedAtColumn()}) ? getDateCarbon($date) : null;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return ($date = $this->{$this->getUpdatedAtColumn()}) ? getDateCarbon($date) : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function setBelongsTo(Model $model): self
    {
        $this->setAttribute($model->getForeignKey(), $model->getKey());
        return $this;
    }

    public function getBelongsKey($relation)
    {
        return $this->getAttribute($this->{$relation}()->getForeignKeyName());
    }

    /**
     * @return int
     */
    public function getKey()
    {
        return (int)parent::getKey();
    }

}

