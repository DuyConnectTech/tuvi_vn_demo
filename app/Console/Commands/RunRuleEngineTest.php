<?php

namespace App\Console\Commands;

use App\Models\Horoscope;
use App\Services\Horoscope\RuleEngine;
use Illuminate\Console\Command;

class RunRuleEngineTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rule:test {horoscopeId : The ID of the horoscope to test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tests the RuleEngine with a specific horoscope ID.';

    /**
     * Execute the console command.
     */
    public function handle(RuleEngine $ruleEngine)
    {
        $horoscopeId = $this->argument('horoscopeId');

        $this->info("Loading horoscope ID: {$horoscopeId}...");

        $horoscope = Horoscope::with([
            'houses', 
            'houses.stars', // Load stars in each house
            'chart_four_pillars', 
            'meta', // Assuming meta is this relation name
        ])->find($horoscopeId);

        if (!$horoscope) {
            $this->error("Horoscope with ID {$horoscopeId} not found.");
            return Command::FAILURE;
        }

        $this->info("Evaluating rules for horoscope '{$horoscope->name}'...");

        $fulfilledRules = $ruleEngine->evaluate($horoscope);

        if ($fulfilledRules->isEmpty()) {
            $this->warn("No rules fulfilled for this horoscope.");
        } else {
            $this->info("Fulfilled Rules:");
            foreach ($fulfilledRules as $rule) {
                $this->comment(" - [{$rule->code}] {$rule->text_template}");
            }
        }

        return Command::SUCCESS;
    }
}