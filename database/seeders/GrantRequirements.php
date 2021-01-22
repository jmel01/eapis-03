<?php

namespace Database\Seeders;

use App\Models\Requirement;
use Illuminate\Database\Seeder;

class GrantRequirements extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $requirements = [
            'Application Form',
            'Certificate of Confirmation of Tribal Membership',
            '2 pcs. latest 2x2 ID picture',
            'Certificate of Good Moral Character',
            'Annual Income Tax Return of Parents/Guardian or Certificate of Tax Exemption from BIR.',
            'ITR of the applicant or its equivalent.',
            'Certificate from the Tribal Leader/Barangay Captain that the family belongs to the poor family in the concept of IPs, provided, it is validated by the NCIP-EAP focal person with conformity of the Provincial Officer.',
            'Certification of the School Registrar/Admission Office that he/she passed the entrance examination of the college/university of his/her choice.',
            'Certified copy of Birth Certificate or its equivalent if not yet available.',
            'Certification from the high school principal that the applicant belongs to the top ten of the graduating class.',
            'Form 138 or high school report card',
            'Authenticated Transcript of Records',
            'Reports of Grades',
            'Certificate of Enrollment',
         ];
      
         foreach ($requirements as $requirement) {
              Requirement::create(['description' => $requirement]);
         }
    }
}
