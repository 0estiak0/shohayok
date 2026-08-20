<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;use Illuminate\Notifications\Notification;use Illuminate\Notifications\Messages\MailMessage;use App\Models\Booking;
class BookingCreated extends Notification {use Queueable;public function __construct(public Booking $booking){}public function via($notifiable){return ['database','mail'];}public function toArray($notifiable){return ['booking_id'=>$this->booking->id,'title'=>'New booking request','message'=>'A customer sent a new booking request.'];}public function toMail($notifiable){return (new MailMessage)->subject('New Shohayok booking request')->line('You have a new booking request.')->action('View dashboard',url('/provider/dashboard'));}}
