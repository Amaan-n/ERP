<?php

namespace App\Repositories;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationsRepository
{
    protected $configuration;

    public function __construct()
    {
        $this->configuration = new Configuration();
    }

    public function getConfigurations()
    {
        return $this->configuration
            ->with(['user', 'child_configurations' => function ($query) {
                return $query->where('is_visible', 1);
            }])
            ->where('parent_id', 0)
            ->where('is_visible', 1)
            ->get();
    }

    public function update(Request $request)
    {
        $this->configuration
            ->whereIn('key', ['working_days'])
            ->update([
                'value' => null
            ]);

        $configurations      = $request->get('configurations');
        $configuration_files = $request->file();
        if (isset($configurations) && !empty($configurations)) {
            foreach ($configurations as $configuration_key => $configuration_value) {
                if (isset($configuration_value) && !empty($configuration_value)) {
                    foreach ($configuration_value as $sub_configuration_key => $sub_configuration_value) {
                        if (isset($configuration_files['configurations'][ $configuration_key ])) {
                            $file_data = $configuration_files['configurations'][ $configuration_key ];
                            if (isset($file_data[ $sub_configuration_key ]) && in_array($sub_configuration_key, array_keys($file_data))) {
                                $picture = $file_data[ $sub_configuration_key ];
                                if (is_object($picture) && $picture->isValid() && $picture->getSize() < 10000000) {
                                    $picture_file_with_ext = $picture->getClientOriginalName();
                                    $destination_path      = public_path('uploads/configurations');
                                    $picture->move($destination_path, $picture_file_with_ext);
                                    $sub_configuration_value = 'uploads/configurations/' . $picture_file_with_ext;
                                }
                            }
                        }
                        $this->configuration
                            ->where('parent_id', $configuration_key)
                            ->where('key', $sub_configuration_key)
                            ->update([
                                'value' => in_array($sub_configuration_key, ['working_days'])
                                    ? implode(', ', $sub_configuration_value)
                                    : $sub_configuration_value
                            ]);
                    }
                }
            }
        }
    }
}
