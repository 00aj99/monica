<?php

namespace App\Services\Contact\Avatar;

use Laravolt\Avatar\Avatar;
use App\Helpers\AvatarHelper;
use App\Services\BaseService;
use App\Models\Contact\Contact;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class GenerateDefaultAvatar extends BaseService
{
    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact_id' => 'required|integer|exists:contacts,id',
        ];
    }

    /**
     * Generate the default image for the avatar, based on the initals of the
     * contact and returns the filename.
     *
     * @param array $data
     * @return string|null
     */
    public function execute(array $data)
    {
        $this->validate($data);

        $contact = Contact::find($data['contact_id']);

        // delete existing default avatar
        $this->deleteExistingDefaultAvatar($contact);

        $img = (new Avatar([
                'width' => '150',
                'height' => '150',
                'shape' => 'square',
                'backgrounds' => [$contact->default_avatar_color],
            ]))->create($contact->name);

        $filename = 'avatars/'.AvatarHelper::generateAdorableUUID().'.jpg';
        Storage::put($filename, $img);

        $contact->avatar_default_url = $filename;
        $contact->save();

        return $contact;
    }

    /**
     * Delete the existing default avatar.
     *
     * @param Contact $contact
     * @return void
     */
    private function deleteExistingDefaultAvatar($contact)
    {
        try {
            Storage::delete($contact->avatar_default_url);
        } catch (FileNotFoundException $e) {
            return;
        }
    }
}
