<?php

// app/Controllers/Admin/Settings.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Settings extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $this->checkAuth();

        $settings = $this->settingModel->findAll();
        $groupedSettings = [];

        foreach ($settings as $setting) {
            $groupedSettings[$setting['group']][] = $setting;
        }

        $data = [
            'title' => 'Pengaturan Website',
            'groupedSettings' => $groupedSettings,
            'user' => session()->get('admin_user')
        ];

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $this->checkAuth();

        $settings = $this->request->getPost('settings');

        if ($settings) {
            foreach ($settings as $key => $value) {
                $this->settingModel->updateSetting($key, $value);
            }

            return redirect()->back()->with('success', 'Pengaturan berhasil disimpan');
        }

        return redirect()->back()->with('error', 'Tidak ada data yang disimpan');
    }

    private function checkAuth()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
    }
}
