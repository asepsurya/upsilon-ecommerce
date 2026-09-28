<?php

namespace Database\Seeders;

use App\Models\SizeGuide;
use Illuminate\Database\Seeder;

class SizeGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            [
                'size_label' => 'S',
                'size_type' => 'tshirt',
                'chest_cm' => '88-92',
                'chest_inch' => '34.5-36.2',
                'waist_cm' => '76-80',
                'waist_inch' => '29.9-31.5',
                'hip_cm' => '92-96',
                'hip_inch' => '36.2-37.8',
                'shoulder_cm' => '42-44',
                'sleeve_length_cm' => '60-62',
                'body_length_cm' => '68-70',
                'notes' => 'Chest 88-92cm, waist 76-80cm',
            ],
            [
                'size_label' => 'M',
                'size_type' => 'tshirt',
                'chest_cm' => '92-98',
                'chest_inch' => '36.2-38.6',
                'waist_cm' => '80-86',
                'waist_inch' => '31.5-33.9',
                'hip_cm' => '96-102',
                'hip_inch' => '37.8-40.2',
                'shoulder_cm' => '44-46',
                'sleeve_length_cm' => '62-64',
                'body_length_cm' => '70-72',
                'notes' => 'Chest 92-98cm, waist 80-86cm',
            ],
            [
                'size_label' => 'L',
                'size_type' => 'tshirt',
                'chest_cm' => '98-104',
                'chest_inch' => '38.6-40.9',
                'waist_cm' => '86-92',
                'waist_inch' => '33.9-36.2',
                'hip_cm' => '102-108',
                'hip_inch' => '40.2-42.5',
                'shoulder_cm' => '46-48',
                'sleeve_length_cm' => '64-66',
                'body_length_cm' => '72-74',
                'notes' => 'Chest 98-104cm, waist 86-92cm',
            ],
            [
                'size_label' => 'XL',
                'size_type' => 'tshirt',
                'chest_cm' => '104-110',
                'chest_inch' => '40.9-43.3',
                'waist_cm' => '92-98',
                'waist_inch' => '36.2-38.6',
                'hip_cm' => '108-114',
                'hip_inch' => '42.5-44.9',
                'shoulder_cm' => '48-50',
                'sleeve_length_cm' => '66-68',
                'body_length_cm' => '74-76',
                'notes' => 'Chest 104-110cm, waist 92-98cm',
            ],
            [
                'size_label' => 'XXL',
                'size_type' => 'tshirt',
                'chest_cm' => '110-116',
                'chest_inch' => '43.3-45.7',
                'waist_cm' => '98-104',
                'waist_inch' => '38.6-40.9',
                'hip_cm' => '114-120',
                'hip_inch' => '44.9-47.2',
                'shoulder_cm' => '50-52',
                'sleeve_length_cm' => '68-70',
                'body_length_cm' => '76-78',
                'notes' => 'Chest 110-116cm, waist 98-104cm',
            ],
        ];

        foreach ($sizes as $size) {
            SizeGuide::updateOrCreate(
                ['size_label' => $size['size_label'], 'size_type' => $size['size_type']],
                $size
            );
        }
    }
}
