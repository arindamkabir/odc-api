<?php

return [
    /*
     * The webhook URLs that we'll use to send a message to Discord.
     */
    'webhook_urls' => [
        'default' => 'https://discord.com/api/webhooks/1186008125808050236/le3d581ZnmhEWl71x83VCU6fFEW8UfkEAEwJX3ymWylS0Rqrs5-HPQ9BwgqLNtXA_Yab',
    ],

    /*
     * This job will send the message to Discord. You can extend this
     * job to set timeouts, retries, etc...
     */
    'job' => Spatie\DiscordAlerts\Jobs\SendToDiscordChannelJob::class,
];
