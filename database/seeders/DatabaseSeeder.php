<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityUpdate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::create([
            'name'        => 'Lona Ayeh',
            'employee_id' => 'NPT-001',
            'phone'       => '+233 24 000 0001',
            'department'  => 'Applications Support',
            'role'        => User::ROLE_ADMIN,
            'email'       => 'admin@npontu.test',
            'password'    => Hash::make('password'),
        ]);

        $ama = User::create([
            'name'        => 'Ama Boateng',
            'employee_id' => 'NPT-014',
            'phone'       => '+233 24 000 0014',
            'department'  => 'Applications Support',
            'role'        => User::ROLE_SUPPORT,
            'email'       => 'ama@npontu.test',
            'password'    => Hash::make('password'),
        ]);

        $kwame = User::create([
            'name'        => 'Kwame Asare',
            'employee_id' => 'NPT-021',
            'phone'       => '+233 24 000 0021',
            'department'  => 'Applications Support',
            'role'        => User::ROLE_SUPPORT,
            'email'       => 'kwame@npontu.test',
            'password'    => Hash::make('password'),
        ]);

        $yaa = User::create([
            'name'        => 'Yaa Mensah',
            'employee_id' => 'NPT-033',
            'phone'       => '+233 24 000 0033',
            'department'  => 'Applications Support',
            'role'        => User::ROLE_SUPPORT,
            'email'       => 'yaa@npontu.test',
            'password'    => Hash::make('password'),
        ]);

        $personnel = collect([$ama, $kwame, $yaa]);

        $activities = collect([
            ['Daily SMS count in comparison to SMS count from logs', 'Reconcile sent SMS volumes against gateway logs.'],
            ['Payment gateway heartbeat check', 'Verify payment switch responds within SLA.'],
            ['USSD session error sweep', 'Scan USSD logs for session timeouts and stuck transactions.'],
            ['Backup verification — DB02', 'Confirm last night\'s backup completed and a restore sample succeeds.'],
            ['Email queue depth check', 'Inspect queued/failed outbound email counts.'],
            ['API uptime — partner endpoints', 'Ping critical partner endpoints and record latency.'],
        ])->map(fn ($row) => Activity::create([
            'title'       => $row[0],
            'description' => $row[1],
            'created_by'  => $admin->id,
            'is_active'   => true,
        ]));

        $remarkBank = [
            'Daily SMS count in comparison to SMS count from logs' => [
                'done' => [
                    'App reports 12,408 sent · gateway logs 12,408. Counts match.',
                    'Reconciled — zero variance against MTN and Vodafone gateway logs.',
                    'All three carriers tally with app figures; no missing deliveries.',
                    'Variance < 0.1%, within tolerance. Closing out.',
                ],
                'pending' => [
                    'App says 9,842 sent, gateway logs show 9,700 — investigating the 142 gap.',
                    'MTN logs not yet available for today; will recheck after 14:00.',
                    'Variance of 3% with Vodafone — ticket #SMS-441 raised with vendor.',
                    'Counts off by 78 messages; pulling delivery receipts to trace which numbers failed.',
                ],
            ],
            'Payment gateway heartbeat check' => [
                'done' => [
                    'Heartbeat round-trip 184ms — well inside 500ms SLA.',
                    'All three switches responsive; no failed transactions in last hour.',
                    'Gateway healthy across MoMo, Visa, and Mastercard rails.',
                    'No 5xx responses in last 60min. Marking healthy.',
                ],
                'pending' => [
                    'Gateway latency spiked to 1.8s at 09:10 — vendor ticket #PG-2241 raised.',
                    'Intermittent 502s from MoMo endpoint. Awaiting vendor response.',
                    'Heartbeat passing but transaction success rate dropped to 92%. Monitoring.',
                    'Visa rail unreachable for 4 minutes; switched to backup processor. Investigating root cause.',
                ],
            ],
            'USSD session error sweep' => [
                'done' => [
                    '0 stuck sessions in last 24h. Logs clean.',
                    'Timeout rate 0.4% — below 1% threshold. Healthy.',
                    'No orphaned transactions detected; menus loading normally.',
                    'All session terminations clean. No customer escalations.',
                ],
                'pending' => [
                    '17 stuck sessions on *123#, all on Telecel network. Reaching out to carrier.',
                    'Spike in session timeouts after 11:00; correlating with app deploy.',
                    'Two transactions stuck mid-flow; manual reversal in progress.',
                    'Session error rate jumped to 3.2% — escalated to platform team.',
                ],
            ],
            'Backup verification — DB02' => [
                'done' => [
                    'Backup completed 02:14; restore sample to staging successful in 9min.',
                    'Snapshot integrity verified; row counts match production.',
                    'Full backup + WAL archive both healthy. DR window met.',
                    'Restore drill passed — RPO 15min, RTO 22min. Within targets.',
                ],
                'pending' => [
                    'Backup completed but restore test scheduled for 14:00 maintenance window.',
                    'Snapshot 4% smaller than yesterday — checking for missing tables.',
                    'Backup job failed at 02:47; rerunning manually. Awaiting completion.',
                    'WAL archive lagging by 8min; investigating replication.',
                ],
            ],
            'Email queue depth check' => [
                'done' => [
                    'Queue depth 142, draining at ~50/sec. Normal.',
                    'No failed jobs in the last hour. SMTP credentials valid.',
                    'All transactional emails delivered within 30s of trigger.',
                    'Failed job queue empty. Outbound healthy.',
                ],
                'pending' => [
                    'Queue depth climbing — 4,200 pending. SMTP throttling suspected.',
                    'Failed jobs at 87; SendGrid returning 429s. Rate-limit ticket open.',
                    'Password-reset emails delayed by ~6min. Investigating backlog.',
                    'Bounce rate jumped to 4%; reviewing sender reputation.',
                ],
            ],
            'API uptime — partner endpoints' => [
                'done' => [
                    'All 7 partner endpoints responding < 400ms. Green.',
                    'No timeouts in last 30min across credit bureau, KYC, and MoMo APIs.',
                    'Partner SLA met for the day. No incidents to log.',
                    'Identity verification API back to baseline latency. Closing.',
                ],
                'pending' => [
                    'Credit bureau API returning 503s intermittently — partner notified.',
                    'KYC partner endpoint slow (avg 2.4s). Awaiting their RCA.',
                    'MoMo collections API timing out on 12% of calls. Escalated to partner ops.',
                    'Bureau X unreachable since 10:32; affected loan flow disabled in app.',
                ],
            ],
        ];

        $genericRemarks = [
            'done'    => ['Check passed — no anomalies.', 'All clear; closing out.', 'Healthy; nothing to action.'],
            'pending' => ['Issue detected — investigating.', 'Awaiting response from upstream.', 'Follow-up needed next shift.'],
        ];

        for ($d = 13; $d >= 0; $d--) {
            $day = Carbon::now()->subDays($d);

            foreach ($activities as $activity) {
                if ($d > 0 && rand(0, 100) < 15) {
                    continue;
                }

                $updateCount = rand(1, 3);
                for ($i = 0; $i < $updateCount; $i++) {
                    $status = $i === $updateCount - 1
                        ? (rand(0, 100) < 70 ? 'done' : 'pending')
                        : 'pending';

                    $when = $day->copy()
                        ->setHour(rand(8, 17))
                        ->setMinute(rand(0, 59));

                    $pool = $remarkBank[$activity->title][$status] ?? $genericRemarks[$status];

                    ActivityUpdate::create([
                        'activity_id' => $activity->id,
                        'user_id'     => $personnel->random()->id,
                        'status'      => $status,
                        'remark'      => $pool[array_rand($pool)],
                        'created_at'  => $when,
                        'updated_at'  => $when,
                    ]);
                }
            }
        }
    }
}
