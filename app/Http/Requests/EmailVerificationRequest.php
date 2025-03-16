<?php

namespace App\Http\Requests;

use App\Models\EmailSubscriber;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class EmailVerificationRequest extends FormRequest
{
    private ?EmailSubscriber $subscriber = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->subscriber = EmailSubscriber::where('id', $this->route('id'))->first();

        if (! hash_equals((string) $this->subscriber->getKey(), (string) $this->route('id'))) {
            return false;
        }

        if (! hash_equals(sha1($this->subscriber->getEmailForVerification()), (string) $this->route('hash'))) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Fulfill the email verification request.
     *
     * @return void
     */
    public function fulfill()
    {
        // $subscriber = EmailSubscriber::findOrFail($this->route('id'));

        if (! $this->subscriber->hasVerifiedEmail()) {
            $this->subscriber->markEmailAsVerified();

            event(new Verified($this->subscriber));
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return \Illuminate\Validation\Validator
     */
    public function withValidator(Validator $validator)
    {
        return $validator;
    }
}
