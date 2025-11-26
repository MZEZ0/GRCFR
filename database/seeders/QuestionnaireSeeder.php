<?php

namespace Database\Seeders;

use App\Models\Policy;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionnaireSeeder extends Seeder
{
    public function run(): void
    {
        $questionSets = [
            'P1' => [
                'Do all users follow a strong password requirement?',
                'Is password history enforced to prevent reuse?',
                'Are passwords rotated periodically according to policy?',
                'Are default passwords changed before systems go live?',
            ],
            'P2' => [
                'Are data backups performed on a regular schedule (daily or weekly)?',
                'Are backups stored in a secure offsite or cloud location?',
                'Are backups encrypted at rest?',
                'Has a backup restore test been performed in the last 6–12 months?',
            ],
            'P3' => [
                'Is antivirus/EDR installed on all company endpoints?',
                'Are malware definitions or signatures updated automatically?',
                'Are scheduled scans enabled on all devices?',
                'Are suspicious files automatically quarantined or blocked?',
            ],
            'P4' => [
                'Do employees receive regular security awareness training?',
                'Are phishing simulations conducted at least annually?',
                'Are users who fail phishing tests tracked and re-trained?',
            ],
            'P5' => [
                'Is access to systems granted based on job role (least privilege)?',
                'Are administrator privileges restricted and monitored?',
                'Are user accounts reviewed periodically for accuracy?',
                "Are terminated or resigned employees' accounts disabled immediately?",
            ],
            'P6' => [
                'Are operating systems and applications updated regularly?',
                'Are security patches applied within a defined timeframe?',
                'Is there a documented process to track and remediate vulnerabilities?',
                'Do you use any automated update or patch management tools?',
            ],
            'P7' => [
                'Is a firewall enabled at the network boundary?',
                'Is HTTPS enforced on all public web applications?',
                'Are exposed services and open ports reviewed on a regular basis?',
            ],
            'P8' => [
                'Are company laptops and desktops encrypted?',
                'Are USB ports restricted, monitored, or controlled?',
                'Is there a remote wipe capability for lost or stolen devices?',
            ],
            'P9' => [
                'Are cloud storage resources encrypted at rest?',
                'Are access keys and secrets rotated regularly?',
                'Are storage buckets or containers private by default?',
                'Is MFA enforced for cloud administrator accounts?',
            ],
            'P10' => [
                'Do you maintain an up-to-date list of critical vendors?',
                'Do critical vendors provide security certifications or reports (e.g. ISO, SOC2)?',
                'Do vendors sign security or data protection agreements?',
            ],
            'P11' => [
                'Do you have a documented incident response procedure?',
                'Do employees know how to report a security incident?',
                'Has the incident response plan been tested in the last 12 months?',
            ],
            'P12' => [
                'Do employees use approved channels for business communication?',
                'Is sensitive data encrypted when transmitted over networks?',
                'Are insecure or personal messaging apps restricted for sensitive topics?',
            ],
            'P13' => [
                'Are system and security logs collected in a central location?',
                'Are logs retained for a defined period (e.g. 90 days or more)?',
                'Are alerts configured for suspicious or unauthorized activities?',
            ],
            'P14' => [
                'Are server rooms or critical equipment rooms kept locked?',
                'Are visitors to sensitive areas logged and escorted?',
                'Is CCTV or physical monitoring in place where appropriate?',
            ],
            'P15' => [
                'Do you have a documented business continuity or disaster recovery plan?',
                'Have critical systems and processes been identified and prioritized?',
                'Has the continuity or DR plan been tested in the last year?',
            ],
            'P16' => [
                'Is personal or sensitive data clearly identified and classified?',
                'Do you have a documented data retention and deletion schedule?',
                'Are employees trained on privacy and data protection requirements?',
            ],
            'P17' => [
                'Have all employees read and acknowledged the Acceptable Use Policy?',
                'Are prohibited activities (e.g. torrenting, illegal downloads) clearly defined?',
                'Are technical controls in place to enforce the Acceptable Use Policy?',
            ],
            'P18' => [
                'Is email protected by spam and phishing filters?',
                'Are email attachments scanned for malware?',
                'Are automatic email forwarding rules to external addresses restricted or reviewed?',
            ],
            'P19' => [
                'Are system or application changes documented before implementation?',
                'Do significant changes require management or IT approval?',
                'Are emergency changes logged and reviewed after the fact?',
            ],
            'P20' => [
                'Are remote workers required to use a VPN for accessing internal systems?',
                'Are personal devices allowed for remote work only under defined conditions?',
                'Are remote endpoints monitored or managed by the organization?',
            ],
            'P21' => [
                'Are mobile devices used for work protected by PIN or biometric lock?',
                'Is device encryption enabled on smartphones and tablets used for company data?',
                'Are unauthorized mobile apps restricted for corporate use?',
            ],
            'P22' => [
                'Do you maintain an up-to-date inventory of IT assets?',
                'Are company assets labeled or tagged for tracking?',
                'Are retired or end-of-life devices securely wiped or destroyed?',
            ],
            'P23' => [
                'Is organizational data classified by sensitivity level?',
                'Do employees understand how to handle each classification level?',
                'Are confidential files accessible only by authorized staff?',
            ],
            'P24' => [
                'Are official social media accounts managed by authorized personnel?',
                'Is sensitive or confidential information prohibited from being shared publicly?',
                'Are employees trained on safe and professional online behavior?',
            ],
            'P25' => [
                'Are fire extinguishers or safety equipment available and regularly inspected?',
                'Are server racks or equipment protected from excessive heat and humidity?',
                'Are power backup systems (such as UPS) tested and maintained regularly?',
            ],
        ];

        foreach ($questionSets as $policyCode => $questions) {
            $policy = Policy::where('code', $policyCode)->first();

            if (! $policy) {
                continue;
            }

            foreach ($questions as $text) {
                Question::firstOrCreate([
                    'policy_id' => $policy->id,
                    'text' => $text,
                ]);
            }
        }
    }
}
