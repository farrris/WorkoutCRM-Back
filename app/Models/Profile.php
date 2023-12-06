<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     title="Profile",
 *     description="Профиль пользователя",
 *     @OA\Xml(
 *         name="Profile"
 *     )
 * )
 */
class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'age',
        'gender',
        'sports_experience',
        'sports_level',
        'kind_of_sport_id',
        'food_type',
        'training_days',
        'work_experience',
        'rate_per_hour'
    ];

    protected $casts = [
        "training_days" => "array"
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
     *      title="first_name",
     *      description="Имя пользователя",
     *      example="Alexey"
     * )
     *
     * @var string
     */
    private $first_name;

    /**
     * @OA\Property(
     *      title="last_name",
     *      description="Фамилия пользователя",
     *      example="Smirnov"
     * )
     *
     * @var string
     */
    private $last_name;

    /**
     * @OA\Property(
     *     title="age",
     *     description="Возраст пользователя",
     *     format="int64",
     *     example=23
     * )
     *
     * @var bigInteger
     */
    private $age;

    /**
     * @OA\Property(
     *      title="gender",
     *      description="Пол пользователя",
     *      example="male"
     * )
     *
     * @var string
     */
    private $gender;

    /**
     * @OA\Property(
     *      title="sports_experience",
     *      description="Стаж тренировок пользователя",
     *      example="4 года"
     * )
     *
     * @var string
     */
    private $sports_experience;

    /**
     * @OA\Property(
     *      title="sports_experience",
     *      description="Спортивный опыт пользователя",
     *      example="advanced"
     * )
     *
     * @var string
     */
    private $sports_level;

    /**
     * @OA\Property(
     *      title="kind_of_sport",
     *      description="Вид спорта пользователя",
     *      ref="#/components/schemas/KindOfSport"
     * )
     */
    private $kind_of_sport;

    /**
     * @OA\Property(
     *      title="food_type",
     *      description="Режим питания пользователя",
     *      example="cut"
     * )
     *
     * @var string
     */
    private $food_type;

    /**
     * @OA\Property(
     *      title="training_days",
     *      description="Расписание тренировок пользователя",
     *      type="array",
     *      @OA\Items(type="string"),
     *      example={"monday", "wednesday", "friday"}
     * )
     *
     * @var array
     */
    private $training_days;
    
    /**
     * @OA\Property(
     *      title="work_experience",
     *      description="Стаж работы тренера",
     *      example="1 год"
     * )
     *
     * @var string
     */
    private $work_experience;

    /**
     * @OA\Property(
     *      title="rate_per_hour",
     *      description="Ставка тренера за час",
     *      example="1000"
     * )
     *
     * @var float
     */
    private $rate_per_hour;
    

    public function kindOfSport(): BelongsTo
    {
        return $this->belongsTo(KindOfSport::class);
    }
}
