<?php

namespace App\Services\Contact\Avatar;

use App\Services\BaseService;

class GetGravatar extends BaseService
{
    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'size' => 'nullable|integer|between:1,2000',
        ];
    }

    /**
     * Get Gravatar, if it exists.
     *
     * @param array $data
     * @return string|null
     */
    public function execute(array $data)
    {
        $this->validate($data);

        try {
            if (! app('gravatar')->exists($data['email'])) {
                return;
            }
        } catch (\Creativeorange\Gravatar\Exceptions\InvalidEmailException $e) {
            // catch invalid email
            return;
        }

        $size = $this->size($data);

        return app('gravatar')->get($data['email'], [
                'size' => $size,
                'secure' => config('app.env') === 'production',
            ]);
    }

    /**
     * Get the size for the gravatar, based on a given parameter. Provides a
     * default otherwise.
     *
     * @param  array  $data
     * @return integer
     */
    private function size(array $data)
    {
        if (isset($data['size'])) {
            return $data['size'];
        }

        return 200;
    }
}
