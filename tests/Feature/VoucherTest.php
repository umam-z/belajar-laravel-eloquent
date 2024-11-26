<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class VoucherTest extends TestCase
{
    /**
     * Eloquent test create voucher
     */
    public function testCreateVoucher(): void
    {
        $voucher = new Voucher();
        $voucher->name = 'Sample Voucher';
        $voucher->voucher_code = uniqid('VOUCHER-SAMPLE-');
        $voucher->save();

        assertNotNull($voucher->id);
    }

    /**
     * Eloquent test create voucher using uuid
     */
    public function testCreateVoucherUUID(): void
    {
        $voucher = new Voucher();
        $voucher->name = 'Sample Voucher';
        $voucher->save();

        assertNotNull($voucher->id);
        assertNotNull($voucher->voucher_code);
    }

    /**
     * Eloquent test Soft Delete
     */
    public function testSoftDelete(): void {
        $this->seed(VoucherSeeder::class);
        $voucher = Voucher::query()->where('name', '=','Sample Voucher')->first();
        $voucher->delete();

        $voucher = Voucher::query()->where('name', '=','Sample Voucher')->first();
        assertNull($voucher);

        $voucher = Voucher::query()->withTrashed()->where('name', '=','Sample Voucher')->first();
        assertNotNull($voucher);
    }
}
