<?php

namespace MrzKit\LaravelExt\Eloquent\Branch;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentModel extends Model
{
    /**
     * @var string 时间格式
     */
    protected $serializeDateFormat = 'Y-m-d H:i:s';

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format($this->serializeDateFormat ?? 'Y-m-d H:i:s');
    }
}
