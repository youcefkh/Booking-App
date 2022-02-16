<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Bookable;
use App\Models\Booking;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $rules = [
            'bookings' => 'required | array | min:1',
            'bookings.*.bookable_id' => 'required | exists:bookables,id',
            "bookings.*.from" => "required | date | after_or_equal:today",
            "bookings.*.to" => "required | date | after:bookings.*.from",

            'customer.first_name' => 'required | min:2',
            'customer.last_name' => 'required | min:2',
            'customer.username' => 'required | min:2 | unique:addresses,username',
            'customer.email' => 'sometimes|nullable|email',
            'customer.address' => 'required | min:3',
            'customer.country' => 'required | min:2',
            'customer.city' => 'required | min:2',
            'customer.zip_code' => 'required | min:2',
            'customer.payment' => 'required | in:credit,debit,paypal',
            'customer.name_on_card' => 'required | min:2',
            'customer.card_number' => 'required | min:2',
            'customer.card_expiration' => 'required | date',
            'customer.cvv' => 'required | min:2',
        ];

        $error_msg = [
            'customer.first_name.required' => 'Please fill the first name field.',
        ];

        $data = $request->validate( $rules, $error_msg);

        //without array_merge $data would only contain the bookings fields
        $data = array_merge($data, $request->validate([
            'bookings.*' => ['required', function ($attribute, $value, $fail) {
                    $bookable = Bookable::findOrFail($value['bookable_id']);
                    if(!$bookable->availableFor($value['from'], $value['to'] ) ){
                        $fail('The object is not available for the given dates');
                    }
                }
            ]
        ]) );

        $bookingsData = $data['bookings'];
        $addressData = $data['customer'];
        
        //create the address first
        $address = Address::create($addressData);

        $bookings = collect($bookingsData)->map(function ($bookingData) use($address) {
            $bookable = Bookable::findOrFail($bookingData['bookable_id']);

            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = $bookable->priceFor($booking->from, $booking->to)['total'];
            
            $booking->bookable()->associate($bookable);

            $booking->address()->associate($address);

            $booking->save();

            return $booking;
        });
        
        return $bookings;
    }
}
