<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnalysisItem extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use HasFactory;

    public $table = 'analysis_items';

    protected $dates = [
        'created_at',
        'last_analysis_date',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'created_at',
        'analysis_results',
        'last_analysis_date',
        'document_id',
        'comments',
        'submitter_email',
        'folder_id',
        'submitter_fullname',
        'updated_at',
        'deleted_at',
        'team_id',
        'original_text',
        'rewritten_text',
    ];

    public function getLastAnalysisDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setLastAnalysisDateAttribute($value)
    {
        $this->attributes['last_analysis_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getAnalysisResultsArray(){
        return json_decode($this->analysis_results, true);
    }

    public function getPlagiarismScore(){
        $val = 0.0;
        if ($this->getAnalysisResultsArray() != NULL && $this->getAnalysisResultsArray()[0] != NULL) {
            $val = floatval($this->getAnalysisResultsArray()[0]);
        }
        if ($val >= 1.0) {
            $val = 1.0;
        }

        $val = $val * 100;

        return intval($val) . "%";
    }

    public function getAnalysisResultsSimilarSentencesArray(){
        if($this->getAnalysisResultsArray() == null || $this->getAnalysisResultsArray()[1] == null){
            return [];
        }
        return $this->getAnalysisResultsArray()[1];
    }

    public function getAnalysisResultsGroupedByDoc(){
        if($this->getAnalysisResultsArray() == null || $this->getAnalysisResultsArray()[2] == null){
            return [];
        }
        return $this->getAnalysisResultsArray()[2];
    }
}
