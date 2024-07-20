<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class JWTGenerateKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:generate-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate public and private keys for JWT authentication';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $configJwtPath = base_path('config/jwt');

        if (! is_dir($configJwtPath)) {
            mkdir($configJwtPath, 0755, true);
        }

        $passphrase = env('JWT_PASS_PHRASE');

        if (empty($passphrase)) {
            $this->error('Passphrase not set in .env file.');

            return;
        }

        // Define paths for keys
        $privateKeyPath = $configJwtPath.'/private.pem';
        $publicKeyPath = $configJwtPath.'/public.pem';

        // Generate the private key with the passphrase
        $privateKeyCommand = sprintf(
            'openssl genpkey -algorithm RSA -out %s',
            escapeshellarg($privateKeyPath),

        );

        // Execute command to generate private key
        exec(command: $privateKeyCommand, result_code: $returnVar);

        if ($returnVar !== 0) {
            $this->error('Failed to generate private key.');

            return;
        }

        // Generate the public key from the private key
        $publicKeyCommand = sprintf(
            'openssl rsa -pubout -in %s -out %s',
            escapeshellarg($privateKeyPath),
            escapeshellarg($publicKeyPath),

        );

        // Execute command to generate public key
        exec(command: $publicKeyCommand, result_code: $returnVar);

        if ($returnVar !== 0) {
            $this->error('Failed to generate public key.');

            return;
        }

        $this->info('JWT keys generated successfully.');
    }
}
