<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="User",
 *     description="Пользователь",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class KindOfSport extends Model
{
    use HasFactory;

    protected $fillable = [
        "title"
    ];

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     */
    private $id;
    /**
     * @OA\Property(
     *      title="title",
     *      description="Название вида спорта",
     *      example="fitness"
     * )
     */
    private $title;
}
