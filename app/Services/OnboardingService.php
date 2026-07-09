<?php

namespace App\Services;

use App\Contracts\IOnboardingService;
use App\Contracts\IFileUploadService;
use App\Models\Marketplace\Shop;
use App\Models\Profiles\BabysitterProfile;
use App\Models\Profiles\DoctorProfile;
use App\Models\Profiles\ParentProfile;
use App\Models\User;
use Illuminate\Support\Str;

class OnboardingService implements IOnboardingService
{
    public function __construct(
        private IFileUploadService $fileUpload,
    ) {}

    public function saveBabysitter(string $userId, array $data): BabysitterProfile
    {
        $user = User::findOrFail($userId);
        $userUpdate = [];

        if (isset($data['full_name'])) {
            $userUpdate['name'] = $data['full_name'];
        }
        if (isset($data['phone'])) {
            $userUpdate['phone'] = $data['phone'];
        }
        if (isset($data['city'])) {
            $userUpdate['city'] = $data['city'];
        }
        if (isset($data['profile_photo'])) {
            $data['avatar'] = $this->fileUpload->save($data['profile_photo'], 'avatars');
            $userUpdate['avatar'] = $data['avatar'];
            unset($data['profile_photo']);
        }

        if (!empty($userUpdate)) {
            $user->update($userUpdate);
        }

        if (isset($data['experience'])) {
            $data['bio'] = $data['experience'];
            unset($data['experience']);
        }
        unset($data['full_name'], $data['email'], $data['phone'], $data['city'], $data['dob'],
              $data['cnic_front'], $data['cnic_back'], $data['police_clearance'], $data['training_cert']);
        return BabysitterProfile::create(array_merge($data, ['user_id' => $userId]));
    }

    public function saveShopOwner(string $userId, array $data): Shop
    {
        $user = User::findOrFail($userId);
        $userUpdate = [];

        if (isset($data['full_name'])) {
            $userUpdate['name'] = $data['full_name'];
        }
        if (isset($data['phone'])) {
            $userUpdate['phone'] = $data['phone'];
        }
        if (isset($data['city'])) {
            $userUpdate['city'] = $data['city'];
        }
        if (isset($data['profile_photo'])) {
            $userUpdate['avatar'] = $this->fileUpload->save($data['profile_photo'], 'avatars');
        }

        if (!empty($userUpdate)) {
            $user->update($userUpdate);
        }

        if (isset($data['shop_logo'])) {
            $data['logo'] = $this->fileUpload->save($data['shop_logo'], 'logos');
            unset($data['shop_logo']);
        }
        if (isset($data['shop_banner'])) {
            $data['banner'] = $this->fileUpload->save($data['shop_banner'], 'banners');
            unset($data['shop_banner']);
        }
        if (isset($data['shop_name'])) {
            $data['name'] = $data['shop_name'];
            $data['slug'] = Str::slug($data['shop_name']) . '-' . $userId;
            unset($data['shop_name']);
        }
        if (isset($data['shop_description'])) {
            $data['description'] = $data['shop_description'];
            unset($data['shop_description']);
        }
        if (isset($data['shop_address'])) {
            $data['contact_info'] = $data['shop_address'];
            unset($data['shop_address']);
        }
        if (isset($data['categories'])) {
            $data['category'] = $data['categories'];
        }
        unset($data['full_name'], $data['email'], $data['phone'], $data['city'], $data['profile_photo'],
              $data['business_license'], $data['categories']);
        return Shop::updateOrCreate(['user_id' => $userId], $data);
    }

    public function saveDoctor(string $userId, array $data): DoctorProfile
    {
        $user = User::findOrFail($userId);
        $userUpdate = [];

        if (isset($data['phone'])) {
            $userUpdate['phone'] = $data['phone'];
        }
        if (isset($data['city'])) {
            $userUpdate['city'] = $data['city'];
        }
        if (isset($data['profile_photo'])) {
            $data['profile_photo'] = $this->fileUpload->save($data['profile_photo'], 'doctor-photos');
            $userUpdate['avatar'] = $data['profile_photo'];
        }
        if (isset($data['full_name'])) {
            $userUpdate['name'] = $data['full_name'];
        }

        if (!empty($userUpdate)) {
            $user->update($userUpdate);
        }

        if (isset($data['clinic_name'])) {
            $data['hospital'] = $data['clinic_name'];
            unset($data['clinic_name']);
        }
        if (!isset($data['license_number']) && isset($data['pmdc_number'])) {
            $data['license_number'] = $data['pmdc_number'];
        }
        if (isset($data['medical_license'])) {
            $data['medical_license'] = $this->fileUpload->save($data['medical_license'], 'doctor-documents');
        }
        if (isset($data['pmdc_cert'])) {
            $data['pmdc_cert'] = $this->fileUpload->save($data['pmdc_cert'], 'doctor-documents');
        }
        if (isset($data['cv'])) {
            $data['cv'] = $this->fileUpload->save($data['cv'], 'doctor-documents');
        }
        unset($data['full_name'], $data['email'], $data['phone'], $data['city'],
              $data['years_experience'], $data['clinic_address']);
        return DoctorProfile::create(array_merge($data, ['user_id' => $userId]));
    }

    public function saveParent(string $userId, array $data): void
    {
        $user = User::findOrFail($userId);
        $updateData = [];

        if (isset($data['full_name'])) {
            $updateData['name'] = $data['full_name'];
        }
        if (isset($data['phone'])) {
            $updateData['phone'] = $data['phone'];
        }
        if (isset($data['city'])) {
            $updateData['city'] = $data['city'];
        }
        if (isset($data['profile_photo'])) {
            $updateData['avatar'] = $this->fileUpload->save($data['profile_photo'], 'avatars');
        }

        if (!empty($updateData)) {
            $user->update($updateData);
        }

        ParentProfile::updateOrCreate(
            ['user_id' => $userId],
            [
                'num_children' => $data['num_children'] ?? 1,
                'children_ages' => $data['children_ages'] ?? null,
                'emergency_contact_name' => $data['emergency_contact_name'] ?? '',
                'emergency_contact_phone' => $data['emergency_contact_phone'] ?? '',
                'address' => $data['address'] ?? '',
                'special_requirements' => $data['special_requirements'] ?? null,
            ]
        );
    }
}
