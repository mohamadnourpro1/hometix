<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Support\Carbon;

class ServeHometixCommand extends ServeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'serve:hometix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve the application on the PHP development server (stable on Windows)';

    /**
     * Get the date from the given PHP server output.
     *
     * On Windows, PHP's built-in server output can arrive as partial chunks
     * (split mid-line). The upstream command expects a full line and crashes
     * when the date prefix cannot be parsed. We fall back to "now" to prevent
     * the dev server from stopping.
     */
    protected function getDateFromLine($line)
    {
        $regex = env('PHP_CLI_SERVER_WORKERS', 1) > 1
            ? '/^\[\d+]\s\[([a-zA-Z0-9: ]+)\]/'
            : '/^\[([^\]]+)\]/';

        $line = str_replace('  ', ' ', $line);

        preg_match($regex, $line, $matches);

        if (! isset($matches[1])) {
            return Carbon::now();
        }

        try {
            return Carbon::createFromFormat('D M d H:i:s Y', $matches[1]);
        } catch (\Throwable $exception) {
            return Carbon::now();
        }
    }
}
