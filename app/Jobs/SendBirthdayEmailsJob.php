<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Mail\BirthdayGreetingMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBirthdayEmailsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Lấy tháng-ngày hiện tại
        $today = now()->format('m-d');

        // Lấy danh sách khách hàng có sinh nhật hôm nay (PostgreSQL)
        $customers = Customer::whereRaw("to_char(birthday, 'MM-DD') = ?", [$today])->get();

        // Gửi mail qua queue cho từng khách hàng
        foreach ($customers as $customer) {
            Mail::to($customer->email)
                ->queue(new BirthdayGreetingMail($customer));
        }
    }
}
