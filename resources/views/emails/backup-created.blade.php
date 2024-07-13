@component('mail::message')
    # Backup Created Properly

    Hello,

    A new backup has been successfully created on the system.

    Backup details:
    - Name: {{ $backupInformation["pathBackup"] }}
    - Datetime: {{ $backupInformation["datetimeBackup"] }}
    - Size: {{ $backupInformation["sizeBackup"] }} KB

    Thank you for using our system.

    Greetings,
    {{ config('app.name') }} Team
@endcomponent
