<?php

namespace App\Models;

use App\Models\Enum\BaseParameterEnum;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $table = 't_estate';
    protected $primaryKey = 'Estate_ID';
    const CREATED_AT = 'Create_Time';
    const UPDATED_AT = 'Update_Time';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(BaseParameter::class,'Estate_Type_ID','type_id')->where('para_type_name',BaseParameterEnum::ESTATE_TYPE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fixture()
    {
        return $this->belongsTo(BaseParameter::class,'Fixture_Type_ID','type_id')->where('para_type_name',BaseParameterEnum::ESTATE_FIXTRUE);
    }
}
