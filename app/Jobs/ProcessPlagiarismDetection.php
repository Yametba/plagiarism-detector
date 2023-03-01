<?php

namespace App\Jobs;

use App\Models\AnalysisItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessPlagiarismDetection implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected AnalysisItem $analysisItem;

    //public $timeout = 60*60*60*9;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AnalysisItem $analysisItem)
    {
        $this->analysisItem = $analysisItem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $analysisItem = $this->analysisItem;

        $python_path = '/media/owr/3817b234-5733-4cca-be5a-21256228b837/home/owr/www/www/yametba/plagiarism-detector/ai-core/venv/bin/python';
        $cmd_path = '/media/owr/3817b234-5733-4cca-be5a-21256228b837/home/owr/www/www/yametba/plagiarism-detector/ai-core/core/plagiarism_checker.py';
        
        $arg1 = '--f=' . $analysisItem->document->getFilePath();

        $arg2 = '--analysis_item_id=' . $analysisItem->id;

        $process = new Process([$python_path, $cmd_path, $arg1, $arg2]);
        $process->run();
        
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $data = $process->getOutput();
    }
}
