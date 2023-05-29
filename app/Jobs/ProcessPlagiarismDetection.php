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

    public $timeout = 60*60*60*9;

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

        $python_path = '/media/owr/3817b234-5733-4cca-be5a-21256228b8371/home/owr/www/www/yametba/plagiarism-detector/ai-core/venv/bin/python';
        $cmd_path = '/media/owr/3817b234-5733-4cca-be5a-21256228b8371/home/owr/www/www/yametba/plagiarism-detector/ai-core/core/plagiarism_checker.py';
        
        $arg_analysis_item_id = '--analysis_item_id=' . $analysisItem->id;
        
        $process = NULL;

        if ($analysisItem->original_text == NULL || $analysisItem->rewritten_text == NULL) {
            $arg_f = '--f=' . $analysisItem->document->getFilePath();
            $process = new Process([$python_path, $cmd_path, $arg_f, $arg_analysis_item_id]);
        }else{
            $arg_original_text = '--original_text=' . $analysisItem->original_text;
            $arg_rewritten_text = '--rewritten_text=' . $analysisItem->rewritten_text;
            $process = new Process([$python_path, $cmd_path, $arg_original_text, $arg_rewritten_text, $arg_analysis_item_id]);
        }

        $process->run();
        
        if (!$process->isSuccessful()) {
            $result = new ProcessFailedException($process); //new \RuntimeException($process->getErrorOutput());
            $analysisItem->analysis_results = $result; //"Une erreure s'est produite. Veuillez uploader à nouveau votre fichier";
            $analysisItem->save();
            throw $result;
        }

        $data = $process->getOutput();
    }
}
