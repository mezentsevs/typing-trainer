<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;
use App\Models\TestResult;
use App\Traits\HasStatisticsRules;

class TestSaveResultRequest extends BaseRequest
{
    use HasStatisticsRules;

    public function authorize(): bool
    {
        return $this->user()->can('create', TestResult::class);
    }

    public function rules(): array
    {
        return static::statisticsRules();
    }
}
