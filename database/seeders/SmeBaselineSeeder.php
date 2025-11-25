<?php

namespace Database\Seeders;

use App\Models\Framework;
use App\Models\Policy;
use App\Models\Risk;
use Illuminate\Database\Seeder;

class SmeBaselineSeeder extends Seeder
{
    public function run(): void
    {
        $framework = Framework::updateOrCreate(
            ['code' => 'SME_BASELINE_V1'],
            [
                'name' => 'SME Security Baseline v1',
                'description' => 'Internal SME governance, risk and compliance baseline with 25 core policies and a mapped risk register.',
            ]
        );

        $policies = [
            ['code' => 'P1', 'title' => 'Password Security Policy', 'short_description' => 'Defines strong password creation, rotation, and storage expectations.'],
            ['code' => 'P2', 'title' => 'Data Backup and Recovery Policy', 'short_description' => 'Requires regular backups and tested restore procedures for critical data.'],
            ['code' => 'P3', 'title' => 'Malware Protection Policy', 'short_description' => 'Ensures antivirus and anti-malware protections are installed and updated.'],
            ['code' => 'P4', 'title' => 'Phishing and Security Awareness Policy', 'short_description' => 'Provides training and simulations to reduce phishing risk.'],
            ['code' => 'P5', 'title' => 'Access Control Policy', 'short_description' => 'Defines role-based access, approvals, and periodic access reviews.'],
            ['code' => 'P6', 'title' => 'Patch and Vulnerability Management Policy', 'short_description' => 'Requires timely patching and vulnerability remediation.'],
            ['code' => 'P7', 'title' => 'Secure Web and Network Policy', 'short_description' => 'Mandates secure configurations for web services and network defenses.'],
            ['code' => 'P8', 'title' => 'Device and Media Protection Policy', 'short_description' => 'Addresses encryption and handling of laptops, mobiles, and removable media.'],
            ['code' => 'P9', 'title' => 'Cloud Security Policy', 'short_description' => 'Sets standards for secure cloud service configuration and monitoring.'],
            ['code' => 'P10', 'title' => 'Vendor and Third-Party Management Policy', 'short_description' => 'Requires due diligence and monitoring of suppliers and partners.'],
            ['code' => 'P11', 'title' => 'Incident Response Policy', 'short_description' => 'Defines escalation, containment, and communication steps during incidents.'],
            ['code' => 'P12', 'title' => 'Secure Communication Policy', 'short_description' => 'Protects sensitive communications and mandates encryption where appropriate.'],
            ['code' => 'P13', 'title' => 'Logging and Monitoring Policy', 'short_description' => 'Specifies logging baselines and centralized monitoring.'],
            ['code' => 'P14', 'title' => 'Physical Security Policy', 'short_description' => 'Covers facility access control and visitor management.'],
            ['code' => 'P15', 'title' => 'Business Continuity and Disaster Recovery Policy', 'short_description' => 'Plans for continuity of operations during disruptions.'],
            ['code' => 'P16', 'title' => 'Data Privacy and Protection Policy', 'short_description' => 'Sets rules for personal data handling and privacy rights.'],
            ['code' => 'P17', 'title' => 'Acceptable Use Policy', 'short_description' => 'Defines acceptable use of company assets and services.'],
            ['code' => 'P18', 'title' => 'Email and Messaging Policy', 'short_description' => 'Guides secure use of email, messaging, and collaboration tools.'],
            ['code' => 'P19', 'title' => 'Change Management Policy', 'short_description' => 'Requires documented review and approval for system changes.'],
            ['code' => 'P20', 'title' => 'Remote Work and Telecommuting Policy', 'short_description' => 'Secures remote work practices and connectivity.'],
            ['code' => 'P21', 'title' => 'Mobile Device Security Policy', 'short_description' => 'Covers mobile device enrollment, encryption, and updates.'],
            ['code' => 'P22', 'title' => 'Asset Management Policy', 'short_description' => 'Ensures inventory, ownership, and lifecycle tracking of assets.'],
            ['code' => 'P23', 'title' => 'Data Classification Policy', 'short_description' => 'Defines data classes and required protections per sensitivity.'],
            ['code' => 'P24', 'title' => 'Social Media and Public Communication Policy', 'short_description' => 'Guides responsible external communications and brand protection.'],
            ['code' => 'P25', 'title' => 'Environmental and Equipment Safety Policy', 'short_description' => 'Addresses equipment safety, power, and environmental controls.'],
        ];

        foreach ($policies as $policy) {
            Policy::updateOrCreate(
                ['code' => $policy['code']],
                $policy + ['framework_id' => $framework->id]
            );
        }

        $risks = [
            ['code' => 'R1', 'title' => 'Plain-Text Passwords', 'statement' => 'User passwords stored or transmitted without encryption.', 'likelihood' => 4, 'impact' => 5, 'residual_level' => 'High', 'mitigation_plan' => 'Enforce hashing and TLS for all credentials.'],
            ['code' => 'R2', 'title' => 'Reused Passwords', 'statement' => 'Employees reuse passwords across business systems.', 'likelihood' => 4, 'impact' => 4, 'residual_level' => 'High', 'mitigation_plan' => 'Require unique passwords and password manager guidance.'],
            ['code' => 'R3', 'title' => 'Missing Backups', 'statement' => 'Critical data lacks recent or tested backups.', 'likelihood' => 3, 'impact' => 5, 'residual_level' => 'High', 'mitigation_plan' => 'Automate backups and test restores quarterly.'],
            ['code' => 'R4', 'title' => 'Outdated Antivirus', 'statement' => 'Endpoint malware signatures are outdated.', 'likelihood' => 3, 'impact' => 3, 'residual_level' => 'Medium', 'mitigation_plan' => 'Enable automatic updates and health monitoring.'],
            ['code' => 'R5', 'title' => 'Phishing Awareness Gap', 'statement' => 'Users are not trained to spot phishing attempts.', 'likelihood' => 4, 'impact' => 4, 'residual_level' => 'High', 'mitigation_plan' => 'Run awareness campaigns and phishing simulations.'],
            ['code' => 'R6', 'title' => 'Unreviewed Access Rights', 'statement' => 'Access permissions are not periodically reviewed.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Schedule quarterly access recertification.'],
            ['code' => 'R7', 'title' => 'Delayed Patching', 'statement' => 'Security patches are applied slowly or inconsistently.', 'likelihood' => 4, 'impact' => 4, 'residual_level' => 'High', 'mitigation_plan' => 'Adopt monthly patch cycles with exception tracking.'],
            ['code' => 'R8', 'title' => 'Missing HTTPS', 'statement' => 'Web applications are served without HTTPS everywhere.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Force HTTPS with HSTS and certificate monitoring.'],
            ['code' => 'R9', 'title' => 'No Firewall', 'statement' => 'Network lacks perimeter or host-based firewalls.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Deploy firewalls with least-privilege rules.'],
            ['code' => 'R10', 'title' => 'Unencrypted Devices', 'statement' => 'Laptops or drives are not encrypted at rest.', 'likelihood' => 3, 'impact' => 5, 'residual_level' => 'High', 'mitigation_plan' => 'Enforce full-disk encryption and startup passwords.'],
            ['code' => 'R11', 'title' => 'Single-Device Storage', 'statement' => 'Business data stored on a single device without redundancy.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Adopt centralized, backed-up storage.'],
            ['code' => 'R12', 'title' => 'Missing MFA', 'statement' => 'Critical systems lack multi-factor authentication.', 'likelihood' => 4, 'impact' => 5, 'residual_level' => 'High', 'mitigation_plan' => 'Roll out MFA for all remote and admin access.'],
            ['code' => 'R13', 'title' => 'Weak Vendors', 'statement' => 'Vendors have inadequate security controls.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Assess vendors and require remediation plans.'],
            ['code' => 'R14', 'title' => 'No Incident Plan', 'statement' => 'There is no defined incident response plan.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Document and exercise an incident plan annually.'],
            ['code' => 'R15', 'title' => 'Uncontrolled Accounting Access', 'statement' => 'Accounting systems have broad, untracked access.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Restrict roles and enable logging for finance systems.'],
            ['code' => 'R16', 'title' => 'Unsecured Email', 'statement' => 'Email transmission lacks security controls.', 'likelihood' => 3, 'impact' => 3, 'residual_level' => 'Medium', 'mitigation_plan' => 'Enable secure email gateways and encryption options.'],
            ['code' => 'R17', 'title' => 'Misconfigured Cloud', 'statement' => 'Cloud resources are deployed with insecure defaults.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Use templates, guardrails, and configuration scanning.'],
            ['code' => 'R18', 'title' => 'Ignored Logs', 'statement' => 'Security logs are not reviewed or centrally stored.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Centralize logs and alert on critical events.'],
            ['code' => 'R19', 'title' => 'Default Passwords', 'statement' => 'Systems retain vendor default credentials.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Change defaults during deployment and audit regularly.'],
            ['code' => 'R20', 'title' => 'Personal Devices Risk', 'statement' => 'Personal devices access company data without controls.', 'likelihood' => 4, 'impact' => 4, 'residual_level' => 'High', 'mitigation_plan' => 'Enforce MDM and acceptable use for BYOD.'],
            ['code' => 'R21', 'title' => 'Weak Wi-Fi', 'statement' => 'Wireless networks use weak encryption or shared credentials.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Adopt WPA3 and per-user credentials.'],
            ['code' => 'R22', 'title' => 'No Accounting Backups', 'statement' => 'Financial systems lack dedicated backups.', 'likelihood' => 3, 'impact' => 5, 'residual_level' => 'High', 'mitigation_plan' => 'Implement offsite backups for finance applications.'],
            ['code' => 'R23', 'title' => 'No Security Awareness Program', 'statement' => 'Organization lacks ongoing security training.', 'likelihood' => 3, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Launch recurring awareness program.'],
            ['code' => 'R24', 'title' => 'Open Server Rooms', 'statement' => 'Server rooms are left unlocked or poorly monitored.', 'likelihood' => 2, 'impact' => 4, 'residual_level' => 'Medium', 'mitigation_plan' => 'Secure rooms with access controls and cameras.'],
            ['code' => 'R25', 'title' => 'No Disaster Recovery Plan', 'statement' => 'There is no tested disaster recovery strategy.', 'likelihood' => 3, 'impact' => 5, 'residual_level' => 'High', 'mitigation_plan' => 'Develop and test DR plans annually.'],
        ];

        foreach ($risks as $risk) {
            Risk::updateOrCreate(
                ['code' => $risk['code']],
                $risk + ['score' => $risk['likelihood'] * $risk['impact']]
            );
        }
    }
}
