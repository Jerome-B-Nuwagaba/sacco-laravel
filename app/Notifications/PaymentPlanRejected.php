<?php

namespace App\Notifications;

use App\Models\PaymentPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentPlanRejected extends Notification
{
    use Queueable;

    protected $paymentPlan;

    /**
     * Create a new notification instance.
     */
    public function __construct(PaymentPlan $paymentPlan)
    {
        $this->paymentPlan = $paymentPlan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your payment plan for Loan ID #' . $this->paymentPlan->loan_id . ' was rejected by the customer.',
            'loan_id' => $this->paymentPlan->loan_id,
            'payment_plan_id' => $this->paymentPlan->id,
            'rejected_by' => auth()->user()->name,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
