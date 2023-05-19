<?php

namespace App\Domains\Customer\Http\Requests;

use App\Domains\Customer\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;

class CustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'date_of_birth' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:customers,email',
            'bank_account_number' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validatePhoneNumber($validator);
            $this->validateBankAccountNumber($validator);
            $this->validateCustomerUniqueness($validator);
        });
    }

    private function validatePhoneNumber($validator)
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        try {
            $phoneNumber = $phoneNumberUtil->parse($this->input('phone_number'), 'US');
            $formattedPhoneNumber = $phoneNumberUtil->format($phoneNumber, PhoneNumberFormat::INTERNATIONAL);
            $this->merge(['phone_number' => str_replace([' ' , '-'] , '' , $formattedPhoneNumber)]);
        } catch (NumberParseException $e) {
            $validator->errors()->add('phone_number', 'Invalid phone number');
        }
    }

    private function validateBankAccountNumber($validator)
    {
        // Add validation logic for bank account number if necessary
    }

    private function validateCustomerUniqueness($validator)
    {
        $query = Customer::where('firstname', $this->input('firstname'))
            ->where('lastname', $this->input('lastname'))
            ->where('date_of_birth', $this->input('date_of_birth'));

        if ($this->route('customer')) {
            $query->where('id', '!=', $this->route('customer')->id);
        }

        $exists = $query->exists();

        if ($exists) {
            $validator->errors()->add('firstname', 'Customer already exists');
            $validator->errors()->add('lastname', 'Customer already exists');
            $validator->errors()->add('date_of_birth', 'Customer already exists');
        }
    }
}
