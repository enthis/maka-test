<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'address',
        'image'
    ];
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    protected $appends = ['image_url'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        // 'password',
        // 'remember_token',
        'deleted_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }
    public function getImageUrlAttribute(): ?string
    {
        // Check if the image path exists in the database
        if ($this->image) {
            // Check if the file actually exists on the disk
            if (Storage::disk('public')->exists('images/' . $this->image)) {
                return asset('storage/images/' . $this->image);
            }
        }

        return null; // or return a default placeholder image URL
    }
    public static function rules($id = null): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->where(function ($query) use ($id) {
                    return $query->where('address', request('address'));
                })->ignore($id),
            ],
            'address' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1024', // 1 MB
        ];
    }
}
