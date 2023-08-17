<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="TypeOfWorkout",
 *     description="Тип тренировки",
 *     @OA\Xml(
 *         name="TypeOfWorkout"
 *     )
 * )
 */

class TypeOfWorkout extends Model
{
    use HasFactory;

    protected $table = "types_of_workout";

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
     *
     * @var bigInteger
     */
    private $id;
    /**
     * @OA\Property(
     *      title="title",
     *      description="Название типа тренировки",
     *      example="power"
     * )
     *
     * @var string
     */
    private $title;
}
