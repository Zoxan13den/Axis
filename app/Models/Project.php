<?php

namespace App\Models;

class Project extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'status'];

    protected $casts = [
        'status' => 'boolean'
    ];

    protected $guarded = ['id'];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Project
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Project
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): Project
    {
        $this->status = $status;

        return $this;
    }

    public function isOwner(User $user): bool
    {
        return $user === $this->user_id;
    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class);
    }
}
