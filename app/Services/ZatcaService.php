<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZatcaService
{
    protected $baseUrl;
    protected $db;
    protected $username;
    protected $password;
    protected $sessionId = null;
    protected $userId = null;
    protected $cookies = [];

    public function __construct()
    {
        $this->baseUrl = rtrim(config('odoo.base_url'), '/');
        $this->db = config('odoo.db');
        $this->username = config('odoo.username');
        $this->password = config('odoo.password');
    }

    /**
     * Authenticate with Odoo and get session info
     */
    public function authenticate()
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post("{$this->baseUrl}/web/session/authenticate", [
                'jsonrpc' => '2.0',
                'params' => [
                    'login' => $this->username,
                    'password' => $this->password,
                    'db' => $this->db
                ]
            ]);

            $data = $response->json();

            if (isset($data['result']['uid'])) {
                // Store the complete session info
                $this->userId = $data['result']['uid'];
                $this->sessionId = $response->cookies()->getCookieByName('session_id')->getValue();

                // Store all cookies for subsequent requests
                $this->cookies = $response->cookies()->toArray();

                return true;
            }

            Log::error('Odoo authentication failed', ['response' => $data]);
            throw new \Exception('Authentication failed: ' . ($data['error']['message'] ?? 'Unknown error'));
        } catch (\Exception $e) {
            Log::error('Odoo authentication error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Create a new invoice in Odoo
     */
    public function createInvoice(array $invoiceData)
    {
        if (!$this->sessionId && !$this->authenticate()) {
            throw new \Exception('Failed to authenticate with Odoo');
        }

        try {
            $response = Http::withHeaders([
                'Cookie' => "session_id={$this->sessionId}",
                'X-Openerp-Session-Id' => $this->sessionId,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/api/account.move", [
                'jsonrpc' => '2.0',
                'params' => [
                    'data' => $invoiceData
                ]
            ]);

            $data = $response->json();

            if (isset($data['result'])) {
                return $data['result'];
            }

            Log::error('Odoo invoice creation failed', ['response' => $data]);
            throw new \Exception('Invoice creation failed: ' . ($data['error']['message'] ?? 'Unknown error'));
        } catch (\Exception $e) {
            Log::error('Odoo invoice creation error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Confirm an invoice in Odoo
     */
    public function confirmInvoice(int $invoiceId)
    {
        if (!$this->sessionId && !$this->authenticate()) {
            throw new \Exception('Failed to authenticate with Odoo');
        }

        try {
            $response = Http::withHeaders([
                'Cookie' => "session_id={$this->sessionId}",
                'X-Openerp-Session-Id' => $this->sessionId,
            ])->post("{$this->baseUrl}/api/confirm_invoice/{$invoiceId}",[
                'params' => []
            ]);

            $data = $response->json();

            if (isset($data['result']['success']) && $data['result']['success']) {
                return $data['result']['QRcode'];
            }

            Log::error('Odoo invoice confirmation failed', ['response' => $data]);
            throw new \Exception('Invoice confirmation failed: ' . ($data['error']['message'] ?? 'Unknown error'));
        } catch (\Exception $e) {
            Log::error('Odoo invoice confirmation error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Get invoice details from Odoo
     */
    public function getInvoice($invoiceId)
    {
        if (!$this->sessionId && !$this->authenticate()) {
            throw new \Exception('Failed to authenticate with Odoo');
        }

        try {
            $response = Http::withHeaders([
                'Cookie' => "session_id={$this->sessionId}",
                'X-Openerp-Session-Id' => $this->sessionId,
            ])->get("{$this->baseUrl}/api/account.move/{$invoiceId}", [
                'query' => '{id, name, invoice_line_ids{product_id,name, quantity,price_unit,analytic_distribution},l10n_sa_qr_code_str}',
            ]);

            $data = $response->json();

            if (isset($data)) {
                return $data;
            }

            Log::error('Odoo invoice retrieval failed', ['response' => $data]);
            throw new \Exception('Invoice retrieval failed: ' . ($data['error']['message'] ?? 'Unknown error'));
        } catch (\Exception $e) {
            Log::error('Odoo invoice retrieval error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Helper method to create a POS invoice
     */
    public function createPosInvoice($partnerId, $productId, $quantity, $priceUnit, $journalId, $teamId, $analyticDistribution)
    {
        $invoiceData = [
            'partner_id' => $partnerId,
            'move_type' => 'out_invoice',
            'journal_id' => $journalId,
            'team_id' => $teamId,
            'invoice_line_ids' => [
                [
                    0, 0, [
                    'product_id' => $productId,
                    'name' => 'Pos item',
                    'quantity' => $quantity,
                    'price_unit' => $priceUnit,
                    'analytic_distribution' => $analyticDistribution
                ]
                ]
            ]
        ];

        return $this->createInvoice($invoiceData);
    }

    /**
     * Get current session info
     */
    public function getSessionInfo()
    {
        if (!$this->sessionId && !$this->authenticate()) {
            throw new \Exception('No active session');
        }

        return [
            'session_id' => $this->sessionId,
            'user_id' => $this->userId,
            'cookies' => $this->cookies
        ];
    }
}