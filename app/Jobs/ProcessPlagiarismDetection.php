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
        $item = $this->analysisItem;

        $script = 'python core/plagiarism_checker.py --original_text="I stand here today humbled by the task before us, grateful for the trust you have bestowed, mindful of the sacrifices borne by our ancestors. I thank President Bush for his service to our nation, as well as the generosity and cooperation he has shown throughout this transition. The new movie is awesome. The cat plays in the garden. The new movie is so great." --rewritten_text="I am humbled by the task at hand, appreciative of the trust you have placed in me, and conscious of the suffering endured by our forefathers as I stand here today. I am grateful to President Bush for his service to our country, as well as for his kindness and cooperation during this transition. The new movie is so great."';

        $python_path = '/media/owr/3817b234-5733-4cca-be5a-21256228b837/home/owr/www/www/yametba/plagiarism-detector/ai-core/venv/bin/python';
        $cmd_path = '/media/owr/3817b234-5733-4cca-be5a-21256228b837/home/owr/www/www/yametba/plagiarism-detector/ai-core/core/plagiarism_checker.py';
        
        $arg1 = '--original_text="I stand here today humbled by the task before us, grateful for the trust you have bestowed, mindful of the sacrifices borne by our ancestors. I thank President Bush for his service to our nation, as well as the generosity and cooperation he has shown throughout this transition. The new movie is awesome. The cat plays in the garden. The new movie is so great."';
        $arg2 = '--rewritten_text="I am humbled by the task at hand, appreciative of the trust you have placed in me, and conscious of the suffering endured by our forefathers as I stand here today. I am grateful to President Bush for his service to our country, as well as for his kindness and cooperation during this transition. The new movie is so great."';

        $arg3 = '--analysis_item_id=' . $item->id;

        $process = new Process([$python_path, $cmd_path, $arg1, $arg2, $arg3]);
        $process->run();
        
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $data = $process->getOutput();

        #throw $data;

        #return $data;
    }
}
